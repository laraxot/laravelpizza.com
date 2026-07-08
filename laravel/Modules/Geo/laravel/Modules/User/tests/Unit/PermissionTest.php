<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function createTestPermission(array $attributes = []): Permission
{
    return PermissionFactory::new()->createOne(array_merge([
        'name' => 'test-permission-'.uniqid(),
        'guard_name' => 'web',
    ], $attributes));
}

/**
 * @param array<string, mixed> $attributes
 */
function createTestRoleForPermission(array $attributes = []): Role
{
    return RoleFactory::new()->createOne(array_merge([
        'name' => 'test-role-'.uniqid(),
        'guard_name' => 'web',
    ], $attributes));
}

test('permission can be created', function (): void {
    $name = 'test-permission-'.uniqid();
    $permission = createTestPermission(['name' => $name]);

    Assert::assertInstanceOf(Permission::class, $permission);
    Assert::assertSame($name, $permission->name);
    Assert::assertSame('web', $permission->guard_name);
});

test('permission has correct fillable attributes', function (): void {
    $permission = createTestPermission();
    $fillable = $permission->getFillable();

    Assert::assertContains('name', $fillable);
    Assert::assertContains('guard_name', $fillable);
    Assert::assertContains('display_name', $fillable);
    Assert::assertContains('description', $fillable);
});

test('permission has correct table configuration', function (): void {
    $table = createTestPermission()->getTable();

    Assert::assertNotSame('', $table);
});

test('permission has correct casts', function (): void {
    $casts = createTestPermission()->getCasts();

    Assert::assertArrayHasKey('id', $casts);
    Assert::assertSame('int', $casts['id']);
});

test('permission can be updated', function (): void {
    $permission = createTestPermission();
    $updatedName = 'updated-permission-'.uniqid();

    $permission->update([
        'name' => $updatedName,
        'guard_name' => 'api',
    ]);
    $permission->refresh();

    Assert::assertSame($updatedName, $permission->name);
    Assert::assertSame('api', $permission->guard_name);
});

test('permission can be deleted', function (): void {
    $permission = createTestPermission();
    $permissionId = $permission->id;

    DB::connection('user')->table($permission->getTable())->where('id', $permissionId)->delete();

    Assert::assertNull(Permission::query()->find($permissionId));
});

test('permission can be assigned to roles', function (): void {
    $permission = createTestPermission();
    $role = createTestRoleForPermission();

    $role->givePermissionTo($permission);

    Assert::assertTrue($role->hasPermissionTo($permission));
    Assert::assertCount(1, $permission->roles);
});

test('permission can be assigned to multiple roles', function (): void {
    $permission = createTestPermission();
    $role1 = createTestRoleForPermission(['name' => 'role-1-'.uniqid()]);
    $role2 = createTestRoleForPermission(['name' => 'role-2-'.uniqid()]);

    $permission->assignRole($role1);
    $permission->assignRole($role2);

    Assert::assertCount(2, $permission->roles);
    Assert::assertTrue($permission->hasRole($role1));
    Assert::assertTrue($permission->hasRole($role2));
});

test('permission can be found by name', function (): void {
    $name = 'test-permission-'.uniqid();
    $permission = createTestPermission(['name' => $name]);
    $foundPermission = Permission::where('name', $name)->first();

    Assert::assertInstanceOf(Permission::class, $foundPermission);
    Assert::assertSame($permission->id, $foundPermission->id);
});

test('permission can be found by guard', function (): void {
    $permission = createTestPermission();
    $webPermissions = Permission::where('guard_name', 'web')->where('id', $permission->id)->get();

    Assert::assertCount(1, $webPermissions);
    $first = $webPermissions->first();
    Assert::assertInstanceOf(Permission::class, $first);
    Assert::assertSame($permission->id, $first->id);
});

test('permission has timestamps', function (): void {
    $permission = createTestPermission();

    Assert::assertNotNull($permission->created_at);
    Assert::assertNotNull($permission->updated_at);
});

