<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Passport;
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthDeviceCode;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(Modules\User\Tests\TestCase::class);

test('every eloquent passport model has a local oauth wrapper', function (): void {
    /** @var list<string> $files */
    $files = glob(base_path('vendor/laravel/passport/src').'/*.php');

    if ([] === $files) {
        Assert::fail('Unable to read Passport source directory.');
    }

    $shortNames = [];

    foreach ($files as $file) {
        $class = 'Laravel\\Passport\\'.basename($file, '.php');

        if (! class_exists($class)) {
            continue;
        }

        $reflection = new ReflectionClass($class);

        if ($reflection->isAbstract()) {
            continue;
        }

        if (! $reflection->isSubclassOf(Model::class)) {
            continue;
        }

        $shortNames[] = $reflection->getShortName();
    }

    sort($shortNames);

    foreach ($shortNames as $shortName) {
        $wrapperClass = 'Modules\\User\\Models\\Oauth'.$shortName;
        Assert::assertTrue(class_exists($wrapperClass), "Missing wrapper {$wrapperClass} for Passport {$shortName}");
    }
});

test('passport uses user module oauth wrappers for eloquent models', function (): void {
    Assert::assertSame(OauthAuthCode::class, Passport::authCodeModel());
    Assert::assertSame(OauthClient::class, Passport::clientModel());
    Assert::assertSame(OauthToken::class, Passport::tokenModel());
    Assert::assertSame(OauthRefreshToken::class, Passport::refreshTokenModel());

    Assert::assertSame(OauthDeviceCode::class, Passport::deviceCodeModel());
});
