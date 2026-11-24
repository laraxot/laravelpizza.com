<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Actions\File\GetModulePathAction;
use Modules\Xot\Tests\TestCase;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\unlink;

uses(TestCase::class);

it('handles absolute urls in AssetAction', function (): void {
    $action = app(AssetAction::class);
    $url = 'https://example.com/asset.js';
    Assert::assertSame($url, $action->execute($url));
});

it('returns path if asset already exists in public folder', function (): void {
    $relative = 'assets/xot-test-exists-'.uniqid('', true).'.txt';
    $absolute = public_path($relative);
    if (! is_dir(\dirname($absolute))) {
        mkdir(\dirname($absolute), 0o755, true);
    }
    file_put_contents($absolute, 'already-public');

    try {
        $action = app(AssetAction::class);
        Assert::assertSame($relative, $action->execute($relative));
    } finally {
        if (is_file($absolute)) {
            unlink($absolute);
        }
    }
});

/**
 * public_html/assets/<module> is a symlink to Modules/<Module>/public, so the asset is served from
 * there. The action used to copy resources/ into public_html on every request and failed with
 * "Failed to open stream" when the link was missing or checked out as a plain file
 * (git core.symlinks=false). It must now only resolve the URL and write nothing.
 */
it('resolves a module asset to its public url without copying anything into public', function (): void {
    $moduleRoot = sys_get_temp_dir().'/xot_mod_'.uniqid('', true);
    $resourceFile = $moduleRoot.'/resources/css/style.css';
    mkdir(\dirname($resourceFile), 0o755, true);
    file_put_contents($resourceFile, 'body{}');

    $dest = public_path('assets/XotAssetTest/css/style.css');

    app()->instance(GetModulePathAction::class, new class($moduleRoot) extends GetModulePathAction
    {
        public function __construct(private string $modulePath) {}

        public function execute(string $module): string
        {
            return $this->modulePath;
        }
    });

    try {
        $result = app(AssetAction::class)->execute('XotAssetTest::css/style.css');
        Assert::assertStringContainsString('assets/xotassettest/css/style.css', $result);
        Assert::assertFileDoesNotExist($dest, 'the asset must be served through the symlink, never copied');
    } finally {
        if (is_file($resourceFile)) {
            unlink($resourceFile);
        }
    }
});

it('does not throw when public assets dir is a plain file left by a checkout without symlinks', function (): void {
    $moduleRoot = sys_get_temp_dir().'/xot_mod_'.uniqid('', true);
    $publicFile = $moduleRoot.'/public/css/style.css';
    mkdir(\dirname($publicFile), 0o755, true);
    file_put_contents($publicFile, 'body{}');

    $standIn = public_path('assets/xotstandintest'); // link in minuscolo, come gli URL
    file_put_contents($standIn, '../../laravel/Modules/XotStandInTest/public');

    app()->instance(GetModulePathAction::class, new class($moduleRoot) extends GetModulePathAction
    {
        public function __construct(private string $modulePath) {}

        public function execute(string $module): string
        {
            return $this->modulePath;
        }
    });

    try {
        $result = app(AssetAction::class)->execute('XotStandInTest::css/style.css');
        Assert::assertStringContainsString('assets/xotstandintest/css/style.css', $result);
        Assert::assertTrue(is_file($standIn), 'the stand-in file must be left untouched');
    } finally {
        foreach ([$standIn, $publicFile] as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
});

it('calculates asset path correctly in AssetPathAction', function (): void {
    Module::partialMock()
        ->shouldReceive('getModulePath')
        ->with('User')
        ->andReturn('/path/to/User/');

    $action = app(AssetPathAction::class);
    $result = $action->execute('User::js/app.js');

    Assert::assertSame('/path/to/User/resources/js/app.js', $result);
});

it('resolves a public URL path to a file under the document root', function (): void {
    $action = app(AssetPathAction::class);

    Assert::assertSame(public_path('themes/Trattoria/images/logo.svg'), $action->execute('/themes/Trattoria/images/logo.svg?v=2'));
    Assert::assertSame(public_path('images/logo.png'), $action->execute('images/logo.png'));
});
