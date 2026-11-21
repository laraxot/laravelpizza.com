<?php

declare(strict_types=1);

namespace Modules\Notify\Traits;

use Illuminate\Cache\RateLimiter;
use Webmozart\Assert\Assert;

/**
 * Fornisce funzionalità per la gestione del rate limiting delle notifiche.
 *
 * @phpstan-ignore trait.unused
 */
trait HasNotificationRateLimiting
{
    /**
     * Verifica se l'invio della notifica è consentito dal rate limiting.
     *
     * @param  string  $key  Chiave univoca per il rate limiting
     */
    protected function shouldSendNotification(string $key): bool
    {
        if (! config('notify.rate_limiting.enabled')) {
            return true;
        }

        $maxAttempts = config('notify.rate_limiting.max_attempts', 5);
        $decayMinutes = config('notify.rate_limiting.decay_minutes', 1);
        Assert::integerish($maxAttempts);
        Assert::integerish($decayMinutes);
        $maxAttempts = (int) $maxAttempts;
        $decayMinutes = (int) $decayMinutes;

        $limiter = app(RateLimiter::class);

        if ($limiter->tooManyAttempts($key, $maxAttempts)) {
            return false;
        }

        $limiter->hit($key, $decayMinutes * 60);

        return true;
    }

    /**
     * Ottiene il tempo rimanente prima che il rate limiting si resetti.
     *
     * @param  string  $key  Chiave univoca per il rate limiting
     * @return int Secondi rimanenti
     */
    protected function getNotificationRateLimitRetryAfter(string $key): int
    {
        $limiter = app(RateLimiter::class);

        return $limiter->availableIn($key);
    }

    /**
     * Ottiene il numero di tentativi rimanenti per il rate limiting.
     *
     * @param  string  $key  Chiave univoca per il rate limiting
     * @return int Tentativi rimanenti
     */
    protected function getNotificationRateLimitRemainingAttempts(string $key): int
    {
        $maxAttempts = config('notify.rate_limiting.max_attempts', 5);
        Assert::integerish($maxAttempts);
        $maxAttempts = (int) $maxAttempts;

        $limiter = app(RateLimiter::class);

        // RateLimiter::attempts() legge dalla cache e non dichiara un tipo di ritorno:
        // il valore va ristretto qui, non castato dentro l'espressione aritmetica.
        $attempts = $limiter->attempts($key);
        Assert::integerish($attempts);

        return $maxAttempts - (int) $attempts;
    }

    /**
     * Resetta il rate limiting per una chiave specifica.
     *
     * @param  string  $key  Chiave univoca per il rate limiting
     */
    protected function resetNotificationRateLimit(string $key): void
    {
        $limiter = app(RateLimiter::class);
        $limiter->clear($key);
    }

    /**
     * Genera una chiave univoca per il rate limiting.
     *
     * @param  string  $type  Tipo di notifica
     * @param  int|string  $identifier  Identificatore univoco (es. ID utente)
     */
    protected function getNotificationRateLimitKey(string $type, int|string $identifier): string
    {
        return 'notify:'.$type.':'.(string) $identifier;
    }
}
