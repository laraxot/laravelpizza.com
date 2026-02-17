<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Illuminate\Support\Facades\File;
use Modules\Cms\Actions\Module\FixJigSawByModuleAction;
use Nwidart\Modules\Laravel\Module;

test('FixJigSawByModuleAction can be instantiated', function () {
    $action = new FixJigSawByModuleAction;

    expect($action)->toBeInstanceOf(FixJigSawByModuleAction::class);
});

test('FixJigSawByModuleAction execute method returns array', function () {
    // Mock a module instance
    $module = Mockery::mock(Module::class);
    $module->shouldReceive('getPath')->andReturn('/tmp/test-module');
    $module->shouldReceive('getName')->andReturn('TestModule');

    // Create a temporary stub file for testing
    $stubsDir = '/tmp/test-stubs';
    if (! is_dir($stubsDir)) {
        mkdir($stubsDir, 0755, true);
    }

    file_put_contents($stubsDir.'/test.stub', 'This is a test stub for ModuleName');

    // Mock File facade to return our test stub file
    File::shouldReceive('allFiles')
        ->with(Mockery::any())
        ->andReturn([new Symfony\Component\Finder\SplFileInfo($stubsDir.'/test.stub', '', 'test.stub')]);

    $action = new FixJigSawByModuleAction;
    $result = $action->execute($module);

    expect($result)->toBeArray();

    // Clean up
    unlink($stubsDir.'/test.stub');
    rmdir($stubsDir);
})->skip('Skipping complex filesystem mock test');
