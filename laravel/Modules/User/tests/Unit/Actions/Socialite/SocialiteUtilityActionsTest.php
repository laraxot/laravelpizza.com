<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Guard;
use Modules\User\Actions\Socialite\GetDomainAllowListAction;
use Modules\User\Actions\Socialite\GetGuardAction;
use Modules\User\Actions\Socialite\GetLoginRedirectRouteAction;
use Modules\User\Actions\Socialite\GetProviderScopesAction;
use Modules\User\Actions\Socialite\IsRegistrationEnabledAction;
use Modules\User\Actions\Socialite\ValidateProviderAction;
use Modules\User\Exceptions\ProviderNotConfigured;
use Modules\User\Tests\TestCase;

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
});
