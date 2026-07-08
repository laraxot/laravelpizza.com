<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
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
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param class-string $wrapperClass
 */
function passportWrapperConnectionName(string $wrapperClass): ?string
{
    config(['passport.connection' => 'user']);

    $reflection = new ReflectionClass($wrapperClass);

    if ($reflection->hasProperty('connection')) {
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);
        $connection = $property->getValue($reflection->newInstanceWithoutConstructor());

        if (is_string($connection) && '' !== $connection) {
            return $connection;
        }
    }

    $instance = new $wrapperClass();

    if (! $instance instanceof Model) {
        return null;
    }

    /* @var \Illuminate\Database\Eloquent\Model $instance */
    return $instance->getConnectionName();
}

beforeEach(function () {
    /* @var \Modules\User\Tests\TestCase $this */
    config(['passport.connection' => 'user']);
});

test('passport eloquent models have oauth wrappers in user module', function (): void {
    $expectedWrappers = [
        AuthCode::class => OauthAuthCode::class,
        Client::class => OauthClient::class,
        DeviceCode::class => OauthDeviceCode::class,
        RefreshToken::class => OauthRefreshToken::class,
        Token::class => OauthToken::class,
    ];

    foreach ($expectedWrappers as $passportClass => $wrapperClass) {
        Assert::assertSame('user', passportWrapperConnectionName($wrapperClass));
    }
});
