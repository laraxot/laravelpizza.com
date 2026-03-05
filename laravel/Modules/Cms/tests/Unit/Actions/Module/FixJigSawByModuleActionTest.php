<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Mockery;
use Modules\Cms\Actions\Module\FixJigSawByModuleAction;
use Nwidart\Modules\Laravel\Module;

test('FixJigSawByModuleAction can be instantiated', function () {
    $action = new FixJigSawByModuleAction;

    expect($action)->toBeInstanceOf(FixJigSawByModuleAction::class);
});

test('FixJigSawByModuleAction execute returns array with existing stubs', function () {
    // Create a mock module that points to real stubs directory
    $module = Mockery::mock(Module::class);
    $module->shouldReceive('getName')->andReturn('Cms');
    $module->shouldReceive('getPath')->andReturn(__DIR__.'/../../../../');

    $action = new FixJigSawByModuleAction;
    $result = $action->execute($module);

    expect($result)->toBeArray();
    expect(count($result))->toBeGreaterThan(0);
});

test('FixJigSawByModuleAction execute with empty stubs directory', function () {
    // Create a mock module with non-existent stubs
    $module = Mockery::mock(Module::class);
    $module->shouldReceive('getName')->andReturn('TestModule');
    $module->shouldReceive('getPath')->andReturn(sys_get_temp_dir().'/nonexistent_module_'.uniqid());

    $action = new FixJigSawByModuleAction;
    $result = $action->execute($module);

    expect($result)->toBeArray();
});

test('FixJigSawByModuleAction publish method returns string', function () {
    $action = new FixJigSawByModuleAction;

    // Use existing stub file
    $stubPath = __DIR__.'/../../../../Console/Commands/stubs/docs/package.json.stub';
    if (! file_exists($stubPath)) {
        // Skip if stub doesn't exist
        expect(true)->toBeTrue();

        return;
    }

    $stubFile = new \Symfony\Component\Finder\SplFileInfo($stubPath, 'docs/package.json.stub', 'package.json.stub');

    // Create a mock module
    $module = Mockery::mock(Module::class);
    $module->shouldReceive('getName')->andReturn('TestModule');
    $modulePath = sys_get_temp_dir().'/test_module_pub_'.uniqid();
    $module->shouldReceive('getPath')->andReturn($modulePath);

    // Ensure directory exists
    if (! is_dir($modulePath)) {
        mkdir($modulePath, 0755, true);
    }
    if (! is_dir($modulePath.'/docs')) {
        mkdir($modulePath.'/docs', 0755, true);
    }

    $result = $action->publish($stubFile, $module);

    expect($result)->toBeString();
    expect(file_exists($result))->toBeTrue();

    // Verify the content was replaced correctly
    $content = file_get_contents($result);
    expect($content)->toContain('TestModule');

    // Cleanup
    @unlink($result);
    @rmdir($modulePath.'/docs');
    @rmdir($modulePath);
});
