<?php

declare(strict_types=1);

use Modules\User\Models\User;

it('has basic test infrastructure', function () {
    expect(true)->toBe(true);
});

it('can create a test user', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    expect($user->email)->toBe('test@example.com');
});