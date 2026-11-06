<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Modules\User\Models\BaseUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Business Logic', function () {
    test('user extends base user', function () {
        Assert::assertSame(BaseUser::class, get_parent_class(User::class));
    });

    test('user has authentication capabilities', function () {
        $user = new User;
        $user->email = 'test@example.com';
        $user->password = 'hashed-password';

        Assert::assertSame('test@example.com', $user->email);
        Assert::assertSame('hashed-password', $user->password);
    });

    test('user can have name components', function () {
        $user = new User;
        $user->first_name = 'Mario';
        $user->last_name = 'Rossi';
        $user->name = 'Mario Rossi';

        Assert::assertSame('Mario', $user->first_name);
        Assert::assertSame('Rossi', $user->last_name);
        Assert::assertSame('Mario Rossi', $user->name);
    });

    test('user has activation status', function () {
        $user = new User;
        $user->is_active = true;

        Assert::assertTrue($user->is_active);
    });

    test('user has otp capability', function () {
        $user = new User;
        $user->is_otp = true;

        Assert::assertTrue($user->is_otp);
    });

    test('user can have language preference', function () {
        $user = new User;
        $user->lang = 'it';

        Assert::assertSame('it', $user->lang);
    });

    test('user has email verification tracking', function () {
        $user = new User;
        $verifiedAt = Carbon::parse('2023-01-01 12:00:00');
        $user->email_verified_at = $verifiedAt;

        Assert::assertTrue($verifiedAt->equalTo($user->email_verified_at));
    });

    test('user has password expiry tracking', function () {
        $user = new User;
        $expiresAt = Carbon::parse('2023-12-31 23:59:59');
        $user->password_expires_at = $expiresAt;

        Assert::assertTrue($expiresAt->equalTo($user->password_expires_at));
    });

    test('user can have current team', function () {
        $user = new User;
        $user->current_team_id = 1;

        Assert::assertSame(1, $user->current_team_id);
    });

    test('user can have profile photo', function () {
        $user = new User;
        $user->profile_photo_path = '/storage/profile-photos/user.jpg';

        Assert::assertSame('/storage/profile-photos/user.jpg', $user->profile_photo_path);
    });

    test('user can have remember token', function () {
        $user = new User;
        $user->remember_token = 'abc123def456';

        Assert::assertSame('abc123def456', $user->remember_token);
    });
});
