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
    PermissionData::from([
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

});

test('PermissionModelsData can be instantiated', function () {
    PermissionModelsData::from([
        'permission' => 'Modules\User\Models\Permission',
        'role' => 'Modules\User\Models\Role',
    ]);

});

test('PermissionTableNamesData can be instantiated', function () {
    PermissionTableNamesData::from([
        'permissions' => 'permissions',
        'roles' => 'roles',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ]);

});

test('PermissionColumnNamesData can be instantiated', function () {
    PermissionColumnNamesData::from([
        'model_morph_key' => 'model_id',
    ]);

});

test('PermissionCacheData can be instantiated', function () {
    PermissionCacheData::from([
        'expiration_time' => DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ]);

});

test('DeviceData can be instantiated', function () {
    DeviceData::from([
        'id' => 1,
        'name' => 'Test Device',
        'user_id' => 1,
    ]);

});

test('SocialProviderData can be instantiated', function () {
    SocialProviderData::from([
        'id' => 1,
        'name' => 'google',
        'active' => true,
    ]);

});

test('FilamentUserData can be instantiated', function () {
    FilamentUserData::from([
        'id' => 1,
        'name' => 'Test User',
    ]);

});

test('SuperAdminData can be instantiated', function () {
    SuperAdminData::from([
        'id' => 1,
        'name' => 'Super Admin',
    ]);

});

test('FilamentShieldData can be instantiated', function () {
    FilamentShieldData::from([
        'enabled' => true,
    ]);

});

test('PasswordData can be instantiated', function () {
    PasswordData::from([
        'min' => 8,
        'max' => 100,
    ]);

});

test('ShieldResourceData can be instantiated', function () {
    ShieldResourceData::from([
        'name' => 'users',
        'enabled' => true,
    ]);

});
