<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * SocialLoginWidget: Widget riutilizzabile per pulsanti login OAuth (Google, Microsoft).
 *
 * Mostra i pulsanti solo per i provider configurati in config/services.
 * Usabile in login, register e altre pagine auth.
 *
 * Regole Laraxot:
 * - Estende XotBaseSchemaWidget
 * - Traduzioni da user::auth.social
 * - Route: socialite.oauth.redirect
 */
class SocialLoginWidget extends XotBaseSchemaWidget
{
    protected string $view = 'user::filament.widgets.auth.social-login';

    /**
     * Widget senza form: schema vuoto.
     *
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
                'label' => __('user::auth.login.google'),
                'icon' => 'google',
                'color' => '#4285F4',
            ];
        }

        if (config('services.microsoft.client_id')) {
            $providers[] = [
                'driver' => 'microsoft',
                'label' => __('user::auth.login.microsoft'),
                'icon' => 'microsoft',
                'color' => '#00A4EF',
            ];
        }

        if (config('services.github.client_id')) {
            $providers[] = [
                'driver' => 'github',
                'label' => __('user::auth.login.github'),
                'icon' => 'github',
                'color' => '#24292F',
            ];
        }

        return $providers;
    }

    public function redirectToProvider(string $driver): void
    {
        $driver = match ($driver) {
            'google' => 'google',
            'microsoft' => 'microsoft',
            default => $driver,
        };

        redirect()->to(route('socialite.oauth.redirect', ['provider' => $driver]));
    }
}
