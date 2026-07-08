<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Mockery\MockInterface;
use Modules\User\Actions\Socialite\GetDomainAllowListAction;
use Modules\User\Actions\Socialite\GetGuardAction;
use Modules\User\Actions\Socialite\GetLoginRedirectRouteAction;
use Modules\User\Actions\Socialite\GetProviderButtonsAction;
use Modules\User\Actions\Socialite\GetProviderScopesAction;
use Modules\User\Actions\Socialite\IsProviderConfiguredAction;
use Modules\User\Actions\Socialite\IsRegistrationEnabledAction;
use Modules\User\Actions\Socialite\LogoutUserAction;
use Modules\User\Actions\Socialite\RedirectToLoginAction;
use Modules\User\Actions\Socialite\ValidateProviderAction;
use Modules\User\Exceptions\ProviderNotConfigured;
use Modules\User\Tests\Unit\Actions\Socialite\Fixtures\DeletableAccessTokenFixture;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('Socialite utility actions', function (): void {
    it('returns allow list when configured as string', function (): void {
        config(['socialite.domain_allowlist' => 'example.com']);

        $result = app(GetDomainAllowListAction::class)->execute();

        Assert::assertSame(['example.com'], $result);
    });

    it('returns allow list when configured as array', function (): void {
        config(['socialite.domain_allowlist' => ['a.com', 'b.com']]);

        $result = app(GetDomainAllowListAction::class)->execute();

        Assert::assertSame(['a.com', 'b.com'], $result);
    });

    it('returns empty array when domain allowlist not configured', function (): void {
        config(['socialite.domain_allowlist' => null]);

        $result = app(GetDomainAllowListAction::class)->execute();

        Assert::assertSame([], $result);
    });

    it('returns registration flag from config', function (): void {
        config(['socialite.registration' => true]);

        $result = app(IsRegistrationEnabledAction::class)->execute();

        Assert::assertTrue($result);
    });

    it('returns true as default when registration config is missing', function (): void {
        config(['socialite.registration' => null]);

        $result = app(IsRegistrationEnabledAction::class)->execute();

        Assert::assertTrue($result);
    });

    it('returns provider scopes when configured', function (): void {
        config(['services.github.scopes' => ['user:email', 'read:org']]);

        $result = app(GetProviderScopesAction::class)->execute('github');

        Assert::assertSame(['user:email', 'read:org'], $result);
    });

    it('returns empty scopes when provider scopes are missing', function (): void {
        config(['services.github.scopes' => null]);

        $result = app(GetProviderScopesAction::class)->execute('github');

        Assert::assertSame([], $result);
    });

    it('validates configured provider without throwing', function (): void {
        config(['services.github' => ['client_id' => 'id']]);

        app(ValidateProviderAction::class)->execute('github');
    });

    it('throws for non configured provider', function (): void {
        try {
            app(ValidateProviderAction::class)->execute('pest-missing-socialite-provider');
            Assert::fail('Expected ProviderNotConfigured was not thrown');
        } catch (ProviderNotConfigured $exception) {
            Assert::assertInstanceOf(ProviderNotConfigured::class, $exception);
        }
    });

    it('returns configured auth guard', function (): void {
        config(['filament.auth.guard' => 'web']);

        $guard = app(GetGuardAction::class)->execute();

        Assert::assertInstanceOf(Guard::class, $guard);
    });

    it('returns static login redirect route', function (): void {
        $route = app(GetLoginRedirectRouteAction::class)->execute();

        Assert::assertSame('filament.admin.pages.dashboard', $route);
    });

    it('returns empty provider buttons array', function (): void {
        $result = app(GetProviderButtonsAction::class)->execute();

        Assert::assertSame([], $result);
    });

    it('checks if provider is configured', function (): void {
        config(['services.github' => ['client_id' => 'id']]);

        Assert::assertTrue(app(IsProviderConfiguredAction::class)->execute('github'));
        Assert::assertFalse(app(IsProviderConfiguredAction::class)->execute('pest-missing-socialite-provider'));
    });

    it('logs out user token and device sessions', function (): void {
        $accessToken = new DeletableAccessTokenFixture();
        $refreshTokenId = 'rtok-'.uniqid();
        $deviceId = 'dev-'.uniqid();
        $userId = 'user-'.uniqid();

        DB::connection('user')->table('oauth_refresh_tokens')->insert([
            'id' => $refreshTokenId,
            'access_token_id' => 'tok-1',
            'revoked' => false,
            'expires_at' => now()->addHour(),
        ]);

        DB::connection('user')->table('device_user')->insert([
            'device_id' => $deviceId,
            'user_id' => $userId,
            'logout_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = configureMock(UserContract::class, function (MockInterface $mock) use ($accessToken, $userId): void {
            $mock->allows(['token' => $accessToken]);
            $mock->allows(['getKey' => $userId]);
        });

        app(LogoutUserAction::class)->execute($user);

        Assert::assertSame(0, DB::connection('user')->table('oauth_refresh_tokens')->where('access_token_id', 'tok-1')->count());
        Assert::assertSame(1, DB::connection('user')->table('device_user')->where('user_id', $userId)->whereNotNull('logout_at')->count());
        Assert::assertTrue($accessToken->deleted);
    });

    it('redirects to login route with error', function (): void {
        if (! Route::has('login')) {
            Route::get('/login', static fn () => 'login')->name('login');
        }

        $response = app(RedirectToLoginAction::class)->execute('messages.not_allowed');

        Assert::assertInstanceOf(RedirectResponse::class, $response);
        Assert::assertStringContainsString('/login', $response->getTargetUrl());
    });
});
