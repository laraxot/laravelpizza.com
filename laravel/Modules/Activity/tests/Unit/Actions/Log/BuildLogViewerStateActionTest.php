<?php

declare(strict_types=1);
use Illuminate\Support\Facades\File;
use Modules\Activity\Actions\Log\BuildLogViewerStateAction;
use Modules\Activity\Enums\LogLevelEnum;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->originalStorage = storage_path();
    $this->tempStorage = $this->originalStorage.'/framework/testing/log-state-'.uniqid('', true);
    File::makeDirectory($this->tempStorage.'/logs/reports/252', 0777, true);
    app()->useStoragePath($this->tempStorage);

    File::put($this->tempStorage.'/logs/laravel.log', implode("\n", [
        '[2026-09-20 10:00:00] production.INFO: avvio',
        '[2026-09-20 10:05:00] production.ERROR: SMTP non raggiungibile',
        '#0 /var/www/vendor/symfony/mailer/Transport.php(12): connect()',
        '',
    ]));
    File::put($this->tempStorage.'/logs/reports/252/daily.log', "[2026-09-17 09:00:00] production.INFO: contacts.received\n");
    File::put($this->originalStorage.'/framework/testing/segreto-stato.log', 'segreto');
});

afterEach(function (): void {
    app()->useStoragePath($this->originalStorage);
    File::deleteDirectory($this->tempStorage);
    File::delete($this->originalStorage.'/framework/testing/segreto-stato.log');
});

it('lists the files and builds the tree even when no file is chosen', function (): void {
    $state = (new BuildLogViewerStateAction)->execute('');

    expect(array_map(fn ($file) => $file->path, $state->files))->toContain('laravel.log')->toContain('reports/252/daily.log');
    expect($state->tree->count)->toBe(2);
    expect($state->tail)->toBeNull();
    expect($state->entries)->toBe([]);
    expect($state->error)->toBeNull();
    expect($state->levels)->toBe(LogLevelEnum::cases());
    expect($state->windows)->toContain(256);
});

it('reads the chosen file and returns its entries newest first with the tail metadata', function (): void {
    $state = (new BuildLogViewerStateAction)->execute('laravel.log');

    expect($state->error)->toBeNull();
    expect($state->total)->toBe(2);
    expect($state->entries[0]->level)->toBe('ERROR');
    expect($state->entries[0]->body)->toContain('#0 /var/www/vendor/symfony/mailer/Transport.php');
    expect($state->tail?->truncated)->toBeFalse();
    expect($state->tail?->size)->toBeGreaterThan(0);
    expect($state->modifiedAt)->toBeInt()->toBeGreaterThan(0);
});

it('applies the level filter and the text search', function (): void {
    $action = new BuildLogViewerStateAction;

    expect($action->execute('laravel.log', 'INFO')->total)->toBe(1);
    expect($action->execute('laravel.log', '', 'smtp')->total)->toBe(1);
    expect($action->execute('laravel.log', '', 'non-c-e')->total)->toBe(0);
});

it('ignores an invalid level and an invalid window instead of failing', function (): void {
    $state = (new BuildLogViewerStateAction)->execute('laravel.log', 'INVENTATO', '', 'abc');

    expect($state->error)->toBeNull();
    expect($state->total)->toBe(2);
});

it('returns a generic error and no entries for paths that try to leave the log directory', function (): void {
    $action = new BuildLogViewerStateAction;

    foreach (['../framework/testing/segreto-stato.log', '../../.env', '/etc/passwd', 'laravel.log/../../../.env', 'non-esiste.log'] as $malicious) {
        $state = $action->execute($malicious);

        expect($state->error)->not->toBeNull();
        expect($state->entries)->toBe([]);
        expect($state->tail)->toBeNull();
        // Il messaggio mostrato all'utente non riporta il percorso richiesto.
        expect($state->error)->not->toContain($malicious);
        // L'elenco dei file resta disponibile: l'utente puo' scegliere un altro file.
        expect($state->files)->not->toBe([]);
    }
});
