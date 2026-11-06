<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\ServiceProvider as BaseSocialiteServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Microsoft\Provider;

class SocialiteServiceProvider extends BaseSocialiteServiceProvider
{
    /**
     * Register the provider services.
     */
    public function register(): void
    {
        parent::register();
        $this->mergeSocialProviderCredentialsFromEnv();

        // Load admin-configured OAuth settings from secure file
        $this->loadAdminSocialiteConfig();
    }

    /**
     * Merge OAuth client credentials from Laravel services config into user.social-providers.
     * Credentials live in config/services.php (env allowed there); module config stays env-free.
     */
    private function mergeSocialProviderCredentialsFromEnv(): void
    {
        /** @var list<string> $providers */
        $providers = [
            'facebook',
            'twitter',
            'linkedin',
            'google',
            'github',
            'gitlab',
            'bitbucket',
            'slack',
            'apple',
            'microsoft',
            'pinterest',
            'reddit',
            'tiktok',
            'twitch',
        ];

        foreach ($providers as $provider) {
            /** @var array<string, mixed> $serviceConfig */
            $serviceConfig = config("services.{$provider}", []);

            $clientId = $serviceConfig['client_id'] ?? null;
            if (is_string($clientId) && $clientId !== '') {
                Config::set("user.social-providers.{$provider}.client_id", $clientId);
            }

            $clientSecret = $serviceConfig['client_secret'] ?? null;
            if (is_string($clientSecret) && $clientSecret !== '') {
                Config::set("user.social-providers.{$provider}.client_secret", $clientSecret);
            }
        }
    }

    /**
     * Bootstrap the provider services.
     */
    public function boot(): void
    {
        parent::boot();

        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('microsoft', Provider::class);
        });
    }

    /**
     * Load admin-configured OAuth settings from secure file.
     * This allows admins to configure GOOGLE_CLIENT_ID/SECRET via backoffice UI.
     */
    private function loadAdminSocialiteConfig(): void
    {
        $adminConfigPath = storage_path('app/private/socialite-config.php');

        if (! file_exists($adminConfigPath)) {
            return;
        }

        /** @var array<string, array<string, mixed>> $adminConfig */
        $adminConfig = require $adminConfigPath;

        foreach ($adminConfig as $provider => $settings) {
            if (! is_array($settings)) {
                continue;
            }

            // Merge with existing services config
            /** @var array<string, mixed> $existingConfig */
            $existingConfig = Config::get("services.{$provider}", []);
            /* @var array<string, mixed> $settings */
            Config::set("services.{$provider}", array_merge($existingConfig, $settings));
        }
    }
}
