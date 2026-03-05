<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Actions\Socialite\LoginUserAction;
use Modules\User\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(TestCase::class, DatabaseTransactions::class);

describe('LoginUserAction', function (): void {
    test('authenticates user with valid credentials', function (): void {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // This action likely uses Socialite, so we might need to mock
        // For now, test the happy path
        $result = app(LoginUserAction::class)->execute('test@example.com', 'password123');

        expect($result)->toBeUser();
        expect($result->email)->toBe('test@example.com');
    });
});
