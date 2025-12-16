<?php

declare(strict_types=1);

use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('can create role with minimal data', function (): void {
    $role = Role::factory()->create([
        'name' => 'Test Role',
        'guard_name' => 'web',
    ]);

    expect($role->id)->not->toBeNull();
    expect($role->name)->toBe('Test Role');
    expect($role->guard_name)->toBe('web');
});

test('can create role with all fields', function (): void {
    $team = Team::factory()->create();

    $roleData = [
        'name' => 'Full Role',
        'guard_name' => 'web',
        'team_id' => $team->id,
        'uuid' => '550e8400-e29b-41d4-a716-446655440000',
    ];

    $role = Role::factory()->create($roleData);

    expect($role->id)->not->toBeNull();
    expect($role->name)->toBe('Full Role');
    expect($role->guard_name)->toBe('web');
    expect($role->team_id)->toBe($team->id);
    expect($role->uuid)->toBe('550e8400-e29b-41d4-a716-446655440000');
});

test('role has connection attribute', function (): void {
    $role = new Role;

    expect($role->connection)->toBe('user');
});

test('role has key type attribute', function (): void {
    $role = new Role;

    expect($role->keyType)->toBe('string');
});

test('role constants are defined', function (): void {
    expect(Role::ROLE_ADMINISTRATOR)->toBe(1);
    expect(Role::ROLE_OWNER)->toBe(2);
    expect(Role::ROLE_USER)->toBe(3);
});

test('can find role by name', function (): void {
    $role = Role::factory()->create(['name' => 'Unique Role Name']);

    $foundRole = Role::where('name', 'Unique Role Name')->first();

    expect($foundRole)->not->toBeNull();
    expect($foundRole->id)->toBe($role->id);
});

test('can find role by guard name', function (): void {
    Role::factory()->create(['guard_name' => 'web']);
    Role::factory()->create(['guard_name' => 'api']);
    Role::factory()->create(['guard_name' => 'web']);

    $webRoles = Role::where('guard_name', 'web')->get();

    expect($webRoles->count())->toBeGreaterThanOrEqual(2);
    expect($webRoles->every(fn ($role) => $role->guard_name === 'web'))->toBeTrue();
});

test('can find role by team id', function (): void {
    $team = Team::factory()->create();
    $role = Role::factory()->create(['team_id' => $team->id]);

    $foundRole = Role::where('team_id', $team->id)->first();

    expect($foundRole)->not->toBeNull();
    expect($foundRole->id)->toBe($role->id);
});

test('can find role by uuid', function (): void {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $role = Role::factory()->create(['uuid' => $uuid]);

    $foundRole = Role::where('uuid', $uuid)->first();

    expect($foundRole)->not->toBeNull();
    expect($foundRole->id)->toBe($role->id);
});

test('can find roles by name pattern', function (): void {
    Role::factory()->create(['name' => 'Admin Role']);
    Role::factory()->create(['name' => 'User Role']);
    Role::factory()->create(['name' => 'Manager Role']);

    $adminRoles = Role::where('name', 'like', '%Role%')->get();

    expect($adminRoles->count())->toBeGreaterThanOrEqual(3);
    expect($adminRoles->every(fn ($role) => str_contains($role->name, 'Role')))->toBeTrue();
});

test('can update role', function (): void {
    $role = Role::factory()->create(['name' => 'Old Name']);

    $role->update(['name' => 'New Name']);

    expect($role->fresh()->name)->toBe('New Name');
});

test('can handle null values', function (): void {
    $role = Role::factory()->create([
        'name' => 'Test Role',
        'guard_name' => 'web',
        'team_id' => null,
        'uuid' => null,
    ]);

    expect($role->team_id)->toBeNull();
    expect($role->uuid)->toBeNull();
});

test('can find roles by multiple criteria', function (): void {
    $team = Team::factory()->create();
    Role::factory()->create([
        'name' => 'Admin Role',
        'guard_name' => 'web',
        'team_id' => $team->id,
    ]);

    Role::factory()->create([
        'name' => 'User Role',
        'guard_name' => 'api',
        'team_id' => $team->id,
    ]);

    $roles = Role::where('team_id', $team->id)->where('guard_name', 'web')->get();

    expect($roles->count())->toBeGreaterThanOrEqual(1);
    expect($roles->first()->name)->toBe('Admin Role');
    expect($roles->first()->guard_name)->toBe('web');
});

test('role has permissions relationship', function (): void {
    $role = Role::factory()->create();

    expect(method_exists($role, 'permissions'))->toBeTrue();
});

test('role has team relationship', function (): void {
    $role = Role::factory()->create();

    expect(method_exists($role, 'team'))->toBeTrue();
});

test('role has users relationship', function (): void {
    $role = Role::factory()->create();

    expect(method_exists($role, 'users'))->toBeTrue();
});

test('role can use permission scopes', function (): void {
    $role = Role::factory()->create();

    expect(method_exists($role, 'permission'))->toBeTrue();
    expect(method_exists($role, 'withoutPermission'))->toBeTrue();
});

test('role can use role scopes', function (): void {
    $role = Role::factory()->create();

    expect(method_exists($role, 'role'))->toBeTrue();
    expect(method_exists($role, 'withoutRole'))->toBeTrue();
});
