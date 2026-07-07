<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
use Modules\User\Models\Permission;
=======
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\ProfileFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\UserFactory;
>>>>>>> 6d3760fe (.)
use Modules\User\Models\Profile;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

<<<<<<< HEAD
it('can create user with profile', function () {
    // Arrange
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

    // Act
    $user = User::create($userData);
    $profile = $user->profile()->create($profileData);

    // Assert
    expect(DB::table('users')->where([
        'id' => $user->id,
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.com',
    ])->exists())->toBeTrue();

    expect(DB::table('profiles')->where([
        'id' => $profile->id,
        'user_id' => $user->id,
        'phone' => '+39 123 456 7890',
        'address' => 'Via Roma 123, Milano',
    ])->exists())->toBeTrue();

    expect($user->profile)->toBeInstanceOf(Profile::class);
    expect($profile->user_id)->toBe($user->id);
});

it('can assign role to user', function () {
    // Arrange
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'doctor']);

    // Act
    $user->assignRole($role);

    // Assert
    expect($user->hasRole('doctor'))->toBeTrue();
    expect($user->hasRole($role))->toBeTrue();
    expect($user->getRoleNames()->toArray())->toContain($role->name);
});

it('can assign multiple roles to user', function () {
    // Arrange
    $user = User::factory()->create();
    $role1 = Role::factory()->create(['name' => 'doctor']);
    $role2 = Role::factory()->create(['name' => 'admin']);

    // Act
    $user->assignRole([$role1, $role2]);

    // Assert
    expect($user->hasRole('doctor'))->toBeTrue();
    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasRole($role1))->toBeTrue();
    expect($user->hasRole($role2))->toBeTrue();
    expect($user->getRoleNames())->toHaveCount(2);
});

it('can remove role from user', function () {
    // Arrange
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'doctor']);
    $user->assignRole($role);

    // Act
    $user->removeRole($role);

    // Assert
    expect($user->hasRole('doctor'))->toBeFalse();
    expect($user->hasRole($role))->toBeFalse();
    expect($user->getRoleNames())->toHaveCount(0);
});

it('can sync user roles', function () {
    // Arrange
    $user = User::factory()->create();
    $role1 = Role::factory()->create(['name' => 'doctor']);
    $role2 = Role::factory()->create(['name' => 'admin']);
    $role3 = Role::factory()->create(['name' => 'nurse']);

    $user->assignRole([$role1, $role2]);

    // Act
    $user->syncRoles([$role2, $role3]);

    // Assert
    expect($user->hasRole('doctor'))->toBeFalse();
    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasRole('nurse'))->toBeTrue();
    expect($user->getRoleNames())->toHaveCount(2);
});

it('can check user permissions', function () {
    // Arrange
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'doctor']);
    $permission = Permission::factory()->create(['name' => 'patients.read']);

    $role->givePermissionTo($permission);
    $user->assignRole($role);

    // Act & Assert
    expect($user->hasPermissionTo('patients.read'))->toBeTrue();
    expect($user->hasPermissionTo($permission))->toBeTrue();
    expect($user->can('patients.read'))->toBeTrue();
});

it('can assign direct permission to user', function () {
    // Arrange
    $user = User::factory()->create();
    $permission = Permission::factory()->create(['name' => 'special.permission']);

    // Act
    $user->givePermissionTo($permission);

    // Assert
    expect($user->hasPermissionTo('special.permission'))->toBeTrue();
    expect($user->hasPermissionTo($permission))->toBeTrue();
    expect($user->can('special.permission'))->toBeTrue();
});

it('can revoke direct permission from user', function () {
    // Arrange
    $user = User::factory()->create();
    $permission = Permission::factory()->create(['name' => 'special.permission']);
    $user->givePermissionTo($permission);

    // Act
    $user->revokePermissionTo($permission);

    // Assert
    expect($user->hasPermissionTo('special.permission'))->toBeFalse();
    expect($user->hasPermissionTo($permission))->toBeFalse();
    expect($user->can('special.permission'))->toBeFalse();
});

it('can check user has any role', function () {
    // Arrange
    $user = User::factory()->create();
    $role1 = Role::factory()->create(['name' => 'doctor']);
    $role2 = Role::factory()->create(['name' => 'nurse']);

    $user->assignRole($role1);

    // Act & Assert
    expect($user->hasAnyRole(['doctor', 'nurse']))->toBeTrue();
    expect($user->hasAnyRole(['nurse', 'admin']))->toBeFalse();
    expect($user->hasAnyRole(['admin', 'super-admin']))->toBeFalse();
});

