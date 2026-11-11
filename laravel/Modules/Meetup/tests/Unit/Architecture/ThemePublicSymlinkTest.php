<?php

declare(strict_types=1);

/*
 * Ogni tema in laravel/Themes/<Tema> e' servito da public_html/themes/<Tema>, che deve essere il symlink relativo
 * ../../laravel/Themes/<Tema>/public: una sola copia degli asset compilati, nessun sorgente nella document root.
 */
test('every theme is published in the document root through a relative symlink to its public folder', function (): void {
    // Test puro sul filesystem: niente applicazione Laravel (tests/Unit non la avvia).
    $laravel = dirname(__DIR__, 5);
    $root = dirname($laravel);
    $themes = glob($laravel.'/Themes/*', GLOB_ONLYDIR) ?: [];

    expect($themes)->not->toBeEmpty();

    foreach ($themes as $themePath) {
        $theme = basename($themePath);
        $link = $root.'/public_html/themes/'.$theme;

        expect(is_link($link))->toBeTrue("public_html/themes/{$theme} deve essere un symlink")
            ->and(readlink($link))->toBe('../../laravel/Themes/'.$theme.'/public')
            ->and(realpath($link))->toBe(realpath($themePath.'/public'));
    }
});
