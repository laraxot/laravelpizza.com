<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Actions\File\ViewPathAction;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

test('fix path action works', function (): void {
    $action = app(FixPathAction::class);
    $path = 'some/path/with/mixed/slashes';
    $expected = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $path);
    Assert::assertSame($expected, $action->execute($path));
});

test('view path action works', function (): void {
    $mock = Mockery::mock(GetViewNameSpacePathAction::class);
    /* @phpstan-ignore-next-line Mockery expectation chain not resolvable without extension */
    $mock->shouldReceive('execute')->with('test_ns')->andReturn('/view/path');

    app()->instance(GetViewNameSpacePathAction::class, $mock);

    $action = app(ViewPathAction::class);
    $result = $action->execute('test_ns::folder.view');

    $expected = '/view/path/folder/view.blade.php';
    $expected = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $expected);

    Assert::assertSame($expected, $result);
});

test('asset path action works', function (): void {
    Module::shouldReceive('getModulePath')
        ->with('test_module')
        ->andReturn('/module/path/');

    $action = app(AssetPathAction::class);
    Assert::assertSame('/module/path/resources/css/style.css', $action->execute('test_module::css/style.css'));
});

test('asset action handles absolute urls', function (): void {
    $action = app(AssetAction::class);
    Assert::assertSame('https://example.com/asset.js', $action->execute('https://example.com/asset.js'));
});
