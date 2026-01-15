<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('can create permission with minimal data', function (): void {
    $permission = Permission::factory()->create([
        'name' => 'test.permission',
        'guard_name' => 'web',
    ]);

    expect($permission->id)->not->toBeNull();
    expect($permission->name)->toBe('test.permission');
    expect($permission->guard_name)->toBe('web');
});

test('can create permission with all fields', function (): void {
    $permissionData = [
        'name' => 'full.permission',
        'guard_name' => 'web',
        'created_by' => 'user123',
        'updated_by' => 'user456',
    ];

    $permission = Permission::factory()->create($permissionData);

    expect($permission->id)->not->toBeNull();
    expect($permission->name)->toBe('full.permission');
    expect($permission->guard_name)->toBe('web');
    expect($permission->created_by)->toBe('user123');
    expect($permission->updated_by)->toBe('user456');
});

test('permission has connection attribute', function (): void {
    $permission = new Permission();

    expect($permission->connection)->toBe('user');
});

test('permission has key type attribute', function (): void {
    $permission = new Permission();

    expect($permission->keyType)->toBe('string');
});

test('permission has fillable attributes', function (): void {
    $permission = new Permission();

    $fillable = $permission->getFillable();

    expect($fillable)->toContain('id');
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('guard_name');
});

test('permission has casts', function (): void {
    $permission = new Permission();

    $casts = $permission->getCasts();

    expect($casts)->toHaveKey('id');
    expect($casts)->toHaveKey('name');
    expect($casts)->toHaveKey('guard_name');
    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');
});

test('can find permission by name', function (): void {
    $permission = Permission::factory()->create(['name' => 'unique.permission']);

    $foundPermission = Permission::where('name', 'unique.permission')->first();

    expect($foundPermission)->not->toBeNull();
    expect($foundPermission->id)->toBe($permission->id);
});

test('can find permission by guard name', function (): void {
    Permission::factory()->create(['guard_name' => 'web']);
    Permission::factory()->create(['guard_name' => 'api']);
    Permission::factory()->create(['guard_name' => 'web']);

    $webPermissions = Permission::where('guard_name', 'web')->get();

    expect($webPermissions->count())->toBeGreaterThanOrEqual(2);
    expect($webPermissions->every(fn ($permission) => 'web' === $permission->guard_name))->toBeTrue();
});

test('can find permission by created by', function (): void {
    $permission = Permission::factory()->create(['created_by' => 'user123']);

    $foundPermission = Permission::where('created_by', 'user123')->first();

    expect($foundPermission)->not->toBeNull();
    expect($foundPermission->id)->toBe($permission->id);
});

test('can find permission by updated by', function (): void {
    $permission = Permission::factory()->create(['updated_by' => 'user456']);

    $foundPermission = Permission::where('updated_by', 'user456')->first();

    expect($foundPermission)->not->toBeNull();
    expect($foundPermission->id)->toBe($permission->id);
});

test('can find permissions by name pattern', function (): void {
    Permission::factory()->create(['name' => 'user.create']);
    Permission::factory()->create(['name' => 'user.update']);
    Permission::factory()->create(['name' => 'user.delete']);
    Permission::factory()->create(['name' => 'post.read']);

    $userPermissions = Permission::where('name', 'like', 'user.%')->get();

    expect($userPermissions->count())->toBeGreaterThanOrEqual(3);
    expect($userPermissions->every(fn ($permission) => str_starts_with($permission->name, 'user.')))->toBeTrue();
});

test('can update permission', function (): void {
    $permission = Permission::factory()->create(['name' => 'old.permission']);

    $permission->update(['name' => 'new.permission']);

    expect($permission->fresh()->name)->toBe('new.permission');
});

test('can handle null values', function (): void {
    $permission = Permission::factory()->create([
        'name' => 'test.permission',
        'guard_name' => 'web',
        'created_by' => null,
        'updated_by' => null,
    ]);

    expect($permission->created_by)->toBeNull();
    expect($permission->updated_by)->toBeNull();
});

test('can find permissions by multiple criteria', function (): void {
    Permission::factory()->create([
        'name' => 'admin.user.create',
        'guard_name' => 'web',
        'created_by' => 'admin',
    ]);

    Permission::factory()->create([
        'name' => 'admin.user.update',
        'guard_name' => 'api',
        'created_by' => 'admin',
    ]);

    $permissions = Permission::where('name', 'like', 'admin.user.%')->where('created_by', 'admin')->get();

    expect($permissions->count())->toBeGreaterThanOrEqual(2);
    expect($permissions->every(
        fn ($permission) => str_starts_with($permission->name, 'admin.user.') && 'admin' === $permission->created_by,
    ))->toBeTrue();
});

test('permission has roles relationship', function (): void {
    $permission = Permission::factory()->create();

    expect(method_exists($permission, 'roles'))->toBeTrue();
});

test('permission has users relationship', function (): void {
    $permission = Permission::factory()->create();

    expect(method_exists($permission, 'users'))->toBeTrue();
});

test('permission can use role scopes', function (): void {
    $permission = Permission::factory()->create();

    expect(method_exists($permission, 'role'))->toBeTrue();
});

test('permission can use permission scopes', function (): void {
    $permission = Permission::factory()->create();

    expect(method_exists($permission, 'permission'))->toBeTrue();
    expect(method_exists($permission, 'withoutPermission'))->toBeTrue();
});

test('permission can use without role scopes', function (): void {
    $permission = Permission::factory()->create();

    expect(method_exists($permission, 'withoutRole'))->toBeTrue();
});

test('permission has factory method', function (): void {
    $permission = new Permission();

    expect(method_exists($permission, 'newFactory'))->toBeTrue();
});

test('permission has get table method', function (): void {
    $permission = new Permission();

    expect(method_exists($permission, 'getTable'))->toBeTrue();
});
