<?php

declare(strict_types=1);
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Modules\Activity\Filament\Pages\LogViewer;
use Modules\Xot\Contracts\UserContract;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Tests\TestCase;

uses(TestCase::class);

/*
 * Usa Tests\TestCase (root) e non Modules\Activity\Tests\TestCase: la pagina Log non tocca il database e la
 * seconda richiede un file sqlite condiviso non presente in ogni ambiente (stesso motivo di
 * Modules/Xot/tests/Feature/Filament/Widgets/EnvWidgetTest.php).
 *
 * Gli utenti sono mock (nessuna riga nel database). storage_path() viene puntato a una cartella temporanea
 * con useStoragePath(), cosi' i test non leggono ne' scrivono mai il vero storage/logs; il percorso
 * originale e' ripristinato sempre in afterEach.
 */
beforeEach(function (): void {
    $this->originalStorage = storage_path();
    $this->tempStorage = $this->originalStorage.'/framework/testing/log-viewer-page-'.uniqid('', true);
    File::makeDirectory($this->tempStorage.'/logs/reports/252', 0777, true);
    app()->useStoragePath($this->tempStorage);

    File::put($this->tempStorage.'/logs/laravel.log', implode("\n", [
        '[2026-09-20 10:00:00] production.INFO: avvio',
        '[2026-09-20 10:05:00] production.ERROR: SMTP non raggiungibile',
        '#0 /var/www/vendor/symfony/mailer/Transport.php(12): connect()',
        '',
    ]));
    File::put($this->tempStorage.'/logs/reports/252/daily_2026-09-17.log', "[2026-09-17 09:00:00] production.INFO: contacts.received\n");
    File::put($this->originalStorage.'/framework/testing/segreto-fuori-dai-log.log', 'segreto');

    $this->actingAsUser = function (bool $isSuperAdmin, bool|Throwable $hasPermission = false): void {
        // UserContract estende gia' Authenticatable: un solo mock basta ed e' tipizzabile da PHPStan.
        /** @var MockInterface&UserContract&Authenticatable $user */
        $user = Mockery::mock(UserContract::class, Authenticatable::class);
        $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);
        $expectation = $user->shouldReceive('hasPermissionTo')->with('log.viewAny');
        if ($hasPermission instanceof Throwable) {
            $expectation->andThrow($hasPermission);
        } else {
            $expectation->andReturn($hasPermission);
        }

        Filament::auth()->setUser($user);
    };
});

afterEach(function (): void {
    app()->useStoragePath($this->originalStorage);
    File::deleteDirectory($this->tempStorage);
    File::delete($this->originalStorage.'/framework/testing/segreto-fuori-dai-log.log');
    Mockery::close();
});

it('allows access to super-admins and to users with the log.viewAny permission', function (): void {
    ($this->actingAsUser)(true);
    expect(LogViewer::canAccess())->toBeTrue();

    ($this->actingAsUser)(false, true);
    expect(LogViewer::canAccess())->toBeTrue();
});

it('denies access to users without the role and without the permission', function (): void {
    ($this->actingAsUser)(false, false);

    expect(LogViewer::canAccess())->toBeFalse();
});

it('denies access, without crashing, when the permission does not exist yet', function (): void {
    ($this->actingAsUser)(false, new PermissionDoesNotExist);

    expect(LogViewer::canAccess())->toBeFalse();
});

it('picks laravel.log as the default file', function (): void {
    $page = new LogViewer;
    $page->mount();

    expect($page->file)->toBe('laravel.log');
});

it('opens the first-level folders at start and keeps the deeper subfolders closed', function (): void {
    $page = new LogViewer;
    $page->mount();

    expect($page->expanded)->toBe(['reports']);
});

it('opens the folders that contain the selected file so it is always visible in the tree', function (): void {
    $page = new LogViewer;
    $page->file = 'reports/252/daily_2026-09-17.log';
    $page->mount();

    expect($page->expanded)->toContain('reports');
    expect($page->expanded)->toContain('reports/252');
});

