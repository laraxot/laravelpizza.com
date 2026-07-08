<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Client;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\OauthClient;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\User\Tests\TestCase $this */
    /* @var TestCase $this */
    config(['passport.connection' => 'user']);

    if (! Schema::connection('user')->hasTable('oauth_clients')) {
        $this->skipTest('oauth_clients table missing on user connection.');
    }
});

describe('Oauth Client', function (): void {
    test('oauth client can be instantiated', function (): void {
        /** @var TestCase $this */
        $client = new OauthClient();

        Assert::assertInstanceOf(OauthClient::class, $client);
        Assert::assertInstanceOf(Client::class, $client);
    });

    test('oauth client has connection user', function (): void {
        $client = new OauthClient();

        Assert::assertSame('user', $client->getConnectionName());
    });

    test('oauth client user relation uses xot data', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        $client = $this->oauthClientTestPersistedClient(['user_id' => (string) $user->getKey()]);

        Assert::assertNotNull($client->user);
        Assert::assertSame($user->getKey(), $client->user->getKey());
    });

    test('oauth client is confidential when secret is present', function (): void {
        /** @var TestCase $this */
        $client = $this->oauthClientTestPersistedClient(['secret' => 'hashed-secret']);

        Assert::assertTrue($client->confidential());
    });

    test('oauth client is not confidential when secret is empty', function (): void {
        /** @var TestCase $this */
        $client = $this->oauthClientTestPersistedClient(['secret' => null]);

        Assert::assertFalse($client->confidential());
    });

    test('oauth client has grant type check', function (): void {
        /** @var TestCase $this */
        $client = $this->oauthClientTestPersistedClient([
            'grant_types' => json_encode(['authorization_code', 'refresh_token']),
        ]);

        Assert::assertTrue($client->hasGrantType('authorization_code'));
        Assert::assertFalse($client->hasGrantType('client_credentials'));
    });

    test('oauth client has scope check', function (): void {
        /** @var TestCase $this */
        $client = $this->oauthClientTestPersistedClient();

        Assert::assertTrue($client->hasScope('read'));
    });
});
