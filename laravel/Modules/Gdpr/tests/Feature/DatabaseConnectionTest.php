<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\User\Models\User;

beforeEach(function () {
    // Clean database before each test
    User::query()->delete();
});

it('can access database connection', function () {
    $count = User::count();
    expect($count)->toBeInt();
});

it('can create user via factory', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);

    expect($user->email)->toBe('test@example.com');
});
