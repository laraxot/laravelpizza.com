<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\Actions\Passport\RevokeAllUserTokensAction;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('RevokeAllUserTokensAction', function (): void {
    test('revokes all user tokens', function (): void {
        $user = User::factory()->create();

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

        expect(DB::connection('user')->table('oauth_access_tokens')->where('user_id', (string) $user->id)->where('revoked', 0)->count())->toBe(2);

        $revoked = app(RevokeAllUserTokensAction::class)->execute($user);

        expect($revoked)->toBe(2);
        expect(DB::connection('user')->table('oauth_access_tokens')->where('user_id', (string) $user->id)->where('revoked', 0)->count())->toBe(0);
    });

    test('handles user with no tokens', function (): void {
        $user = User::factory()->create();

        $revoked = app(RevokeAllUserTokensAction::class)->execute($user);

        expect($revoked)->toBe(0);
    });

    test('revokes tokens by user id string', function (): void {
        $user = User::factory()->create();

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
        ]);

        $revoked = app(RevokeAllUserTokensAction::class)->execute($user->id);

        expect($revoked)->toBe(1);
    });

    test('does not revoke already revoked tokens', function (): void {
        $user = User::factory()->create();

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
                'name' => 'revoked-token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'user_id' => (string) $user->id,
                'client_id' => $clientId,
                'name' => 'active-token',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $revoked = app(RevokeAllUserTokensAction::class)->execute($user);

        expect($revoked)->toBe(1);
        expect(DB::connection('user')->table('oauth_access_tokens')->where('user_id', (string) $user->id)->where('revoked', 1)->count())->toBe(2);
    });

    test('returns count of revoked tokens', function (): void {
        $user = User::factory()->create();

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

        $tokenCount = 5;
        $tokens = [];
        for ($i = 0; $i < $tokenCount; ++$i) {
            $tokens[] = [
                'id' => (string) Str::uuid(),
                'user_id' => (string) $user->id,
                'client_id' => $clientId,
                'name' => "token-$i",
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::connection('user')->table('oauth_access_tokens')->insert($tokens);

        $revoked = app(RevokeAllUserTokensAction::class)->execute($user);

        expect($revoked)->toBe($tokenCount);
    });

    test('revokes tokens for specific user only', function (): void {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $clientId = (string) Str::uuid();
        DB::connection('user')->table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => (string) $user1->id,
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
                'user_id' => (string) $user1->id,
                'client_id' => $clientId,
                'name' => 'user1-token',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'user_id' => (string) $user2->id,
                'client_id' => $clientId,
                'name' => 'user2-token',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        app(RevokeAllUserTokensAction::class)->execute($user1);

        expect(DB::connection('user')->table('oauth_access_tokens')->where('user_id', (string) $user1->id)->where('revoked', 0)->count())->toBe(0);
        expect(DB::connection('user')->table('oauth_access_tokens')->where('user_id', (string) $user2->id)->where('revoked', 0)->count())->toBe(1);
    });

    test('handles multiple consecutive revocations', function (): void {
        $user = User::factory()->create();

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
        ]);

        $firstRevoke = app(RevokeAllUserTokensAction::class)->execute($user);
        $secondRevoke = app(RevokeAllUserTokensAction::class)->execute($user);

        expect($firstRevoke)->toBe(1);
        expect($secondRevoke)->toBe(0);
    });
});