test('permission can be created with factory', function (): void {
    $permission = PermissionFactory::new()->createOne([
        'name' => 'factory-permission-'.uniqid(),
        'guard_name' => 'web',
    ]);

    Assert::assertInstanceOf(Permission::class, $permission);
    Assert::assertNotSame('', $permission->name);
    Assert::assertNotSame('', $permission->guard_name);
});

test('permission can be created with specific attributes', function (): void {
    $permission = PermissionFactory::new()->createOne([
        'name' => 'custom-permission-'.uniqid(),
        'guard_name' => 'custom-guard',
    ]);

    Assert::assertStringContainsString('custom-permission-', $permission->name);
    Assert::assertSame('custom-guard', $permission->guard_name);
});

test('permission can check if it has role', function (): void {
    $permission = createTestPermission();
    $role = createTestRoleForPermission();

    Assert::assertFalse($permission->hasRole($role));

    $permission->assignRole($role);

    Assert::assertTrue($permission->hasRole($role));
});

test('permission can check if it has any roles', function (): void {
    $permission = createTestPermission();

    Assert::assertFalse($permission->hasAnyRole([]));

    $role = createTestRoleForPermission();
    $permission->assignRole($role);

    Assert::assertTrue($permission->hasAnyRole([$role]));
});

test('permission can check if it has all roles', function (): void {
    $permission = createTestPermission();
    $role1 = createTestRoleForPermission(['name' => 'role-1-'.uniqid()]);
    $role2 = createTestRoleForPermission(['name' => 'role-2-'.uniqid()]);

    $permission->syncRoles([$role1, $role2]);

    Assert::assertTrue($permission->hasAllRoles([$role1, $role2]));
    Assert::assertTrue($permission->hasAllRoles([$role1]));
    Assert::assertFalse($permission->hasAllRoles([$role1, $role2, 'non-existent']));
});

test('permission can be revoked from role', function (): void {
    $permission = createTestPermission();
    $role = createTestRoleForPermission();

    $permission->assignRole($role);
    Assert::assertTrue($permission->hasRole($role));

    $permission->removeRole($role);
    Assert::assertFalse($permission->hasRole($role));
});

test('permission can be synced with roles', function (): void {
    $permission = createTestPermission();
    $role1 = createTestRoleForPermission(['name' => 'role-1-'.uniqid()]);
    $role2 = createTestRoleForPermission(['name' => 'role-2-'.uniqid()]);
    $role3 = createTestRoleForPermission(['name' => 'role-3-'.uniqid()]);

    $permission->syncRoles([$role1, $role2]);
    Assert::assertCount(2, $permission->roles);

    $permission->syncRoles([$role2, $role3]);
    Assert::assertCount(2, $permission->roles);
    Assert::assertFalse($permission->hasRole($role1));
    Assert::assertTrue($permission->hasRole($role2));
    Assert::assertTrue($permission->hasRole($role3));
});

test('permission can be filtered by created_by', function (): void {
    $permission = createTestPermission();
    $createdBy = 'user-123-'.uniqid();

    Permission::withoutEvents(static function () use ($permission, $createdBy): void {
        $permission->forceFill(['created_by' => $createdBy])->save();
    });

    $found = Permission::where('created_by', $createdBy)->first();
    Assert::assertInstanceOf(Permission::class, $found);
    Assert::assertSame((int) $permission->id, (int) $found->id);
});

test('permission can be filtered by updated_by', function (): void {
    $permission = createTestPermission();
    $updatedBy = 'user-456-'.uniqid();

    Permission::withoutEvents(static function () use ($permission, $updatedBy): void {
        $permission->forceFill(['updated_by' => $updatedBy])->save();
    });

    $found = Permission::where('updated_by', $updatedBy)->first();
    Assert::assertInstanceOf(Permission::class, $found);
    Assert::assertSame((int) $permission->id, (int) $found->id);
});

test('permission handles null metadata values', function (): void {
    $permission = createTestPermission();

    Permission::withoutEvents(static function () use ($permission): void {
        $permission->forceFill([
            'created_by' => null,
            'updated_by' => null,
        ])->save();
    });

    Assert::assertNull($permission->created_by);
    Assert::assertNull($permission->updated_by);
});
