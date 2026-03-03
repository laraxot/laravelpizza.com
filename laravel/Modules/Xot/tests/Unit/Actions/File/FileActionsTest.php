<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Actions\File\ViewPathAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Actions\File\GetModulePathAction;
use Modules\Xot\Actions\File\AssetAction;
use Tests\TestCase;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;

uses(TestCase::class);

test('fix path action works', function () {
    $action = app(FixPathAction::class);
    $path = 'some/path\with/mixed\slashes';
    $expected = str_replace(['/', ''], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $path);
    expect($action->execute($path))->toBe($expected);
});

test('view path action works', function () {
    $this->mock(GetViewNameSpacePathAction::class)
        ->shouldReceive('execute')
        ->with('test_ns')
        ->andReturn('/view/path');
        
    $action = app(ViewPathAction::class);
    $result = $action->execute('test_ns::folder.view');
    
    $expected = '/view/path/folder/view.blade.php';
    $expected = str_replace(['/', ''], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $expected);
    
    expect($result)->toBe($expected);
});

test('asset path action works', function () {
    Module::shouldReceive('getModulePath')
        ->with('test_module')
        ->andReturn('/module/path/');
        
    $action = app(AssetPathAction::class);
    expect($action->execute('test_module::css/style.css'))->toBe('/module/path/resources/css/style.css');
});

test('asset action handles absolute urls', function () {
    $action = app(AssetAction::class);
    expect($action->execute('https://example.com/asset.js'))->toBe('https://example.com/asset.js');
});

test('asset action returns path if exists in public', function () {
    $path = 'css/existing.css';
    // We cannot easily mock public_path() to return a path that File::exists recognizes as true 
    // without creating the actual file if we don't mock File facade completely.
    File::shouldReceive('exists')
        ->with(public_path($path))
        ->andReturn(true);
        
    $action = app(AssetAction::class);
    expect($action->execute($path))->toBe($path);
});
