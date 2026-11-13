<?php

declare(strict_types=1);
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
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('PermissionData can be instantiated', function () {
    expect(PermissionData::from([
        'models' => PermissionModelsData::from(['permission' => 'Modules\User\Models\Permission', 'role' => 'Modules\User\Models\Role']),
        'table_names' => PermissionTableNamesData::from(['permissions' => 'permissions', 'roles' => 'roles', 'model_has_permissions' => 'model_has_permissions', 'model_has_roles' => 'model_has_roles', 'role_has_permissions' => 'role_has_permissions']),
        'column_names' => PermissionColumnNamesData::from(['model_morph_key' => 'model_id']),
        'register_permission_check_method' => false,
        'teams' => false,
        'display_permission_in_exception' => false,
        'display_role_in_exception' => false,
        'enable_wildcard_permission' => false,
        'cache' => PermissionCacheData::from(['enabled' => true, 'key' => 'spatie.permission.cache', 'expiration_time' => DateInterval::createFromDateString('24 hours'), 'store' => 'default']),
    ]))->toEqual(PermissionData::from([
        'models' => PermissionModelsData::from(['permission' => 'Modules\User\Models\Permission', 'role' => 'Modules\User\Models\Role']),
        'table_names' => PermissionTableNamesData::from(['permissions' => 'permissions', 'roles' => 'roles', 'model_has_permissions' => 'model_has_permissions', 'model_has_roles' => 'model_has_roles', 'role_has_permissions' => 'role_has_permissions']),
        'column_names' => PermissionColumnNamesData::from(['model_morph_key' => 'model_id']),
        'register_permission_check_method' => false,
        'teams' => false,
        'display_permission_in_exception' => false,
        'display_role_in_exception' => false,
        'enable_wildcard_permission' => false,
        'cache' => PermissionCacheData::from(['enabled' => true, 'key' => 'spatie.permission.cache', 'expiration_time' => DateInterval::createFromDateString('24 hours'), 'store' => 'default']),
    ]));

});

test('PermissionModelsData can be instantiated', function () {
    expect(PermissionModelsData::from([
        'permission' => 'Modules\User\Models\Permission',
        'role' => 'Modules\User\Models\Role',
    ]))->toEqual(PermissionModelsData::from([
        'permission' => 'Modules\User\Models\Permission',
        'role' => 'Modules\User\Models\Role',
    ]));

});

test('PermissionTableNamesData can be instantiated', function () {
    expect(PermissionTableNamesData::from([
        'permissions' => 'permissions',
        'roles' => 'roles',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ]))->toEqual(PermissionTableNamesData::from([
        'permissions' => 'permissions',
        'roles' => 'roles',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ]));

});

test('PermissionColumnNamesData can be instantiated', function () {
    expect(PermissionColumnNamesData::from([
        'model_morph_key' => 'model_id',
    ]))->toEqual(PermissionColumnNamesData::from([
        'model_morph_key' => 'model_id',
    ]));

});

test('PermissionCacheData can be instantiated', function () {
    expect(PermissionCacheData::from([
        'expiration_time' => DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ]))->toEqual(PermissionCacheData::from([
        'expiration_time' => DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ]));

});

test('DeviceData can be instantiated', function () {
    expect(DeviceData::from([
        'id' => 1,
        'name' => 'Test Device',
        'user_id' => 1,
    ]))->toEqual(DeviceData::from([
        'id' => 1,
        'name' => 'Test Device',
        'user_id' => 1,
    ]));

});

test('SocialProviderData can be instantiated', function () {
    expect(SocialProviderData::from([
        'id' => 1,
        'name' => 'google',
        'active' => true,
    ]))->toEqual(SocialProviderData::from([
        'id' => 1,
        'name' => 'google',
        'active' => true,
    ]));

});

test('FilamentUserData can be instantiated', function () {
    expect(FilamentUserData::from([
        'id' => 1,
        'name' => 'Test User',
    ]))->toEqual(FilamentUserData::from([
        'id' => 1,
        'name' => 'Test User',
    ]));

});

test('SuperAdminData can be instantiated', function () {
    expect(SuperAdminData::from([
        'id' => 1,
        'name' => 'Super Admin',
    ]))->toEqual(SuperAdminData::from([
        'id' => 1,
        'name' => 'Super Admin',
    ]));

});

test('FilamentShieldData can be instantiated', function () {
    expect(FilamentShieldData::from([
        'enabled' => true,
    ]))->toEqual(FilamentShieldData::from([
        'enabled' => true,
    ]));

});

test('PasswordData can be instantiated', function () {
    expect(PasswordData::from([
        'min' => 8,
        'max' => 100,
    ]))->toEqual(PasswordData::from([
        'min' => 8,
        'max' => 100,
    ]));

});

test('ShieldResourceData can be instantiated', function () {
    expect(ShieldResourceData::from([
        'name' => 'users',
        'enabled' => true,
    ]))->toEqual(ShieldResourceData::from([
        'name' => 'users',
        'enabled' => true,
    ]));

});
