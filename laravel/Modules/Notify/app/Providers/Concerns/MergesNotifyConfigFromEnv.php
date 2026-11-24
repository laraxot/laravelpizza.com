<?php

declare(strict_types=1);

namespace Modules\Notify\Providers\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

/**
 * Merges Notify module config from laravel/config/notify-env.php (env SSoT).
 * Pattern STORY-288 / User social-providers — no env() in module config or provider.
 */
trait MergesNotifyConfigFromEnv
{
    protected function mergeNotifyModuleConfigFromEnv(): void
    {
        /** @var array<string, mixed> $envConfig */
        $envConfig = config('notify-env', []);

        $this->mergeNotifyCompanyConfig($envConfig);
        $this->mergeNotifyMailLayoutConfig($envConfig);
        $this->mergeChannelConfig('sms', $envConfig);
        $this->mergeChannelConfig('whatsapp', $envConfig);
        $this->mergeChannelConfig('telegram', $envConfig);
    }

    /**
     * @param  array<string, mixed>  $envConfig
     */
    protected function mergeNotifyCompanyConfig(array $envConfig): void
    {
        $prefix = 'notify.notify';

        foreach (['company', 'email', 'paths'] as $section) {
            /** @var array<string, mixed> $values */
            $values = Arr::get($envConfig, $section, []);
            foreach ($values as $key => $value) {
                Config::set("{$prefix}.{$section}.{$key}", $value);
            }
        }
    }

    /**
     * @param  array<string, mixed>  $envConfig
     */
    protected function mergeNotifyMailLayoutConfig(array $envConfig): void
    {
        $prefix = 'notify.config';
        /** @var array<string, mixed> $layout */
        $layout = Arr::get($envConfig, 'mail_layout', []);

        if (array_key_exists('logo_url', $layout)) {
            Config::set("{$prefix}.logo_url", $layout['logo_url']);
        }
        if (array_key_exists('unsubscribe_url', $layout)) {
            Config::set("{$prefix}.unsubscribe_url", $layout['unsubscribe_url']);
        }

        /** @var array<string, mixed> $socialLinks */
        $socialLinks = Arr::get($layout, 'social_links', []);
        foreach ($socialLinks as $key => $value) {
            Config::set("{$prefix}.social_links.{$key}", $value);
        }
    }

    /**
     * @param  array<string, mixed>  $envConfig
     */
    protected function mergeChannelConfig(string $channel, array $envConfig): void
    {
        /** @var array<string, mixed> $channelConfig */
        $channelConfig = Arr::get($envConfig, $channel, []);

        foreach ($channelConfig as $key => $value) {
            Config::set("notify.{$channel}.{$key}", $value);
        }
    }
}
