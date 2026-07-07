<?php

declare(strict_types=1);

use Modules\User\Models\OauthClient;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

test('oauth client can be instantiated', function (): void {
    $client = new OauthClient();

<<<<<<< HEAD
    expect($client)->toBeInstanceOf(OauthClient::class)
        ->and($client)->toBeInstanceOf(Laravel\Passport\Client::class)
        ->and($client)->toBeInstanceOf(Illuminate\Contracts\Auth\Access\Authorizable::class);
=======
beforeEach(function (): void {
    /* @var \Modules\User\Tests\TestCase $this */
    /* @var TestCase $this */
    config(['passport.connection' => 'user']);

    if (! Schema::connection('user')->hasTable('oauth_clients')) {
        $this->skipTest('oauth_clients table missing on user connection.');
    }
>>>>>>> 9fa499be (.)
});

test('oauth client has connection user', function (): void {
    $client = new OauthClient();

<<<<<<< HEAD
    expect($client->getConnectionName())->toBe('user');
});

test('oauth client has guard_name api', function (): void {
    $client = new OauthClient();

    expect($client->guard_name)->toBe('api');
});

test('oauth client user relation uses xot data', function (): void {
    $user = User::factory()->create();
    $client = OauthClient::factory()->create(['user_id' => $user->getKey()]);

    expect($client->user)->not->toBeNull()
        ->and($client->user->getKey())->toBe($user->getKey());
});

test('oauth client can returns false when permission does not exist', function (): void {
    $client = OauthClient::factory()->create();

    expect($client->can('non-existent-permission'))->toBeFalse();
});

test('oauth client cant returns true when permission does not exist', function (): void {
    $client = OauthClient::factory()->create();

    expect($client->cant('non-existent-permission'))->toBeTrue();
});

test('oauth client cannot is alias of cant', function (): void {
    $client = OauthClient::factory()->create();

    expect($client->cannot('non-existent-permission'))->toBeTrue();
});

test('oauth client canAny returns false for empty abilities', function (): void {
    $client = OauthClient::factory()->create();

    expect($client->canAny([]))->toBeFalse();
=======
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
>>>>>>> 9fa499be (.)
});
