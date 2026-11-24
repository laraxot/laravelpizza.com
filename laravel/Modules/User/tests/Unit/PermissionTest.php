<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * Fixture del permesso su cui girano i test di questo file.
 *
 * Prima era una proprieta' dinamica assegnata in `beforeEach()` (`$this->permission`), e
 * questo rompeva due cose insieme:
 *
 * - PHP 8.2 ha deprecato le proprieta' dinamiche: la TestCase non dichiara `$permission`,
 *   quindi l'assegnazione vive solo grazie a una deprecation;
 * - dentro una closure di Pest `$this` non e' la TestCase del modulo ma
 *   `Pest\PendingCalls\TestCall`, il cui `@mixin` e' `PHPUnit\Framework\TestCase`. Il valore
 *   letto era quindi `mixed`, e ogni `->name`, `->getFillable()`, `->assignRole()` su quel
 *   `mixed` era una segnalazione a sé.
 *
 * Una funzione tipizzata da' a ogni test lo stesso oggetto nuovo di `beforeEach()` e un tipo
 * vero a tutti i chiamanti. `createOne()` e non `create()`: `create()` e' dichiarato
 * `TModel|Collection<int, TModel>` perche' con `count()` restituisce una collezione, mentre
 * qui serve — ed e' sempre stato inteso — un singolo model.
 */
function userTestPermission(): Permission
{
    return Permission::factory()->createOne([
        'name' => 'test-permission',
        'guard_name' => 'web',
    ]);
}

test('permission can be created', function (): void {
    $permission = userTestPermission();

    expect($permission->name)->toBe('test-permission');
    expect($permission->guard_name)->toBe('web');
});

test('permission has correct fillable attributes', function (): void {
    $fillable = userTestPermission()->getFillable();

    expect($fillable)->toContain('name');
    expect($fillable)->toContain('guard_name');
    expect($fillable)->toContain('display_name');
    expect($fillable)->toContain('description');
    expect($fillable)->toContain('created_by');
    expect($fillable)->toContain('updated_by');
});

test('permission has correct table configuration', function (): void {
    $table = userTestPermission()->getTable();

    expect($table)->not->toBeEmpty();
});

test('permission has correct casts', function (): void {
    $casts = userTestPermission()->getCasts();

    // permissions.id e' bigIncrements: il model dichiara solo il cast della chiave intera.
    expect($casts)->toHaveKey('id');
    expect($casts['id'])->toBe('int');
});

test('permission can be updated', function (): void {
    $permission = userTestPermission();

    $permission->update([
        'name' => 'updated-permission',
        'guard_name' => 'api',
    ]);

    $permission->refresh();

    expect($permission->name)->toBe('updated-permission');
    expect($permission->guard_name)->toBe('api');
});

test('permission can be deleted', function (): void {
    $permission = userTestPermission();
    $permissionId = $permission->id;

    $permission->delete();

    expect(Permission::find($permissionId))->toBeNull();
});

test('permission can be assigned to roles', function (): void {
    $permission = userTestPermission();

    $role = Role::factory()->createOne([
        'name' => 'test-role',
        'guard_name' => 'web',
    ]);

    $role->givePermissionTo($permission);

    expect($role->hasPermissionTo($permission))->toBeTrue();
    expect($permission->roles)->toHaveCount(1);
});

test('permission can be assigned to multiple roles', function (): void {
    $permission = userTestPermission();

    $role1 = Role::factory()->createOne(['name' => 'role-1']);
    $role2 = Role::factory()->createOne(['name' => 'role-2']);

    $permission->assignRole($role1);
    $permission->assignRole($role2);

    expect($permission->roles)->toHaveCount(2);
    expect($permission->hasRole($role1))->toBeTrue();
    expect($permission->hasRole($role2))->toBeTrue();
});

test('permission can be found by name', function (): void {
    $permission = userTestPermission();

    $foundPermission = Permission::where('name', 'test-permission')->firstOrFail();
    expect($foundPermission->id)->toBe($permission->id);
});

test('permission can be found by guard', function (): void {
    $permission = userTestPermission();

    $webPermissions = Permission::where('guard_name', 'web')->get();

    expect($webPermissions)->toHaveCount(1);
    expect($webPermissions->firstOrFail()->id)->toBe($permission->id);
});

test('permission has timestamps', function (): void {
    $permission = userTestPermission();

    expect($permission->created_at)->not->toBeNull();
    expect($permission->updated_at)->not->toBeNull();
});

test('permission can be created with factory', function (): void {
    $permission = Permission::factory()->createOne();

    expect($permission->name)->not->toBeEmpty();
    expect($permission->guard_name)->not->toBeEmpty();
});

test('permission can be created with specific attributes', function (): void {
    $permission = Permission::factory()->createOne([
        'name' => 'custom-permission',
        'guard_name' => 'custom-guard',
    ]);

    expect($permission->name)->toBe('custom-permission');
    expect($permission->guard_name)->toBe('custom-guard');
});

test('permission can check if it has role', function (): void {
    $permission = userTestPermission();

    $role = Role::factory()->createOne(['name' => 'test-role']);

    expect($permission->hasRole($role))->toBeFalse();

    $permission->assignRole($role);

    expect($permission->hasRole($role))->toBeTrue();
});

test('permission can check if it has any roles', function (): void {
    $permission = userTestPermission();

    expect($permission->hasAnyRole([]))->toBeFalse();

    $role = Role::factory()->createOne(['name' => 'test-role']);
    $permission->assignRole($role);

    expect($permission->hasAnyRole([$role]))->toBeTrue();
});

test('permission can check if it has all roles', function (): void {
    $permission = userTestPermission();

    $role1 = Role::factory()->createOne(['name' => 'role-1']);
    $role2 = Role::factory()->createOne(['name' => 'role-2']);

    $permission->syncRoles([$role1, $role2]);

    expect($permission->hasAllRoles([$role1, $role2]))->toBeTrue();
    expect($permission->hasAllRoles([$role1]))->toBeTrue();
    expect($permission->hasAllRoles([$role1, $role2, 'non-existent']))->toBeFalse();
});

test('permission can be revoked from role', function (): void {
    $permission = userTestPermission();

    $role = Role::factory()->createOne(['name' => 'test-role']);

    $permission->assignRole($role);
    expect($permission->hasRole($role))->toBeTrue();

    $permission->removeRole($role);
    expect($permission->hasRole($role))->toBeFalse();
});

test('permission can be synced with roles', function (): void {
    $permission = userTestPermission();

    $role1 = Role::factory()->createOne(['name' => 'role-1']);
    $role2 = Role::factory()->createOne(['name' => 'role-2']);
    $role3 = Role::factory()->createOne(['name' => 'role-3']);

    // Initially assign role1 and role2
    $permission->syncRoles([$role1, $role2]);
    expect($permission->roles)->toHaveCount(2);

    // Sync to only role2 and role3
    $permission->syncRoles([$role2, $role3]);
    expect($permission->roles)->toHaveCount(2);
    expect($permission->hasRole($role1))->toBeFalse();
    expect($permission->hasRole($role2))->toBeTrue();
    expect($permission->hasRole($role3))->toBeTrue();
});
