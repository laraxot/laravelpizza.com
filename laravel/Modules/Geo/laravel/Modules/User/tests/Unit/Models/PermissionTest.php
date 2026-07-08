<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Models\Permission;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function modelsPermissionCreate(array $attributes = []): Permission
{
    return PermissionFactory::new()->createOne(array_merge([
        'name' => 'models-permission-'.uniqid(),
        'guard_name' => 'web',
    ], $attributes));
}

test('can create permission with minimal data', function (): void {
    $name = 'test.permission-'.uniqid();
    $permission = modelsPermissionCreate(['name' => $name]);

    Assert::assertInstanceOf(Permission::class, $permission);
    Assert::assertNotNull($permission->id);
    Assert::assertSame($name, $permission->name);
    Assert::assertSame('web', $permission->guard_name);
});

test('can create permission with all fields', function (): void {
    $name = 'full.permission-'.uniqid();
    $permission = modelsPermissionCreate(['name' => $name, 'guard_name' => 'web']);

    Permission::withoutEvents(static function () use ($permission): void {
        $permission->forceFill([
            'created_by' => 'user123',
            'updated_by' => 'user456',
        ])->save();
    });
    $permission->refresh();

    Assert::assertSame($name, $permission->name);
    Assert::assertSame('web', $permission->guard_name);
    Assert::assertSame('user123', $permission->created_by);
    Assert::assertSame('user456', $permission->updated_by);
});

test('permission has connection attribute', function (): void {
    Assert::assertSame('user', (new Permission())->getConnectionName());
});

test('permission has fillable attributes', function (): void {
    $fillable = (new Permission())->getFillable();

    Assert::assertContains('name', $fillable);
    Assert::assertContains('guard_name', $fillable);
});

test('permission has casts', function (): void {
    $casts = (new Permission())->getCasts();

    Assert::assertArrayHasKey('id', $casts);
    Assert::assertSame('int', $casts['id']);
});

test('can find permission by name', function (): void {
    $name = 'unique.permission-'.uniqid();
    $permission = modelsPermissionCreate(['name' => $name]);
    $foundPermission = Permission::where('name', $name)->first();

    Assert::assertInstanceOf(Permission::class, $foundPermission);
    Assert::assertSame($permission->id, $foundPermission->id);
});

test('can find permission by guard name', function (): void {
    $marker = uniqid();
    modelsPermissionCreate(['guard_name' => 'web', 'name' => "web-{$marker}-1"]);
    modelsPermissionCreate(['guard_name' => 'api', 'name' => "api-{$marker}-1"]);
    modelsPermissionCreate(['guard_name' => 'web', 'name' => "web-{$marker}-2"]);

    $webPermissions = Permission::where('guard_name', 'web')
        ->where('name', 'like', "%{$marker}%")
        ->get();

    Assert::assertGreaterThanOrEqual(2, $webPermissions->count());
    foreach ($webPermissions as $webPermission) {
        Assert::assertInstanceOf(Permission::class, $webPermission);
        Assert::assertSame('web', $webPermission->guard_name);
    }
});

test('can find permission by created by', function (): void {
    $createdBy = 'user123-'.uniqid();
    $permission = modelsPermissionCreate();

    Permission::withoutEvents(static function () use ($permission, $createdBy): void {
        $permission->forceFill(['created_by' => $createdBy])->save();
    });

    $foundPermission = Permission::where('created_by', $createdBy)->first();

    Assert::assertInstanceOf(Permission::class, $foundPermission);
    Assert::assertSame($permission->id, $foundPermission->id);
});

test('can find permission by updated by', function (): void {
    $updatedBy = 'user456-'.uniqid();
    $permission = modelsPermissionCreate();

    Permission::withoutEvents(static function () use ($permission, $updatedBy): void {
        $permission->forceFill(['updated_by' => $updatedBy])->save();
    });

    $foundPermission = Permission::where('updated_by', $updatedBy)->first();

    Assert::assertInstanceOf(Permission::class, $foundPermission);
    Assert::assertSame($permission->id, $foundPermission->id);
});

test('can find permissions by name pattern', function (): void {
    $marker = uniqid();
    modelsPermissionCreate(['name' => "user.create-{$marker}"]);
    modelsPermissionCreate(['name' => "user.update-{$marker}"]);
    modelsPermissionCreate(['name' => "user.delete-{$marker}"]);
    modelsPermissionCreate(['name' => "post.read-{$marker}"]);

    $userPermissions = Permission::where('name', 'like', "user.%-{$marker}")->get();

    Assert::assertGreaterThanOrEqual(3, $userPermissions->count());
    foreach ($userPermissions as $userPermission) {
        Assert::assertInstanceOf(Permission::class, $userPermission);
        Assert::assertStringStartsWith('user.', $userPermission->name);
    }
});

test('can update permission', function (): void {
    $oldName = 'old.permission-'.uniqid();
    $newName = 'new.permission-'.uniqid();
    $permission = modelsPermissionCreate(['name' => $oldName]);

    $permission->update(['name' => $newName]);
    $fresh = $permission->fresh();

    Assert::assertInstanceOf(Permission::class, $fresh);
    Assert::assertSame($newName, $fresh->name);
});

test('can handle null values', function (): void {
    $permission = modelsPermissionCreate();

    Permission::withoutEvents(static function () use ($permission): void {
        $permission->forceFill([
            'created_by' => null,
            'updated_by' => null,
        ])->save();
    });
    $permission->refresh();

    Assert::assertNull($permission->created_by);
    Assert::assertNull($permission->updated_by);
});

test('can find permissions by multiple criteria', function (): void {
    $marker = uniqid();
    $first = modelsPermissionCreate([
        'name' => "admin.user.create-{$marker}",
        'guard_name' => 'web',
    ]);
    $second = modelsPermissionCreate([
        'name' => "admin.user.update-{$marker}",
        'guard_name' => 'api',
    ]);

    Permission::withoutEvents(static function () use ($first, $second): void {
        $first->forceFill(['created_by' => 'admin'])->save();
        $second->forceFill(['created_by' => 'admin'])->save();
    });

    $permissions = Permission::where('name', 'like', "admin.user.%-{$marker}")
        ->where('created_by', 'admin')
        ->get();

    Assert::assertGreaterThanOrEqual(2, $permissions->count());
    foreach ($permissions as $permission) {
        Assert::assertInstanceOf(Permission::class, $permission);
        Assert::assertStringStartsWith('admin.user.', $permission->name);
        Assert::assertSame('admin', $permission->created_by);
    }
});

test('permission has table name', function (): void {
    Assert::assertNotSame('', (new Permission())->getTable());
});

test('permission can be deleted from database', function (): void {
    $permission = modelsPermissionCreate();
    $permissionId = $permission->id;

    DB::connection('user')->table($permission->getTable())->where('id', $permissionId)->delete();

    Assert::assertNull(Permission::query()->find($permissionId));
});
