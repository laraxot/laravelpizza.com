<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Modules\Meetup\Actions\Auth\RegisterUserAction;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

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
        ->and($user->first_name)->toBe('John');

    $this->assertDatabaseHas('users', ['email' => $email], 'user');
    $this->assertAuthenticatedAs($user);
});
