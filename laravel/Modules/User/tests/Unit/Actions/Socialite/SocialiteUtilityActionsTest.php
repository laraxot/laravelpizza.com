<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

describe('Socialite utility actions', function (): void {
    it('returns allow list when configured as string', function (): void {
        config(['filament-socialite.domain_allowlist' => 'example.com']);

        $result = app(GetDomainAllowListAction::class)->execute();

        expect($result)->toBe(['example.com']);
    });

    it('returns allow list when configured as array', function (): void {
        config(['filament-socialite.domain_allowlist' => ['a.com', 'b.com']]);

        $result = app(GetDomainAllowListAction::class)->execute();

        expect($result)->toBe(['a.com', 'b.com']);
    });

    it('returns registration flag from config', function (): void {
        config(['filament-socialite.registration' => true]);

        $result = app(IsRegistrationEnabledAction::class)->execute();

        expect($result)->toBeTrue();
    });

    it('returns provider scopes when configured', function (): void {
        config(['services.github.scopes' => ['user:email', 'read:org']]);

        $result = app(GetProviderScopesAction::class)->execute('github');

        expect($result)->toBe(['user:email', 'read:org']);
    });

    it('returns empty scopes when provider scopes are missing', function (): void {
        config(['services.github.scopes' => null]);

        $result = app(GetProviderScopesAction::class)->execute('github');

        expect($result)->toBe([]);
    });

    it('validates configured provider without throwing', function (): void {
        config(['services.github' => ['client_id' => 'id']]);

        app(ValidateProviderAction::class)->execute('github');

        expect(true)->toBeTrue();
    });

    it('throws for non configured provider', function (): void {
        config(['services.github' => ['client_id' => 'id']]);

        app(ValidateProviderAction::class)->execute('gitlab');
    })->throws(ProviderNotConfigured::class);

    it('returns configured auth guard', function (): void {
        config(['filament.auth.guard' => 'web']);

        $guard = app(GetGuardAction::class)->execute();

        expect($guard)->toBeInstanceOf(Guard::class);
    });

    it('returns static login redirect route', function (): void {
        $route = app(GetLoginRedirectRouteAction::class)->execute();

        expect($route)->toBe('filament.admin.pages.dashboard');
    });

    it('returns empty provider buttons array', function (): void {
        $result = app(GetProviderButtonsAction::class)->execute();

        expect($result)->toBe([]);
    });

    it('checks if provider is configured', function (): void {
        config(['services.github' => ['client_id' => 'id']]);

        expect(app(IsProviderConfiguredAction::class)->execute('github'))->toBeTrue()
            ->and(app(IsProviderConfiguredAction::class)->execute('gitlab'))->toBeFalse();
    });

    it('logs out user token and device sessions', function (): void {
        $accessToken = new class {
            public bool $deleted = false;

            public function getKey(): string
            {
                return 'tok-1';
            }

            public function delete(): void
            {
                $this->deleted = true;
            }
        };

        DB::connection('user')->table('oauth_refresh_tokens')->insert([
            'id' => 'rtok-1',
            'access_token_id' => 'tok-1',
            'revoked' => false,
            'expires_at' => now()->addHour(),
        ]);

        DB::connection('user')->table('device_user')->insert([
            'device_id' => 'dev-1',
            'user_id' => 'user-1',
            'logout_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = Mockery::mock(UserContract::class);
        $user->shouldReceive('token')->once()->andReturn($accessToken);
        $user->shouldReceive('getKey')->once()->andReturn('user-1');

        app(LogoutUserAction::class)->execute($user);

        expect($accessToken->deleted)->toBeTrue()
            ->and(DB::connection('user')->table('oauth_refresh_tokens')->where('access_token_id', 'tok-1')->count())->toBe(0)
            ->and(DB::connection('user')->table('device_user')->where('user_id', 'user-1')->whereNotNull('logout_at')->count())->toBe(1);
    });

    it('redirects to login route with error', function (): void {
        if (! Route::has('login')) {
            Route::get('/login', static fn () => 'login')->name('login');
        }

        $response = app(RedirectToLoginAction::class)->execute('messages.not_allowed');

        expect($response)->toBeInstanceOf(RedirectResponse::class)
            ->and($response->getTargetUrl())->toContain('/login');
    });
});
