<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Modules\Meetup\Actions\Auth\RegisterUserAction;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;
use Webmozart\Assert\InvalidArgumentException;

uses(TestCase::class, DatabaseTransactions::class);

test('it can register a user with valid data', function () {
    $email = 'test.'.uniqid().'@example.com';
    $data = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $email,
        'password' => 'Password123!',
    ];

    $user = app(RegisterUserAction::class)->execute($data);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->email)->toBe($email)
        ->and($user->first_name)->toBe('John')
        ->and($user->last_name)->toBe('Doe');

    $this->assertDatabaseHas('users', ['email' => $email], 'user');
    $this->assertAuthenticatedAs($user);
});

test('it throws exception if first_name is not a string', function () {
    app(RegisterUserAction::class)->execute([
        'first_name' => [],
        'last_name' => 'Doe',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
})->throws(InvalidArgumentException::class);

test('it throws exception if last_name is not a string', function () {
    app(RegisterUserAction::class)->execute([
        'first_name' => 'John',
        'last_name' => 123,
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
})->throws(InvalidArgumentException::class);

test('it throws exception if email is not a string', function () {
    app(RegisterUserAction::class)->execute([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => ['not', 'a', 'string'],
        'password' => 'password',
    ]);
})->throws(InvalidArgumentException::class);

test('it throws exception if password is not a string', function () {
    app(RegisterUserAction::class)->execute([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'test@example.com',
        'password' => true,
    ]);
})->throws(InvalidArgumentException::class);
