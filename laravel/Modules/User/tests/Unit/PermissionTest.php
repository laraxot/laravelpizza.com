<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    // Use uniqid() suffix so each test run creates a unique name,
    // avoiding UniqueConstraintViolationException when DatabaseTransactions
    // does not roll back the 'user' connection between tests.
    $suffix = uniqid('', true);
    $this->permissionName = 'test-permission-'.$suffix;
    $this->permission = Permission::factory()->create([
        'name' => $this->permissionName,
        'guard_name' => 'web',
    ]);
});

afterEach(function (): void {
    // Flush Spatie Permission cache so stale cached data does not
    // bleed between tests.
    app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
});

test('permission can be created', function (): void {
    expect($this->permission)->toBeInstanceOf(Permission::class);
    expect($this->permission->name)->toBe($this->permissionName);
    expect($this->permission->guard_name)->toBe('web');
});

test('permission has correct fillable attributes', function (): void {
    $fillable = $this->permission->getFillable();

    expect($fillable)->toContain('name');
    expect($fillable)->toContain('guard_name');
    expect($fillable)->toContain('display_name');
    expect($fillable)->toContain('description');
});

test('permission has correct table configuration', function (): void {
    $table = $this->permission->getTable();

    expect($table)->toBeString();
    expect($table)->not->toBeEmpty();
});

test('permission has correct casts', function (): void {
    $casts = $this->permission->getCasts();

    expect($casts)->toHaveKey('id');

    expect($casts['id'])->toBe('int'); // Spatie Permission uses int ID by default
});

test('permission can be updated', function (): void {
    $newName = 'updated-permission-'.uniqid('', true);
    $this->permission->update([
        'name' => $newName,
        'guard_name' => 'api',
    ]);

    $this->permission->refresh();

    expect($this->permission->name)->toBe($newName);
    expect($this->permission->guard_name)->toBe('api');
});

test('permission can be deleted', function (): void {
    $permissionId = $this->permission->id;

    $this->permission->delete();

    expect(Permission::find($permissionId))->toBeNull();
});

test('permission can be assigned to roles', function (): void {
    $role = Role::factory()->create([
        'name' => 'test-role-'.uniqid('', true),
        'guard_name' => 'web',
    ]);

    $role->givePermissionTo($this->permission);

    expect($role->hasPermissionTo($this->permission))->toBeTrue();
    expect($this->permission->roles)->toHaveCount(1);
});

test('permission can be assigned to multiple roles', function (): void {
    $suffix = uniqid('', true);
    $role1 = Role::factory()->create(['name' => 'role-1-'.$suffix]);
    $role2 = Role::factory()->create(['name' => 'role-2-'.$suffix]);

    $this->permission->assignRole($role1);
    $this->permission->assignRole($role2);

    expect($this->permission->roles)->toHaveCount(2);
    expect($this->permission->hasRole($role1))->toBeTrue();
    expect($this->permission->hasRole($role2))->toBeTrue();
});

test('permission can be found by name', function (): void {
    $foundPermission = Permission::where('name', $this->permissionName)->first();

    expect($foundPermission)->toBeInstanceOf(Permission::class);
    expect($foundPermission->id)->toBe($this->permission->id);
});

test('permission can be found by guard', function (): void {
    // Filter specifically by the permission we created to avoid
    // interference from pre-existing data in the test database.
    $found = Permission::where('guard_name', 'web')
        ->where('name', $this->permissionName)
        ->first();

    expect($found)->not->toBeNull();
    expect($found->id)->toBe($this->permission->id);
});

test('permission has timestamps', function (): void {
    expect($this->permission->created_at)->not->toBeNull();
    expect($this->permission->updated_at)->not->toBeNull();
});

test('permission can be created with factory', function (): void {
    // The factory uses fake()->unique()->word() which may collide with data
    // leftover in the database from prior runs (DatabaseTransactions does not
    // always clean up the 'user' connection). We override the name with a
    // guaranteed-unique value to avoid UniqueConstraintViolationException.
    $permission = Permission::factory()->create([
        'name' => 'factory-perm-'.uniqid('', true),
    ]);

    expect($permission)->toBeInstanceOf(Permission::class);
    expect($permission->name)->not->toBeEmpty();
    expect($permission->guard_name)->not->toBeEmpty();
});

