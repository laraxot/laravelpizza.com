<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\Auth\SocialLoginWidget;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('Social Login Widget', function () {
    test('widget renders correctly when microsoft is configured', function () {
        config(['services.microsoft.client_id' => 'test-client-id']);
        config(['services.google.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget();
        $providers = $widget->getProviders();

        Assert::assertCount(1, $providers);
        Assert::assertSame('microsoft', $providers[0]['driver']);
    });

    test('widget renders correctly when google is configured', function () {
        config(['services.google.client_id' => 'google-client-id']);
        config(['services.microsoft.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget();
        $providers = $widget->getProviders();

        Assert::assertCount(1, $providers);
        Assert::assertSame('google', $providers[0]['driver']);
        Assert::assertSame('Google', $providers[0]['label']);
    });

    test('widget returns empty when no providers configured', function () {
        config(['services.microsoft.client_id' => null]);
        config(['services.google.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget();
        $providers = $widget->getProviders();

        Assert::assertEmpty($providers);
    });

    test('widget shows all configured providers', function () {
        config(['services.google.client_id' => 'google-id']);
        config(['services.microsoft.client_id' => 'microsoft-id']);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget();
        $providers = $widget->getProviders();

        Assert::assertCount(2, $providers);
        $drivers = array_column($providers, 'driver');
        Assert::assertContains('google', $drivers);
        Assert::assertContains('microsoft', $drivers);
    });
});

describe('Socialite routes', function () {
    test('BO redirect route exists for microsoft', function () {
        $url = route('socialite.oauth.redirect', ['provider' => 'microsoft']);
        Assert::assertStringContainsString('microsoft', (string) $url);
        Assert::assertStringContainsString('/admin/login/', (string) $url);
    });

    test('FO redirect route exists for google (STORY-478)', function () {
        $url = route('socialite.oauth.fo.redirect', ['provider' => 'google']);
        Assert::assertStringContainsString('google', (string) $url);
        Assert::assertStringContainsString('/auth/social/', (string) $url);
    });

    test('FO and BO routes are distinct paths', function () {
        $fo = route('socialite.oauth.fo.redirect', ['provider' => 'google']);
        $bo = route('socialite.oauth.redirect', ['provider' => 'google']);

        Assert::assertNotSame($fo, $bo);
        Assert::assertStringContainsString('/auth/social/', (string) $fo);
        Assert::assertStringContainsString('/admin/login/', (string) $bo);
    });

    test('shared callback route is accessible', function () {
        $url = route('socialite.oauth.callback', ['provider' => 'google']);
        Assert::assertStringContainsString('/sso/google/callback', (string) $url);
    });
});
