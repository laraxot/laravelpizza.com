<?php

declare(strict_types=1);

use function Safe\file_get_contents;

/**
 * Behaviour: PTVX layout owner is UI (not Cms). Filament Styles/Scripts + bare notifications.
 * Existing UI tests: this file. Cms must remain absent.
 * User: «@auth @livewire(notifications) @endauth e' sbagliato — solo @livewire(notifications)».
 * Docs: https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 */
test('ui main layout contains filament styles scripts and bare notifications', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/layouts/main.blade.php';
    expect(is_file($path))->toBeTrue();
    $c = (string) file_get_contents($path);
    expect($c)->toContain('@filamentStyles');
    expect($c)->toContain('@filamentScripts');
    expect($c)->toContain("@livewire('notifications')");
    expect($c)->not->toContain('@endauth');
});

test('ui master layout contains filament styles scripts and bare notifications', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/layouts/master.blade.php';
    expect(is_file($path))->toBeTrue();
    $c = (string) file_get_contents($path);
    expect($c)->toContain('@filamentStyles');
    expect($c)->toContain('@filamentScripts');
    expect($c)->toContain("@livewire('notifications')");
    expect($c)->not->toContain('@endauth');
});

test('cms module directory is absent in ptvx', function (): void {
    $cms = dirname(__DIR__, 4).'/Cms';
    expect(is_dir($cms))->toBeFalse();
});
