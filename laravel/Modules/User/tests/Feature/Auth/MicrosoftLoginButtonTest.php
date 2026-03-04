<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\Auth\SocialLoginWidget;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

describe('Microsoft Login Button', function () {
    test('social login widget renders correctly when microsoft is configured', function () {
        config(['services.microsoft.client_id' => 'test-client-id']);

        $widget = new SocialLoginWidget;
        $providers = $widget->getProviders();

        expect($providers)->toHaveCount(1);
        expect($providers[0]['driver'])->toBe('microsoft');
        expect($providers[0]['label'])->toBe(__('user::auth.social.microsoft'));
    });

    test('social login widget returns empty when no providers configured', function () {
        config(['services.microsoft.client_id' => null]);
        config(['services.google.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget;
        $providers = $widget->getProviders();

        expect($providers)->toBeEmpty();
    });

    test('socialite microsoft redirect route exists', function () {
        $url = route('socialite.oauth.redirect', ['provider' => 'microsoft']);
        expect($url)->toContain('microsoft');
    });
});
