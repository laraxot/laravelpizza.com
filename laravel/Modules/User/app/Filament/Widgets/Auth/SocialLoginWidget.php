<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Schemas\Components\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * Pulsanti OAuth (Google, Microsoft, GitHub).
 *
 * Panel: route `socialite.oauth.redirect`.
 * FO: `$redirectRoute = 'socialite.oauth.fo.redirect'`.
 */
class SocialLoginWidget extends XotBaseSchemaWidget
{
    protected static bool $isDiscovered = false;

    protected string $view = 'user::filament.widgets.auth.social-login';

    public string $redirectRoute = 'oauth.redirect';

    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * @return list<array{driver: string, label: string, icon: string, color: string}>
     */
    public function getProviders(): array
    {
        $providers = [];

        if (config('services.google.client_id')) {
            $providers[] = [
                'driver' => 'google',
                'label' => __('user::auth.login.google.text'),
                'icon' => 'google',
                'color' => '#4285F4',
            ];
        }

        if (config('services.microsoft.client_id')) {
            $providers[] = [
                'driver' => 'microsoft',
                'label' => __('user::auth.login.microsoft.text'),
                'icon' => 'microsoft',
                'color' => '#00A4EF',
            ];
        }

        if (config('services.github.client_id')) {
            $providers[] = [
                'driver' => 'github',
                'label' => __('user::auth.login.github.text'),
                'icon' => 'github',
                'color' => '#24292F',
            ];
        }

        return $providers;
    }

    public function getRedirectUrl(string $driver): string
    {
        $locale = app()->getLocale();
        if (! is_string($locale)) {
            $locale = config('app.locale', 'it');
        }
        if (! is_string($locale)) {
            $locale = 'it';
        }
        $locale = trim($locale, '/');
        $supported = LaravelLocalization::getSupportedLanguagesKeys();
        if (! in_array($locale, $supported, true)) {
            $fallback = config('app.locale', 'it');
            $locale = is_string($fallback) ? $fallback : 'it';
        }

        return route($this->normalizeRedirectRoute(), ['provider' => $driver, 'lang' => $locale]);
    }

    public function redirectToProvider(string $driver): void
    {
        if (! in_array($driver, ['google', 'microsoft', 'github'], true)) {
            return;
        }

        redirect()->to($this->getRedirectUrl($driver));
    }

    private function normalizeRedirectRoute(): string
    {
        return match ($this->redirectRoute) {
            'socialite.oauth.redirect', 'socialite.oauth.fo.redirect', 'oauth.redirect', 'auth.google.index', 'oauth.callback' => $this->redirectRoute,
            default => 'oauth.callback',
        };
    }
}
