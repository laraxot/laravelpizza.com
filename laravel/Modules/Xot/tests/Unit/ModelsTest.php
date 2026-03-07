<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

it('can create a test user', function () {
    $user = \Modules\User\Models\User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    expect($user)->toBeInstanceOf(\Modules\User\Models\User::class);
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
});

it('can create a test tenant', function () {
    $tenant = \Modules\Tenant\Models\Tenant::factory()->create([
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
    ]);

    expect($tenant)->toBeInstanceOf(\Modules\Tenant\Models\Tenant::class);
    expect($tenant->name)->toBe('Test Tenant');
    expect($tenant->domain)->toBe('test.example.com');
});

it('can create a test module', function () {
    $module = \Modules\Xot\Models\Module::factory()->create([
        'name' => 'TestModule',
        'enabled' => true,
    ]);

    expect($module)->toBeInstanceOf(\Modules\Xot\Models\Module::class);
    expect($module->name)->toBe('TestModule');
    expect($module->enabled)->toBeTrue();
});

it('can run module migrations', function () {
    $this->artisan('migrate', ['--env' => 'testing', '--force' => true])->assertExitCode(0);
});

it('can create a test asset', function () {
    $asset = \Modules\UI\Models\Asset::factory()->create([
        'name' => 'Test Asset',
        'path' => '/test/path',
    ]);

    expect($asset)->toBeInstanceOf(\Modules\UI\Models\Asset::class);
    expect($asset->name)->toBe('Test Asset');
    expect($asset->path)->toBe('/test/path');
});
