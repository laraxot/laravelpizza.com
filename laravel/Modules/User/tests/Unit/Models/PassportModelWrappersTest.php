<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\DeviceCode;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthDeviceCode;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use Modules\User\Tests\TestCase;
use Spatie\Permission\Traits\HasRoles;

uses(TestCase::class);

test('passport eloquent models have oauth wrappers in user module', function (): void {
    $expectedWrappers = [
        AuthCode::class => OauthAuthCode::class,
        Client::class => OauthClient::class,
        DeviceCode::class => OauthDeviceCode::class,
        RefreshToken::class => OauthRefreshToken::class,
        Token::class => OauthToken::class,
    ];

    foreach ($expectedWrappers as $passportClass => $wrapperClass) {
        expect(class_exists($passportClass))->toBeTrue();
        expect(class_exists($wrapperClass))->toBeTrue();
        expect(is_subclass_of($wrapperClass, $passportClass))->toBeTrue();
        expect((new $wrapperClass())->getConnectionName())->toBe('user');
    }
});

test('oauth client implements authorizable contract', function (): void {
    $client = new OauthClient();
    expect($client)->toBeInstanceOf(Authorizable::class);
});

test('oauth client uses has roles trait', function (): void {
    $client = new OauthClient();
    expect(in_array(HasRoles::class, class_uses_recursive($client), true))->toBeTrue();
});

test('oauth client has guard name property', function (): void {
    $client = new OauthClient();
    expect($client->guard_name)->toBe('api');
});

test('oauth client has required properties', function (): void {
    $client = new OauthClient();

    // These properties are defined in the PHPDoc
    expect(property_exists($client, 'id'))->toBeTrue();
    expect(property_exists($client, 'name'))->toBeTrue();
    expect(property_exists($client, 'secret'))->toBeTrue();
    expect(property_exists($client, 'provider'))->toBeTrue();
    expect(property_exists($client, 'redirect'))->toBeTrue();
    expect(property_exists($client, 'personal_access_client'))->toBeTrue();
    expect(property_exists($client, 'password_client'))->toBeTrue();
    expect(property_exists($client, 'revoked'))->toBeTrue();
    expect(property_exists($client, 'user_id'))->toBeTrue();
});