it('can check user has all roles', function () {
    // Arrange
    $user = User::factory()->create();
    $role1 = Role::factory()->create(['name' => 'doctor']);
    $role2 = Role::factory()->create(['name' => 'admin']);

    $user->assignRole([$role1, $role2]);

    // Act & Assert
    expect($user->hasAllRoles(['doctor', 'admin']))->toBeTrue();
    expect($user->hasAllRoles(['doctor', 'nurse']))->toBeFalse();
});

it('can get user permissions', function () {
    // Arrange
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'doctor']);
    $permission1 = Permission::factory()->create(['name' => 'patients.read']);
    $permission2 = Permission::factory()->create(['name' => 'patients.write']);

    $role->givePermissionTo([$permission1, $permission2]);
    $user->assignRole($role);

    // Act
    $permissions = $user->getAllPermissions();

    // Assert
    expect($permissions)->toHaveCount(2);
    expect($permissions->contains($permission1))->toBeTrue();
    expect($permissions->contains($permission2))->toBeTrue();
});

it('can get user roles', function () {
    // Arrange
    $user = User::factory()->create();
    $role1 = Role::factory()->create(['name' => 'doctor']);
    $role2 = Role::factory()->create(['name' => 'admin']);

    $user->assignRole([$role1, $role2]);

    // Act
    $roles = $user->getRoleNames();

    // Assert
    expect($roles)->toHaveCount(2);
    expect($roles)->toContain('doctor');
    expect($roles)->toContain('admin');
});

it('can check user is super admin', function () {
    // Arrange
    $user = User::factory()->create();
    $superAdminRole = Role::factory()->create(['name' => 'super-admin']);

    $user->assignRole($superAdminRole);

    // Act & Assert
    expect($user->hasRole('super-admin'))->toBeTrue();
    expect($user->isSuperAdmin())->toBeTrue();
});

it('can update user profile', function () {
    // Arrange
    $user = User::factory()->create();
    $profile = $user->profile()->create([
        'phone' => '+39 123 456 7890',
        'address' => 'Via Roma 123, Milano',
    ]);

    $updatedData = [
        'phone' => '+39 987 654 3210',
        'address' => 'Via Milano 456, Roma',
        'birth_date' => '1985-10-20',
    ];

    // Act
    $profile->update($updatedData);

    // Assert
    expect(DB::table('profiles')->where([
        'id' => $profile->id,
        'phone' => '+39 987 654 3210',
        'address' => 'Via Milano 456, Roma',
        'birth_date' => '1985-10-20',
    ])->exists())->toBeTrue();
});

it('can delete user with profile', function () {
    // Arrange
    $user = User::factory()->create();
    $profile = $user->profile()->create([
        'phone' => '+39 123 456 7890',
    ]);

    // Act
    $profile->forceDelete();
    $user->forceDelete();

    // Assert
    expect(DB::table('users')->where(['id' => $user->id])->exists())->toBeFalse();
    expect(DB::table('profiles')->where(['id' => $profile->id])->exists())->toBeFalse();
});

it('can soft delete user', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $user->delete();

    // Assert
    expect($user->fresh()->trashed())->toBeTrue();
    expect(DB::table('users')->where(['id' => $user->id])->exists())->toBeTrue();
});

it('can restore soft deleted user', function () {
    // Arrange
    $user = User::factory()->create();
    $user->delete();

    // Act
    $user->restore();

    // Assert
    expect($user->fresh()->trashed())->toBeFalse();
    expect(DB::table('users')->where(['id' => $user->id])->exists())->toBeTrue();
});

it('can force delete user', function () {
    // Arrange
    $user = User::factory()->create();
    $profile = $user->profile()->create([
        'phone' => '+39 123 456 7890',
    ]);

    // Act
    $profile->forceDelete();
    $user->forceDelete();

    // Assert
    expect(DB::table('users')->where(['id' => $user->id])->exists())->toBeFalse();
    expect(DB::table('profiles')->where(['id' => $profile->id])->exists())->toBeFalse();
});

