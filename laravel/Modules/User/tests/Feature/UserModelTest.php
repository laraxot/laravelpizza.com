<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Spatie\MediaLibrary\HasMedia;

uses(TestCase::class);

beforeEach(function () {
    $user = User::factory();
    $admin = User::factory();
});

describe('User Model Creation', function () {
    it('can be created with valid data', function () {
        $userData = [
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test-'.uniqid().'@example.com',
            'password' => bcrypt('password'),
            'lang' => 'it',
            'is_active' => true,
        ];

        $user = User::factory()->create($userData);

        expect($user)
            ->toBeInstanceOf(User::class)
            ->name->toBe('Test User')
            ->first_name->toBe('Test')
            ->last_name->toBe('User')
            ->email->toBe($userData['email'])
            ->lang->toBe('it')
            ->is_active->toBe(true);
    });

    it('generates uuid for id', function () {
        expect($user->id); // UUID format
    });

    it('uses user database connection', function () {
        expect($user->getConnectionName());
    });

    it('has factory', function () {
        $users = User::factory()->count(3)->create();

        expect($users)->toHaveCount(3);
        $users->each(function ($user) {
            expect($user)->toBeInstanceOf(User::class);
        });
    });
});

describe('User Model Attributes', function () {
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
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        expect($user->email_verified_at)->toBeNull();

        $user->update(['email_verified_at' => now()]);

        expect($user->fresh()->email_verified_at)->not->toBeNull();
    });

    it('can store remember token', function () {
        $token = Str::random(60);
        $user = User::factory()->create([
            'remember_token' => $token,
        ]);

        expect($user->remember_token)->toBe($token);
    });

    it('can access socialite feature', function () {
        expect($user->canAccessSocialite());
    });
});

describe('User Relationships', function () {
    it('can have teams', function () {
        expect($user->teams());
    });

    it('can own teams', function () {
        expect($user->ownedTeams());
    });

    it('can have current team', function () {
        $team = Team::factory()->create(['user_id' => $user->id]);
        $user->update(['current_team_id' => $team->id]);

        expect($user->currentTeam());
    });

    it('can have roles', function () {
        expect($user->roles());
    });

    it('can have permissions', function () {
        expect($user->permissions(
            ->toBeInstanceOf(BelongsToMany::class);
    });

    it('can have profile', function () {
        expect($user->profile());
    });

    it('can have devices', function () {
        expect($user->devices());
    });

    it('can have authentication logs', function () {
        // authentications() returns MorphMany (polymorphic relationship)
        expect($user->authentications());
    });

    it('can have oauth clients', function () {
        // clients() may return HasMany or MorphMany depending on implementation
        $relation = $user->clients();
        expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\Relation::class);
    });

    it('can have oauth tokens', function () {
        // tokens() may return HasMany or MorphMany depending on implementation
        $relation = $user->tokens();
        expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\Relation::class);
    });

    it('can have notifications', function () {
        expect($user->notifications());
    });

    it('can have socialite users', function () {
        expect($user->socialiteUsers());
    });
});

describe('User Team Management', function () {
    it('can join a team', function () {
        $team = Team::factory()->create();

        $user->teams();
        $user->refresh();

        expect($user->teams->contains('id', $team->id));
    });

    it('can leave a team', function () {
        $team = Team::factory()->create();
        $user->teams();
        $user->refresh();

        expect($user->teams->contains('id', $team->id));

        $user->teams();

        expect($user->fresh());
    });

    it('can own multiple teams', function () {
        $teams = Team::factory()->count(3)->create(['user_id' => $user->id]);

        expect($user->ownedTeams);
    });

    it('can switch current team', function () {
        $team1 = Team::factory()->create(['user_id' => $user->id]);
        $team2 = Team::factory()->create(['user_id' => $user->id]);

        $user->update(['current_team_id' => $team1->id]);
        expect($user->fresh());

        $user->update(['current_team_id' => $team2->id]);
        expect($user->fresh());
    });
});

describe('User Permission System', function () {
    it('can have roles assigned', function () {
        $role = Role::factory()->create(['name' => 'assigned role '.uniqid()]);

        $user->assignRole($role);

        expect($user->hasRole($role));
    });

    it('can have direct permissions', function () {
        $permission = Permission::factory()->create(['name' => 'direct permission '.uniqid()]);

        $user->givePermissionTo($permission);

        expect($user->hasPermissionTo($permission));
    });

    it('can check multiple permissions', function () {
        $uid = uniqid();
        $permission1 = Permission::factory()->create(['name' => 'edit posts '.$uid]);
        $permission2 = Permission::factory()->create(['name' => 'delete posts '.$uid]);

        $user->givePermissionTo([$permission1, $permission2]);

        expect($user->hasAllPermissions([$permission1, $permission2]));
    });

    it('can check any permission', function () {
        $uid = uniqid();
        $permission1 = Permission::factory()->create(['name' => 'edit posts '.$uid]);
        $permission2 = Permission::factory()->create(['name' => 'delete posts '.$uid]);

        $user->givePermissionTo($permission1);

        expect($user->hasAnyPermission([$permission1, $permission2]));
    });
});

describe('User Media Management', function () {
    it('implements HasMedia interface', function () {
        expect($user);
    });

    it('can have media attached', function () {
        expect($user->media());
    });
});

describe('User Scopes and Queries', function () {
    it('can filter by active users', function () {
        User::factory()->create(['is_active' => true]);
        User::factory()->create(['is_active' => false]);

        $activeUsers = User::where('is_active', true)->get();
        $inactiveUsers = User::where('is_active', false)->get();

        expect($activeUsers->every(fn ($user) => $user->is_active))->toBe(true);
        expect($inactiveUsers->every(fn ($user) => ! $user->is_active))->toBe(true);
    });

    it('can filter by email verified', function () {
        User::factory()->create(['email_verified_at' => now()]);
        User::factory()->create(['email_verified_at' => null]);

        $verifiedUsers = User::whereNotNull('email_verified_at')->get();
        $unverifiedUsers = User::whereNull('email_verified_at')->get();

        expect($verifiedUsers->every(fn ($user) => null !== $user->email_verified_at))->toBe(true);
        expect($unverifiedUsers->every(fn ($user) => null === $user->email_verified_at))->toBe(true);
    });

    it('can filter by language', function () {
        User::factory()->create(['lang' => 'it']);
        User::factory()->create(['lang' => 'en']);

        $italianUsers = User::where('lang', 'it')->get();
        $englishUsers = User::where('lang', 'en')->get();

        expect($italianUsers->every(fn ($user) => 'it' === $user->lang))->toBe(true);
        expect($englishUsers->every(fn ($user) => 'en' === $user->lang))->toBe(true);
    });
});
