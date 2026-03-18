<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Tenant\Models\Tenant;
use Modules\UI\Models\Asset;
use Modules\User\Models\User;
use Modules\Xot\Models\Module;

uses(TestCase::class)->in(__DIR__);

it('can create a test user', function () {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
});

it('can create a test tenant', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
    ]);

    expect($tenant)->toBeInstanceOf(Tenant::class);
    expect($tenant->name)->toBe('Test Tenant');
    expect($tenant->domain)->toBe('test.example.com');
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

it('can run module migrations', function () {
    $this->artisan('migrate', ['--env' => 'testing', '--force' => true]);
});

it('can create a test asset', function () {
    $asset = Asset::factory()->create([
        'name' => 'Test Asset',
        'path' => '/test/path',
    ]);

    expect($asset)->toBeInstanceOf(Asset::class);
    expect($asset->name)->toBe('Test Asset');
    expect($asset->path)->toBe('/test/path');
});
