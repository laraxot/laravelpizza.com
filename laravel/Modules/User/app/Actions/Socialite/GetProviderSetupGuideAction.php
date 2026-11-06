<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Uri;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Valori con cui si riempie il testo `user::auth.provider-setup-guide` (DCP-271): dove si creano le credenziali,
 * quale URI registrare e dove impostarle. Il testo vive nei file di lingua, i dati dei provider solo qui.
 */
class GetProviderSetupGuideAction
{
    use QueueableAction;

    /** @var array<string, string> */
    private const array CONSOLES = [
        'google' => 'https://console.developers.google.com/auth/clients',
        'microsoft' => 'https://entra.microsoft.com',
        'github' => 'https://github.com/settings/developers',
    ];

    /** @var array<string, string> */
    private const array LABELS = [
        'google' => 'Google',
        'microsoft' => 'Microsoft',
        'github' => 'GitHub',
    ];

    private const string BACK_OFFICE_PAGE = 'filament.user::admin.pages.socialite-provider-settings-page';

    /**
     * @param  list<string>  $missing  nomi delle variabili d'ambiente mancanti
     * @return array<string, string> segnaposto del testo: provider, missing, console, redirect, admin, hint
     */
    public function execute(string $provider, array $missing): array
    {
        $redirect = Uri::of(app(GetProviderRedirectUriAction::class)->execute($provider));
        $label = self::LABELS[$provider] ?? ucfirst($provider);
        $hint = '';

        // Google non accetta IP grezzi ne' http (tranne localhost): in LAN l'URI da registrare e' quello di localhost.
        if ($provider === 'google' && ! $this->isAcceptedByGoogle($redirect)) {
            $port = $redirect->port();
            $redirect = $redirect->withScheme('http')->withHost('localhost')->withPort($port);
            $origin = 'http://localhost'.($port === null ? '' : ':'.$port);
            $hint = $this->text('provider-setup-lan-hint', ['provider' => $label, 'localhost' => $origin]);
        }

        return [
            'provider' => $label,
            'missing' => implode(', ', $missing),
            'console' => self::CONSOLES[$provider] ?? '',
            'redirect' => $redirect->value(),
            'admin' => Route::has(self::BACK_OFFICE_PAGE) ? route(self::BACK_OFFICE_PAGE) : '',
            'hint' => $hint,
        ];
    }

    /** Regole di Google per gli URI di reindirizzamento: https e dominio pubblico, oppure localhost. */
    private function isAcceptedByGoogle(Uri $uri): bool
    {
        $host = $uri->host() ?? '';
        if (in_array($host, ['localhost', '127.0.0.1', '[::1]'], true)) {
            return true;
        }

        return $uri->scheme() === 'https'
            && filter_var($host, FILTER_VALIDATE_IP) === false
            && str_contains($host, '.');
    }

    /** @param  array<string, string>  $replace */
    private function text(string $key, array $replace): string
    {
        $text = __('user::auth.'.$key, $replace);
        Assert::string($text);

        return $text;
    }
}
