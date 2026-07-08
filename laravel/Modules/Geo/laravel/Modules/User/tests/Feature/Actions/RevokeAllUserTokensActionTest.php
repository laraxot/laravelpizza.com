<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\Actions\Passport\RevokeAllUserTokensAction;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('RevokeAllUserTokensAction', function (): void {
    test('revokes all user tokens', function (): void {
        $user = UserFactory::new()->createOne();

        $clientId = (string) Str::uuid();
        DB::connection('user')->table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => (string) $user->id,
            'name' => 'Test Client',
            'secret' => 'secret',
            'provider' => 'users',
            'redirect' => 'http://localhost/callback',
            'redirect_uris' => '[]',
            'grant_types' => '[]',
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::connection('user')->table('oauth_access_tokens')->insert([
            [
                'id' => (string) Str::uuid(),
                'user_id' => (string) $user->id,
                'client_id' => $clientId,
                'name' => 'token1',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'user_id' => (string) $user->id,
                'client_id' => $clientId,
                'name' => 'token2',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Assert::assertSame(2, DB::connection('user')->table('oauth_access_tokens')->where('user_id', (string) $user->id)->where('revoked', 0)->count());
        $revoked = app(RevokeAllUserTokensAction::class)->execute($user);

        Assert::assertSame(2, $revoked);
        Assert::assertSame(0, DB::connection('user')->table('oauth_access_tokens')->where('user_id', (string) $user->id)->where('revoked', 0)->count());
    });

    test('handles user with no tokens', function (): void {
        $user = UserFactory::new()->createOne();

        $revoked = app(RevokeAllUserTokensAction::class)->execute($user);

        Assert::assertSame(0, $revoked);
    });
});
