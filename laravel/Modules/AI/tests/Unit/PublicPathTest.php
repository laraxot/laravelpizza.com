<?php

declare(strict_types=1);
use App\Application;
use Modules\Xot\Tests\TestCase;
use Webmozart\Assert\Assert;

uses(TestCase::class)->group('no-xot-db');

/**
 * Guardia sul document root.
 *
 * Il web server serve `public_html/`, non `laravel/public/`. `App\Application` sovrascrive
 * `publicPath()` perche' l'app sta in `laravel/` ma la radice pubblica e' un livello sopra.
 *
 * Senza questa guardia la regressione e' muta: `php artisan storage:link` crea il symlink
 * nella cartella sbagliata, Vite scrive il manifest dove nessuno lo legge, e gli asset
 * tornano 404 in produzione senza un solo errore nei log.
 *
 * @see docs/wiki/rules/public-path-public-html.md
 */
it('risolve public_path() su public_html, non su laravel/public', function (): void {
    expect(public_path())->toEndWith(DIRECTORY_SEPARATOR.'public_html');
});

it('non risolve public_path() dentro laravel/', function (): void {
    expect(public_path())->not->toContain(DIRECTORY_SEPARATOR.'laravel'.DIRECTORY_SEPARATOR);
});

it('appende i segmenti sotto public_html', function (): void {
    expect(public_path('build/manifest.json'))
        ->toEndWith(DIRECTORY_SEPARATOR.'public_html'.DIRECTORY_SEPARATOR.'build'.DIRECTORY_SEPARATOR.'manifest.json');
});

it('normalizza lo slash iniziale del segmento', function (): void {
    expect(public_path('/favicon.ico'))->toBe(public_path('favicon.ico'));
});

it('restituisce un percorso anche per segmenti non ancora creati', function (): void {
    $path = public_path('segmento-che-non-esiste-'.__LINE__);
    $base = public_path();
    Assert::stringNotEmpty($base);

    expect($path)->toStartWith($base)
        ->and(file_exists($path))->toBeFalse();
});

it('usa la Application con publicPath sovrascritto', function (): void {
    expect(app())->toBeInstanceOf(Application::class)
        ->and((new ReflectionMethod(Application::class, 'publicPath'))->getDeclaringClass()->getName())
        ->toBe(Application::class);
});

it('public_html esiste ed e fuori da laravel/', function (): void {
    expect(is_dir(public_path()))->toBeTrue()
        ->and(dirname(public_path()))->toBe(dirname(base_path()));
});
