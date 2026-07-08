<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\ProfileFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Profile;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Management Business Logic', function (): void {
    test('can create user with profile', function (): void {
        $userData = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ];

        $profileData = [
            'phone' => '+39 123 456 7890',
            'address' => 'Via Roma 123, Milano',
            'birth_date' => '1990-05-15',
            'gender' => 'M',
        ];

        $user = User::create($userData);
        $createdProfile = $user->profile()->create($profileData);
        Assert::assertInstanceOf(Profile::class, $createdProfile);
        $profile = $createdProfile;

        Assert::assertTrue(DB::table('users')->where([
            'id' => $user->id,
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
        ])->exists());
        Assert::assertTrue(DB::table('profiles')->where([
            'id' => $profile->id,
            'user_id' => $user->id,
            'phone' => '+39 123 456 7890',
            'address' => 'Via Roma 123, Milano',
        ])->exists());
        Assert::assertInstanceOf(Profile::class, $user->profile);
        Assert::assertSame($user->id, $profile->user_id);
    });

    test('can assign role to user', function (): void {
        $user = UserFactory::new()->createOne();
        $role = RoleFactory::new()->createOne(['name' => 'doctor']);

        $user->assignRole($role);

        Assert::assertTrue($user->hasRole('doctor'));
        Assert::assertTrue($user->hasRole($role));
        Assert::assertContains($role->name, $user->getRoleNames()->toArray());
    });

    test('can assign multiple roles to user', function (): void {
        $user = UserFactory::new()->createOne();
        $role1 = RoleFactory::new()->createOne(['name' => 'doctor']);
        $role2 = RoleFactory::new()->createOne(['name' => 'admin']);

        $user->assignRole([$role1, $role2]);

        Assert::assertTrue($user->hasRole('doctor'));
        Assert::assertTrue($user->hasRole('admin'));
        Assert::assertTrue($user->hasRole($role1));
        Assert::assertTrue($user->hasRole($role2));
        Assert::assertCount(2, $user->getRoleNames());
    });

    test('can remove role from user', function (): void {
        $user = UserFactory::new()->createOne();
        $role = RoleFactory::new()->createOne(['name' => 'doctor']);
        $user->assignRole($role);

        $user->removeRole($role);

        Assert::assertFalse($user->hasRole('doctor'));
        Assert::assertFalse($user->hasRole($role));
        Assert::assertCount(0, $user->getRoleNames());
    });

    test('can sync user roles', function (): void {
        $user = UserFactory::new()->createOne();
        $role1 = RoleFactory::new()->createOne(['name' => 'doctor']);
        $role2 = RoleFactory::new()->createOne(['name' => 'admin']);
        $role3 = RoleFactory::new()->createOne(['name' => 'nurse']);

        $user->assignRole([$role1, $role2]);

        $user->syncRoles([$role2, $role3]);

        Assert::assertFalse($user->hasRole('doctor'));
        Assert::assertTrue($user->hasRole('admin'));
        Assert::assertTrue($user->hasRole('nurse'));
        Assert::assertCount(2, $user->getRoleNames());
    });

    test('can check user permissions', function (): void {
        $user = UserFactory::new()->createOne();
        $role = RoleFactory::new()->createOne(['name' => 'doctor']);
        $permission = PermissionFactory::new()->createOne(['name' => 'patients.read']);

        $role->givePermissionTo($permission);
        $user->assignRole($role);

        Assert::assertTrue($user->hasPermissionTo('patients.read'));
        Assert::assertTrue($user->hasPermissionTo($permission));
        Assert::assertTrue($user->can('patients.read'));
    });

    test('can assign direct permission to user', function (): void {
        $user = UserFactory::new()->createOne();
        $permission = PermissionFactory::new()->createOne(['name' => 'special.permission']);

        $user->givePermissionTo($permission);

        Assert::assertTrue($user->hasPermissionTo('special.permission'));
        Assert::assertTrue($user->hasPermissionTo($permission));
        Assert::assertTrue($user->can('special.permission'));
    });

    test('can revoke direct permission from user', function (): void {
        $user = UserFactory::new()->createOne();
        $permission = PermissionFactory::new()->createOne(['name' => 'special.permission']);
        $user->givePermissionTo($permission);

        $user->revokePermissionTo($permission);

        Assert::assertFalse($user->hasPermissionTo('special.permission'));
        Assert::assertFalse($user->hasPermissionTo($permission));
        Assert::assertFalse($user->can('special.permission'));
    });

    test('can check user has any role', function (): void {
        $user = UserFactory::new()->createOne();
        $role1 = RoleFactory::new()->createOne(['name' => 'doctor']);
        $role2 = RoleFactory::new()->createOne(['name' => 'nurse']);

        $user->assignRole($role1);

        Assert::assertTrue($user->hasAnyRole(['doctor', 'nurse']));
        Assert::assertFalse($user->hasAnyRole(['nurse', 'admin']));
        Assert::assertFalse($user->hasAnyRole(['admin', 'super-admin']));
    });

    test('can check user has all roles', function (): void {
        $user = UserFactory::new()->createOne();
        $role1 = RoleFactory::new()->createOne(['name' => 'doctor']);
        $role2 = RoleFactory::new()->createOne(['name' => 'admin']);

        $user->assignRole([$role1, $role2]);

        Assert::assertTrue($user->hasAllRoles(['doctor', 'admin']));
        Assert::assertFalse($user->hasAllRoles(['doctor', 'nurse']));
    });

    test('can get user permissions', function (): void {
        $user = UserFactory::new()->createOne();
        $role = RoleFactory::new()->createOne(['name' => 'doctor']);
        $permission1 = PermissionFactory::new()->createOne(['name' => 'patients.read']);
        $permission2 = PermissionFactory::new()->createOne(['name' => 'patients.write']);

        $role->givePermissionTo([$permission1, $permission2]);
        $user->assignRole($role);

        $permissions = $user->getAllPermissions();

        Assert::assertCount(2, $permissions);
        Assert::assertTrue($permissions->contains($permission1));
        Assert::assertTrue($permissions->contains($permission2));
    });

    test('can get user roles', function (): void {
        $user = UserFactory::new()->createOne();
        $role1 = RoleFactory::new()->createOne(['name' => 'doctor']);
        $role2 = RoleFactory::new()->createOne(['name' => 'admin']);

        $user->assignRole([$role1, $role2]);

        $roles = $user->getRoleNames();

        Assert::assertCount(2, $roles);
        Assert::assertStringContainsString((string) 'doctor', (string) $roles);
        Assert::assertStringContainsString((string) 'admin', (string) $roles);
    });

    test('can check user is super admin', function (): void {
        $user = UserFactory::new()->createOne();
        $superAdminRole = RoleFactory::new()->createOne(['name' => 'super-admin']);

        $user->assignRole($superAdminRole);

        Assert::assertTrue($user->hasRole('super-admin'));
        Assert::assertTrue($user->isSuperAdmin());
    });

    test('can update user profile', function (): void {
        $user = UserFactory::new()->createOne();
        $createdProfile = ProfileFactory::new()->createOne([
            'user_id' => $user->id,
            'phone' => '+39 123 456 7890',
            'address' => 'Via Roma 123, Milano',
        ]);
        Assert::assertInstanceOf(Profile::class, $createdProfile);
        $profile = $createdProfile;

        $updatedData = [
            'phone' => '+39 987 654 3210',
            'address' => 'Via Milano 456, Roma',
            'birth_date' => '1985-10-20',
        ];

        $profile->update($updatedData);

        Assert::assertTrue(DB::table('profiles')->where([
            'id' => $profile->id,
            'phone' => '+39 987 654 3210',
            'address' => 'Via Milano 456, Roma',
            'birth_date' => '1985-10-20',
        ])->exists());
    });

    test('can delete user with profile', function (): void {
        $user = UserFactory::new()->createOne();
        $createdProfile = ProfileFactory::new()->createOne([
            'user_id' => $user->id,
            'phone' => '+39 123 456 7890',
        ]);
        Assert::assertInstanceOf(Profile::class, $createdProfile);
        $profile = $createdProfile;

        $profile->forceDelete();
        $user->forceDelete();

        Assert::assertFalse(DB::table('users')->where(['id' => $user->id])->exists());
        Assert::assertFalse(DB::table('profiles')->where(['id' => $profile->id])->exists());
    });

    test('can soft delete user', function (): void {
        /* @var TestCase $this */
        $this->skipTest('User model does not use SoftDeletes.');
    });

    test('can restore soft deleted user', function (): void {
        /* @var TestCase $this */
        $this->skipTest('User model does not use SoftDeletes.');
    });

    test('can force delete user', function (): void {
        $user = UserFactory::new()->createOne();
        $createdProfile = ProfileFactory::new()->createOne([
            'user_id' => $user->id,
            'phone' => '+39 123 456 7890',
        ]);
        Assert::assertInstanceOf(Profile::class, $createdProfile);
        $profile = $createdProfile;

        $profile->forceDelete();
        $user->forceDelete();

        Assert::assertFalse(DB::table('users')->where(['id' => $user->id])->exists());
        Assert::assertFalse(DB::table('profiles')->where(['id' => $profile->id])->exists());
    });

    test('can search users by name', function (): void {
        $user1 = UserFactory::new()->createOne(['name' => 'Mario Rossi']);
        $user2 = UserFactory::new()->createOne(['name' => 'Giulia Bianchi']);
        $user3 = UserFactory::new()->createOne(['name' => 'Marco Rossi']);

        $results = User::where('name', 'like', '%Rossi%')->get();

        Assert::assertCount(2, $results);
        Assert::assertTrue($results->contains($user1));
        Assert::assertTrue($results->contains($user3));
        Assert::assertFalse($results->contains($user2));
    });

    test('can search users by email', function (): void {
        $user1 = UserFactory::new()->createOne(['email' => 'mario@example.com']);
        $user2 = UserFactory::new()->createOne(['email' => 'giulia@test.com']);
        $user3 = UserFactory::new()->createOne(['email' => 'marco@example.org']);

        $results = User::where('email', 'like', '%@example%')->get();

        Assert::assertCount(2, $results);
        Assert::assertTrue($results->contains($user1));
        Assert::assertTrue($results->contains($user3));
        Assert::assertFalse($results->contains($user2));
    });

    test('can filter users by role', function (): void {
        $doctorRole = RoleFactory::new()->createOne(['name' => 'doctor']);
        $nurseRole = RoleFactory::new()->createOne(['name' => 'nurse']);

        $user1 = UserFactory::new()->createOne();
        $user2 = UserFactory::new()->createOne();
        $user3 = UserFactory::new()->createOne();

        $user1->assignRole($doctorRole);
        $user2->assignRole($nurseRole);
        $user3->assignRole($doctorRole);

        $doctors = User::role('doctor')->get();

        Assert::assertCount(2, $doctors);
        Assert::assertTrue($doctors->contains($user1));
        Assert::assertTrue($doctors->contains($user3));
        Assert::assertFalse($doctors->contains($user2));
    });

    test('can filter users by permission', function (): void {
        $role = RoleFactory::new()->createOne(['name' => 'doctor']);
        $permission = PermissionFactory::new()->createOne(['name' => 'patients.read']);

        $role->givePermissionTo($permission);

        $user1 = UserFactory::new()->createOne();
        $user2 = UserFactory::new()->createOne();

        $user1->assignRole($role);

        $usersWithPermission = User::permission('patients.read')->get();

        Assert::assertCount(1, $usersWithPermission);
        Assert::assertTrue($usersWithPermission->contains($user1));
        Assert::assertFalse($usersWithPermission->contains($user2));
    });

    test('can get users with roles and permissions', function (): void {
        $role = RoleFactory::new()->createOne(['name' => 'doctor']);
        $permission = PermissionFactory::new()->createOne(['name' => 'patients.read']);

        $role->givePermissionTo($permission);

        $user = UserFactory::new()->createOne();
        $user->assignRole($role);

        $userWithRelations = User::with(['roles', 'permissions'])->find($user->id);

        Assert::assertNotNull($userWithRelations);
        Assert::assertTrue($userWithRelations->relationLoaded('roles'));
        Assert::assertTrue($userWithRelations->relationLoaded('permissions'));
        Assert::assertCount(1, $userWithRelations->roles);
        Assert::assertCount(1, $userWithRelations->getAllPermissions());
    });

    test('can validate user email uniqueness', function (): void {
        /* @var TestCase $this */
        UserFactory::new()->createOne(['email' => 'test@example.com']);

        try {
            User::create([
                'name' => 'Another User',
                'email' => 'test@example.com',
                'password' => Hash::make('password123'),
            ]);
            $this->fail('Expected QueryException was not thrown');
        } catch (QueryException $exception) {
            Assert::assertInstanceOf(QueryException::class, $exception);
        }
    });

    test('can handle user email verification', function (): void {
        $user = UserFactory::new()->createOne(['email_verified_at' => null]);

        $user->markEmailAsVerified();

        Assert::assertNotNull($user->email_verified_at);
        Assert::assertTrue($user->hasVerifiedEmail());
    });

    test('can handle user status changes', function (): void {
        $user = UserFactory::new()->createOne(['is_active' => true]);

        $user->update(['is_active' => false]);

        $freshModel2 = $user->fresh();
        Assert::assertNotNull($freshModel2);
        Assert::assertFalse($freshModel2->is_active);

        $user->update(['is_active' => true]);

        $freshModel3 = $user->fresh();
        Assert::assertNotNull($freshModel3);
        Assert::assertTrue($freshModel3->is_active);
    });

    test('can handle user info', function (): void {
        $user = UserFactory::new()->createOne();

        $user->update(['lang' => 'it']);

        Assert::assertTrue(DB::table('users')->where([
            'id' => $user->id,
            'lang' => 'it',
        ])->exists());
    });
});
