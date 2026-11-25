<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Modules\Xot\Actions\Artisan\HandleArtisanActRequestAction;
use Modules\Xot\Enums\ArtisanActEnum;
use Modules\Xot\Tests\TestCase;

use function Safe\ob_end_clean;
use function Safe\ob_start;

uses(TestCase::class);

beforeEach(function (): void {
    // Il migrate rinfresca la connessione di default: la puntiamo a una sqlite in memoria.
    Config::set('database.default', 'mysql');
    Config::set('database.connections.mysql', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
});

test('act sconosciuto restituisce stringa vuota senza toccare artisan', function (): void {
    Artisan::shouldReceive('call')->never();

    expect(app(HandleArtisanActRequestAction::class)->execute('unknown-command'))->toBe('');
});

test('i valori dell enum sono esattamente gli act storici', function (): void {
    expect(array_map(static fn (ArtisanActEnum $case): string => $case->value, ArtisanActEnum::cases()))
        ->toBe([
            'migrate', 'routelist', 'routelist1', 'routecache', 'routeclear', 'queue:flush', 'optimize',
            'clear', 'clearcache', 'configcache', 'viewclear', 'debugbar:clear', 'module-list',
            'module-disable', 'module-enable', 'error', 'error-show', 'error-clear',
        ]);
});

test('gli act che sono un semplice comando artisan lo inoltrano e racchiudono l output in pre', function (string $act, string $command): void {
    Request::replace(['module' => '']);
    Artisan::shouldReceive('call')->once()->with($command, [])->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('fatto');

    expect(app(HandleArtisanActRequestAction::class)->execute($act))->toBe('[<pre>fatto</pre>]');
})->with([
    'routelist' => ['routelist', 'route:list'],
    'routecache' => ['routecache', 'route:cache'],
    'routeclear' => ['routeclear', 'route:clear'],
    'queue:flush' => ['queue:flush', 'queue:flush'],
    'optimize' => ['optimize', 'optimize'],
    'clearcache' => ['clearcache', 'cache:clear'],
    'configcache' => ['configcache', 'config:cache'],
    'viewclear' => ['viewclear', 'view:clear'],
    'module-list' => ['module-list', 'module:list'],
]);

test('module-enable e module-disable aggiungono il nome del modulo al comando', function (string $act, string $command): void {
    Request::replace(['module' => 'Blog']);
    Artisan::shouldReceive('call')->once()->with($command, [])->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('ok');

    expect(app(HandleArtisanActRequestAction::class)->execute($act))->toBe('[<pre>ok</pre>]');
})->with([
    'enable' => ['module-enable', 'module:enable Blog'],
    'disable' => ['module-disable', 'module:disable Blog'],
]);

test('migrate senza modulo lancia migrate', function (): void {
    Request::replace(['module' => '']);
    Artisan::shouldReceive('call')->once()->with('migrate', [])->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration completed');

    expect(app(HandleArtisanActRequestAction::class)->execute('migrate'))->toContain('Migration completed');
});

test('migrate con modulo lancia module:migrate per quel modulo', function (): void {
    Request::replace(['module' => 'TestModule']);
    Artisan::shouldReceive('call')->once()->with('module:migrate', ['module' => 'TestModule'])->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Module migration');

    ob_start();
    $result = app(HandleArtisanActRequestAction::class)->execute('migrate');
    ob_end_clean();

    expect($result)->toContain('Module migration');
});

test('un parametro module non stringa viene ignorato', function (): void {
    Request::replace(['module' => ['not', 'a', 'string']]);
    Artisan::shouldReceive('call')->once()->with('migrate', [])->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration');

    expect(app(HandleArtisanActRequestAction::class)->execute('migrate'))->toContain('Migration');
});