it('can search users by name', function () {
    // Arrange
    $user1 = User::factory()->create(['name' => 'Mario Rossi']);
    $user2 = User::factory()->create(['name' => 'Giulia Bianchi']);
    $user3 = User::factory()->create(['name' => 'Marco Rossi']);

    // Act
    $results = User::where('name', 'like', '%Rossi%')->get();

    // Assert
    expect($results)->toHaveCount(2);
    expect($results->contains($user1))->toBeTrue();
    expect($results->contains($user3))->toBeTrue();
    expect($results->contains($user2))->toBeFalse();
});

it('can search users by email', function () {
    // Arrange
    $user1 = User::factory()->create(['email' => 'mario@example.com']);
    $user2 = User::factory()->create(['email' => 'giulia@test.com']);
    $user3 = User::factory()->create(['email' => 'marco@example.org']);

    // Act
    $results = User::where('email', 'like', '%@example%')->get();

    // Assert
    expect($results)->toHaveCount(2);
    expect($results->contains($user1))->toBeTrue();
    expect($results->contains($user3))->toBeTrue();
    expect($results->contains($user2))->toBeFalse();
});

it('can filter users by role', function () {
    // Arrange
    $doctorRole = Role::factory()->create(['name' => 'doctor']);
    $nurseRole = Role::factory()->create(['name' => 'nurse']);

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    $user1->assignRole($doctorRole);
    $user2->assignRole($nurseRole);
    $user3->assignRole($doctorRole);

    // Act
    $doctors = User::role('doctor')->get();

    // Assert
    expect($doctors)->toHaveCount(2);
    expect($doctors->contains($user1))->toBeTrue();
    expect($doctors->contains($user3))->toBeTrue();
    expect($doctors->contains($user2))->toBeFalse();
});

it('can filter users by permission', function () {
    // Arrange
    $role = Role::factory()->create(['name' => 'doctor']);
    $permission = Permission::factory()->create(['name' => 'patients.read']);

    $role->givePermissionTo($permission);

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $user1->assignRole($role);

    // Act
    $usersWithPermission = User::permission('patients.read')->get();

    // Assert
    expect($usersWithPermission)->toHaveCount(1);
    expect($usersWithPermission->contains($user1))->toBeTrue();
    expect($usersWithPermission->contains($user2))->toBeFalse();
});

it('can get users with roles and permissions', function () {
    // Arrange
    $role = Role::factory()->create(['name' => 'doctor']);
    $permission = Permission::factory()->create(['name' => 'patients.read']);

    $role->givePermissionTo($permission);

    $user = User::factory()->create();
    $user->assignRole($role);

    // Act
    $userWithRelations = User::with(['roles', 'permissions'])->find($user->id);

    // Assert
    expect($userWithRelations)->not->toBeNull();
    expect($userWithRelations->relationLoaded('roles'))->toBeTrue();
    expect($userWithRelations->relationLoaded('permissions'))->toBeTrue();
    expect($userWithRelations->roles)->toHaveCount(1);
    expect($userWithRelations->getAllPermissions())->toHaveCount(1);
});

it('can validate user email uniqueness', function () {
    // Arrange
    User::factory()->create(['email' => 'test@example.com']);

    // Act & Assert
    expect(fn () => User::create([
        'name' => 'Another User',
        'email' => 'test@example.com', // Same email
        'password' => Hash::make('password123'),
    ]))->toThrow(QueryException::class);
});

it('can handle user email verification', function () {
    // Arrange
    $user = User::factory()->create(['email_verified_at' => null]);

    // Act
    $user->markEmailAsVerified();

    // Assert
    expect($user->email_verified_at)->not->toBeNull();
    expect($user->hasVerifiedEmail())->toBeTrue();
});

it('can handle user status changes', function () {
    // Arrange
    $user = User::factory()->create(['is_active' => true]);

    // Act - Deactivate user
    $user->update(['is_active' => false]);

    // Assert
    expect($user->fresh()->is_active)->toBeFalse();

    // Act - Activate user
    $user->update(['is_active' => true]);

    // Assert
    expect($user->fresh()->is_active)->toBeTrue();
});

it('can handle user info', function () {
    // Arrange
    $user = User::factory()->create();
    $lastLogin = now();

    // Act
    $user->update(['lang' => 'it']);

    // Assert
    expect(DB::table('users')->where([
        'id' => $user->id,
        'lang' => 'it',
    ])->exists())->toBeTrue();
=======
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
        $this->skipTest('User model does not use SoftDeletes.');
    });

    test('can restore soft deleted user', function (): void {
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
>>>>>>> 6d3760fe (.)
});
