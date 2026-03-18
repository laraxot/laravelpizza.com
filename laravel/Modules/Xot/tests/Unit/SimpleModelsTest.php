<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\UI\Models\Asset;
use Modules\Xot\Models\Module;

uses(TestCase::class)->in(__DIR__);

it('can create a test asset', function () {
    $asset = Asset::factory()->create([
        'name' => 'Test Asset',
        'path' => '/test/path',
    ]);

    expect($asset)->toBeInstanceOf(Asset::class);
    expect($asset->name)->toBe('Test Asset');
    expect($asset->path)->toBe('/test/path');
});

it('can create a test module', function () {
    $module = Module::factory()->create([
        'name' => 'TestModule',
        'enabled' => true,
    ]);

    expect($module)->toBeInstanceOf(Module::class);
    expect($module->name)->toBe('TestModule');
    expect($module->enabled)->toBeTrue();
});

it('can run migrations', function () {
    $this->artisan('migrate', ['--env' => 'testing', '--force' => true]);
});
