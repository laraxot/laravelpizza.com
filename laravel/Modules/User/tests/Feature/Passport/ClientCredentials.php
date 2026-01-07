<?php

declare(strict_types=1);

use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * @return array{client: Client, secret: string}
 */
function createPassportClient(): array
{
    $repository = app(ClientRepository::class);

    $client = $repository->createClientCredentialsGrantClient('Flow Test Client');

    return ['client' => $client, 'secret' => $client->plainSecret ?? $client->secret];
}

test('client credentials grant returns token', function (): void {
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
    ['client' => $client] = createPassportClient();
    $user = User::factory()->create();

    $client->owner()->associate($user);
    $client->forceFill([
        'user_id' => $user->getKey(),
        'owner_id' => (string) $user->getKey(),
        'owner_type' => $user::class,
    ]);
    $client->save();
    $client->refresh();

    expect($client->owner)->not->toBeNull()
        ->and($client->owner->is($user))->toBeTrue()
        ->and($client->user_id)->toBe($user->getKey());
});
