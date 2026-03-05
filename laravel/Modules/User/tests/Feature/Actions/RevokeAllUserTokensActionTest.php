<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Actions\Passport\RevokeAllUserTokensAction;
use Modules\User\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(TestCase::class, DatabaseTransactions::class);

describe('RevokeAllUserTokensAction', function (): void {
    test('revokes all user tokens', function (): void {
        $user = User::factory()->create();
        $user->createToken('token1', ['*']);
        $user->createToken('token2', ['*']);
        
        expect($user->tokens()->count())->toBe(2);
        
        app(RevokeAllUserTokensAction::class)->execute($user);
        
        $user->refresh();
        expect($user->tokens()->count())->toBe(0);
    });

    test('handles user with no tokens', function (): void {
        $user = User::factory()->create();
        
        app(RevokeAllUserTokensAction::class)->execute($user);
        
        expect($user->tokens()->count())->toBe(0);
    });
});
