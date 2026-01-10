<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->permission = Permission::factory()->create([
        'name' => 'test-permission',
        'guard_name' => 'web',
    ]);
});

test('permission can be created', function (): void {
    expect($this->permission)->toBeInstanceOf(Permission::class);
    expect($this->permission->name)->toBe('test-permission');
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
    $this->permission->update([
        'name' => 'updated-permission',
        'guard_name' => 'api',
    ]);

    $this->permission->refresh();

    expect($this->permission->name)->toBe('updated-permission');
    expect($this->permission->guard_name)->toBe('api');
});

test('permission can be deleted', function (): void {
    $permissionId = $this->permission->id;

    $this->permission->delete();

    expect(Permission::find($permissionId))->toBeNull();
});

test('permission can be assigned to roles', function (): void {
    $role = Role::factory()->create([
        'name' => 'test-role',
        'guard_name' => 'web',
    ]);

    $role->givePermissionTo($this->permission);

    expect($role->hasPermissionTo($this->permission))->toBeTrue();
    expect($this->permission->roles)->toHaveCount(1);
});

test('permission can be assigned to multiple roles', function (): void {
    $role1 = Role::factory()->create(['name' => 'role-1']);
    $role2 = Role::factory()->create(['name' => 'role-2']);

    $this->permission->assignRole($role1);
    $this->permission->assignRole($role2);

    expect($this->permission->roles)->toHaveCount(2);
    expect($this->permission->hasRole($role1))->toBeTrue();
    expect($this->permission->hasRole($role2))->toBeTrue();
});

test('permission can be found by name', function (): void {
    $foundPermission = Permission::where('name', 'test-permission')->first();

    expect($foundPermission)->toBeInstanceOf(Permission::class);
    expect($foundPermission->id)->toBe($this->permission->id);
});

test('permission can be found by guard', function (): void {
    $webPermissions = Permission::where('guard_name', 'web')->get();

    expect($webPermissions)->toHaveCount(1);
    expect($webPermissions->first()->id)->toBe($this->permission->id);
});

test('permission has timestamps', function (): void {
    expect($this->permission->created_at)->not->toBeNull();
    expect($this->permission->updated_at)->not->toBeNull();
});

test('permission can be created with factory', function (): void {
    $permission = Permission::factory()->create();

    expect($permission)->toBeInstanceOf(Permission::class);
    expect($permission->name)->not->toBeEmpty();
    expect($permission->guard_name)->not->toBeEmpty();
});

test('permission can be created with specific attributes', function (): void {
    $permission = Permission::factory()->create([
        'name' => 'custom-permission',
        'guard_name' => 'custom-guard',
    ]);

    expect($permission->name)->toBe('custom-permission');
    expect($permission->guard_name)->toBe('custom-guard');
});

test('permission can check if it has role', function (): void {
    $role = Role::factory()->create(['name' => 'test-role']);

    expect($this->permission->hasRole($role))->toBeFalse();

    $this->permission->assignRole($role);

    expect($this->permission->hasRole($role))->toBeTrue();
});

test('permission can check if it has any roles', function (): void {
    expect($this->permission->hasAnyRole([]))->toBeFalse();

    $role = Role::factory()->create(['name' => 'test-role']);
    $this->permission->assignRole($role);

    expect($this->permission->hasAnyRole([$role]))->toBeTrue();
});

test('permission can check if it has all roles', function (): void {
    $role1 = Role::factory()->create(['name' => 'role-1']);
    $role2 = Role::factory()->create(['name' => 'role-2']);

    $this->permission->syncRoles([$role1, $role2]);

    expect($this->permission->hasAllRoles([$role1, $role2]))->toBeTrue();
    expect($this->permission->hasAllRoles([$role1]))->toBeTrue();
    expect($this->permission->hasAllRoles([$role1, $role2, 'non-existent']))->toBeFalse();
});

test('permission can be revoked from role', function (): void {
    $role = Role::factory()->create(['name' => 'test-role']);

    $this->permission->assignRole($role);
    expect($this->permission->hasRole($role))->toBeTrue();

    $this->permission->removeRole($role);
    expect($this->permission->hasRole($role))->toBeFalse();
});

test('permission can be synced with roles', function (): void {
    $role1 = Role::factory()->create(['name' => 'role-1']);
    $role2 = Role::factory()->create(['name' => 'role-2']);
    $role3 = Role::factory()->create(['name' => 'role-3']);

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
    Permission::withoutEvents(function (): void {
        $this->permission->forceFill(['created_by' => 'user-123'])->save();
    });

    $found = Permission::where('created_by', 'user-123')->first();
    expect($found)->not->toBeNull();
    expect((int) $found->id)->toBe((int) $this->permission->id);
});

test('permission can be filtered by updated_by', function (): void {
    Permission::withoutEvents(function (): void {
        $this->permission->forceFill(['updated_by' => 'user-456'])->save();
    });

    $found = Permission::where('updated_by', 'user-456')->first();
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
