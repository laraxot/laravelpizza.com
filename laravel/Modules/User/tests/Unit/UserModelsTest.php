<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

it('can create a user with basic attributes', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password123'),
    ]);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@example.com');
    expect($user->exists)->toBeTrue();
});

it('can create a user with profile', function () {
    $user = User::factory()->withProfile()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    expect($user->profile)->toBeInstanceOf(\Modules\User\Models\Profile::class);
    expect($user->profile->user_id)->toBe($user->id);
});

it('can authenticate a user', function () {
    $user = User::factory()->create([
        'email' => 'auth@example.com',
        'password' => bcrypt('secret123'),
    ]);

    $this->assertTrue(auth(
        'email' => 'auth@example.com',
        'password' => 'secret123',
    ]));
});

it('can create a user role', function () {
    $role = \Modules\User\Models\Role::factory()->create([
        'name' => 'admin',
        'guard_name' => 'web',
    ]);

    expect($role)->toBeInstanceOf(\Modules\User\Models\Role::class);
    expect($role->name)->toBe('admin');
});

it('can create a user permission', function () {
    $permission = \Modules\User\Models\Permission::factory()->create([
        'name' => 'edit_posts',
        'guard_name' => 'web',
    ]);

    expect($permission)->toBeInstanceOf(\Modules\User\Models\Permission::class);
    expect($permission->name)->toBe('edit_posts');
});

it('can assign role to user', function () {
    $user = User::factory()->create();
    $role = \Modules\User\Models\Role::factory()->create([
        'name' => 'editor',
        'guard_name' => 'web',
    ]);

    $user->assignRole($role);

    expect($user->hasRole('editor'))->toBeTrue();
});

it('can attach permission to user', function () {
    $user = User::factory()->create();
    $permission = \Modules\User\Models\Permission::factory()->create([
        'name' => 'delete_users',
        'guard_name' => 'web',
    ]);

    $user->givePermissionTo($permission);

    expect($user->can('delete_users'))->toBeTrue();
});

it('can create a tenant user', function () {
    $tenant = \Modules\Tenant\Models\Tenant::factory()->create([
        'name' => 'Test Tenant',
        'domain' => 'tenant.example.com',
    ]);

    $user = User::factory()->forTenant($tenant)->create([
        'name' => 'Tenant User',
        'email' => 'tenant@example.com',
    ]);

    expect($user->tenant_id)->toBe($tenant->id);
    expect($user->tenant->name)->toBe('Test Tenant');
});

it('can create a user with socialite data', function () {
    $user = User::factory()->create([
        'name' => 'Social User',
        'email' => 'social@example.com',
    ]);

    $user->socialite()->create([
        'provider' => 'google',
        'provider_id' => 'google_12345',
        'token' => 'google_token',
    ]);

    expect($user->socialite->first())->toBeInstanceOf(\Modules\User\Models\Socialite::class);
    expect($user->socialite->first()->provider)->toBe('google');
});
