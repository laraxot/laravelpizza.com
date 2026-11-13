<?php

declare(strict_types=1);

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\User\Actions\Auth\RevokeUserAccessAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * SEC-05 (story account-deletion-and-email-verification): un account cancellato dal titolare (`deleted_at`, Gdpr DeleteAccountAction)
 * non entra piu' da nessuna parte. Il filtro sta nel provider utenti (`BuildActiveUserProviderAction`, registrato come driver `eloquent`),
 * quindi copre login, sessioni gia' aperte, cookie "ricordami" e token Passport; `RevokeUserAccessAction` revoca anche i token.
 */

beforeEach(function (): void {
    config(['activitylog.enabled' => false]);
});

test('the users provider is the one that excludes deleted accounts', function (): void {
    $provider = Auth::createUserProvider('users');

    Assert::assertInstanceOf(EloquentUserProvider::class, $provider);
    Assert::assertNotNull($provider->getQueryCallback());
});

test('the users provider remains usable while a legacy users table lacks deleted_at', function (): void {
    $provider = Auth::createUserProvider('users');
    Assert::assertNotNull($provider);
    $callback = $provider->getQueryCallback();
    Assert::assertNotNull($callback);

    $legacyModel = new User;
    $legacyModel->setTable('users_legacy_provider_test');
    $query = $legacyModel->newQuery();
    Assert::assertInstanceOf(Builder::class, $query);

    $callback($query);

    Assert::assertStringNotContainsString('where `users_legacy_provider_test`.`deleted_at`', $query->toRawSql());
});

test('a deleted account is not found by id, credentials or remember token', function (): void {
    $provider = Auth::createUserProvider('users');
    Assert::assertNotNull($provider);
    $user = UserFactory::new()->createOne(['remember_token' => 'remember-'.Str::random(20)]);
    $email = (string) $user->email;
    $rememberToken = (string) $user->remember_token;

    Assert::assertNotNull($provider->retrieveById($user->getKey()));

    $user->deleted_at = now();
    $user->save();

    Assert::assertNull($provider->retrieveById($user->getKey()));
    Assert::assertNull($provider->retrieveByCredentials(['email' => $email]));
    Assert::assertNull($provider->retrieveByToken($user->getKey(), $rememberToken));
});

test('web login fails for a deleted account with the right password', function (): void {
    $user = UserFactory::new()->createOne(['deleted_at' => now()]);

    Assert::assertFalse(Auth::guard('web')->attempt(['email' => (string) $user->email, 'password' => 'password123']));
    Assert::assertTrue(Auth::guard('web')->guest());
});

test('web login still works for an active account', function (): void {
    $user = UserFactory::new()->createOne();

    Assert::assertTrue(Auth::guard('web')->attempt(['email' => (string) $user->email, 'password' => 'password123']));
});

test('api login answers 401 for a deleted account and issues no token', function (): void {
    /** @var TestCase $this */
    $user = UserFactory::new()->createOne(['deleted_at' => now()]);

    $this->postJson('/api/user/login', ['email' => (string) $user->email, 'password' => 'password123'])
        ->assertStatus(401)
        ->assertJsonPath('success', false);

    Assert::assertSame(0, OauthToken::query()->where('user_id', $user->getKey())->count());
});

test('the passport password grant does not find a deleted account', function (): void {
    $user = UserFactory::new()->createOne(['deleted_at' => now()]);

    Assert::assertNull(User::findForPassport((string) $user->email));
});

test('revoking access revokes access and refresh tokens and rotates the remember token', function (): void {
    $oldRememberToken = Str::random(20);
    $user = UserFactory::new()->createOne(['remember_token' => $oldRememberToken]);
    $other = UserFactory::new()->createOne();
    $clientId = (string) Str::uuid();

    $tokenId = Str::random(80);
    OauthToken::query()->forceCreate([
        'id' => $tokenId,
        'user_id' => $user->getKey(),
        'client_id' => $clientId,
        'name' => 'test',
        'scopes' => [],
        'revoked' => false,
        'expires_at' => now()->addDay(),
    ]);
    $refreshId = Str::random(80);
    OauthRefreshToken::query()->forceCreate([
        'id' => $refreshId,
        'access_token_id' => $tokenId,
        'revoked' => false,
        'expires_at' => now()->addDays(30),
    ]);
    $otherTokenId = Str::random(80);
    OauthToken::query()->forceCreate([
        'id' => $otherTokenId,
        'user_id' => $other->getKey(),
        'client_id' => $clientId,
        'name' => 'test',
        'scopes' => [],
        'revoked' => false,
        'expires_at' => now()->addDay(),
    ]);

    $revoked = app(RevokeUserAccessAction::class)->execute($user);

    Assert::assertSame(1, $revoked);
    Assert::assertTrue((bool) OauthToken::query()->findOrFail($tokenId)->revoked);
    Assert::assertTrue((bool) OauthRefreshToken::query()->findOrFail($refreshId)->revoked);
    Assert::assertFalse((bool) OauthToken::query()->findOrFail($otherTokenId)->revoked);
    $newRememberToken = $user->fresh()?->remember_token;
    Assert::assertIsString($newRememberToken);
    Assert::assertNotSame($oldRememberToken, $newRememberToken);
    Assert::assertNull(Auth::createUserProvider('users')?->retrieveByToken($user->getKey(), $oldRememberToken));
});

test('revoking access leaves a user without a remember token untouched', function (): void {
    $user = UserFactory::new()->createOne(['remember_token' => null]);

    app(RevokeUserAccessAction::class)->execute($user);

    Assert::assertNull($user->fresh()?->remember_token);
});
