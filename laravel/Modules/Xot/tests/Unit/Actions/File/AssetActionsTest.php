<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Actions\File\GetModulePathAction;
use Modules\Xot\Tests\TestCase;
use Nwidart\Modules\Facades\Module;

uses(TestCase::class);

it('handles absolute urls in AssetAction', function (): void {
    $action = app(AssetAction::class);
    $url = 'https://example.com/asset.js';
    expect($action->execute($url))->toBe($url);
});

it('returns path if asset already exists in public folder', function (): void {
    $path = 'css/app.css';
    File::shouldReceive('exists')->with(public_path($path))->andReturn(true);

    $action = app(AssetAction::class);
    expect($action->execute($path))->toBe($path);
});

it('resolves module assets correctly in AssetAction', function (): void {
    $path = 'Xot::css/style.css';
    $modulePath = '/var/www/Modules/Xot';
    $from = $modulePath.'/resources/css/style.css';
    $to = public_path('assets/Xot/css/style.css');

    // Mocks
    $this->mock(GetModulePathAction::class
        ->shouldReceive('execute')->with('Xot')->andReturn($modulePath);

    $this->mock(FixPathAction::class
        ->shouldReceive('execute')->andReturnArg(0);

    File::shouldReceive('exists')->with(public_path($path))->andReturn(false);
    File::shouldReceive('exists')->with($from)->andReturn(true);
    File::shouldReceive('exists')->with($to)->andReturn(true);
    // Since we are not in production, forceCopy will be true, we might need more mocks for copy
    File::shouldReceive('exists')->with(dirname($to))->andReturn(true);
    File::shouldReceive('copy')->once();

    $action = app(AssetAction::class);
    $result = $action->execute($path);

    expect($result)->toContain('assets/Xot/css/style.css');
});

it('calculates asset path correctly in AssetPathAction', function (): void {
    Module::shouldReceive('getModulePath')
        ->once()
        ->with('User')
        ->andReturn('/path/to/User/');

    $action = app(AssetPathAction::class);
    $result = $action->execute('User::js/app.js');

    expect($result)->toBe('/path/to/User/resources/js/app.js');
});
