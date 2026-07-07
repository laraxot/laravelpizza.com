<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Webmozart\Assert\Assert as WebmozartAssert;

uses(TestCase::class);

it('can create a tenant', function (): void {
    $tenant = createTenant([
        'name' => 'Test Company',
        'domain' => 'test.company.com',
        'database' => 'tenant_test_db',
    ]);

    expect($tenant)->toBeInstanceOf(Tenant::class);
    expect($tenant->name)->toBe('Test Company');
    expect($tenant->domain)->toBe('test.company.com');
    expect($tenant->database)->toBe('tenant_test_db');
});

it('can create a tenant with settings', function (): void {
    $tenant = createTenant([
        'name' => 'Settings Tenant',
        'domain' => 'settings.example.com',
        'settings' => ['locale' => 'it', 'timezone' => 'Europe/Rome'],
    ]);

    expect($tenant->settings)->toBeArray();
    expect($tenant->settings['locale'] ?? null)->toBe('it');
});

it('exposes users relationship', function (): void {
    $tenant = createTenant([
        'name' => 'User Tenant',
        'domain' => 'user.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
    $user = $userFactory->createOne([
        'name' => 'Tenant User',
        'email' => 'user@tenant.example.com',
    ]);
    WebmozartAssert::isInstanceOf($user, User::class);

    $tenant->users()->save($user);

    expect($tenant->users()->whereKey($user->id)->exists())->toBeTrue();
});

it('can create multiple users for a tenant', function (): void {
    $tenant = createTenant([
        'name' => 'Multi User Tenant',
        'domain' => 'multi.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
    $users = $userFactory->count(3)->create();
    foreach ($users->all() as $user) {
        $tenant->users()->save($user);
    }

    expect($tenant->users()->count())->toBe(3);
});

it('reports active state via isActive', function (): void {
    $active = createTenant(['is_active' => true]);
    $inactive = createTenant(['is_active' => false]);

    expect($active->isActive())->toBeTrue();
    expect($inactive->isActive())->toBeFalse();
});
