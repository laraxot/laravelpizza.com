<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Models\Permission;
use Modules\User\Models\Profile;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

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
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.com',
    ]);

    $this->assertDatabaseHas('profiles', [
        'id' => $profile->id,
        'user_id' => $user->id,
        'phone' => '+39 123 456 7890',
        'address' => 'Via Roma 123, Milano',
    ]);

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
    expect($user->hasAnyRole(['nurse', 'admin']))->toBeTrue();
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

it('can check user is admin', function () {
    // Arrange
    $user = User::factory()->create();
    $adminRole = Role::factory()->create(['name' => 'admin']);

    $user->assignRole($adminRole);

    // Act & Assert
    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->isAdmin())->toBeTrue();
});

it('can check user is doctor', function () {
    // Arrange
    $user = User::factory()->create();
    $doctorRole = Role::factory()->create(['name' => 'doctor']);

    $user->assignRole($doctorRole);

    // Act & Assert
    expect($user->hasRole('doctor'))->toBeTrue();
    expect($user->isDoctor())->toBeTrue();
});

it('can check user is patient', function () {
    // Arrange
    $user = User::factory()->create();
    $patientRole = Role::factory()->create(['name' => 'patient']);

    $user->assignRole($patientRole);

    // Act & Assert
    expect($user->hasRole('patient'))->toBeTrue();
    expect($user->isPatient())->toBeTrue();
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
    $this->assertDatabaseHas('profiles', [
        'id' => $profile->id,
        'phone' => '+39 987 654 3210',
        'address' => 'Via Milano 456, Roma',
        'birth_date' => '1985-10-20',
    ]);
});

it('can delete user with profile', function () {
    // Arrange
    $user = User::factory()->create();
    $profile = $user->profile()->create([
        'phone' => '+39 123 456 7890',
    ]);

    // Act
    $user->delete();

    // Assert
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
    $this->assertDatabaseMissing('profiles', ['id' => $profile->id]);
});

it('can soft delete user', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $user->delete();

    // Assert
    $this->assertSoftDeleted('users', ['id' => $user->id]);
    $this->assertDatabaseHas('users', ['id' => $user->id]);
});

it('can restore soft deleted user', function () {
    // Arrange
    $user = User::factory()->create();
    $user->delete();

    // Act
    $user->restore();

    // Assert
    $this->assertNotSoftDeleted('users', ['id' => $user->id]);
    $this->assertDatabaseHas('users', ['id' => $user->id]);
});

it('can force delete user', function () {
    // Arrange
    $user = User::factory()->create();
    $profile = $user->profile()->create([
        'phone' => '+39 123 456 7890',
    ]);

    // Act
    $user->forceDelete();

    // Assert
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
    $this->assertDatabaseMissing('profiles', ['id' => $profile->id]);
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
    expect($userWithRelations->permissions)->toHaveCount(1);
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

it('can validate user password strength', function () {
    // Arrange
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'weak', // Weak password
    ];

    // Act & Assert
    $this->expectException(ValidationException::class);

    $this->post('/register', $userData);
});

it('can handle user password reset', function () {
    // Arrange
    $user = User::factory()->create();
    $token = 'reset-token-123';

    // Act
    $user->update(['password_reset_token' => $token]);

    // Assert
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'password_reset_token' => $token,
    ]);
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

it('can handle user last login', function () {
    // Arrange
    $user = User::factory()->create();
    $lastLogin = now();

    // Act
    $user->update(['last_login_at' => $lastLogin]);

    // Assert
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'last_login_at' => $lastLogin,
    ]);
});

it('can handle user status changes', function () {
    // Arrange
    $user = User::factory()->create(['status' => 'active']);

    // Act - Deactivate user
    $user->update(['status' => 'inactive']);

    // Assert
    expect($user->fresh()->status)->toBe('inactive');

    // Act - Activate user
    $user->update(['status' => 'active']);

    // Assert
    expect($user->fresh()->status)->toBe('active');
});

it('can handle user preferences', function () {
    // Arrange
    $user = User::factory()->create();
    $preferences = [
        'language' => 'it',
        'timezone' => 'Europe/Rome',
        'notifications' => true,
        'theme' => 'dark',
    ];

    // Act
    $user->update(['preferences' => $preferences]);

    // Assert
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'preferences' => json_encode($preferences),
    ]);

    expect($user->fresh()->preferences['language'])->toBe('it');
    expect($user->fresh()->preferences['timezone'])->toBe('Europe/Rome');
    expect($user->fresh()->preferences['notifications'])->toBeTrue();
    expect($user->fresh()->preferences['theme'])->toBe('dark');
});
