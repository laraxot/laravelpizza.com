<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\Device;
use Modules\User\Models\Notification;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthToken;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

uses(TestCase::class);

/*
 * Le relazioni si leggono da un `new User()`: costruire la relazione non tocca il database.
 * I test che persistono dati partono con `skipUnlessUsersTableReady()` (stesso uso del resto del modulo).
 */
describe('User Model Creation', function () {
    beforeEach(fn () => skipUnlessUsersTableReady());

    it('can be created with valid data', function () {
        $userData = [
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'lang' => 'it',
            'is_active' => true,
        ];

        $user = User::factory()->create($userData);

        expect($user)
            ->name->toBe('Test User')
            ->first_name->toBe('Test')
            ->last_name->toBe('User')
            ->email->toBe('test@example.com')
            ->lang->toBe('it')
            ->is_active->toBe(true);
    });

    it('generates uuid for id', function () {
        expect(createTestUser()->id)->toHaveLength(36); // UUID format
    });

    it('has factory', function () {
        expect(User::factory()->count(3)->create())->toHaveCount(3);
    });
});

describe('User Model Configuration', function () {
    it('uses user database connection', function () {
        expect((new User())->getConnectionName())->toBe('user');
    });
});

describe('User Model Attributes', function () {
    beforeEach(fn () => skipUnlessUsersTableReady());

    it('has full name accessor', function () {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        expect($user->full_name)->toBe('John Doe');
    });

    it('can have password expiration', function () {
        $user = User::factory()->create([
            'password_expires_at' => now()->addDays(30),
        ]);

        expect($user->password_expires_at)->not->toBeNull();
    });

    it('can be active or inactive', function () {
        $activeUser = User::factory()->create(['is_active' => true]);
        $inactiveUser = User::factory()->create(['is_active' => false]);

        expect($activeUser->is_active)->toBe(true);
        expect($inactiveUser->is_active)->toBe(false);
    });

    it('can have otp enabled', function () {
        $user = User::factory()->create(['is_otp' => true]);

        expect($user->is_otp)->toBe(true);
    });

    it('can have profile photo path', function () {
        $user = User::factory()->create([
            'profile_photo_path' => 'photos/user.jpg',
        ]);

        expect($user->profile_photo_path)->toBe('photos/user.jpg');
    });
});

describe('User Authentication Features', function () {
    it('can verify email', function () {
        skipUnlessUsersTableReady();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        expect($user->email_verified_at)->toBeNull();

        $user->update(['email_verified_at' => now()]);

        expect($user->refresh()->email_verified_at)->not->toBeNull();
    });

    it('can store remember token', function () {
        skipUnlessUsersTableReady();

        $token = Str::random(60);
        $user = User::factory()->create([
            'remember_token' => $token,
        ]);

        expect($user->remember_token)->toBe($token);
    });

    it('can access socialite feature', function () {
        expect((new User())->canAccessSocialite())->toBe(true);
    });
});

describe('User Relationships', function () {
    it('can have teams', function () {
        expect((new User())->teams()->getRelated()::class)->toBe(Team::class);
    });

    it('can own teams', function () {
        expect((new User())->ownedTeams()->getRelated()::class)->toBe(Team::class);
    });

    it('can have current team', function () {
        expect((new User())->currentTeam()->getRelated()::class)->toBe(Team::class);
    });

    it('can have roles', function () {
        expect((new User())->roles()->getRelated()::class)->toBe(Role::class);
    });

    it('can have permissions', function () {
        expect((new User())->permissions()->getRelated()::class)->toBe(Permission::class);
    });

    it('can have profile', function () {
        // Il profilo e' la classe configurata del progetto (XotData), non sempre `User\Models\Profile`.
        expect((new User())->profile()->getRelated()::class)->toBe(XotData::make()->getProfileClass());
    });

    it('can have devices', function () {
        expect((new User())->devices()->getRelated()::class)->toBe(Device::class);
    });

    it('can have authentication logs', function () {
        expect((new User())->authentications()->getRelated()::class)->toBe(AuthenticationLog::class);
    });

    it('can have oauth clients', function () {
        expect((new User())->clients()->getRelated()::class)->toBe(OauthClient::class);
    });

    it('can have oauth tokens', function () {
        expect((new User())->tokens()->getRelated()::class)->toBe(OauthToken::class);
    });

    it('can have notifications', function () {
        expect((new User())->notifications()->getRelated()::class)->toBe(Notification::class);
    });

    it('can have socialite users', function () {
        expect((new User())->socialiteUsers()->getRelated()::class)->toBe(SocialiteUser::class);
    });
});

