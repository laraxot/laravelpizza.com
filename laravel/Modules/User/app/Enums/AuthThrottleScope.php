<?php

declare(strict_types=1);

namespace Modules\User\Enums;

/**
 * Moduli di autenticazione aperti agli anonimi che si limitano per IP e per email (SEC-012).
 *
 * Il login ha il suo freno (`LoginWidget`, conta solo i tentativi errati); qui ci sono i moduli che si limitano a ogni invio,
 * valido o no: registrazione (crea utenti) e recupero password (manda email).
 */
enum AuthThrottleScope: string
{
    /** Invii consentiti per indirizzo IP nella finestra: alto abbastanza per un IP condiviso (un ufficio). */
    public const int MAX_PER_IP = 10;

    /** Durata della finestra di conteggio e del blocco, in secondi. */
    public const int DECAY_SECONDS = 600;

    case Register = 'register';
    case ForgotPassword = 'forgot-password';

    /** Invii consentiti per indirizzo email nella finestra: frena chi riempie una casella altrui da molti IP. */
    public function maxPerEmail(): int
    {
        return match ($this) {
            self::Register => 5,
            self::ForgotPassword => 3,
        };
    }
}
