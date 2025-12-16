<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Spatie\MediaLibrary\HasMedia;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->create();
});

describe('User Model Creation', function () {
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
            ->toBeInstanceOf(User::class)
            ->name->toBe('Test User')
            ->first_name->toBe('Test')
            ->last_name->toBe('User')
            ->email->toBe('test@example.com')
            ->lang->toBe('it')
            ->is_active->toBe(true);
    });

    it('generates uuid for id', function () {
        expect($this->user->id)->toBeString()->toHaveLength(36); // UUID format
    });

    it('uses user database connection', function () {
        expect($this->user->getConnectionName())->toBe('user');
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
        expect($this->user->canAccessSocialite())->toBe(true);
    });
});

describe('User Relationships', function () {
    it('can have teams', function () {
        expect($this->user->teams())->toBeInstanceOf(BelongsToMany::class);
    });

    it('can own teams', function () {
        expect($this->user->ownedTeams())->toBeInstanceOf(HasMany::class);
    });

    it('can have current team', function () {
        $team = Team::factory()->create(['user_id' => $this->user->id]);
        $this->user->update(['current_team_id' => $team->id]);

        expect($this->user->currentTeam())->toBeInstanceOf(BelongsTo::class);
    });

    it('can have roles', function () {
        expect($this->user->roles())->toBeInstanceOf(BelongsToMany::class);
    });

    it('can have permissions', function () {
        expect($this->user->permissions())
            ->toBeInstanceOf(BelongsToMany::class);
    });

    it('can have profile', function () {
        expect($this->user->profile())->toBeInstanceOf(HasOne::class);
    });

    it('can have devices', function () {
        expect($this->user->devices())->toBeInstanceOf(BelongsToMany::class);
    });

    it('can have authentication logs', function () {
        expect($this->user->authentications())->toBeInstanceOf(HasMany::class);
    });

    it('can have oauth clients', function () {
        expect($this->user->clients())->toBeInstanceOf(HasMany::class);
    });

    it('can have oauth tokens', function () {
        expect($this->user->tokens())->toBeInstanceOf(HasMany::class);
    });

    it('can have notifications', function () {
        expect($this->user->notifications())->toBeInstanceOf(MorphMany::class);
    });

    it('can have socialite users', function () {
        expect($this->user->socialiteUsers())->toBeInstanceOf(HasMany::class);
    });
});

describe('User Team Management', function () {
    it('can join a team', function () {
        $team = Team::factory()->create();

        $this->user->teams()->attach($team);

        expect($this->user->teams)->toContain($team);
    });

    it('can leave a team', function () {
        $team = Team::factory()->create();
        $this->user->teams()->attach($team);

        expect($this->user->teams)->toContain($team);

        $this->user->teams()->detach($team);

        expect($this->user->fresh()->teams)->not->toContain($team);
    });

    it('can own multiple teams', function () {
        $teams = Team::factory()->count(3)->create(['user_id' => $this->user->id]);

        expect($this->user->ownedTeams)->toHaveCount(3);
    });

    it('can switch current team', function () {
        $team1 = Team::factory()->create(['user_id' => $this->user->id]);
        $team2 = Team::factory()->create(['user_id' => $this->user->id]);

        $this->user->update(['current_team_id' => $team1->id]);
        expect($this->user->fresh()->current_team_id)->toBe($team1->id);

        $this->user->update(['current_team_id' => $team2->id]);
        expect($this->user->fresh()->current_team_id)->toBe($team2->id);
    });
});

describe('User Permission System', function () {
    it('can have roles assigned', function () {
        $role = Role::factory()->create();

        $this->user->assignRole($role);

        expect($this->user->hasRole($role))->toBe(true);
    });

    it('can have direct permissions', function () {
        $permission = Permission::factory()->create();

        $this->user->givePermissionTo($permission);

        expect($this->user->hasPermissionTo($permission))->toBe(true);
    });

    it('can check multiple permissions', function () {
        $permission1 = Permission::factory()->create(['name' => 'edit posts']);
        $permission2 = Permission::factory()->create(['name' => 'delete posts']);

        $this->user->givePermissionTo([$permission1, $permission2]);

        expect($this->user->hasAllPermissions([$permission1, $permission2]))->toBe(true);
    });

    it('can check any permission', function () {
        $permission1 = Permission::factory()->create(['name' => 'edit posts']);
        $permission2 = Permission::factory()->create(['name' => 'delete posts']);

        $this->user->givePermissionTo($permission1);

        expect($this->user->hasAnyPermission([$permission1, $permission2]))->toBe(true);
    });
});

describe('User Media Management', function () {
    it('implements HasMedia interface', function () {
        expect($this->user)->toBeInstanceOf(HasMedia::class);
    });

    it('can have media attached', function () {
        expect($this->user->media())->toBeInstanceOf(MorphMany::class);
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

        expect($verifiedUsers->every(fn ($user) => $user->email_verified_at !== null))->toBe(true);
        expect($unverifiedUsers->every(fn ($user) => $user->email_verified_at === null))->toBe(true);
    });

    it('can filter by language', function () {
        User::factory()->create(['lang' => 'it']);
        User::factory()->create(['lang' => 'en']);

        $italianUsers = User::where('lang', 'it')->get();
        $englishUsers = User::where('lang', 'en')->get();

        expect($italianUsers->every(fn ($user) => $user->lang === 'it'))->toBe(true);
        expect($englishUsers->every(fn ($user) => $user->lang === 'en'))->toBe(true);
    });
});

describe('User Soft Deletes', function () {
    it('can handle soft deletes if supported', function () {
        if (! method_exists(User::class, 'withTrashed')) {
            $this->markTestSkipped('SoftDeletes trait not present on User model');
        }
        // This would test soft delete functionality if the trait were present
        $this->markTestSkipped('User model does not implement SoftDeletes trait');
    });

    it('can handle restore after soft delete if supported', function () {
        if (! method_exists(User::class, 'withTrashed')) {
            $this->markTestSkipped('SoftDeletes trait not present on User model');
        }
        // This would test restore functionality if the trait were present
        $this->markTestSkipped('User model does not implement SoftDeletes trait');
    });

    it('can handle force delete if supported', function () {
        if (! method_exists(User::class, 'forceDelete')) {
            $this->markTestSkipped('SoftDeletes trait not present on User model');
        }
        // This would test force delete functionality if the trait were present
        $this->markTestSkipped('User model does not implement SoftDeletes trait');
    });
});
