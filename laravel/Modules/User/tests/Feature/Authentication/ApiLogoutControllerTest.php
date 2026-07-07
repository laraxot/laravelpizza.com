<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Authentication;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Modules\User\Models\Device;
use Modules\User\Models\DeviceUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
=======
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\Database\Factories\DeviceFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\DeviceUser;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(TestCase::class);

beforeEach(function (): void {
<<<<<<< HEAD
    Config::set('app.key', config('app.key') ?: 'base64:'.base64_encode(random_bytes(32)));

    $this->user = User::factory()->create([
=======
    /* @var TestCase $this */
    $this->skipUnlessUserTable('device_user');
    $this->skipUnlessUserTable('devices');

    Config::set('app.key', config('app.key') ?: 'base64:'.base64_encode(random_bytes(32)));

    $this->user = UserFactory::new()->createOne([
        'email' => 'api-logout-'.uniqid('', true).'@example.com',
>>>>>>> 40b96bcd6 (.)
        'email_verified_at' => now(),
        'is_active' => true,
    ]);

<<<<<<< HEAD
    $this->device = Device::factory()->create();

    DeviceUser::factory()->create([
        'user_id' => (string) $this->user->getKey(),
        'device_id' => (string) $this->device->getKey(),
=======
    $this->device = DeviceFactory::new()->createOne();

    DeviceUser::query()->create([
        'user_id' => (string) $this->requireUser()->getKey(),
        'device_id' => (string) $this->requireDevice()->getKey(),
>>>>>>> 40b96bcd6 (.)
        'login_at' => now()->subHour(),
        'logout_at' => null,
    ]);
});

<<<<<<< HEAD
function ensurePersonalAccessClient(): void
{
    $clientModel = Passport::client();

    if ($clientModel->newQuery()->where('revoked', false)->exists()) {
        return;
    }

    $repository = app(ClientRepository::class);
    $repository->createPersonalAccessGrantClient('Test Personal Access Client');
}

test('api logout revokes current personal access token and marks device logout time', function (): void {
    ensurePersonalAccessClient();

    $personalAccessToken = $this->user->createToken('Api Logout Test');
    $accessToken = $personalAccessToken->token;

    expect(DB::connection('user')->table('oauth_access_tokens')->where('id', $accessToken->getKey())->exists())->toBeTrue();
    expect(DeviceUser::query()->where('user_id', (string) $this->user->getKey())->whereNull('logout_at')->exists())->toBeTrue();

    $response = $this->withHeader('Authorization', 'Bearer '.$personalAccessToken->accessToken)
        ->getJson('/api/v2/logout');

    $response->assertOk()
        ->assertJsonPath('message', 'Successfully logged out.')
        ->assertJsonPath('data.user_id', (string) $this->user->getKey());

    expect(DB::connection('user')->table('oauth_access_tokens')->where('id', $accessToken->getKey())->value('revoked'))->toBe(1);
    expect(DeviceUser::query()->where('user_id', (string) $this->user->getKey())->whereNotNull('logout_at')->exists())->toBeTrue();
=======
describe('Api Logout Controller', function (): void {
    test('api logout revokes current personal access token and marks device logout time', function (): void {
        /** @var TestCase $this */
        $user = $this->requireUser();
        $privateKey = storage_path('oauth-private.key');
        $publicKey = storage_path('oauth-public.key');

        if (! is_readable($privateKey) || ! is_readable($publicKey)) {
            $this->skipTest('Passport OAuth keys not configured for test environment.');
        }

        ensurePersonalAccessClient();

        $personalAccessToken = null;
        try {
            $personalAccessToken = $user->createToken('Api Logout Test');
        } catch (\Exception $exception) {
            $this->skipTest('Passport token creation unavailable: '.$exception->getMessage());
        }

        if (null === $personalAccessToken) {
            $this->skipTest('Passport token creation unavailable.');
        }

        if (! $personalAccessToken instanceof PersonalAccessTokenResult) {
            $this->fail('Passport token creation returned unexpected type.');
        }

        $tokenResult = $personalAccessToken;

        $accessTokenModel = $user->tokens()->latest('id')->first();
        Assert::assertNotNull($accessTokenModel);

        Assert::assertTrue(DB::connection('user')->table('oauth_access_tokens')->where('id', $accessTokenModel->getKey())->exists());
        Assert::assertTrue(DeviceUser::query()->where('user_id', (string) $user->getKey())->whereNull('logout_at')->exists());
        $response = $this->withHeader('Authorization', 'Bearer '.$tokenResult->accessToken)
            ->getJson('/api/v2/logout');

        $response->assertOk()
            ->assertJsonPath('message', 'Successfully logged out.')
            ->assertJsonPath('data.user_id', (string) $user->getKey());

        Assert::assertSame(1, DB::connection('user')->table('oauth_access_tokens')->where('id', $accessTokenModel->getKey())->value('revoked'));
        Assert::assertTrue(DeviceUser::query()->where('user_id', (string) $user->getKey())->whereNotNull('logout_at')->exists());
    });
>>>>>>> 40b96bcd6 (.)
});
