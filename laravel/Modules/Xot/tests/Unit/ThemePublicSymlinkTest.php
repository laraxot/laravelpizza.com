<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\readlink;

uses(TestCase::class);

/**
 * Asset di temi e moduli nella document root, solo tramite symlink RELATIVI (mai copie):
 *   public_html/themes/<Tema>   -> ../../laravel/Themes/<Tema>/public    (php artisan xot:theme-link)
 *   public_html/assets/<modulo> -> ../../laravel/Modules/<Modulo>/public (php artisan xot:module-link)
 * I link si creano in ogni installazione e non si committano: li elencano public_html/themes/.gitignore e
 * public_html/assets/.gitignore, con due righe per nome (`<nome>/` cartella reale, `<nome>` symlink).
 * Un link non ancora creato (checkout nuovo, CI) fa saltare il test, non fallire.
 * SSoT: laravel/Modules/Xot/docs/wiki/rules/theme-public-symlink.md
 */
function themePublicSymlinkRepoRoot(): string
{
    return dirname(__DIR__, 5);
}

/**
 * @return array<string, array{0: string|null, 1: string|null}> nome nel docroot => [nome, cartella public sorgente]
 */
function publicAssetLinks(string $docrootDir, string $sourceGlob, bool $lowercase): array
{
    $links = [];
    foreach (glob(themePublicSymlinkRepoRoot().'/laravel/'.$sourceGlob, GLOB_ONLYDIR) as $dir) {
        if (! is_string($dir)) {
            continue;
        }
        $name = basename(dirname($dir));
        $linkName = $lowercase ? strtolower($name) : $name;
        $links[$docrootDir.'/'.$linkName] = [$linkName, $name];
    }

    // Pest non accetta dataset vuoti: senza temi o moduli con public/ (layout diverso da laravel/) si salta.
    return $links === [] ? ['nessuna cartella public trovata' => [null, null]] : $links;
}

it('ogni tema con build ha il symlink relativo in public_html/themes', function (?string $link, ?string $theme): void {
    if ($link === null || $theme === null) {
        $this->markTestSkipped('Nessun tema con public/ sotto laravel/Themes.');
    }
    $path = themePublicSymlinkRepoRoot().'/public_html/themes/'.$link;
    if (! file_exists($path) && ! is_link($path)) {
        $this->markTestSkipped('Link non ancora creato: php artisan xot:theme-link');
    }

    expect(is_link($path))->toBeTrue('public_html/themes/'.$link.' deve essere un symlink, non una copia')
        ->and(readlink($path))->toBe('../../laravel/Themes/'.$theme.'/public')
        ->and(is_file($path.'/manifest.json'))->toBeTrue('manifest Vite non raggiungibile da '.$path);
})->with(publicAssetLinks('themes', 'Themes/*/public', false));

it('ogni modulo con public/ ha il symlink relativo in public_html/assets', function (?string $link, ?string $module): void {
    if ($link === null || $module === null) {
        $this->markTestSkipped('Nessun modulo con public/ sotto laravel/Modules.');
    }
    $path = themePublicSymlinkRepoRoot().'/public_html/assets/'.$link;
    if (! file_exists($path) && ! is_link($path)) {
        $this->markTestSkipped('Link non ancora creato: php artisan xot:module-link');
    }

    expect(is_link($path))->toBeTrue('public_html/assets/'.$link.' deve essere un symlink, non una copia')
        ->and(readlink($path))->toBe('../../laravel/Modules/'.$module.'/public');
})->with(publicAssetLinks('assets', 'Modules/*/public', true));

it('i .gitignore del docroot escludono cartella reale e symlink di ogni link', function (string $docrootDir, string $sourceGlob, bool $lowercase): void {
    $gitignore = themePublicSymlinkRepoRoot().'/public_html/'.$docrootDir.'/.gitignore';
    if (! is_file($gitignore)) {
        $this->markTestSkipped('public_html/'.$docrootDir.'/.gitignore assente (layout diverso dal repo base)');
    }
    $lines = array_map('trim', explode("\n", file_get_contents($gitignore)));

    foreach (publicAssetLinks($docrootDir, $sourceGlob, $lowercase) as [$link]) {
        if ($link === null) {
            continue;
        }
        expect($lines)->toContain($link.'/')
            ->and($lines)->toContain($link);
    }
})->with([
    'temi' => ['themes', 'Themes/*/public', false],
    'moduli' => ['assets', 'Modules/*/public', true],
]);

it('public_html non contiene file di sviluppo o diagnostica', function (string $file): void {
    expect(file_exists(themePublicSymlinkRepoRoot().'/public_html/'.$file))->toBeFalse();
})->with([
    'hot del dev server Vite' => ['hot'],
    'phpinfo esposto' => ['info.php'],
]);

it('nessun tema conserva lo script npm copy', function (?string $link, ?string $theme): void {
    if ($theme === null) {
        $this->markTestSkipped('Nessun tema con public/ sotto laravel/Themes.');
    }
    $packageJson = themePublicSymlinkRepoRoot().'/laravel/Themes/'.$theme.'/package.json';
    if (! is_file($packageJson)) {
        $this->markTestSkipped('Il tema '.$theme.' non ha package.json.');
    }

    expect(file_get_contents($packageJson))->not->toContain('"copy"');
})->with(publicAssetLinks('themes', 'Themes/*/public', false));