describe('User Team Management', function () {
    beforeEach(fn () => skipUnlessUsersTableReady());

    it('can join a team', function () {
        $user = createTestUser();
        $team = Team::factory()->create();

        $user->teams()->attach($team);

        expect($user->teams->modelKeys())->toContain($team->getKey());
    });

    it('can leave a team', function () {
        $user = createTestUser();
        $team = Team::factory()->create();
        $user->teams()->attach($team);

        expect($user->teams->modelKeys())->toContain($team->getKey());

        $user->teams()->detach($team);

        expect($user->refresh()->teams->modelKeys())->not->toContain($team->getKey());
    });

    it('can own multiple teams', function () {
        $user = createTestUser();
        Team::factory()->count(3)->create(['user_id' => $user->id]);

        expect($user->ownedTeams)->toHaveCount(3);
    });

    it('can switch current team', function () {
        $user = createTestUser();
        $team1 = Team::factory()->create(['user_id' => $user->id]);
        $team2 = Team::factory()->create(['user_id' => $user->id]);

        $user->update(['current_team_id' => $team1->id]);
        expect($user->refresh()->current_team_id)->toBe($team1->id);

        $user->update(['current_team_id' => $team2->id]);
        expect($user->refresh()->current_team_id)->toBe($team2->id);
    });
});

describe('User Permission System', function () {
    beforeEach(fn () => skipUnlessUsersTableReady());

    it('can have roles assigned', function () {
        skipUnlessRoleAssignmentSupported();

        $user = createTestUser();
        $role = Role::factory()->create();

        $user->assignRole($role);

        expect($user->hasRole($role))->toBe(true);
    });

    it('can have direct permissions', function () {
        skipUnlessDirectPermissionSupported();

        $user = createTestUser();
        $permission = Permission::factory()->create();

        $user->givePermissionTo($permission);

        expect($user->hasPermissionTo($permission))->toBe(true);
    });

    it('can check multiple permissions', function () {
        skipUnlessDirectPermissionSupported();

        $user = createTestUser();
        $permission1 = Permission::factory()->create(['name' => 'edit posts']);
        $permission2 = Permission::factory()->create(['name' => 'delete posts']);

        $user->givePermissionTo([$permission1, $permission2]);

        expect($user->hasAllPermissions([$permission1, $permission2]))->toBe(true);
    });

    it('can check any permission', function () {
        skipUnlessDirectPermissionSupported();

        $user = createTestUser();
        $permission1 = Permission::factory()->create(['name' => 'edit posts']);
        $permission2 = Permission::factory()->create(['name' => 'delete posts']);

        $user->givePermissionTo($permission1);

        expect($user->hasAnyPermission([$permission1, $permission2]))->toBe(true);
    });
});

describe('User Media Management', function () {
    it('can have media attached', function () {
        expect((new User())->media()->getRelated()::class)->toBe(Media::class);
    });
});

describe('User Scopes and Queries', function () {
    beforeEach(fn () => skipUnlessUsersTableReady());

    it('can filter by active users', function () {
        User::factory()->create(['is_active' => true]);
        User::factory()->create(['is_active' => false]);

        $activeUsers = User::where('is_active', true)->get();
        $inactiveUsers = User::where('is_active', false)->get();

        expect($activeUsers->every(fn (User $user): bool => (bool) $user->is_active))->toBe(true);
        expect($inactiveUsers->every(fn (User $user): bool => ! $user->is_active))->toBe(true);
    });

    it('can filter by email verified', function () {
        User::factory()->create(['email_verified_at' => now()]);
        User::factory()->create(['email_verified_at' => null]);

        $verifiedUsers = User::whereNotNull('email_verified_at')->get();
        $unverifiedUsers = User::whereNull('email_verified_at')->get();

        expect($verifiedUsers->every(fn (User $user): bool => $user->email_verified_at !== null))->toBe(true);
        expect($unverifiedUsers->every(fn (User $user): bool => $user->email_verified_at === null))->toBe(true);
    });

    it('can filter by language', function () {
        User::factory()->create(['lang' => 'it']);
        User::factory()->create(['lang' => 'en']);

        $italianUsers = User::where('lang', 'it')->get();
        $englishUsers = User::where('lang', 'en')->get();

        expect($italianUsers->every(fn (User $user): bool => $user->lang === 'it'))->toBe(true);
        expect($englishUsers->every(fn (User $user): bool => $user->lang === 'en'))->toBe(true);
    });
});

// BaseUser non usa SoftDeletes (trait commentato): niente withTrashed/restore/forceDelete da verificare.
describe('User Soft Deletes', function () {
    it('can handle soft deletes if supported')->skip('User model does not use SoftDeletes.');

    it('can handle restore after soft delete if supported')->skip('User model does not use SoftDeletes.');

    it('can handle force delete if supported')->skip('User model does not use SoftDeletes.');
});
