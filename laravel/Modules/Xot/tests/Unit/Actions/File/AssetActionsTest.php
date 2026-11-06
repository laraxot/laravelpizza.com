<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Actions\File\GetModulePathAction;
use Modules\Xot\Tests\TestCase;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\chmod;
use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\fileinode;
use function Safe\filemtime;
use function Safe\glob;
use function Safe\mkdir;
use function Safe\touch;
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

it('publishes module asset to public assets path', function (): void {
    $moduleRoot = sys_get_temp_dir().'/xot_mod_'.uniqid('', true);
    $resourceFile = $moduleRoot.'/resources/css/style.css';
    mkdir(\dirname($resourceFile), 0o755, true);
    file_put_contents($resourceFile, 'body{}');

    $dest = public_path('assets/XotAssetTest/css/style.css');
    if (is_file($dest)) {
        unlink($dest);
    }

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
        Assert::assertStringContainsString('assets/XotAssetTest/css/style.css', $result);
        Assert::assertFileExists($dest);
    } finally {
        if (is_file($dest)) {
            unlink($dest);
        }
        if (is_file($resourceFile)) {
            unlink($resourceFile);
        }
    }
});

it('keeps published dest when force-copy fails (best-effort via copyAsset)', function (): void {
    $from = sys_get_temp_dir().'/xot_asset_from_'.uniqid('', true).'.bin';
    $to = sys_get_temp_dir().'/xot_asset_to_'.uniqid('', true).'.bin';
    file_put_contents($from, 'source-bytes');
    file_put_contents($to, 'dest-already-published');
    chmod($to, 0444);

    try {
        $action = app(AssetAction::class);
        $method = new ReflectionMethod(AssetAction::class, 'copyAsset');
        $method->invoke($action, $from, $to, 'assets/demo/icon.png', true);

        Assert::assertFileExists($to);
        Assert::assertSame('dest-already-published', file_get_contents($to));
    } finally {
        chmod($to, 0644);
        if (is_file($from)) {
            unlink($from);
        }
        if (is_file($to)) {
            unlink($to);
        }
    }
});

it('skips force-copy when destination exists but is not writable', function (): void {
    $from = sys_get_temp_dir().'/xot_asset_from_'.uniqid('', true).'.bin';
    $to = sys_get_temp_dir().'/xot_asset_to_'.uniqid('', true).'.bin';
    file_put_contents($from, 'new-source');
    file_put_contents($to, 'keep-me');
    chmod($to, 0444);

    try {
        $action = app(AssetAction::class);
        $method = new ReflectionMethod(AssetAction::class, 'copyAsset');
        $method->invoke($action, $from, $to, 'assets/demo/icon.png', true);

        Assert::assertSame('keep-me', file_get_contents($to));
    } finally {
        chmod($to, 0644);
        if (is_file($from)) {
            unlink($from);
        }
        if (is_file($to)) {
            unlink($to);
        }
    }
});

/*
 * Outside production every request force-copies the asset (story 5.180). A plain copy()
 * truncates the public file before writing it: a browser fetching the logo in that
 * window gets an empty PNG (measured 2026-09-29: 11787 truncated reads out of 20000
 * with 4 concurrent writers, 0 with temp file + rename).
 */
it('does not rewrite an up-to-date destination on force-copy', function (): void {
    $from = sys_get_temp_dir().'/xot_asset_from_'.uniqid('', true).'.bin';
    $to = sys_get_temp_dir().'/xot_asset_to_'.uniqid('', true).'.bin';
    file_put_contents($from, 'same-bytes');
    file_put_contents($to, 'same-bytes');
    $publishedAt = time() - 100;
    touch($from, $publishedAt - 100);
    touch($to, $publishedAt);
    clearstatcache();

    try {
        $action = app(AssetAction::class);
        $method = new ReflectionMethod(AssetAction::class, 'copyAsset');
        $method->invoke($action, $from, $to, 'assets/demo/logo.png', true);

        clearstatcache();
        Assert::assertSame($publishedAt, filemtime($to), 'an identical destination must not be rewritten');
    } finally {
        foreach ([$from, $to] as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
});

it('replaces a stale destination atomically, never truncating it in place', function (): void {
    $from = sys_get_temp_dir().'/xot_asset_from_'.uniqid('', true).'.bin';
    $to = sys_get_temp_dir().'/xot_asset_to_'.uniqid('', true).'.bin';
    file_put_contents($from, 'new-logo-bytes');
    file_put_contents($to, 'old');
    touch($to, time() - 200);
    touch($from, time() - 100);
    clearstatcache();
    $inodeBefore = fileinode($to);

    try {
        $action = app(AssetAction::class);
        $method = new ReflectionMethod(AssetAction::class, 'copyAsset');
        $method->invoke($action, $from, $to, 'assets/demo/logo.png', true);

        clearstatcache();
        Assert::assertSame('new-logo-bytes', file_get_contents($to));
        Assert::assertNotSame($inodeBefore, fileinode($to), 'the destination must be swapped by rename(), not rewritten in place');
        Assert::assertSame([], glob($to.'.*.tmp'), 'no temporary file may be left behind');
    } finally {
        foreach ([$from, $to] as $file) {
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
