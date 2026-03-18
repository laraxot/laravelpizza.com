<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Views;

test('headernav auth ctas use theme localization keys and not legacy auth keys', function (): void {
    $paths = [
        base_path('Modules/Cms/resources/views/components/headernav/simple.blade.php'),
        base_path('Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php'),
    ];

    foreach ($paths as $path) {
        $content = file_get_contents($path);

        expect($content)->not->toBeFalse();
        if (! is_string($content)) {
            continue;
        }

        expect($content)
            ->toContain("@include('pub_theme::components.ui.auth-buttons'")
            ->not->toContain("__('user::auth.login-in')")
            ->not->toContain("__('user::auth.sign-up')")
            ->not->toContain("localizeUrl('/auth/login')")
            ->not->toContain("localizeUrl('/auth/register')");
    }
});

test('headernav auth ctas delegate rendering to theme auth-buttons partial', function (): void {
    $paths = [
        base_path('Modules/Cms/resources/views/components/headernav/simple.blade.php'),
        base_path('Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php'),
    ];

    foreach ($paths as $path) {
        $content = file_get_contents($path);

        expect($content)->not->toBeFalse();
        if (! is_string($content)) {
            continue;
        }

        expect($content)
            ->toContain("@include('pub_theme::components.ui.auth-buttons', ['showLabels' => true, 'size' => 'md'])");
    }
});
