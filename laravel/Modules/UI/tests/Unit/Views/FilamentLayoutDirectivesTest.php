<?php

declare(strict_types=1);

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_replace;

/**
 * Behaviour: layout owner is UI (not Cms). Filament Styles/Scripts + bare notifications.
 * Existing UI tests: this file. UI layouts must not reference Cms (checked on the code, not on the folder,
 * so it holds in projects that do ship Modules/Cms).
 *
 * @see Modules/UI/docs/adr/0004-optional-cms-delegation-for-block-data.md
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

test('ui layouts do not depend on the cms module', function (): void {
    $layouts = glob(dirname(__DIR__, 3).'/resources/views/components/layouts/*.blade.php');
    expect($layouts)->not->toBeEmpty();

    foreach ($layouts as $layout) {
        expect($layout)->toBeString();
        if (! is_string($layout)) {
            continue;
        }

        // I commenti Blade possono nominare cms::* per spiegare perche' non lo usano: contano solo i riferimenti reali.
        $code = (string) preg_replace('/\{\{--.*?--\}\}/s', '', (string) file_get_contents($layout));

        expect($code)->not->toContain('cms::', 'Modules\Cms');
    }
});