test('permission can be created with specific attributes', function (): void {
    $name = 'custom-permission-'.uniqid('', true);
    $permission = Permission::factory()->create([
        'name' => $name,
        'guard_name' => 'custom-guard',
    ]);

    expect($permission->name)->toBe($name);
    expect($permission->guard_name)->toBe('custom-guard');
});

test('permission can check if it has role', function (): void {
    $role = Role::factory()->create(['name' => 'test-role-'.uniqid('', true)]);

    expect($this->permission->hasRole($role))->toBeFalse();

    $this->permission->assignRole($role);

    expect($this->permission->hasRole($role))->toBeTrue();
});

test('permission can check if it has any roles', function (): void {
    expect($this->permission->hasAnyRole([]))->toBeFalse();

    $role = Role::factory()->create(['name' => 'test-role-'.uniqid('', true)]);
    $this->permission->assignRole($role);

    expect($this->permission->hasAnyRole([$role]))->toBeTrue();
});

test('permission can check if it has all roles', function (): void {
    $suffix = uniqid('', true);
    $role1 = Role::factory()->create(['name' => 'role-1-'.$suffix]);
    $role2 = Role::factory()->create(['name' => 'role-2-'.$suffix]);

    $this->permission->syncRoles([$role1, $role2]);

    expect($this->permission->hasAllRoles([$role1, $role2]))->toBeTrue();
    expect($this->permission->hasAllRoles([$role1]))->toBeTrue();
    expect($this->permission->hasAllRoles([$role1, $role2, 'non-existent']))->toBeFalse();
});

test('permission can be revoked from role', function (): void {
    $role = Role::factory()->create(['name' => 'test-role-'.uniqid('', true)]);

    $this->permission->assignRole($role);
    expect($this->permission->hasRole($role))->toBeTrue();

    $this->permission->removeRole($role);
    expect($this->permission->hasRole($role))->toBeFalse();
});

test('permission can be synced with roles', function (): void {
    $suffix = uniqid('', true);
    $role1 = Role::factory()->create(['name' => 'role-1-'.$suffix]);
    $role2 = Role::factory()->create(['name' => 'role-2-'.$suffix]);
    $role3 = Role::factory()->create(['name' => 'role-3-'.$suffix]);

    // Initially assign role1 and role2
    $this->permission->syncRoles([$role1, $role2]);
    expect($this->permission->roles)->toHaveCount(2);

    // Sync to only role2 and role3
    $this->permission->syncRoles([$role2, $role3]);
    expect($this->permission->roles)->toHaveCount(2);
    expect($this->permission->hasRole($role1))->toBeFalse();
    expect($this->permission->hasRole($role2))->toBeTrue();
    expect($this->permission->hasRole($role3))->toBeTrue();
});

test('permission can be filtered by created_by', function (): void {
    $createdBy = 'user-'.uniqid('', true);
    Permission::withoutEvents(function () use ($createdBy): void {
        $this->permission->forceFill(['created_by' => $createdBy])->save();
    });

    $found = Permission::where('created_by', $createdBy)->first();
    expect($found)->not->toBeNull();
    expect((int) $found->id)->toBe((int) $this->permission->id);
});

test('permission can be filtered by updated_by', function (): void {
    $updatedBy = 'user-'.uniqid('', true);
    Permission::withoutEvents(function () use ($updatedBy): void {
        $this->permission->forceFill(['updated_by' => $updatedBy])->save();
    });

    $found = Permission::where('updated_by', $updatedBy)->first();
    expect($found)->not->toBeNull();
    expect((int) $found->id)->toBe((int) $this->permission->id);
});

test('permission handles null metadata values', function (): void {
    Permission::withoutEvents(function (): void {
        $this->permission->forceFill([
            'created_by' => null,
            'updated_by' => null,
        ])->save();
    });

    expect($this->permission->created_by)->toBeNull();
    expect($this->permission->updated_by)->toBeNull();
});
