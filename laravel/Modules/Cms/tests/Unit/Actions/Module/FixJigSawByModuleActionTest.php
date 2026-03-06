<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Actions\Module\FixJigSawByModuleAction;
use Nwidart\Modules\Laravel\Module;

test('FixJigSawByModuleAction can be instantiated', function () {
    $action = new FixJigSawByModuleAction();

    expect($action)->toBeInstanceOf(FixJigSawByModuleAction::class);
});

test('FixJigSawByModuleAction execute with real stubs returns array', function () {
    // Create a mock module that points to real stubs directory
    $module = Mockery::mock(Module::class);
    $module->shouldReceive('getName')->andReturn('Cms');
    $module->shouldReceive('getPath')->andReturn('/var/www/_bases/base_laravelpizza/laravel/Modules/Cms/app');

    $action = new FixJigSawByModuleAction();
    $result = $action->execute($module);

    expect($result)->toBeArray();
    expect(count($result))->toBeGreaterThan(0);
});

test('FixJigSawByModuleAction execute creates files in module docs directory', function () {
    // Create a real temporary directory
    $tempModulePath = sys_get_temp_dir().'/test_module_'.uniqid();
    $docsPath = $tempModulePath.'/docs';
    mkdir($docsPath, 0755, true);

    // Create a mock module that returns the temp path
    $module = Mockery::mock(Module::class);
    $module->shouldReceive('getName')->andReturn('TestModule');
    $module->shouldReceive('getPath')->andReturn($tempModulePath);

    $action = new FixJigSawByModuleAction();
    $result = $action->execute($module);

    expect($result)->toBeArray();
    expect(count($result))->toBeGreaterThan(0);

    // Verify files were created
    foreach ($result as $filePath) {
        expect(file_exists($filePath))->toBeTrue();
        @unlink($filePath);
    }

    // Cleanup
    @rmdir($docsPath);
    @rmdir($tempModulePath);
});

test('FixJigSawByModuleAction publish replaces ModuleName placeholder', function () {
    $action = new FixJigSawByModuleAction();

    // Use stub file that contains ModuleName placeholder
    $stubPath = '/var/www/_bases/base_laravelpizza/laravel/Modules/Cms/app/Console/Commands/stubs/docs/config.php.stub';

    $stubFile = new Symfony\Component\Finder\SplFileInfo($stubPath, 'docs/config.php.stub', 'config.php.stub');

    // Create a mock module with real temp directory
    $modulePath = sys_get_temp_dir().'/test_module_pub_'.uniqid();
    $docsPath = $modulePath.'/docs';
    mkdir($modulePath, 0755, true);
    mkdir($docsPath, 0755, true);

    $module = Mockery::mock(Module::class);
    $module->shouldReceive('getName')->andReturn('TestModule');
    $module->shouldReceive('getPath')->andReturn($modulePath);

    $result = $action->publish($stubFile, $module);

    expect($result)->toBeString();
    expect(file_exists($result))->toBeTrue();

    // Verify the content was replaced correctly
    $content = file_get_contents($result);
    expect($content)->toContain('TestModule');
    expect($content)->not->toContain('ModuleName');

    // Cleanup
    @unlink($result);
    @rmdir($docsPath);
    @rmdir($modulePath);
});
