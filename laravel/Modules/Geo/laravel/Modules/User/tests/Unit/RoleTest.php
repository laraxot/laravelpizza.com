<?php

declare(strict_types=1);

use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function createTestRole(array $attributes = []): Role
{
    return RoleFactory::new()->createOne(array_merge([
        'name' => 'test-role-'.uniqid(),
        'guard_name' => 'web',
    ], $attributes));
}

/**
 * @param array<string, mixed> $attributes
 */
function createTestPermissionForRole(array $attributes = []): Permission
{
    return PermissionFactory::new()->createOne(array_merge([
        'name' => 'test-permission-'.uniqid(),
        'guard_name' => 'web',
    ], $attributes));
}

test('role can be created', function (): void {
    $name = 'test-role-'.uniqid();
    $role = createTestRole(['name' => $name]);

    Assert::assertInstanceOf(Role::class, $role);
    Assert::assertSame($name, $role->name);
    Assert::assertSame('web', $role->guard_name);
});

test('role has correct constants', function (): void {
    Assert::assertSame(1, Role::ROLE_ADMINISTRATOR);
    Assert::assertSame(2, Role::ROLE_OWNER);
    Assert::assertSame(3, Role::ROLE_USER);
});

test('role has correct table configuration', function (): void {
    $table = createTestRole()->getTable();

    Assert::assertNotSame('', $table);
});

test('role has correct casts', function (): void {
    $casts = createTestRole()->getCasts();

    Assert::assertSame('int', $casts['id']);
    Assert::assertSame('string', $casts['name']);
    Assert::assertSame('string', $casts['guard_name']);
    Assert::assertSame('datetime', $casts['created_at']);
    Assert::assertSame('datetime', $casts['updated_at']);
});

test('role can be updated', function (): void {
    $role = createTestRole();

    $role->update([
        'name' => 'updated-role',
        'guard_name' => 'api',
    ]);
    $role->refresh();

    Assert::assertSame('updated-role', $role->name);
    Assert::assertSame('api', $role->guard_name);
});

test('role can be deleted', function (): void {
    $role = createTestRole();
    $roleId = $role->id;

    $role->delete();

    Assert::assertNull(Role::find($roleId));
});

test('role can have permissions', function (): void {
    $role = createTestRole();
    $permission = createTestPermissionForRole();

    $role->givePermissionTo($permission);

    Assert::assertTrue($role->hasPermissionTo($permission));
    Assert::assertCount(1, $role->permissions);
});

test('role can have multiple permissions', function (): void {
    $role = createTestRole();
    $permission1 = createTestPermissionForRole(['name' => 'permission-1-'.uniqid()]);
    $permission2 = createTestPermissionForRole(['name' => 'permission-2-'.uniqid()]);

    $role->syncPermissions([$permission1, $permission2]);

    Assert::assertCount(2, $role->permissions);
    Assert::assertTrue($role->hasPermissionTo($permission1));
    Assert::assertTrue($role->hasPermissionTo($permission2));
});

test('role can revoke permissions', function (): void {
    $role = createTestRole();
    $permission = createTestPermissionForRole();

    $role->givePermissionTo($permission);
    Assert::assertTrue($role->hasPermissionTo($permission));

    $role->revokePermissionTo($permission);
    Assert::assertFalse($role->hasPermissionTo($permission));
});

test('role can be found by name', function (): void {
    $name = 'test-role-'.uniqid();
    $role = createTestRole(['name' => $name]);
    $foundRole = Role::where('name', $name)->first();

    Assert::assertInstanceOf(Role::class, $foundRole);
    Assert::assertSame($role->id, $foundRole->id);
});

test('role can be found by guard', function (): void {
    $role = createTestRole();
    $webRoles = Role::where('guard_name', 'web')->where('id', $role->id)->get();

    Assert::assertCount(1, $webRoles);
    $first = $webRoles->first();
    Assert::assertInstanceOf(Role::class, $first);
    Assert::assertSame($role->id, $first->id);
});

test('role has timestamps', function (): void {
    $role = createTestRole();

    Assert::assertNotNull($role->created_at);
    Assert::assertNotNull($role->updated_at);
});

test('role can be created with factory', function (): void {
    $role = RoleFactory::new()->createOne([
        'name' => 'factory-role-'.uniqid(),
        'guard_name' => 'web',
    ]);

    Assert::assertInstanceOf(Role::class, $role);
    Assert::assertNotSame('', $role->name);
    Assert::assertNotSame('', $role->guard_name);
});

test('role can be created with specific attributes', function (): void {
    $role = RoleFactory::new()->createOne([
        'name' => 'custom-role-'.uniqid(),
        'guard_name' => 'custom-guard',
    ]);

    Assert::assertStringContainsString('custom-role-', $role->name);
    Assert::assertSame('custom-guard', $role->guard_name);
});

test('role can check if it has any permissions', function (): void {
    $role = createTestRole();

    Assert::assertFalse($role->hasAnyPermission([]));

    $permission = createTestPermissionForRole();
    $role->givePermissionTo($permission);

    Assert::assertTrue($role->hasAnyPermission([$permission]));
});

test('role can check if it has all permissions', function (): void {
    $role = createTestRole();
    $permission1 = createTestPermissionForRole(['name' => 'permission-1-'.uniqid()]);
    $permission2 = createTestPermissionForRole(['name' => 'permission-2-'.uniqid()]);

    $role->syncPermissions([$permission1, $permission2]);

    Assert::assertTrue($role->hasAllPermissions([$permission1, $permission2]));
    Assert::assertTrue($role->hasAllPermissions([$permission1]));
    Assert::assertFalse($role->hasAllPermissions([$permission1, $permission2, 'non-existent']));
});

test('role can be filtered by team_id', function (): void {
    $role = createTestRole();
    $team = TeamFactory::new()->createOne(['name' => 'team-'.uniqid()]);

    Role::withoutEvents(static function () use ($role, $team): void {
        $role->forceFill(['team_id' => $team->id])->save();
    });

    $found = Role::where('team_id', $team->id)->first();
    Assert::assertInstanceOf(Role::class, $found);
    Assert::assertSame((int) $role->id, (int) $found->id);
});

test('role handles null metadata values', function (): void {
    $role = createTestRole();

    Role::withoutEvents(static function () use ($role): void {
        $role->forceFill([
            'team_id' => null,
            'created_by' => null,
            'updated_by' => null,
        ])->save();
    });

    Assert::assertNull($role->team_id);
    Assert::assertNull($role->created_by);
    Assert::assertNull($role->updated_by);
});
