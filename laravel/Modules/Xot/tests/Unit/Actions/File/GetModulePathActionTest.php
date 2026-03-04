<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\GetModulePathAction;
use Modules\Xot\Tests\TestCase;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;

uses(TestCase::class);

it('gets module path from facade correctly', function (): void {
    Module::shouldReceive('getModulePath')
        ->once()
        ->with('Xot')
        ->andReturn('/path/to/Xot/');

    $action = app(GetModulePathAction::class);
    $result = $action->execute('Xot');

    expect($result)->toBe('/path/to/Xot/');
});

it('gets module path from fallback correctly', function (): void {
    Module::shouldReceive('getModulePath')
        ->once()
        ->andThrow(new \Exception('Module not found'));

    // We assume Modules directory exists in base_path
    $modulesPath = base_path('Modules');
    if (!File::exists($modulesPath)) {
        File::makeDirectory($modulesPath);
    }
    
    // Create a dummy module dir
    $dummyModule = $modulesPath . '/TestModule';
    if (!File::exists($dummyModule)) {
        File::makeDirectory($dummyModule);
    }

    $action = app(GetModulePathAction::class);
    // Case-insensitive search
    $result = $action->execute('testmodule');

    expect($result)->toBe($dummyModule);
    
    File::deleteDirectory($dummyModule);
});
