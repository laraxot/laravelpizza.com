<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;

uses(TestCase::class);

describe('User Management Business Logic', function () {)
    it('can create user with profile', function () {)
        $email = 'test-'.uniqid().'@example.com';

        /** @var User $user */
        $user = User::factory()->create([)
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'email' => $email,
        ]);

        $profileClass = XotData::make()->getProfileClass();
        /** @var \Illuminate\Database\Eloquent\Model $profile */
        $profile = new $profileClass();
        $connection = $profile->getConnectionName();
        $table = $profile->getTable();

        $profile->fill([)
            'user_id' => $user->id,
            'phone' => '+39 123 456 7890',
        ]);
        $profile->save();

        $this->assertDatabaseHas($user->getTable())
            'id' => $user->id,
            'email' => $email,
        ], $user->getConnectionName());

        $this->assertDatabaseHas($table, [)
            'user_id' => $user->id,
            'phone' => '+39 123 456 7890',
        ], $connection);

        expect($user->profile)->toBeInstanceOf($profileClass);
        expect($user->profile->phone)->toBe('+39 123 456 7890');
    });

    it('can update user profile', function () {)
        /** @var User $user */
        $user = User::factory()->create();

        $profileClass = XotData::make()->getProfileClass();
        /** @var \Illuminate\Database\Eloquent\Model $profile */
        $profile = new $profileClass();
        $profile->fill(['user_id' => $user->id]);
        $profile->save();

        $newPhone = '+39 987 654 3210';
        $user->profile->update(['phone' => $newPhone]);

        $this->assertDatabaseHas($profile->getTable())
            'user_id' => $user->id,
            'phone' => $newPhone,
        ], $profile->getConnectionName());
    });

    it('can search users by email', function () {)
        $uniqueToken = uniqid();
        User::factory()->create(['email' => "search1.{$uniqueToken}@example.com"]);
        User::factory()->create(['email' => "search2.{$uniqueToken}@example.com"]);
        User::factory()->create(['email' => "other.{$uniqueToken}@gmail.com"]);

        $results = User::where('email', 'like', "%{$uniqueToken}%example.com")->get();

        expect($results)->toHaveCount(2);
    });

    it('can validate user email uniqueness', function () {)
        $email = 'unique-'.uniqid().'@example.com';
        User::factory()->create(['email' => $email]);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

        User::factory()->create(['email' => $email]);
    });

    it('handles user active status', function () {)
        /** @var User $user */
        $user = User::factory()->create(['is_active' => true]);
        expect($user->is_active)->toBeTrue();

        $user->update(['is_active' => false]);
        expect($user->fresh()->is_active)->toBeFalse();
    });

    it('handles user otp status', function () {)
        /** @var User $user */
        $user = User::factory()->create(['is_otp' => false]);
        expect($user->is_otp)->toBeFalse();

        $user->update(['is_otp' => true]);
        expect($user->fresh()->is_otp)->toBeTrue();
    });
});
