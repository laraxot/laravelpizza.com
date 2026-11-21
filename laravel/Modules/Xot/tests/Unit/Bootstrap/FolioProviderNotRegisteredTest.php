<?php

declare(strict_types=1);

use function Safe\file_get_contents;

/**
 * Behaviour: App FolioServiceProvider must not be registered in bootstrap.
 * FolioVolt alone owns Folio mounts in FO projects with Cms.
 * Existing: none. User: non scomodare App Folio quando c'è FolioVolt.
 */
test('bootstrap providers does not register App FolioServiceProvider', function (): void {
    // this file: Modules/Xot/tests/Unit/Bootstrap → laravel = dirname 5
    $laravelRoot = dirname(__DIR__, 5);
    $path = $laravelRoot.'/bootstrap/providers.php';
    expect(is_file($path))->toBeTrue();

    $contents = (string) file_get_contents($path);
    expect($contents)->not->toContain('App\\Providers\\FolioServiceProvider');
    expect($contents)->not->toMatch('/FolioServiceProvider::class/');
});
