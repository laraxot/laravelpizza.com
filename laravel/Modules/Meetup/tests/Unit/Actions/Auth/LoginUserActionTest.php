<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Modules\Meetup\Actions\Auth\LoginUserAction;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

test('it can login a user with valid credentials', function () {
    $password = 'Password123!';
    $user = User::factory()->create([
        'password' => bcrypt($password),
    ]);

    $result = app(LoginUserAction::class)->execute([
        'email' => $user->email,
        'password' => $password,
    ]);

    expect($result)->toBeTrue();
    $this->assertAuthenticatedAs($user);
});

test('it returns false with invalid credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('correct-password'),
    ]);

    $result = app(LoginUserAction::class)->execute([
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    expect($result)->toBeFalse();
    $this->assertGuest();
});

test('it returns false if email does not exist', function () {
    $result = app(LoginUserAction::class)->execute([
        'email' => 'nonexistent@example.com',
        'password' => 'some-password',
    ]);

    expect($result)->toBeFalse();
    $this->assertGuest();
});
