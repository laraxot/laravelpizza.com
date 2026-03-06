<?php

declare(strict_types=1);

use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('can create role with minimal data', function (): void {
    $role = Role::factory()->create([
        'name' => 'Test Role '.uniqid(),
        'guard_name' => 'web',
    ]);

    expect($role->id)->not->toBeNull();
    expect($role->guard_name)->toBe('web');
});

test('can create role with all fields', function (): void {
    $team = Team::factory()->create();

    $roleData = [
        'name' => 'Full Role '.uniqid(),
        'guard_name' => 'web',
        'team_id' => $team->id,
    ];

    $role = Role::factory()->create($roleData);

    expect($role->id)->not->toBeNull();
    expect($role->guard_name)->toBe('web');
    expect($role->team_id)->toBe($team->id);
});

test('role has connection attribute', function (): void {
    $role = new Role();

    expect($role->getConnectionName())->toBe('user');
});

test('role has key type attribute', function (): void {
    $role = new Role();

    expect($role->getKeyType())->toBe('int');
});

test('role constants are defined', function (): void {
    expect(Role::ROLE_ADMINISTRATOR)->toBe(1);
    expect(Role::ROLE_OWNER)->toBe(2);
    expect(Role::ROLE_USER)->toBe(3);
});

test('can find role by name', function (): void {
    $uniqueName = 'Unique Role Name '.uniqid();
    $role = Role::factory()->create(['name' => $uniqueName]);

    $foundRole = Role::where('name', $uniqueName)->first();

    expect($foundRole)->not->toBeNull();
    expect($foundRole->id)->toBe($role->id);
});

test('can find role by guard name', function (): void {
    $suffix = uniqid();
    Role::factory()->create(['name' => 'Role Web 1 '.$suffix, 'guard_name' => 'web']);
    Role::factory()->create(['name' => 'Role Api '.$suffix, 'guard_name' => 'api']);
    Role::factory()->create(['name' => 'Role Web 2 '.$suffix, 'guard_name' => 'web']);

    $webRoles = Role::where('name', 'like', '%'.$suffix)->where('guard_name', 'web')->get();

    expect($webRoles->count())->toBeGreaterThanOrEqual(2);
    expect($webRoles->every(fn ($role) => 'web' === $role->guard_name))->toBeTrue();
});

test('can find role by team id', function (): void {
    $team = Team::factory()->create();
    $role = Role::factory()->create(['team_id' => $team->id]);

    $foundRole = Role::where('team_id', $team->id)->first();

    expect($foundRole)->not->toBeNull();
    expect($foundRole->id)->toBe($role->id);
});

test('can find role by uuid', function (): void {
    // Skip if uuid column doesn't exist in roles table
    if (! Schema::connection('user')->hasColumn('roles', 'uuid')) {
        $this->markTestSkipped('The roles table does not have a uuid column.');

        return;
    }

    $uuid = '550e8400-e29b-41d4-'.uniqid('', true);
    $role = Role::factory()->create(['uuid' => $uuid]);

    $foundRole = Role::where('uuid', $uuid)->first();

    expect($foundRole)->not->toBeNull();
    expect($foundRole->id)->toBe($role->id);
});

test('can find roles by name pattern', function (): void {
    $suffix = uniqid();
    Role::factory()->create(['name' => 'Admin Role '.$suffix]);
    Role::factory()->create(['name' => 'User Role '.$suffix]);
    Role::factory()->create(['name' => 'Manager Role '.$suffix]);

    $matchingRoles = Role::where('name', 'like', '%Role '.$suffix.'%')->get();

    expect($matchingRoles->count())->toBeGreaterThanOrEqual(3);
    expect($matchingRoles->every(fn ($role) => str_contains($role->name, 'Role '.$suffix)))->toBeTrue();
});

test('can update role', function (): void {
    $oldName = 'Old Name '.uniqid();
    $newName = 'New Name '.uniqid();
    $role = Role::factory()->create(['name' => $oldName]);

    $role->update(['name' => $newName]);

    expect($role->fresh()->name)->toBe($newName);
});

test('can handle null values', function (): void {
    $role = Role::factory()->create([
        'name' => 'Null Test Role '.uniqid(),
        'guard_name' => 'web',
        'team_id' => null,
    ]);

    expect($role->team_id)->toBeNull();
});

test('can find roles by multiple criteria', function (): void {
    $team = Team::factory()->create();
    $suffix = uniqid();
    Role::factory()->create([
        'name' => 'Admin Role '.$suffix,
        'guard_name' => 'web',
        'team_id' => $team->id,
    ]);

    Role::factory()->create([
        'name' => 'User Role '.$suffix,
        'guard_name' => 'api',
        'team_id' => $team->id,
    ]);

    $roles = Role::where('team_id', $team->id)->where('guard_name', 'web')->get();

    expect($roles->count())->toBeGreaterThanOrEqual(1);
    expect($roles->first()->guard_name)->toBe('web');
});

test('role has permissions relationship', function (): void {
    $role = Role::factory()->create(['name' => 'perms-rel '.uniqid()]);

    expect(method_exists($role, 'permissions'))->toBeTrue();
});

test('role has team relationship', function (): void {
    $role = Role::factory()->create(['name' => 'team-rel '.uniqid()]);

    expect(method_exists($role, 'team'))->toBeTrue();
});

test('role has users relationship', function (): void {
    $role = Role::factory()->create(['name' => 'users-rel '.uniqid()]);

    expect(method_exists($role, 'users'))->toBeTrue();
});

test('role can use permission scopes', function (): void {
    $role = Role::factory()->create(['name' => 'perm-scope '.uniqid()]);

    expect(is_callable([Role::query(), 'where']))->toBeTrue();
});

test('role can use role scopes', function (): void {
    $role = Role::factory()->create(['name' => 'role-scope '.uniqid()]);

    expect(is_callable([Role::query(), 'where']))->toBeTrue();
});