it('toggles a folder open and closed', function (): void {
    $page = new LogViewer;
    $page->mount();

    $page->toggleFolder('reports/252');
    expect($page->expanded)->toBe(['reports', 'reports/252']);

    $page->toggleFolder('reports/252');
    expect($page->expanded)->toBe(['reports']);
});

it('selects a file from the tree and reads it', function (): void {
    $page = new LogViewer;
    $page->mount();

    $page->selectFile('reports/252/daily_2026-09-17.log');
    $state = $page->getLogState();

    expect($page->file)->toBe('reports/252/daily_2026-09-17.log');
    expect($state->error)->toBeNull();
    expect($state->total)->toBe(1);
});

it('does not read a file outside the log directory even if selected from a crafted request', function (): void {
    $page = new LogViewer;
    $page->mount();

    $page->selectFile('../framework/testing/segreto-fuori-dai-log.log');
    $state = $page->getLogState();

    expect($state->error)->not->toBeNull();
    expect($state->entries)->toBe([]);
});

it('passes the user choices to the state and exposes the tree', function (): void {
    $page = new LogViewer;
    $page->file = 'laravel.log';
    $page->level = 'INFO';
    $page->search = 'avvio';

    $state = $page->getLogState();

    expect($state->total)->toBe(1);
    expect($state->tree->count)->toBe(2);
    expect($state->tree->folders[0]->path)->toBe('reports');
    expect($state->tree->folders[0]->folders[0]->path)->toBe('reports/252');
});

it('registers the header actions with string keys', function (): void {
    $page = new LogViewer;
    $actions = (fn (): array => $this->getHeaderActions())->call($page);

    expect(array_keys($actions))->toBe(['refresh', 'download']);
});

it('points the download to the Folio page with the chosen file', function (): void {
    $page = new LogViewer;
    $page->file = 'reports/252/daily_2026-09-17.log';

    $url = $page->getDownloadUrl();

    expect($url)->toContain(LogViewer::DOWNLOAD_PATH.'?file=');
    expect(urldecode($url))->toContain('reports/252/daily_2026-09-17.log');
});

it('renders the tree branch: closed folders hide their files, the selected file is highlighted', function (): void {
    $tree = (new LogViewer)->getLogState()->tree;
    $render = fn (array $expanded, string $selected): string => view('activity::filament.pages.partials.log-tree-node', [
        'node' => $tree,
        'expanded' => $expanded,
        'selected' => $selected,
    ])->render();

    $closed = $render(['reports'], 'laravel.log');
    expect($closed)->toContain('laravel.log');
    expect($closed)->toContain('toggleFolder(');
    expect($closed)->toContain('aria-current="true"');
    expect($closed)->not->toContain('daily_2026-09-17.log');

    $open = $render(['reports', 'reports/252'], 'reports/252/daily_2026-09-17.log');
    expect($open)->toContain('daily_2026-09-17.log');
    expect($open)->toContain("selectFile('reports\\/252\\/daily_2026-09-17.log')");
});

it('escapes file names in the tree and passes paths with quotes to wire:click safely', function (): void {
    File::put($this->tempStorage.'/logs/<u>x.log', 'x');
    File::put($this->tempStorage.'/logs/it\'s.log', 'x');

    $tree = (new LogViewer)->getLogState()->tree;
    $html = view('activity::filament.pages.partials.log-tree-node', [
        'node' => $tree,
        'expanded' => [],
        'selected' => '',
    ])->render();

    // Il nome del file e' testo, mai HTML.
    expect($html)->not->toContain('<u>x.log');
    expect($html)->toContain('&lt;u&gt;x.log');
    // L'apice nel percorso non rompe l'attributo wire:click.
    expect($html)->toContain("selectFile('it\\u0027s.log')");
});
