<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\User\Actions\Passport\CreateClientAction;
use Modules\User\Actions\Passport\CreateGenericClientAction;
use Modules\User\Actions\Passport\RegenerateClientSecretAction;
use Modules\User\Actions\Passport\RevokeClientAction;
use Modules\User\Actions\Passport\RevokeRefreshTokenAction;
use Modules\User\Actions\Passport\RevokeTokenAction;
use Modules\User\Models\OauthClient;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('Passport actions coverage batch 2', function (): void {
    it('creates oauth client with defaults and user association', function (): void {
        $user = User::factory()->create();

        $client = app(CreateClientAction::class)->execute(
            name: 'Coverage Client',
            redirect: 'https://example.test/callback',
            user: $user,
        );

        expect($client)->toBeInstanceOf(OauthClient::class)
            ->and($client->id)->not->toBeEmpty()
            ->and($client->provider)->toBe('users')
            ->and((bool) $client->personal_access_client)->toBeFalse()
            ->and((bool) $client->password_client)->toBeFalse()
            ->and((bool) $client->revoked)->toBeFalse()
            ->and((string) $client->user_id)->toBe((string) $user->id)
            ->and($client->secret)->not->toBeNull();

        expect(strlen((string) $client->secret))->toBeGreaterThanOrEqual(40);

        expect(
            DB::connection('user')->table('oauth_clients')->where('id', (string) $client->id)->exists()
        )->toBeTrue();
    });

    it('creates generic oauth client with explicit flags and provider', function (): void {
        $client = app(CreateGenericClientAction::class)->execute(
            name: 'Generic Coverage Client',
            redirect: 'https://example.test/generic-callback',
            personalAccess: true,
            password: false,
            provider: 'admins',
        );

        expect($client)->toBeInstanceOf(OauthClient::class)
            ->and((bool) $client->personal_access_client)->toBeTrue()
            ->and((bool) $client->password_client)->toBeFalse()
            ->and($client->provider)->toBe('admins')
            ->and((bool) $client->revoked)->toBeFalse();
    });

    it('regenerates client secret from model instance and client id', function (): void {
        $clientId = (string) Str::uuid();

        DB::connection('user')->table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => null,
            'name' => 'Client To Regenerate',
            'secret' => 'old-secret-value',
            'provider' => 'users',
            'redirect' => 'https://example.test/regen',
            'redirect_uris' => '[]',
            'grant_types' => '[]',
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $action = app(RegenerateClientSecretAction::class);

        $client = OauthClient::query()->findOrFail($clientId);
        $secretFromModel = $action->execute($client);
        $secretFromId = $action->execute($clientId);

        expect($secretFromModel)->not->toBe('old-secret-value')
            ->and(strlen($secretFromModel))->toBe(40)
            ->and(strlen($secretFromId))->toBe(40)
            ->and($secretFromId)->not->toBe($secretFromModel);

        $storedSecret = DB::connection('user')->table('oauth_clients')->where('id', $clientId)->value('secret');

        expect($storedSecret)->not->toBe($secretFromId)
            ->and(Hash::check($secretFromId, (string) $storedSecret))->toBeTrue();
    });

    it('revokes refresh token and returns false for missing token', function (): void {
        $clientId = (string) Str::uuid();
        $tokenId = (string) Str::uuid();
        $refreshId = hash('sha256', (string) Str::uuid());

        DB::connection('user')->table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => null,
            'name' => 'Refresh Client',
            'secret' => 'secret',
            'provider' => 'users',
            'redirect' => 'https://example.test/refresh',
            'redirect_uris' => '[]',
            'grant_types' => '[]',
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::connection('user')->table('oauth_access_tokens')->insert([
            'id' => $tokenId,
            'user_id' => null,
            'client_id' => $clientId,
            'name' => 'token',
            'scopes' => '[]',
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            'expires_at' => now()->addDay(),
        ]);

        DB::connection('user')->table('oauth_refresh_tokens')->insert([
            'id' => $refreshId,
            'access_token_id' => $tokenId,
            'revoked' => 0,
            'expires_at' => now()->addDay(),
        ]);

        $action = app(RevokeRefreshTokenAction::class);

        expect($action->execute($refreshId))->toBeTrue();
        expect(DB::connection('user')->table('oauth_refresh_tokens')->where('id', $refreshId)->value('revoked'))->toBe(1);

        expect($action->execute('missing-refresh-token-id'))->toBeFalse();
    });

    it('revokes access token and associated refresh token', function (): void {
        $clientId = (string) Str::uuid();
        $tokenId = (string) Str::uuid();
        $refreshId = hash('sha256', (string) Str::uuid());

        DB::connection('user')->table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => null,
            'name' => 'Token Client',
            'secret' => 'secret',
            'provider' => 'users',
            'redirect' => 'https://example.test/token',
            'redirect_uris' => '[]',
            'grant_types' => '[]',
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::connection('user')->table('oauth_access_tokens')->insert([
            'id' => $tokenId,
            'user_id' => null,
            'client_id' => $clientId,
            'name' => 'token',
            'scopes' => '[]',
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            'expires_at' => now()->addDay(),
        ]);

        DB::connection('user')->table('oauth_refresh_tokens')->insert([
            'id' => $refreshId,
            'access_token_id' => $tokenId,
            'revoked' => 0,
            'expires_at' => now()->addDay(),
        ]);

        $action = app(RevokeTokenAction::class);

        expect($action->execute($tokenId))->toBeTrue();

        expect(DB::connection('user')->table('oauth_access_tokens')->where('id', $tokenId)->value('revoked'))->toBe(1);
        expect(DB::connection('user')->table('oauth_refresh_tokens')->where('id', $refreshId)->value('revoked'))->toBe(1);
        expect($action->execute('missing-access-token-id'))->toBeFalse();
    });

    it('revokes client with and without associated tokens', function (): void {
        $clientWithTokenId = (string) Str::uuid();
        $tokenId = (string) Str::uuid();
        $clientWithoutTokenRevokeId = (string) Str::uuid();
        $tokenNoRevokeId = (string) Str::uuid();

        DB::connection('user')->table('oauth_clients')->insert([
            [
                'id' => $clientWithTokenId,
                'user_id' => null,
                'name' => 'Client Revoke With Tokens',
                'secret' => 'secret',
                'provider' => 'users',
                'redirect' => 'https://example.test/client-revoke',
                'redirect_uris' => '[]',
                'grant_types' => '[]',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => $clientWithoutTokenRevokeId,
                'user_id' => null,
                'name' => 'Client Revoke Without Tokens',
                'secret' => 'secret',
                'provider' => 'users',
                'redirect' => 'https://example.test/client-no-token-revoke',
                'redirect_uris' => '[]',
                'grant_types' => '[]',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::connection('user')->table('oauth_access_tokens')->insert([
            [
                'id' => $tokenId,
                'user_id' => null,
                'client_id' => $clientWithTokenId,
                'name' => 'token-to-revoke',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'expires_at' => now()->addDay(),
            ],
            [
                'id' => $tokenNoRevokeId,
                'user_id' => null,
                'client_id' => $clientWithoutTokenRevokeId,
                'name' => 'token-not-revoked',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'expires_at' => now()->addDay(),
            ],
        ]);

        $action = app(RevokeClientAction::class);

        expect($action->execute($clientWithTokenId, true))->toBeTrue();
        expect(DB::connection('user')->table('oauth_clients')->where('id', $clientWithTokenId)->value('revoked'))->toBe(1);
        expect(DB::connection('user')->table('oauth_access_tokens')->where('id', $tokenId)->value('revoked'))->toBe(1);

        $clientModel = OauthClient::query()->findOrFail($clientWithoutTokenRevokeId);

        expect($action->execute($clientModel, false))->toBeTrue();
        expect(DB::connection('user')->table('oauth_clients')->where('id', $clientWithoutTokenRevokeId)->value('revoked'))->toBe(1);
        expect(DB::connection('user')->table('oauth_access_tokens')->where('id', $tokenNoRevokeId)->value('revoked'))->toBe(0);

        expect($action->execute('missing-client-id', true))->toBeFalse();
    });
});
