<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\readlink;

/*
 * Gli asset compilati stanno nel modulo o nel tema che li produce (`Modules/<Modulo>/public`,
 * `Themes/<Tema>/public`); la document root `public_html` li vede con un symlink relativo:
 *
 *   public_html/assets/<modulo in minuscolo> -> ../../laravel/Modules/<Modulo>/public
 *   public_html/themes/<Tema>                -> ../../laravel/Themes/<Tema>/public
 *
 * Una sola copia, versionata con il codice che la usa e che viaggia con il modulo tra i progetti; nessun
 * `npm run copy` o `vendor:publish` da ricordare. `public_html/assets/.gitignore` elenca `<modulo>/`: la barra
 * finale vale solo per le cartelle, quindi il symlink resta tracciato e una copia vera viene ignorata.
 *
 * Test sui file del repository: non avvia l'applicazione né il database.
 */

function publicAssetsRepoRoot(): string
{
    return dirname(__DIR__, 5);
}

/**
 * @return array<string, array{string, string}>
 */
function publicAssetsModules(): array
{
    $modules = [];
    foreach (glob(dirname(__DIR__, 3).'/*/public', GLOB_ONLYDIR) as $public) {
        if (! is_string($public)) {
            continue;
        }
        $module = basename(dirname($public));
        $modules[$module] = [$module, strtolower($module)];
    }

    return $modules;
}

it('links every module public folder from public_html/assets', function (string $module, string $name): void {
    $link = publicAssetsRepoRoot().'/public_html/assets/'.$name;
    if (! is_dir(publicAssetsRepoRoot().'/public_html')) {
        $this->markTestSkipped('progetto senza public_html');
    }

    expect(is_link($link))->toBeTrue("public_html/assets/{$name} deve essere un symlink, non una copia")
        ->and(readlink($link))->toBe("../../laravel/Modules/{$module}/public");
})->with(publicAssetsModules());

it('ignores real copies of module assets but keeps the symlinks tracked', function (): void {
    $gitignore = publicAssetsRepoRoot().'/public_html/assets/.gitignore';
    if (! is_dir(publicAssetsRepoRoot().'/public_html')) {
        $this->markTestSkipped('progetto senza public_html');
    }

    expect($gitignore)->toBeFile();
    $lines = array_map(trim(...), explode("\n", file_get_contents($gitignore)));

    foreach (publicAssetsModules() as [, $name]) {
        expect($lines)->toContain($name.'/');
    }
});

/*
 * Anche i moduli senza `public/` vanno nel .gitignore: per loro AssetAction crea una cartella vera
 * `public_html/assets/<modulo>/` con le copie da `resources/`, che è una cache e non deve entrare nel repo.
 */
it('lists every module in public_html/assets/.gitignore', function (): void {
    $gitignore = publicAssetsRepoRoot().'/public_html/assets/.gitignore';
    if (! is_dir(publicAssetsRepoRoot().'/public_html')) {
        $this->markTestSkipped('progetto senza public_html');
    }

    $lines = array_map(trim(...), explode("\n", file_get_contents($gitignore)));
    $missing = [];
    foreach (glob(dirname(__DIR__, 3).'/*/module.json') as $manifest) {
        if (! is_string($manifest)) {
            continue;
        }
        $name = strtolower(basename(dirname($manifest))).'/';
        if (! in_array($name, $lines, true)) {
            $missing[] = $name;
        }
    }

    expect($missing)->toBe([], 'voci mancanti in public_html/assets/.gitignore: '.implode(' ', $missing));
});

/**
 * @return array<string, array{string}>
 */
function publicAssetsBuiltThemes(): array
{
    $themes = [];
    foreach (glob(publicAssetsRepoRoot().'/laravel/Themes/*/public/manifest.json') as $manifest) {
        if (! is_string($manifest)) {
            continue;
        }
        $theme = basename(dirname($manifest, 2));
        $themes[$theme] = [$theme];
    }

    return $themes;
}

it('links every built theme from public_html/themes and ignores real copies', function (string $theme): void {
    if (! is_dir(publicAssetsRepoRoot().'/public_html')) {
        $this->markTestSkipped('progetto senza public_html');
    }
    $link = publicAssetsRepoRoot().'/public_html/themes/'.$theme;
    $lines = array_map(trim(...), explode("\n", file_get_contents(publicAssetsRepoRoot().'/public_html/themes/.gitignore')));

    expect(is_link($link))->toBeTrue("public_html/themes/{$theme} deve essere un symlink, non una copia")
        ->and(readlink($link))->toBe("../../laravel/Themes/{$theme}/public")
        ->and($lines)->toContain($theme.'/');
})->with(publicAssetsBuiltThemes());
