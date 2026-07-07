<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\User\Tests\Unit;

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);
=======
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\ProfileFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\SocialiteUserFactory;
use Modules\User\Database\Factories\TenantFactory;
use Modules\User\Models\Permission;
use Modules\User\Models\Profile;
use Modules\User\Models\Role;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\Tenant;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;
>>>>>>> 6d3760fe (.)

uses(TestCase::class);

it('can create a user with basic attributes', function () {
<<<<<<< HEAD
    $user = User::factory()->create([
=======
    $email = 'john-'.uniqid('', true).'@example.com';
    $user = createTestUser([
>>>>>>> 6d3760fe (.)
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password123'),
    ]);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@example.com');
    expect($user->exists)->toBeTrue();
});

it('can create a user with profile', function () {
<<<<<<< HEAD
    $user = User::factory()->withProfile()->create([
=======
    skipUnlessUserTable('profiles', 'profiles table missing on user connection.');
    skipUnlessUserColumn('profiles', 'user_id', 'profiles.user_id column missing on user connection.');
    skipUnlessUserColumn('profiles', 'uuid', 'profiles.uuid column missing on user connection.');

    $email = 'jane-'.uniqid('', true).'@example.com';
    $user = createTestUser([
>>>>>>> 6d3760fe (.)
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    expect($user->profile)->toBeInstanceOf(\Modules\User\Models\Profile::class);
    expect($user->profile->user_id)->toBe($user->id);
});

it('can authenticate a user', function () {
<<<<<<< HEAD
    $user = User::factory()->create([
        'email' => 'auth@example.com',
=======
    $email = 'auth-'.uniqid('', true).'@example.com';
    $user = createTestUser([
        'email' => $email,
>>>>>>> 6d3760fe (.)
        'password' => bcrypt('secret123'),
    ]);

    $this->assertTrue(auth())
        'email' => 'auth@example.com',
        'password' => 'secret123',
    ]));
});

it('can create a user role', function () {
<<<<<<< HEAD
    $role = \Modules\User\Models\Role::factory()->create([
        'name' => 'admin',
=======
    $roleName = 'admin-'.uniqid();
    $role = RoleFactory::new()->createOne([
        'name' => $roleName,
>>>>>>> 6d3760fe (.)
        'guard_name' => 'web',
    ]);

    expect($role)->toBeInstanceOf(\Modules\User\Models\Role::class);
    expect($role->name)->toBe('admin');
});

it('can create a user permission', function () {
<<<<<<< HEAD
    $permission = \Modules\User\Models\Permission::factory()->create([
        'name' => 'edit_posts',
=======
    $permissionName = 'edit_posts_'.uniqid();
    $permission = PermissionFactory::new()->createOne([
        'name' => $permissionName,
>>>>>>> 6d3760fe (.)
        'guard_name' => 'web',
    ]);

    expect($permission)->toBeInstanceOf(\Modules\User\Models\Permission::class);
    expect($permission->name)->toBe('edit_posts');
});

it('can assign role to user', function () {
<<<<<<< HEAD
    $user = User::factory()->create();
    $role = \Modules\User\Models\Role::factory()->create([
        'name' => 'editor',
=======
    skipUnlessRoleAssignmentSupported();

    $user = createTestUser();
    $roleName = 'editor-'.uniqid();
    $role = RoleFactory::new()->createOne([
        'name' => $roleName,
>>>>>>> 6d3760fe (.)
        'guard_name' => 'web',
    ]);

    $user->assignRole($role);

    expect($user->hasRole('editor'))->toBeTrue();
});

it('can attach permission to user', function () {
<<<<<<< HEAD
    $user = User::factory()->create();
    $permission = \Modules\User\Models\Permission::factory()->create([
        'name' => 'delete_users',
=======
    skipUnlessDirectPermissionSupported();

    $user = createTestUser();
    $permissionName = 'delete_users_'.uniqid();
    $permission = PermissionFactory::new()->createOne([
        'name' => $permissionName,
>>>>>>> 6d3760fe (.)
        'guard_name' => 'web',
    ]);

    $user->givePermissionTo($permission);

    expect($user->can('delete_users'))->toBeTrue();
});

it('can create a tenant user', function () {
<<<<<<< HEAD
    $tenant = \Modules\Tenant\Models\Tenant::factory()->create([
        'name' => 'Test Tenant',
        'domain' => 'tenant.example.com',
=======
    skipUnlessUserColumn('users', 'tenant_id', 'users.tenant_id column missing on user connection.');

    $tenant = TenantFactory::new()->createOne([
        'name' => 'Test Tenant '.uniqid(),
        'domain' => 'tenant-'.uniqid().'.example.com',
>>>>>>> 6d3760fe (.)
    ]);

    $user = User::factory()->forTenant($tenant)->create([
        'name' => 'Tenant User',
        'email' => 'tenant@example.com',
    ]);

    expect($user->tenant_id)->toBe($tenant->id);
    expect($user->tenant->name)->toBe('Test Tenant');
});

it('can create a user with socialite data', function () {
<<<<<<< HEAD
    $user = User::factory()->create([
=======
    $email = 'social-'.uniqid('', true).'@example.com';
    $user = createTestUser([
>>>>>>> 6d3760fe (.)
        'name' => 'Social User',
        'email' => 'social@example.com',
    ]);

    $user->socialite()->create([
        'provider' => 'google',
        'provider_id' => 'google_12345',
        'token' => 'google_token',
    ]);

    expect($user->socialite->first())->toBeInstanceOf(\Modules\User\Models\Socialite::class);
    expect($user->socialite->first()->provider)->toBe('google');
});
