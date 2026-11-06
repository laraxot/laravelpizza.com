<?php

declare(strict_types=1);

namespace Modules\User\Exceptions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Modules\User\Actions\Socialite\GetProviderSetupGuideAction;
use Modules\User\Actions\Socialite\RedirectToLoginAction;

/**
 * Un provider OAuth e' richiesto ma le sue credenziali mancano o sono segnaposto (DCP-271).
 *
 * Si registra da sola (una riga `warning`, non uno stack trace a ogni clic) e si rende da sola: torna a
 * `/{lang}/auth/login` con un errore nostro invece di mandare il cittadino alla pagina di errore del provider.
 * Con APP_DEBUG l'errore e' la guida (cosa manca, dove creare le credenziali, dove impostarle); altrimenti un
 * messaggio gentile, senza nomi di variabili d'ambiente.
 */
final class ProviderNotConfigured extends \LogicException
{
    /**
     * @param  list<string>  $missing  nomi delle variabili d'ambiente mancanti
     */
    private function __construct(string $message, public readonly string $provider, public readonly array $missing)
    {
        parent::__construct($message);
    }

    /**
     * @param  list<string>  $missing  nomi delle variabili d'ambiente mancanti
     */
    public static function make(string $provider, array $missing = []): static
    {
        $detail = $missing === [] ? '' : ' Missing: '.implode(', ', $missing).'.';

        return new self(
            'Provider "'.$provider.'" is not configured.'.$detail.' Guide: Modules/User/docs/bmad/google-auth-login.md',
            $provider,
            $missing,
        );
    }

    public function report(): bool
    {
        Log::warning($this->getMessage());

        return true;
    }

    public function render(): RedirectResponse
    {
        $key = config('app.debug') === true ? 'auth.provider-setup-guide' : 'auth.provider-not-configured';

        return app(RedirectToLoginAction::class)->execute(
            $key,
            app(GetProviderSetupGuideAction::class)->execute($this->provider, $this->missing),
        );
    }
}
