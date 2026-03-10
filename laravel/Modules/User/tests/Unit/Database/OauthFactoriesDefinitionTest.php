<?php

declare(strict_types=1);

use Modules\User\Database\Factories\OauthAccessTokenFactory;
use Modules\User\Database\Factories\OauthAuthCodeFactory;
use Modules\User\Database\Factories\OauthClientFactory;
use Modules\User\Database\Factories\OauthRefreshTokenFactory;

uses(Modules\User\Tests\TestCase::class);

it('oauth factories expose the expected definition keys', function (): void {
    $clientDefinition = (new OauthClientFactory())->definition();
    $accessTokenDefinition = (new OauthAccessTokenFactory())->definition();
    $authCodeDefinition = (new OauthAuthCodeFactory())->definition();
    $refreshTokenDefinition = (new OauthRefreshTokenFactory())->definition();

    expect($clientDefinition)
        ->toHaveKeys([
            'id',
            'user_id',
            'name',
            'secret',
            'provider',
            'redirect',
            'personal_access_client',
            'password_client',
            'revoked',
            'grant_types',
            'scopes',
        ]);

    expect($accessTokenDefinition)
        ->toHaveKeys([
            'id',
            'user_id',
            'client_id',
            'name',
            'scopes',
            'revoked',
            'expires_at',
        ]);

    expect($authCodeDefinition)
        ->toHaveKeys([
            'id',
            'user_id',
            'client_id',
            'scopes',
            'revoked',
            'expires_at',
        ]);

    expect($refreshTokenDefinition)
        ->toHaveKeys([
            'id',
            'access_token_id',
            'revoked',
            'expires_at',
        ]);
});
