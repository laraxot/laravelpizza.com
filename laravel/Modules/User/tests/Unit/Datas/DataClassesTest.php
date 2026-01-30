<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

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

    expect($permissionData)->toBeInstanceOf(PermissionData::class);
});

test('PermissionModelsData can be instantiated', function () {
    $modelsData = PermissionModelsData::from([
        'permission' => 'Modules\User\Models\Permission',
        'role' => 'Modules\User\Models\Role',
    ]);

    expect($modelsData)->toBeInstanceOf(PermissionModelsData::class);
});

test('PermissionTableNamesData can be instantiated', function () {
    $tableNamesData = PermissionTableNamesData::from([
        'permissions' => 'permissions',
        'roles' => 'roles',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ]);

    expect($tableNamesData)->toBeInstanceOf(PermissionTableNamesData::class);
});

test('PermissionColumnNamesData can be instantiated', function () {
    $columnNamesData = PermissionColumnNamesData::from([
        'model_morph_key' => 'model_id',
    ]);

    expect($columnNamesData)->toBeInstanceOf(PermissionColumnNamesData::class);
});

test('PermissionCacheData can be instantiated', function () {
    $cacheData = PermissionCacheData::from([
        'expiration_time' => DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ]);

    expect($cacheData)->toBeInstanceOf(PermissionCacheData::class);
});

test('DeviceData can be instantiated', function () {
    $deviceData = DeviceData::from([
        'id' => 1,
        'name' => 'Test Device',
        'user_id' => 1,
    ]);

    expect($deviceData)->toBeInstanceOf(DeviceData::class);
});

test('SocialProviderData can be instantiated', function () {
    $socialProviderData = SocialProviderData::from([
        'id' => 1,
        'name' => 'google',
        'active' => true,
    ]);

    expect($socialProviderData)->toBeInstanceOf(SocialProviderData::class);
});

test('FilamentUserData can be instantiated', function () {
    $filamentUserData = FilamentUserData::from([
        'id' => 1,
        'name' => 'Test User',
    ]);

    expect($filamentUserData)->toBeInstanceOf(FilamentUserData::class);
});

test('SuperAdminData can be instantiated', function () {
    $superAdminData = SuperAdminData::from([
        'id' => 1,
        'name' => 'Super Admin',
    ]);

    expect($superAdminData)->toBeInstanceOf(SuperAdminData::class);
});

test('FilamentShieldData can be instantiated', function () {
    $filamentShieldData = FilamentShieldData::from([
        'enabled' => true,
    ]);

    expect($filamentShieldData)->toBeInstanceOf(FilamentShieldData::class);
});

test('PasswordData can be instantiated', function () {
    $passwordData = PasswordData::from([
        'min' => 8,
        'max' => 100,
    ]);

    expect($passwordData)->toBeInstanceOf(PasswordData::class);
});

test('ShieldResourceData can be instantiated', function () {
    $shieldResourceData = ShieldResourceData::from([
        'name' => 'users',
        'enabled' => true,
    ]);

    expect($shieldResourceData)->toBeInstanceOf(ShieldResourceData::class);
});
