<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->role = Role::factory()->create([
        'name' => 'test-role',
        'guard_name' => 'web',
    ]);
});

test('role can be created', function (): void {
    expect($this->role)->toBeInstanceOf(Role::class);
    expect($this->role->name)->toBe('test-role');
    expect($this->role->guard_name)->toBe('web');
});

test('role has correct constants', function (): void {
    expect(Role::ROLE_ADMINISTRATOR)->toBe(1);
    expect(Role::ROLE_OWNER)->toBe(2);
    expect(Role::ROLE_USER)->toBe(3);
});

test('role has correct table configuration', function (): void {
    $table = $this->role->getTable();

    expect($table)->toBeString();
    expect($table)->not->toBeEmpty();
});

test('role has correct casts', function (): void {
    $casts = $this->role->getCasts();

    expect($casts)->toHaveKey('id');
    expect($casts)->toHaveKey('uuid');
    expect($casts)->toHaveKey('name');
    expect($casts)->toHaveKey('guard_name');
    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');

    expect($casts['id'])->toBe('string');
    expect($casts['uuid'])->toBe('string');
    expect($casts['name'])->toBe('string');
    expect($casts['guard_name'])->toBe('string');
    expect($casts['created_at'])->toBe('datetime');
    expect($casts['updated_at'])->toBe('datetime');
});

test('role can be updated', function (): void {
    $this->role->update([
        'name' => 'updated-role',
        'guard_name' => 'api',
    ]);

    $this->role->refresh();

    expect($this->role->name)->toBe('updated-role');
    expect($this->role->guard_name)->toBe('api');
});

test('role can be deleted', function (): void {
    $roleId = $this->role->id;

    $this->role->delete();

    expect(Role::find($roleId))->toBeNull();
});

test('role can have permissions', function (): void {
    $permission = Permission::factory()->create([
        'name' => 'test-permission',
        'guard_name' => 'web',
    ]);

    $this->role->givePermissionTo($permission);

    expect($this->role->hasPermissionTo($permission))->toBeTrue();
    expect($this->role->permissions)->toHaveCount(1);
});

test('role can have multiple permissions', function (): void {
    $permission1 = Permission::factory()->create(['name' => 'permission-1']);
    $permission2 = Permission::factory()->create(['name' => 'permission-2']);

    $this->role->syncPermissions([$permission1, $permission2]);

    expect($this->role->permissions)->toHaveCount(2);
    expect($this->role->hasPermissionTo($permission1))->toBeTrue();
    expect($this->role->hasPermissionTo($permission2))->toBeTrue();
});

test('role can revoke permissions', function (): void {
    $permission = Permission::factory()->create(['name' => 'test-permission']);

    $this->role->givePermissionTo($permission);
    expect($this->role->hasPermissionTo($permission))->toBeTrue();

    $this->role->revokePermissionTo($permission);
    expect($this->role->hasPermissionTo($permission))->toBeFalse();
});

test('role can be found by name', function (): void {
    $foundRole = Role::where('name', 'test-role')->first();

    expect($foundRole)->toBeInstanceOf(Role::class);
    expect($foundRole->id)->toBe($this->role->id);
});

test('role can be found by guard', function (): void {
    $webRoles = Role::where('guard_name', 'web')->get();

    expect($webRoles)->toHaveCount(1);
    expect($webRoles->first()->id)->toBe($this->role->id);
});

test('role has timestamps', function (): void {
    expect($this->role->created_at)->not->toBeNull();
    expect($this->role->updated_at)->not->toBeNull();
});

test('role can be created with factory', function (): void {
    $role = Role::factory()->create();

    expect($role)->toBeInstanceOf(Role::class);
    expect($role->name)->not->toBeEmpty();
    expect($role->guard_name)->not->toBeEmpty();
});

test('role can be created with specific attributes', function (): void {
    $role = Role::factory()->create([
        'name' => 'custom-role',
        'guard_name' => 'custom-guard',
    ]);

    expect($role->name)->toBe('custom-role');
    expect($role->guard_name)->toBe('custom-guard');
});

test('role can check if it has any permissions', function (): void {
    expect($this->role->hasAnyPermission([]))->toBeFalse();

    $permission = Permission::factory()->create(['name' => 'test-permission']);
    $this->role->givePermissionTo($permission);

    expect($this->role->hasAnyPermission([$permission]))->toBeTrue();
});

test('role can check if it has all permissions', function (): void {
    $permission1 = Permission::factory()->create(['name' => 'permission-1']);
    $permission2 = Permission::factory()->create(['name' => 'permission-2']);

    $this->role->syncPermissions([$permission1, $permission2]);

    expect($this->role->hasAllPermissions([$permission1, $permission2]))->toBeTrue();
    expect($this->role->hasAllPermissions([$permission1]))->toBeTrue();
    expect($this->role->hasAllPermissions([$permission1, $permission2, 'non-existent']))->toBeFalse();
});
