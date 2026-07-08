<?php

declare(strict_types=1);

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

uses(TestCase::class);

it('can create a user with basic attributes', function () {
    $email = 'john-'.uniqid('', true).'@example.com';
    $user = createTestUser([
        'name' => 'John Doe',
        'email' => $email,
        'password' => bcrypt('password123'),
    ]);

    Assert::assertInstanceOf(User::class, $user);
    Assert::assertSame('John Doe', $user->name);
    Assert::assertSame($email, $user->email);
    Assert::assertTrue($user->exists);
});

it('can create a user with profile', function () {
    skipUnlessUserTable('profiles', 'profiles table missing on user connection.');
    skipUnlessUserColumn('profiles', 'user_id', 'profiles.user_id column missing on user connection.');
    skipUnlessUserColumn('profiles', 'uuid', 'profiles.uuid column missing on user connection.');

    $email = 'jane-'.uniqid('', true).'@example.com';
    $user = createTestUser([
        'name' => 'Jane Smith',
        'email' => $email,
    ]);

    ProfileFactory::new()->createOne(['user_id' => $user->id]);

    $user->refresh();

    Assert::assertInstanceOf(Profile::class, $user->profile);
    Assert::assertSame($user->id, $user->profile->user_id);
});

it('can authenticate a user', function () {
    $email = 'auth-'.uniqid('', true).'@example.com';
    $user = createTestUser([
        'email' => $email,
        'password' => bcrypt('secret123'),
    ]);

    Assert::assertTrue(auth()->attempt([
        'email' => $email,
        'password' => 'secret123',
    ]));
    Assert::assertSame($user->id, auth()->id());
});

it('can create a user role', function () {
    $roleName = 'admin-'.uniqid();
    $role = RoleFactory::new()->createOne([
        'name' => $roleName,
        'guard_name' => 'web',
    ]);

    Assert::assertInstanceOf(Role::class, $role);
    Assert::assertSame($roleName, $role->name);
});

it('can create a user permission', function () {
    $permissionName = 'edit_posts_'.uniqid();
    $permission = PermissionFactory::new()->createOne([
        'name' => $permissionName,
        'guard_name' => 'web',
    ]);

    Assert::assertInstanceOf(Permission::class, $permission);
    Assert::assertSame($permissionName, $permission->name);
});

it('can assign role to user', function () {
    skipUnlessRoleAssignmentSupported();

    $user = createTestUser();
    $roleName = 'editor-'.uniqid();
    $role = RoleFactory::new()->createOne([
        'name' => $roleName,
        'guard_name' => 'web',
    ]);

    $user->assignRole($role);

    Assert::assertTrue($user->hasRole($roleName));
});

it('can attach permission to user', function () {
    skipUnlessDirectPermissionSupported();

    $user = createTestUser();
    $permissionName = 'delete_users_'.uniqid();
    $permission = PermissionFactory::new()->createOne([
        'name' => $permissionName,
        'guard_name' => 'web',
    ]);

    $user->givePermissionTo($permission);

    Assert::assertTrue($user->can($permissionName));
});

it('can create a tenant user', function () {
    skipUnlessUserColumn('users', 'tenant_id', 'users.tenant_id column missing on user connection.');

    $tenant = TenantFactory::new()->createOne([
        'name' => 'Test Tenant '.uniqid(),
        'domain' => 'tenant-'.uniqid().'.example.com',
    ]);

    $email = 'tenant-'.uniqid('', true).'@example.com';
    $user = createTestUser([
        'name' => 'Tenant User',
        'email' => $email,
        'tenant_id' => $tenant->id,
    ]);

    Assert::assertSame($tenant->id, $user->getAttribute('tenant_id'));
    $tenantRelation = $user->getRelationValue('tenant');
    Assert::assertInstanceOf(Tenant::class, $tenantRelation);
    Assert::assertSame($tenant->name, $tenantRelation->name);
});

it('can create a user with socialite data', function () {
    $email = 'social-'.uniqid('', true).'@example.com';
    $user = createTestUser([
        'name' => 'Social User',
        'email' => $email,
    ]);

    SocialiteUserFactory::new()->createOne([
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google_'.uniqid(),
        'token' => 'google_token',
    ]);

    $socialiteUser = $user->socialiteUsers()->first();

    Assert::assertInstanceOf(SocialiteUser::class, $socialiteUser);
    Assert::assertSame('google', $socialiteUser->provider);
});
