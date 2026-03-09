<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

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
