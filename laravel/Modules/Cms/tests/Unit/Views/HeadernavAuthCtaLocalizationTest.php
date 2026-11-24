<?php

declare(strict_types=1);

<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
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
