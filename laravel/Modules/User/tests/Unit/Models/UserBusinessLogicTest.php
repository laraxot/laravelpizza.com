<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Modules\User\Models\BaseUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('User Business Logic', function () {
    test('user extends base user', function () {
        expect(new User())->toBeInstanceOf(BaseUser::class);
    });

    test('user has authentication capabilities', function () {
        $user = new User();
        $user->email = 'test@example.com';
        $user->password = 'hashed-password';

        expect($user->email)->toBe('test@example.com');
        expect(Hash::check('hashed-password', $user->password))->toBeTrue();
    });

    test('user can have name components', function () {
        $user = new User();
        $user->first_name = 'Mario';
        $user->last_name = 'Rossi';
        $user->name = 'Mario Rossi';

        expect($user->first_name)->toBe('Mario');
        expect($user->last_name)->toBe('Rossi');
        expect($user->name)->toBe('Mario Rossi');
    });

    test('user has activation status', function () {
        $user = new User();
        $user->is_active = true;

        expect($user->is_active)->toBe(true);
    });

    test('user has otp capability', function () {
        $user = new User();
        $user->is_otp = true;

        expect($user->is_otp)->toBe(true);
    });

    test('user can have language preference', function () {
        $user = new User();
        $user->lang = 'it';

        expect($user->lang)->toBe('it');
    });

    test('user has email verification tracking', function () {
        $user = new User();
        $user->email_verified_at = '2023-01-01 12:00:00';

        expect($user->email_verified_at->format('Y-m-d H:i:s'))->toBe('2023-01-01 12:00:00');
    });

    test('user has password expiry tracking', function () {
        $user = new User();
        $user->password_expires_at = '2023-12-31 23:59:59';

        expect($user->password_expires_at->format('Y-m-d H:i:s'))->toBe('2023-12-31 23:59:59');
    });

    test('user can have current team', function () {
        $user = new User();
        $user->current_team_id = 1;

        expect($user->current_team_id)->toBe(1);
    });

    test('user can have profile photo', function () {
        $user = new User();
        $user->profile_photo_path = '/storage/profile-photos/user.jpg';

        expect($user->profile_photo_path)->toBe('/storage/profile-photos/user.jpg');
    });

    test('user can have remember token', function () {
        $user = new User();
        $user->remember_token = 'abc123def456';

        expect($user->remember_token)->toBe('abc123def456');
    });
});
