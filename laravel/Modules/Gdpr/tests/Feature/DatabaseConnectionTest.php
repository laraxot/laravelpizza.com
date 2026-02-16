<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

beforeEach(function () {
    // Clean database before each test
    \Modules\User\Models\User::query()->delete();
});

it('can access database connection', function () {
    $count = \Modules\User\Models\User::count();
    expect($count)->toBeInt();
});

it('can create user via factory', function () {
    $user = \Modules\User\Models\User::factory()->create([
        'email' => 'test@example.com',
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);

    expect($user->email)->toBe('test@example.com');
});
