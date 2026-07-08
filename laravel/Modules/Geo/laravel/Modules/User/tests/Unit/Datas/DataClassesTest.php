<?php

declare(strict_types=1);

use DateInterval;
use Modules\User\Datas\DeviceData;
use Modules\User\Datas\FilamentShieldData;
use Modules\User\Datas\FilamentUserData;
use Modules\User\Datas\PasswordData;
use Modules\User\Datas\PermissionCacheData;
use Modules\User\Datas\PermissionColumnNamesData;
use Modules\User\Datas\PermissionData;
use Modules\User\Datas\PermissionModelsData;
use Modules\User\Datas\PermissionTableNamesData;
use Modules\User\Datas\ShieldResourceData;
use Modules\User\Datas\SocialProviderData;
use Modules\User\Datas\SuperAdminData;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

test('PermissionData can be instantiated', function () {
    $permissionData = PermissionData::from([
        'models' => PermissionModelsData::from(['permission' => 'Modules\User\Models\Permission', 'role' => 'Modules\User\Models\Role']),
        'table_names' => PermissionTableNamesData::from(['permissions' => 'permissions', 'roles' => 'roles', 'model_has_permissions' => 'model_has_permissions', 'model_has_roles' => 'model_has_roles', 'role_has_permissions' => 'role_has_permissions']),
        'column_names' => PermissionColumnNamesData::from(['model_morph_key' => 'model_id']),
        'register_permission_check_method' => false,
        'teams' => false,
        'display_permission_in_exception' => false,
        'display_role_in_exception' => false,
        'enable_wildcard_permission' => false,
        'cache' => PermissionCacheData::from(['enabled' => true, 'key' => 'spatie.permission.cache', 'expiration_time' => DateInterval::createFromDateString('24 hours'), 'store' => 'default']),
    ]);

    Assert::assertInstanceOf(PermissionData::class, $permissionData);
});

test('PermissionModelsData can be instantiated', function () {
    $modelsData = PermissionModelsData::from([
        'permission' => 'Modules\User\Models\Permission',
        'role' => 'Modules\User\Models\Role',
    ]);

    Assert::assertInstanceOf(PermissionModelsData::class, $modelsData);
});

test('PermissionTableNamesData can be instantiated', function () {
    $tableNamesData = PermissionTableNamesData::from([
        'permissions' => 'permissions',
        'roles' => 'roles',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ]);

    Assert::assertInstanceOf(PermissionTableNamesData::class, $tableNamesData);
});

test('PermissionColumnNamesData can be instantiated', function () {
    $columnNamesData = PermissionColumnNamesData::from([
        'model_morph_key' => 'model_id',
    ]);

    Assert::assertInstanceOf(PermissionColumnNamesData::class, $columnNamesData);
});

test('PermissionCacheData can be instantiated', function () {
    $cacheData = PermissionCacheData::from([
        'expiration_time' => DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ]);

    Assert::assertInstanceOf(PermissionCacheData::class, $cacheData);
});

test('DeviceData can be instantiated', function () {
    $deviceData = DeviceData::from([
        'id' => 1,
        'name' => 'Test Device',
        'user_id' => 1,
    ]);

    Assert::assertInstanceOf(DeviceData::class, $deviceData);
});

test('SocialProviderData can be instantiated', function () {
    $socialProviderData = SocialProviderData::from([
        'id' => 1,
        'name' => 'google',
        'active' => true,
    ]);

    Assert::assertInstanceOf(SocialProviderData::class, $socialProviderData);
});

test('FilamentUserData can be instantiated', function () {
    $filamentUserData = FilamentUserData::from([
        'id' => 1,
        'name' => 'Test User',
    ]);

    Assert::assertInstanceOf(FilamentUserData::class, $filamentUserData);
});

test('SuperAdminData can be instantiated', function () {
    $superAdminData = SuperAdminData::from([
        'id' => 1,
        'name' => 'Super Admin',
    ]);

    Assert::assertInstanceOf(SuperAdminData::class, $superAdminData);
});

test('FilamentShieldData can be instantiated', function () {
    $filamentShieldData = FilamentShieldData::from([
        'enabled' => true,
    ]);

    Assert::assertInstanceOf(FilamentShieldData::class, $filamentShieldData);
});

test('PasswordData can be instantiated', function () {
    $passwordData = PasswordData::from([
        'min' => 8,
        'max' => 100,
    ]);

    Assert::assertInstanceOf(PasswordData::class, $passwordData);
});

test('ShieldResourceData can be instantiated', function () {
    $shieldResourceData = ShieldResourceData::from([
        'name' => 'users',
        'enabled' => true,
    ]);

    Assert::assertInstanceOf(ShieldResourceData::class, $shieldResourceData);
});
