<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Passport;

use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @return array{client: Client, secret: string}
 */
function createPassportClient(): array
{
    $repository = app(ClientRepository::class);

    $client = $repository->createClientCredentialsGrantClient('Flow Test Client');

    $secret = $client->plainSecret ?? $client->getAttribute('secret');
    if (! is_string($secret)) {
        Assert::fail('Passport client secret is not a string.');
    }

    return [
        'client' => $client,
        'secret' => $secret,
    ];
}

test('client credentials grant returns token', function (): void {
    /* @var TestCase $this */
    ['client' => $client, 'secret' => $secret] = createPassportClient();

    $response = $this->post('/oauth/token', [
        'grant_type' => 'client_credentials',
        'client_id' => $client->id,
        'client_secret' => $secret,
        'scope' => '',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['token_type', 'expires_in', 'access_token'])
        ->assertJsonPath('token_type', 'Bearer');
});

test('client credentials can be associated to a specific user', function (): void {
    /* @var TestCase $this */
    ['client' => $client] = createPassportClient();
    $user = UserFactory::new()->createOne();

    $ownerId = $user->getKey();
    if (! is_int($ownerId) && ! is_string($ownerId)) {
        Assert::fail('User key is neither int nor string.');
    }

    $client->owner()->associate($user);
    $client->forceFill([
        'user_id' => $ownerId,
        'owner_id' => (string) $ownerId,
        'owner_type' => User::class,
    ]);
    $client->save();
    $client->refresh();

    Assert::assertNotNull($client->owner);
    Assert::assertTrue($client->owner->is($user));
    Assert::assertSame($user->getKey(), $client->getAttribute('user_id'));
});
