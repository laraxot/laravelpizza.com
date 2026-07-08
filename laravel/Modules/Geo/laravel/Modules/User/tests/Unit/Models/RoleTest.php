<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Models\Role;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function modelsRoleCreate(array $attributes = []): Role
{
    return RoleFactory::new()->createOne(array_merge([
        'name' => 'models-role-'.uniqid(),
        'guard_name' => 'web',
    ], $attributes));
}

test('can create role with minimal data', function (): void {
    $name = 'test-role-'.uniqid();
    $role = modelsRoleCreate(['name' => $name]);

    Assert::assertInstanceOf(Role::class, $role);
    Assert::assertNotNull($role->id);
    Assert::assertSame($name, $role->name);
    Assert::assertSame('web', $role->guard_name);
});

test('can create role with all fields', function (): void {
    $team = TeamFactory::new()->createOne(['name' => 'team-'.uniqid()]);
    $name = 'full-role-'.uniqid();

    $role = modelsRoleCreate([
        'name' => $name,
        'guard_name' => 'web',
        'team_id' => $team->id,
    ]);

    Assert::assertSame($name, $role->name);
    Assert::assertSame('web', $role->guard_name);
    Assert::assertSame($team->id, $role->team_id);
});

test('role has connection attribute', function (): void {
    Assert::assertSame('user', (new Role())->getConnectionName());
});

test('role constants are defined', function (): void {
    Assert::assertSame(1, Role::ROLE_ADMINISTRATOR);
    Assert::assertSame(2, Role::ROLE_OWNER);
    Assert::assertSame(3, Role::ROLE_USER);
});

test('can find role by name', function (): void {
    $name = 'Unique Role Name-'.uniqid();
    $role = modelsRoleCreate(['name' => $name]);
    $foundRole = Role::where('name', $name)->first();

    Assert::assertInstanceOf(Role::class, $foundRole);
    Assert::assertSame($role->id, $foundRole->id);
});

test('can find role by guard name', function (): void {
    $marker = uniqid();
    modelsRoleCreate(['guard_name' => 'web', 'name' => "web-{$marker}-1"]);
    modelsRoleCreate(['guard_name' => 'api', 'name' => "api-{$marker}-1"]);
    modelsRoleCreate(['guard_name' => 'web', 'name' => "web-{$marker}-2"]);

    $webRoles = Role::where('guard_name', 'web')
        ->where('name', 'like', "%{$marker}%")
        ->get();

    Assert::assertGreaterThanOrEqual(2, $webRoles->count());
    foreach ($webRoles as $webRole) {
        Assert::assertInstanceOf(Role::class, $webRole);
        Assert::assertSame('web', $webRole->guard_name);
    }
});

test('can find role by team id', function (): void {
    $team = TeamFactory::new()->createOne(['name' => 'team-'.uniqid()]);
    $role = modelsRoleCreate(['team_id' => $team->id]);
    $foundRole = Role::where('team_id', $team->id)->where('id', $role->id)->first();

    Assert::assertInstanceOf(Role::class, $foundRole);
    Assert::assertSame($role->id, $foundRole->id);
});

test('can find roles by name pattern', function (): void {
    $marker = uniqid();
    modelsRoleCreate(['name' => "Admin Role {$marker}"]);
    modelsRoleCreate(['name' => "User Role {$marker}"]);
    modelsRoleCreate(['name' => "Manager Role {$marker}"]);

    $roles = Role::where('name', 'like', "%Role {$marker}%")->get();

    Assert::assertGreaterThanOrEqual(3, $roles->count());
    foreach ($roles as $role) {
        Assert::assertInstanceOf(Role::class, $role);
        Assert::assertStringContainsString('Role', $role->name);
    }
});

test('can update role', function (): void {
    $oldName = 'Old Name-'.uniqid();
    $newName = 'New Name-'.uniqid();
    $role = modelsRoleCreate(['name' => $oldName]);

    $role->update(['name' => $newName]);
    $fresh = $role->fresh();

    Assert::assertInstanceOf(Role::class, $fresh);
    Assert::assertSame($newName, $fresh->name);
});

test('can handle null values', function (): void {
    $role = modelsRoleCreate();

    Role::withoutEvents(static function () use ($role): void {
        $role->forceFill(['team_id' => null])->save();
    });
    $role->refresh();

    Assert::assertNull($role->team_id);
});

test('can find roles by multiple criteria', function (): void {
    $team = TeamFactory::new()->createOne(['name' => 'team-'.uniqid()]);
    $marker = uniqid();
    modelsRoleCreate([
        'name' => "Admin Role {$marker}",
        'guard_name' => 'web',
        'team_id' => $team->id,
    ]);
    modelsRoleCreate([
        'name' => "User Role {$marker}",
        'guard_name' => 'api',
        'team_id' => $team->id,
    ]);

    $roles = Role::where('team_id', $team->id)
        ->where('guard_name', 'web')
        ->where('name', 'like', "%{$marker}%")
        ->get();

    Assert::assertGreaterThanOrEqual(1, $roles->count());
    $first = $roles->first();
    Assert::assertInstanceOf(Role::class, $first);
    Assert::assertStringContainsString("Admin Role {$marker}", $first->name);
    Assert::assertSame('web', $first->guard_name);
});

test('role has table name', function (): void {
    Assert::assertNotSame('', (new Role())->getTable());
});

test('role can be deleted from database', function (): void {
    $role = modelsRoleCreate();
    $roleId = $role->id;

    DB::connection('user')->table($role->getTable())->where('id', $roleId)->delete();

    Assert::assertNull(Role::query()->find($roleId));
});
