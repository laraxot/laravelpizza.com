<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\GetModulePathAction;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

it('gets module path from facade correctly', function (): void {
    /* @var \Modules\Xot\Tests\TestCase $this */
    Module::shouldReceive('getModulePath')
        ->once()
        ->with('Xot')
        ->andReturn('/path/to/Xot/');

    $action = app(GetModulePathAction::class);
    $result = $action->execute('Xot');

    Assert::assertSame('/path/to/Xot/', $result);
});

it('gets module path from fallback correctly', function (): void {
    /* @var \Modules\Xot\Tests\TestCase $this */
    Module::shouldReceive('getModulePath')
        ->once()
        ->andThrow(new Exception('Module not found'));

    // We assume Modules directory exists in base_path
    $modulesPath = base_path('Modules');
    if (! File::exists($modulesPath)) {
        File::makeDirectory($modulesPath);
    }

    // Create a dummy module dir
    $dummyModule = $modulesPath.'/TestModule';
    if (! File::exists($dummyModule)) {
        File::makeDirectory($dummyModule);
    }

    $action = app(GetModulePathAction::class);
    // Case-insensitive search
    $result = $action->execute('testmodule');

    Assert::assertSame($dummyModule, $result);
    File::deleteDirectory($dummyModule);
});
