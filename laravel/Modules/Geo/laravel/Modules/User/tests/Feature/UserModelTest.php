<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    $this->user = UserFactory::new()->createOne([
        'email' => 'user-'.uniqid('', true).'@example.com',
    ]);
});

describe('User Model', function (): void {
    test('can be created with valid data', function (): void {
        $userData = [
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test-'.uniqid().'@example.com',
            'password' => bcrypt('password'),
            'lang' => 'it',
            'is_active' => true,
        ];

        $user = UserFactory::new()->createOne($userData);

        Assert::assertInstanceOf(User::class, $user);
    });

    test('generates uuid for id', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertNotEmpty($user->id);
    });

    test('uses user database connection', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertIsString($user->getConnectionName());
    });

    test('has factory', function (): void {
        /** @var Collection<int, User> $users */
        $users = UserFactory::new()->count(3)->create();

        Assert::assertCount(3, $users);
        $users->each(function ($user) {
            Assert::assertInstanceOf(User::class, $user);
        });
    });

    test('has full name accessor', function (): void {
        $user = UserFactory::new()->createOne([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        Assert::assertSame('John Doe', $user->full_name);
    });

    test('can have password expiration', function (): void {
        $user = UserFactory::new()->createOne([
            'password_expires_at' => now()->addDays(30),
        ]);

        Assert::assertNotNull($user->password_expires_at);
    });

    test('can be active or inactive', function (): void {
        $activeUser = UserFactory::new()->createOne(['is_active' => true]);
        $inactiveUser = UserFactory::new()->createOne(['is_active' => false]);

        Assert::assertSame(true, $activeUser->is_active);
        Assert::assertSame(false, $inactiveUser->is_active);
    });

    test('can have otp enabled', function (): void {
        $user = UserFactory::new()->createOne(['is_otp' => true]);

        Assert::assertSame(true, $user->is_otp);
    });

    test('can have profile photo path', function (): void {
        $user = UserFactory::new()->createOne([
            'profile_photo_path' => 'photos/user.jpg',
        ]);

        Assert::assertSame('photos/user.jpg', $user->profile_photo_path);
    });

    test('can verify email', function (): void {
        $user = UserFactory::new()->createOne([
            'email_verified_at' => null,
        ]);

        Assert::assertNull($user->email_verified_at);
        $user->update(['email_verified_at' => now()]);

        $freshModel0 = $user->fresh();
        Assert::assertNotNull($freshModel0);
        Assert::assertNotNull($freshModel0->email_verified_at);
    });

    test('can store remember token', function (): void {
        $token = Str::random(60);
        $user = UserFactory::new()->createOne([
            'remember_token' => $token,
        ]);

        Assert::assertSame($token, $user->remember_token);
    });

    test('can have teams', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(BelongsToMany::class, $user->membershipTeams());
    });

    test('can own teams', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(HasMany::class, $user->ownedTeams());
    });

    test('can have current team', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        $team = TeamFactory::new()->createOne(['user_id' => $user->id]);
        $user->update(['current_team_id' => $team->id]);

        Assert::assertInstanceOf(BelongsToMany::class, $user->membershipTeams());
    });

    test('can have roles', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(BelongsToMany::class, $user->roles());
    });

    test('can have permissions', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(BelongsToMany::class, $user->permissions());
    });

    test('can have profile', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(HasOne::class, $user->profile());
    });

    test('can have devices', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(BelongsToMany::class, $user->devices());
    });

    test('can have authentication logs', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(MorphMany::class, $user->authentications());
    });

    test('can have oauth clients', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        $relation = $user->clients();
        Assert::assertInstanceOf(MorphMany::class, $relation);
    });

    test('can have oauth tokens', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        $relation = $user->tokens();
        Assert::assertInstanceOf(HasMany::class, $relation);
    });

    test('can have notifications', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(MorphMany::class, $user->notifications());
    });

    test('can have socialite users', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(HasMany::class, $user->socialiteUsers());
    });

    test('can join ateam', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        $team = TeamFactory::new()->createOne();
        $user->membershipTeams()->attach($team);

        $freshModel1 = $user->fresh();
        Assert::assertNotNull($freshModel1);
        Assert::assertTrue($freshModel1->teams->contains('id', $team->id));
    });

    test('can leave ateam', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        $team = TeamFactory::new()->createOne();
        $user->membershipTeams()->attach($team);
        $user->membershipTeams()->detach($team);

        $freshModel2 = $user->fresh();
        Assert::assertNotNull($freshModel2);
        Assert::assertFalse($freshModel2->teams->contains('id', $team->id));
    });

    test('can own multiple teams', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        TeamFactory::new()->count(3)->create(['user_id' => $user->id]);

        $freshModel3 = $user->fresh();
        Assert::assertNotNull($freshModel3);
        Assert::assertCount(3, $freshModel3->ownedTeams);
    });

    test('can switch current team', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        $team1 = TeamFactory::new()->createOne(['user_id' => $user->id]);
        $team2 = TeamFactory::new()->createOne(['user_id' => $user->id]);

        $user->update(['current_team_id' => $team1->id]);
        Assert::assertNotNull($freshUser = $user->fresh());
        Assert::assertSame($team1->id, $freshUser->current_team_id);
        $user->update(['current_team_id' => $team2->id]);
        Assert::assertNotNull($freshUser = $user->fresh());
        Assert::assertSame($team2->id, $freshUser->current_team_id);
    });

    test('permission skip check', function (): void {
        /** @var TestCase $this */
        if (! $this->userTableExists('model_has_permission')) {
            $this->skipTest('model_has_permission table missing on user connection.');
        }

        $user = $this->requireUser();
        $role = RoleFactory::new()->createOne(['name' => 'assigned role '.uniqid()]);

        $user->assignRole($role);

        Assert::assertTrue($user->hasRole($role));
    });

    test('can have direct permissions', function (): void {
        /** @var TestCase $this */
        if (! $this->userTableExists('model_has_permission')) {
            $this->skipTest('model_has_permission table missing on user connection.');
        }

        $user = $this->requireUser();
        $permission = PermissionFactory::new()->createOne(['name' => 'direct permission '.uniqid()]);

        $user->givePermissionTo($permission);

        Assert::assertTrue($user->hasPermissionTo($permission));
    });

    test('can check multiple permissions', function (): void {
        /** @var TestCase $this */
        if (! $this->userTableExists('model_has_permission')) {
            $this->skipTest('model_has_permission table missing on user connection.');
        }

        $user = $this->requireUser();
        $uid = uniqid();
        $permission1 = PermissionFactory::new()->createOne(['name' => 'edit posts '.$uid]);
        $permission2 = PermissionFactory::new()->createOne(['name' => 'delete posts '.$uid]);

        $user->givePermissionTo([$permission1, $permission2]);

        Assert::assertTrue($user->hasAllPermissions([$permission1, $permission2]));
    });

    test('can check any permission', function (): void {
        /** @var TestCase $this */
        if (! $this->userTableExists('model_has_permission')) {
            $this->skipTest('model_has_permission table missing on user connection.');
        }

        $user = $this->requireUser();
        $uid = uniqid();
        $permission1 = PermissionFactory::new()->createOne(['name' => 'edit posts '.$uid]);
        $permission2 = PermissionFactory::new()->createOne(['name' => 'delete posts '.$uid]);

        $user->givePermissionTo($permission1);

        Assert::assertTrue($user->hasAnyPermission([$permission1, $permission2]));
    });

    test('implements has media interface', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(User::class, $user);
    });

    test('can have media attached', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        Assert::assertInstanceOf(MorphMany::class, $user->media());
    });

    test('can filter by active users', function (): void {
        UserFactory::new()->createOne(['is_active' => true]);
        UserFactory::new()->createOne(['is_active' => false]);

        $activeUsers = User::where('is_active', true)->get();
        $inactiveUsers = User::where('is_active', false)->get();

        Assert::assertSame(true, $activeUsers->every(fn ($user) => $user->is_active));
        Assert::assertSame(true, $inactiveUsers->every(fn ($user) => ! $user->is_active));
    });

    test('can filter by email verified', function (): void {
        UserFactory::new()->createOne(['email_verified_at' => now()]);
        UserFactory::new()->createOne(['email_verified_at' => null]);

        $verifiedUsers = User::whereNotNull('email_verified_at')->get();
        $unverifiedUsers = User::whereNull('email_verified_at')->get();

        Assert::assertSame(true, $verifiedUsers->every(fn ($user) => null !== $user->email_verified_at));
        Assert::assertSame(true, $unverifiedUsers->every(fn ($user) => null === $user->email_verified_at));
    });

    test('can filter by language', function (): void {
        UserFactory::new()->createOne(['lang' => 'it']);
        UserFactory::new()->createOne(['lang' => 'en']);

        $italianUsers = User::where('lang', 'it')->get();
        $englishUsers = User::where('lang', 'en')->get();

        Assert::assertSame(true, $italianUsers->every(fn ($user) => 'it' === $user->lang));
        Assert::assertSame(true, $englishUsers->every(fn ($user) => 'en' === $user->lang));
    });
});
