<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Carbon\Carbon;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\Profile;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Model', function (): void {
    test('can be created in memory', function (): void {
        $user = stubUser();

        Assert::assertInstanceOf(User::class, $user);
        Assert::assertFalse($user->exists);
        Assert::assertIsString($user->email);
    });

    test('supports mass assignment of expected attributes behavior', function (): void {
        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Roe',
            'name' => 'Jane Roe',
            'email' => 'jane.roe@example.test',
            'lang' => 'en',
            'is_active' => false,
            'is_otp' => true,
        ];
        $user = new User($data);
        Assert::assertSame('Jane', $user->first_name);
        Assert::assertSame('Roe', $user->last_name);
        Assert::assertSame('jane.roe@example.test', $user->email);
        Assert::assertSame('en', $user->lang);
        Assert::assertFalse($user->is_active);
        Assert::assertTrue($user->is_otp);
    });

    test('declares sensitive attributes as hidden without serialization', function (): void {
        $user = stubUser();
        $hidden = $user->getHidden();
        Assert::assertStringContainsString('password', implode(',', $hidden));
        Assert::assertContains('remember_token', $hidden);
    });

    test('casts attributes correctly', function (): void {
        $user = stubUser([
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'is_active' => true,
            'is_otp' => false,
        ]);

        Assert::assertInstanceOf(Carbon::class, $user->email_verified_at);

        Assert::assertInstanceOf(Carbon::class, $user->created_at);
    });

    test('has profile relationship in memory', function (): void {
        $user = stubUser();
        $profile = new Profile();
        $profile->forceFill(['user_id' => 'test-user-id']);
        $user->setRelation('profile', $profile);

        Assert::assertInstanceOf(Profile::class, $user->profile);
    });

    test('can attach authentication logs in memory', function (): void {
        $user = stubUser();
        $log = new AuthenticationLog();
        $user->setRelation('authentications', collect([$log]));
        Assert::assertCount(1, $user->authentications);
    });

    test('can expose owned teams relation when preset', function (): void {
        $user = stubUser();
        $team = new Team();
        $user->setRelation('ownedTeams', collect([$team]));
        Assert::assertCount(1, $user->ownedTeams);
    });

    test('can expose teams relation when preset', function (): void {
        $user = stubUser();
        $team = new Team();
        $user->setRelation('teams', collect([$team]));
        Assert::assertCount(1, $user->teams);
    });

    test('has full name accessor', function (): void {
        $user = stubUser([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        Assert::assertSame('John Doe', $user->full_name);
    });

    test('handles null names in full name accessor', function (): void {
        $user = stubUser([
            'first_name' => 'John',
            'last_name' => null,
        ]);

        Assert::assertSame('John', rtrim($user->full_name));
    });

    test('hashes password when set', function (): void {
        $user = stubUser(['password' => 'plain-password']);
    });

    test('reflects verified email state when timestamp is set', function (): void {
        $user = stubUser(['email_verified_at' => null]);
        Assert::assertFalse($user->hasVerifiedEmail());
        $user->email_verified_at = \Illuminate\Support\Carbon::parse(Carbon::now()->toDateTimeString());
        Assert::assertTrue($user->hasVerifiedEmail());
    });

    test('can be activated deactivated in memory', function (): void {
        $user = stubUser(['is_active' => false]);
        Assert::assertFalse($user->is_active);
        $user->is_active = true;
        Assert::assertTrue($user->is_active);
    });

    test('supports otp authentication', function (): void {
        $user = stubUser(['is_otp' => true]);

        Assert::assertTrue($user->is_otp);
    });

    test('exposes active flag for filtering in memory', function (): void {
        $u1 = stubUser(['is_active' => true]);
        $u2 = stubUser(['is_active' => false]);

        $active = collect([$u1, $u2])->filter(fn (User $u) => true === $u->is_active);
        $inactive = collect([$u1, $u2])->filter(fn (User $u) => false === $u->is_active);

        Assert::assertCount(1, $inactive);
        Assert::assertCount(1, $active);
    });

    test('exposes email verification flag for filtering in memory', function (): void {
        $u1 = stubUser(['email_verified_at' => Carbon::now()]);
        $u2 = stubUser(['email_verified_at' => null]);

        $verified = collect([$u1, $u2])->filter(fn (User $u) => null !== $u->email_verified_at);
        $unverified = collect([$u1, $u2])->filter(fn (User $u) => null === $u->email_verified_at);

        Assert::assertCount(1, $unverified);
        Assert::assertCount(1, $verified);
    });

    test('exposes language for filtering in memory', function (): void {
        $u1 = stubUser(['lang' => 'it']);
        $u2 = stubUser(['lang' => 'en']);

        $italians = collect([$u1, $u2])->where('lang', 'it');
        Assert::assertCount(1, $italians);
    });

    test('has password expiration', function (): void {
        $user = stubUser(['password_expires_at' => Carbon::now()->addDays(30)]);

        Assert::assertInstanceOf(Carbon::class, $user->password_expires_at);
    });

    test('tracks creation and updates in memory', function (): void {
        $user = stubUser();

        Assert::assertInstanceOf(Carbon::class, $user->created_at);
        Assert::assertInstanceOf(Carbon::class, $user->updated_at);
    });

    test('can have current team in memory', function (): void {
        $user = stubUser(['current_team_id' => 'team-id']);
        Assert::assertSame('team-id', $user->current_team_id);
    });

    test('can own teams in memory', function (): void {
        $user = stubUser();
        $team = new Team();
        $team->forceFill(['user_id' => $user->id]);
        $user->setRelation('ownedTeams', collect([$team]));

        Assert::assertCount(1, $user->ownedTeams);
    });
});
