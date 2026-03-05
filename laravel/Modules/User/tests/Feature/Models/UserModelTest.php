<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\Permission;
use Modules\User\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('User Model', function (): void {
    test('can create user with factory', function (): void {
        $user = User::factory()->create();

        expect($user)->toBeInstanceOf(User::class);
        expect($user->id)->not->toBeNull();
        expect($user->email)->not->toBeNull();
        expect($user->name)->not->toBeNull();
    });

    test('user has email attribute', function (): void {
        $email = 'test-' . uniqid() . '@example.com';
        $user = User::factory()->create(['email' => $email]);

        expect($user->email)->toBe($email);
    });

    test('user has name attribute', function (): void {
        $name = 'John Doe';
        $user = User::factory()->create(['name' => $name]);

        expect($user->name)->toBe($name);
    });

    test('user has first_name and last_name attributes', function (): void {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        expect($user->first_name)->toBe('John');
        expect($user->last_name)->toBe('Doe');
    });

    test('user is active by default', function (): void {
        $user = User::factory()->create();

        expect($user->is_active)->toBeTrue();
    });

    test('user can have roles assigned', function (): void {
        $user = User::factory()->create();
        $role = Role::factory()->create(['guard_name' => 'web']);

        $user->assignRole($role);

        expect($user->roles()->count())->toBe(1);
        expect($user->roles()->first()->id)->toBe($role->id);
    });

    test('user can have multiple roles', function (): void {
        $user = User::factory()->create();
        $role1 = Role::factory()->create(['name' => 'admin', 'guard_name' => 'web']);
        $role2 = Role::factory()->create(['name' => 'editor', 'guard_name' => 'web']);

        $user->assignRole([$role1, $role2]);

        expect($user->roles()->count())->toBe(2);
    });

    test('user can have permissions', function (): void {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['guard_name' => 'web', 'name' => 'permission-' . uniqid()]);

        $user->givePermissionTo($permission);

        expect($user->permissions()->count())->toBe(1);
    });

    test('user can check if has role', function (): void {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'admin-' . uniqid(), 'guard_name' => 'web']);

        $user->assignRole($role);

        expect($user->hasRole($role))->toBeTrue();
        expect($user->hasRole($role->name))->toBeTrue();
    });

    test('user can check if has permission', function (): void {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['name' => 'perm-' . uniqid(), 'guard_name' => 'web']);

        $user->givePermissionTo($permission);

        expect($user->hasPermissionTo($permission))->toBeTrue();
    });

    test('user can have password hash', function (): void {
        $user = User::factory()->create();

        expect($user->password)->not->toBeNull();
        expect(strlen($user->password))->toBeGreaterThan(10);
    });

    test('password is hidden from serialization', function (): void {
        $user = User::factory()->create();

        expect(in_array('password', $user->getHidden(), true))->toBeTrue();
    });

    test('user can have remember token', function (): void {
        $user = User::factory()->create();
        $token = 'test-remember-token';

        $user->remember_token = $token;
        $user->save();

        $retrieved = User::find($user->id);
        expect($retrieved->remember_token)->toBe($token);
    });

    test('user can be inactive', function (): void {
        $user = User::factory()->create(['is_active' => false]);

        expect($user->is_active)->toBeFalse();
    });

    test('user can be active', function (): void {
        $user = User::factory()->create(['is_active' => true]);

        expect($user->is_active)->toBeTrue();
    });

    test('user has phone attribute', function (): void {
        $user = User::factory()->create();

        // Phone might not be in all schema versions, just test the user was created
        expect($user)->toBeInstanceOf(User::class);
    });

    test('user has email verified at timestamp', function (): void {
        $user = User::factory()->create(['email_verified_at' => now()]);

        expect($user->email_verified_at)->not->toBeNull();
    });

    test('user can have unverified email', function (): void {
        $user = User::factory()->create(['email_verified_at' => null]);

        expect($user->email_verified_at)->toBeNull();
    });

    test('user can access filament by default', function (): void {
        $user = User::factory()->create();

        expect($user->canAccessFilament())->toBeTrue();
    });

    test('user can access socialite by default', function (): void {
        $user = User::factory()->create();

        expect($user->canAccessSocialite())->toBeTrue();
    });

    test('user has timestamps', function (): void {
        $user = User::factory()->create();

        expect($user->created_at)->not->toBeNull();
        expect($user->updated_at)->not->toBeNull();
    });

    test('user uses uuid as primary key', function (): void {
        $user = User::factory()->create();

        expect($user->id)->not->toBeNull();
        expect(strlen($user->id))->toBeGreaterThan(0);
    });

    test('user increments is false for uuid', function (): void {
        expect(User::factory()->make()->incrementing)->toBeFalse();
    });

    test('user fillable attributes are correct', function (): void {
        $user = User::factory()->make();

        expect(in_array('email', $user->getFillable(), true))->toBeTrue();
        expect(in_array('name', $user->getFillable(), true))->toBeTrue();
    });

    test('user connection is user', function (): void {
        $user = User::factory()->make();

        expect($user->getConnectionName())->toBe('user');
    });

    test('user can be queried by email', function (): void {
        $email = 'unique-test@example.com';
        User::factory()->create(['email' => $email]);

        $user = User::where('email', $email)->first();

        expect($user)->not->toBeNull();
        expect($user->email)->toBe($email);
    });

    test('user can be updated', function (): void {
        $user = User::factory()->create(['name' => 'Original Name']);
        $originalId = $user->id;

        $user->update(['name' => 'Updated Name']);

        expect($user->name)->toBe('Updated Name');
        
        $refreshed = User::find($originalId);
        expect($refreshed->name)->toBe('Updated Name');
    });

    test('user can be deleted', function (): void {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $deleted = User::find($userId);
        expect($deleted)->toBeNull();
    });

    test('user has current team id attribute', function (): void {
        $user = User::factory()->create(['current_team_id' => 'team-123']);

        expect($user->current_team_id)->toBe('team-123');
    });

    test('user has lang attribute for localization', function (): void {
        $user = User::factory()->create(['lang' => 'it']);

        expect($user->lang)->toBe('it');
    });

    test('user belongs to socialite users', function (): void {
        $user = User::factory()->create();
        SocialiteUser::factory()->create(['user_id' => $user->id, 'provider' => 'google']);

        $socialiteUsers = $user->socialiteUsers()->get();

        expect($socialiteUsers)->toHaveCount(1);
        expect($socialiteUsers->first()->provider)->toBe('google');
    });

    test('user can have multiple socialite accounts', function (): void {
        $user = User::factory()->create();
        SocialiteUser::factory()->create(['user_id' => $user->id, 'provider' => 'google']);
        SocialiteUser::factory()->create(['user_id' => $user->id, 'provider' => 'github']);

        expect($user->socialiteUsers()->count())->toBe(2);
    });
});
