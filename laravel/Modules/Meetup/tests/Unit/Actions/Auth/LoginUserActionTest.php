<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Modules\Meetup\Actions\Auth\LoginUserAction;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;
use Webmozart\Assert\InvalidArgumentException;

uses(TestCase::class);

test('it can login a user with valid credentials', function () {
    $password = 'Password123!';
    $user = User::factory()->create([
        'password' => $password,
    ]);

    $result = app(LoginUserAction::class)->execute([
        'email' => $user->email,
        'password' => $password,
    ]);

    expect($result)->toBeTrue();
    $this->assertAuthenticatedAs($user);
});

test('it can login a user and remember them', function () {
    $password = 'Password123!';
    $user = User::factory()->create([
        'password' => $password,
    ]);

    // We can't easily assert "remembered" in a unit test without deeper mocking,
    // but we can ensure the action executes without error when remember is true.
    $result = app(LoginUserAction::class)->execute([
        'email' => $user->email,
        'password' => $password,
        'remember' => true,
    ]);

    expect($result)->toBeTrue();
    $this->assertAuthenticatedAs($user);
});

test('it returns false with invalid credentials', function () {
    $user = User::factory()->create([
        'password' => 'correct-password',
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

test('it throws exception if email is not a string', function () {
    app(LoginUserAction::class)->execute([
        'email' => 123,
        'password' => 'password',
    ]);
})->throws(InvalidArgumentException::class);

test('it throws exception if password is not a string', function () {
    app(LoginUserAction::class)->execute([
        'email' => 'test@example.com',
        'password' => ['not', 'a', 'string'],
    ]);
})->throws(InvalidArgumentException::class);

test('it handles missing fields by using defaults', function () {
    // Missing email and password will result in empty strings, which Auth::attempt handles as failure.
    $result = app(LoginUserAction::class)->execute([]);

    expect($result)->toBeFalse();
});
