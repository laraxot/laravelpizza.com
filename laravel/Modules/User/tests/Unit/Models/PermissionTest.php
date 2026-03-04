<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('can create permission with minimal data', function (): void {
    $name = 'test.permission.'.uniqid();
    $permission = Permission::factory()->create([
        'name' => $name,
        'guard_name' => 'web',
    ]);

    expect($permission->id)->not->toBeNull();
    expect($permission->name)->toBe($name);
    expect($permission->guard_name)->toBe('web');
});

test('can create permission with all fields', function (): void {
    $name = 'full.permission.'.uniqid();
    $permissionData = [
        'name' => $name,
        'guard_name' => 'web',
        'created_by' => 'user123',
        'updated_by' => 'user456',
    ];

    $permission = Permission::factory()->create($permissionData);

    expect($permission->id)->not->toBeNull();
    expect($permission->name)->toBe($name);
    expect($permission->guard_name)->toBe('web');
    expect($permission->created_by)->toBe('user123');
    expect($permission->updated_by)->toBe('user456');
});

test('permission has connection attribute', function (): void {
    $permission = new Permission;

    expect($permission->connection)->toBe('user');
});

test('permission has key type attribute', function (): void {
    $permission = new Permission;

    expect($permission->keyType)->toBe('string');
});

test('permission has fillable attributes', function (): void {
    $permission = new Permission;

    $fillable = $permission->getFillable();

    expect($fillable)->toContain('id');
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('guard_name');
});

test('permission has casts', function (): void {
    $permission = new Permission;

    $casts = $permission->getCasts();

    expect($casts)->toHaveKey('id');
    expect($casts)->toHaveKey('name');
    expect($casts)->toHaveKey('guard_name');
    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');
});

test('can find permission by name', function (): void {
    $name = 'unique.permission.'.uniqid();
    $permission = Permission::factory()->create(['name' => $name]);

    $foundPermission = Permission::where('name', $name)->first();

    expect($foundPermission)->not->toBeNull();
    expect($foundPermission->id)->toBe($permission->id);
});

test('can find permission by guard name', function (): void {
    $suffix = uniqid();
    Permission::factory()->create(['name' => 'guard.perm1.'.$suffix, 'guard_name' => 'web']);
    Permission::factory()->create(['name' => 'guard.perm2.'.$suffix, 'guard_name' => 'api']);
    Permission::factory()->create(['name' => 'guard.perm3.'.$suffix, 'guard_name' => 'web']);

    $webPermissions = Permission::where('name', 'like', 'guard.perm%.'.$suffix)->where('guard_name', 'web')->get();

    expect($webPermissions->count())->toBeGreaterThanOrEqual(2);
    expect($webPermissions->every(fn ($permission) => $permission->guard_name === 'web'))->toBeTrue();
});

test('can find permission by created by', function (): void {
    $name = 'created-by.perm.'.uniqid();
    $permission = Permission::factory()->create(['name' => $name, 'created_by' => 'user123']);

    $foundPermission = Permission::where('name', $name)->where('created_by', 'user123')->first();

    expect($foundPermission)->not->toBeNull();
    expect($foundPermission->id)->toBe($permission->id);
});

test('can find permission by updated by', function (): void {
    $name = 'updated-by.perm.'.uniqid();
    $permission = Permission::factory()->create(['name' => $name, 'updated_by' => 'user456']);

    $foundPermission = Permission::where('name', $name)->where('updated_by', 'user456')->first();

    expect($foundPermission)->not->toBeNull();
    expect($foundPermission->id)->toBe($permission->id);
});

test('can find permissions by name pattern', function (): void {
    $suffix = uniqid();
    Permission::factory()->create(['name' => 'user.create.'.$suffix]);
    Permission::factory()->create(['name' => 'user.update.'.$suffix]);
    Permission::factory()->create(['name' => 'user.delete.'.$suffix]);
    Permission::factory()->create(['name' => 'post.read.'.$suffix]);

    $userPermissions = Permission::where('name', 'like', 'user.%.'.$suffix)->get();

    expect($userPermissions->count())->toBeGreaterThanOrEqual(3);
    expect($userPermissions->every(fn ($permission) => str_starts_with($permission->name, 'user.')))->toBeTrue();
});

test('can update permission', function (): void {
    $oldName = 'old.permission.'.uniqid();
    $newName = 'new.permission.'.uniqid();
    $permission = Permission::factory()->create(['name' => $oldName]);

    $permission->update(['name' => $newName]);

    expect($permission->fresh()->name)->toBe($newName);
});

test('can handle null values', function (): void {
    $name = 'null-test.perm.'.uniqid();
    $permission = Permission::factory()->create([
        'name' => $name,
        'guard_name' => 'web',
        'created_by' => null,
        'updated_by' => null,
    ]);

    expect($permission->created_by)->toBeNull();
    expect($permission->updated_by)->toBeNull();
});

test('can find permissions by multiple criteria', function (): void {
    $suffix = uniqid();
    Permission::factory()->create([
        'name' => 'admin.user.create.'.$suffix,
        'guard_name' => 'web',
        'created_by' => 'admin',
    ]);

    Permission::factory()->create([
        'name' => 'admin.user.update.'.$suffix,
        'guard_name' => 'api',
        'created_by' => 'admin',
    ]);

    $permissions = Permission::where('name', 'like', 'admin.user.%.'.$suffix)->where('created_by', 'admin')->get();

    expect($permissions->count())->toBeGreaterThanOrEqual(2);
    expect($permissions->every(
        fn ($permission) => str_starts_with($permission->name, 'admin.user.') && $permission->created_by === 'admin',
    ))->toBeTrue();
});

test('permission has roles relationship', function (): void {
    $permission = Permission::factory()->create(['name' => 'roles-rel.'.uniqid()]);

    expect(method_exists($permission, 'roles'))->toBeTrue();
});

test('permission has users relationship', function (): void {
    $permission = Permission::factory()->create(['name' => 'users-rel.'.uniqid()]);

    expect(method_exists($permission, 'users'))->toBeTrue();
});

test('permission can use role scopes', function (): void {
    $permission = Permission::factory()->create(['name' => 'role-scope.'.uniqid()]);

    expect(method_exists($permission, 'role'))->toBeTrue();
});

test('permission can use permission scopes', function (): void {
    $permission = Permission::factory()->create(['name' => 'perm-scope.'.uniqid()]);

    expect(method_exists($permission, 'permission'))->toBeTrue();
    expect(method_exists($permission, 'withoutPermission'))->toBeTrue();
});

test('permission can use without role scopes', function (): void {
    $permission = Permission::factory()->create(['name' => 'without-role.'.uniqid()]);

    expect(method_exists($permission, 'withoutRole'))->toBeTrue();
});

test('permission has factory method', function (): void {
    $permission = new Permission;

    expect(method_exists($permission, 'newFactory'))->toBeTrue();
});

test('permission has get table method', function (): void {
    $permission = new Permission;

    expect(method_exists($permission, 'getTable'))->toBeTrue();
});
