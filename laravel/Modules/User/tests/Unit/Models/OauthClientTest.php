<?php

declare(strict_types=1);

use Modules\User\Models\OauthClient;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

test('oauth client can be instantiated', function (): void {
    $client = new OauthClient();

    expect($client)->toBeInstanceOf(OauthClient::class)
        ->and($client)->toBeInstanceOf(Laravel\Passport\Client::class)
        ->and($client)->toBeInstanceOf(Illuminate\Contracts\Auth\Access\Authorizable::class);
});

test('oauth client has connection user', function (): void {
    $client = new OauthClient();

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
});
