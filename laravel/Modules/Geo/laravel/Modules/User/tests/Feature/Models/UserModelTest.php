<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Models;

use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\SocialiteUserFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    $this->skipUnlessUsersTableReady();
});

describe('User Model', function (): void {
    test('can create user with factory', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertInstanceOf(User::class, $user);
        Assert::assertNotNull($user->id);
        Assert::assertNotNull($user->email);
        Assert::assertNotNull($user->name);
    });

    test('user has email attribute', function (): void {
        $email = 'test-'.uniqid().'@example.com';
        $user = UserFactory::new()->createOne(['email' => $email]);

        Assert::assertSame($email, $user->email);
    });

    test('user has name attribute', function (): void {
        $name = 'John Doe';
        $user = UserFactory::new()->createOne(['name' => $name]);

        Assert::assertSame($name, $user->name);
    });

    test('user has first name and last name attributes', function (): void {
        $user = UserFactory::new()->createOne([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        Assert::assertSame('John', $user->first_name);
        Assert::assertSame('Doe', $user->last_name);
    });

    test('user is active by default', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertTrue($user->is_active);
    });

    test('user can have roles assigned', function (): void {
        $user = UserFactory::new()->createOne();
        $role = RoleFactory::new()->createOne(['guard_name' => 'web']);

        $user->assignRole($role);

        Assert::assertSame(1, $user->roles()->count());
        $firstRole = $user->roles()->first();
        Assert::assertNotNull($firstRole);
        Assert::assertInstanceOf(Role::class, $firstRole);
        Assert::assertSame($role->id, $firstRole->getKey());
    });

    test('user can have multiple roles', function (): void {
        $user = UserFactory::new()->createOne();
        $role1 = RoleFactory::new()->createOne(['name' => 'admin', 'guard_name' => 'web']);
        $role2 = RoleFactory::new()->createOne(['name' => 'editor', 'guard_name' => 'web']);

        $user->assignRole([$role1, $role2]);

        Assert::assertSame(2, $user->roles()->count());
    });

    test('user can have permissions', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessDirectPermissionSupported();

        $user = UserFactory::new()->createOne();
        $permission = PermissionFactory::new()->createOne(['guard_name' => 'web', 'name' => 'permission-'.uniqid()]);

        $user->givePermissionTo($permission);

        Assert::assertSame(1, $user->permissions()->count());
    });

    test('user can check if has role', function (): void {
        $user = UserFactory::new()->createOne();
        $role = RoleFactory::new()->createOne(['name' => 'admin-'.uniqid(), 'guard_name' => 'web']);

        $user->assignRole($role);

        Assert::assertTrue($user->hasRole($role));
        Assert::assertTrue($user->hasRole($role->name));
    });

    test('user can check if has permission', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessDirectPermissionSupported();

        $user = UserFactory::new()->createOne();
        $permission = PermissionFactory::new()->createOne(['name' => 'perm-'.uniqid(), 'guard_name' => 'web']);

        $user->givePermissionTo($permission);

        Assert::assertTrue($user->hasPermissionTo($permission));
    });

    test('user can have password hash', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertNotNull($user->password);
        Assert::assertGreaterThan(10, strlen($user->password));
    });

    test('password is hidden from serialization', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertTrue(in_array('password', $user->getHidden(), true));
    });

    test('user can have remember token', function (): void {
        $user = UserFactory::new()->createOne();
        $token = 'test-remember-token';

        $user->remember_token = $token;
        $user->save();

        $retrieved = User::query()->findOrFail($user->id);
        Assert::assertSame($token, $retrieved->remember_token);
    });

    test('user can be inactive', function (): void {
        $user = UserFactory::new()->createOne(['is_active' => false]);

        Assert::assertFalse($user->is_active);
    });

    test('user can be active', function (): void {
        $user = UserFactory::new()->createOne(['is_active' => true]);

        Assert::assertTrue($user->is_active);
    });

    test('user has phone attribute', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertInstanceOf(User::class, $user);
    });

    test('user has email verified at timestamp', function (): void {
        $user = UserFactory::new()->createOne(['email_verified_at' => now()]);

        Assert::assertNotNull($user->email_verified_at);
    });

    test('user can have unverified email', function (): void {
        $user = UserFactory::new()->createOne(['email_verified_at' => null]);

        Assert::assertNull($user->email_verified_at);
    });

    test('user can access filament by default', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertTrue($user->canAccessFilament());
    });

    test('user can access socialite by default', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertTrue($user->canAccessSocialite());
    });

    test('user has timestamps', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertNotNull($user->created_at);
        Assert::assertNotNull($user->updated_at);
    });

    test('user uses uuid as primary key', function (): void {
        $user = UserFactory::new()->createOne();

        Assert::assertNotNull($user->id);
        Assert::assertGreaterThan(0, strlen($user->id));
    });

    test('user increments is false for uuid', function (): void {
        Assert::assertFalse(UserFactory::new()->makeOne()->incrementing);
    });

    test('user fillable attributes are correct', function (): void {
        $user = UserFactory::new()->makeOne();

        Assert::assertTrue(in_array('email', $user->getFillable(), true));
        Assert::assertTrue(in_array('name', $user->getFillable(), true));
    });

    test('user connection is user', function (): void {
        $user = UserFactory::new()->makeOne();

        Assert::assertSame('user', $user->getConnectionName());
    });

    test('user can be queried by email', function (): void {
        $email = 'unique-test-'.uniqid('', true).'@example.com';
        UserFactory::new()->createOne(['email' => $email]);

        $user = User::where('email', $email)->first();

        Assert::assertNotNull($user);
        Assert::assertSame($email, $user->email);
    });

    test('user can be updated', function (): void {
        $user = UserFactory::new()->createOne(['name' => 'Original Name']);
        $originalId = $user->id;

        $user->update(['name' => 'Updated Name']);

        Assert::assertSame('Updated Name', $user->name);
        $refreshed = User::query()->findOrFail($originalId);
        Assert::assertSame('Updated Name', $refreshed->name);
    });

    test('user can be deleted', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessDirectPermissionSupported();

        $user = UserFactory::new()->createOne();
        $userId = $user->id;

        $user->delete();

        $deleted = User::find($userId);
        Assert::assertNull($deleted);
    });

    test('user has current team id attribute', function (): void {
        $user = UserFactory::new()->createOne(['current_team_id' => 'team-123']);

        Assert::assertSame('team-123', $user->current_team_id);
    });

    test('user has lang attribute for localization', function (): void {
        $user = UserFactory::new()->createOne(['lang' => 'it']);

        Assert::assertSame('it', $user->lang);
    });

    test('user belongs to socialite users', function (): void {
        $user = UserFactory::new()->createOne();
        SocialiteUserFactory::new()->createOne([
            'user_id' => $user->id,
            'provider' => 'google',
            'provider_id' => 'google-'.uniqid(),
        ]);

        $socialiteUsers = $user->socialiteUsers()->get();

        Assert::assertCount(1, $socialiteUsers);
        $firstSocialite = $socialiteUsers->first();
        Assert::assertNotNull($firstSocialite);
        Assert::assertSame('google', $firstSocialite->provider);
    });

    test('user can have multiple socialite accounts', function (): void {
        $user = UserFactory::new()->createOne();
        SocialiteUserFactory::new()->createOne([
            'user_id' => $user->id,
            'provider' => 'google',
            'provider_id' => 'google-'.uniqid(),
        ]);
        SocialiteUserFactory::new()->createOne([
            'user_id' => $user->id,
            'provider' => 'github',
            'provider_id' => 'github-'.uniqid(),
        ]);

        Assert::assertSame(2, $user->socialiteUsers()->count());
    });
});
