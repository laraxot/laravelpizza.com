<?php

declare(strict_types=1);
use Modules\User\Filament\Widgets\Auth\SocialLoginWidget;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Social Login Widget', function () {
    test('widget renders correctly when microsoft is configured', function () {
        config(['services.microsoft.client_id' => 'test-client-id']);
        config(['services.google.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget;
        $providers = $widget->getProviders();

        Assert::assertCount(1, $providers);
        Assert::assertSame('microsoft', $providers[0]['driver']);
    });

    test('widget renders correctly when google is configured', function () {
        config(['services.google.client_id' => 'google-client-id']);
        config(['services.microsoft.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget;
        $providers = $widget->getProviders();

        Assert::assertCount(1, $providers);
        Assert::assertSame('google', $providers[0]['driver']);
        Assert::assertSame('Google', $providers[0]['label']);
    });

    test('widget returns empty when no providers configured', function () {
        config(['services.microsoft.client_id' => null]);
        config(['services.google.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget;
        $providers = $widget->getProviders();

        Assert::assertEmpty($providers);
    });

    test('widget shows all configured providers', function () {
        config(['services.google.client_id' => 'google-id']);
        config(['services.microsoft.client_id' => 'microsoft-id']);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget;
        $providers = $widget->getProviders();

        Assert::assertCount(2, $providers);
        $drivers = array_column($providers, 'driver');
        Assert::assertContains('google', $drivers);
        Assert::assertContains('microsoft', $drivers);
    });
});

describe('Socialite routes', function () {
    test('localized redirect route exists for microsoft', function () {
        $url = route('oauth.redirect', ['lang' => 'it', 'provider' => 'microsoft']);
        Assert::assertStringContainsString('microsoft', (string) $url);
        Assert::assertStringContainsString('/it/auth/login/', (string) $url);
    });

    test('localized redirect route exists for google', function () {
        $url = route('oauth.redirect', ['lang' => 'it', 'provider' => 'google']);
        Assert::assertStringContainsString('google', (string) $url);
        Assert::assertStringContainsString('/it/auth/login/', (string) $url);
    });

    test('the localized redirect route is shared by providers', function () {
        $google = route('oauth.redirect', ['lang' => 'it', 'provider' => 'google']);
        $microsoft = route('oauth.redirect', ['lang' => 'it', 'provider' => 'microsoft']);

        Assert::assertStringContainsString('/it/auth/login/google', (string) $google);
        Assert::assertStringContainsString('/it/auth/login/microsoft', (string) $microsoft);
    });

    test('shared callback route is accessible', function () {
        $url = route('oauth.callback', ['provider' => 'google']);
        Assert::assertStringContainsString('/it/auth/login/google/callback', (string) $url);
    });
});
