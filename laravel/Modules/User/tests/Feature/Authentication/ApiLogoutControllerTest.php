<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Authentication;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Modules\User\Database\Factories\DeviceFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\DeviceUser;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    TestCase::skipUnlessUserTable('device_user');
    TestCase::skipUnlessUserTable('devices');

    Config::set('app.key', config('app.key') ?: 'base64:'.base64_encode(random_bytes(32)));

    TestCase::$user = UserFactory::new()->createOne([
        'email' => 'api-logout-'.uniqid('', true).'@example.com',
        'email_verified_at' => now(),
        'is_active' => true,
    ]);

    TestCase::$device = DeviceFactory::new()->createOne();

    $userKey = TestCase::requireUser()->getKey();
    $deviceKey = TestCase::requireDevice()->getKey();

    DeviceUser::query()->create([
        'user_id' => (is_int($userKey) || is_string($userKey)) ? (string) $userKey : '',
        'device_id' => (is_int($deviceKey) || is_string($deviceKey)) ? (string) $deviceKey : '',
        'login_at' => now()->subHour(),
        'logout_at' => null,
    ]);
});

describe('Api Logout Controller', function (): void {
    test('api logout revokes current personal access token and marks device logout time', function (): void {
        /** @var TestCase $this */
        $user = TestCase::requireUser();
        $userKey = $user->getKey();
        $userKeyString = (is_int($userKey) || is_string($userKey)) ? (string) $userKey : '';
        $privateKey = storage_path('oauth-private.key');
        $publicKey = storage_path('oauth-public.key');

        if (! is_readable($privateKey) || ! is_readable($publicKey)) {
            $this->skipTest('Passport OAuth keys not configured for test environment.');
        }

        ensurePersonalAccessClient();

        try {
            $tokenResult = $user->createToken('Api Logout Test');
        } catch (\Exception $exception) {
            $this->skipTest('Passport token creation unavailable: '.$exception->getMessage());
        }

        $accessTokenModel = $user->tokens()->latest('id')->first();
        Assert::assertNotNull($accessTokenModel);

        Assert::assertTrue(DB::connection('user')->table('oauth_access_tokens')->where('id', $accessTokenModel->getKey())->exists());
        Assert::assertTrue(DeviceUser::query()->where('user_id', $userKeyString)->whereNull('logout_at')->exists());
        $response = $this->withHeader('Authorization', 'Bearer '.$tokenResult->accessToken)
            ->getJson('/api/v2/logout');

        $response->assertOk()
            ->assertJsonPath('message', 'Successfully logged out.')
            ->assertJsonPath('data.user_id', $userKeyString);

        Assert::assertSame(1, DB::connection('user')->table('oauth_access_tokens')->where('id', $accessTokenModel->getKey())->value('revoked'));
        Assert::assertTrue(DeviceUser::query()->where('user_id', $userKeyString)->whereNotNull('logout_at')->exists());
    });
});
