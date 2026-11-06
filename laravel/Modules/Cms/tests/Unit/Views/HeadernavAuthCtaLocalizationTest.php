<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

test('headernav auth ctas use theme localization keys and not legacy auth keys', function (): void {
    $paths = [
        base_path('Modules/Cms/resources/views/components/headernav/simple.blade.php'),
        base_path('Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php'),
    ];

    foreach ($paths as $path) {
        $content = cmsReadFile($path);

        Assert::assertStringContainsString("@include('pub_theme::components.ui.auth-buttons'", $content);
        Assert::assertStringNotContainsString("__('user::auth.login-in')", $content);
        Assert::assertStringNotContainsString("__('user::auth.sign-up')", $content);
        Assert::assertStringNotContainsString("localizeUrl('/auth/login')", $content);
        Assert::assertStringNotContainsString("localizeUrl('/auth/register')", $content);
    }
});

test('headernav auth ctas delegate rendering to theme auth-buttons partial', function (): void {
    $paths = [
        base_path('Modules/Cms/resources/views/components/headernav/simple.blade.php'),
        base_path('Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php'),
    ];

    foreach ($paths as $path) {
        $content = cmsReadFile($path);

        Assert::assertStringContainsString("@include('pub_theme::components.ui.auth-buttons', ['showLabels' => true, 'size' => 'md'])", $content);
    }
});
