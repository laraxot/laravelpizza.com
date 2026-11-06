<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Modules\User\Enums\AuthThrottleScope;

/**
 * Freno per invio dei moduli di registrazione e recupero password (SEC-012): una finestra per IP e una per email.
 *
 * Ogni invio conta, valido o no, e il controllo va fatto PRIMA di validare o scrivere: cosi' chi riempie il modulo in serie non
 * raggiunge ne' la query di unicita' ne' l'invio dell'email. Le chiavi usano l'hash di IP ed email: nella cache non restano dati personali.
 */
final class ConsumeAuthSubmissionSlotAction
{
    /**
     * @return int secondi da attendere; 0 = invio consentito (e conteggiato)
     */
    public function execute(AuthThrottleScope $scope, string $email, ?string $ip): int
    {
        $limits = [self::key($scope, 'ip', $ip ?? 'unknown') => AuthThrottleScope::MAX_PER_IP];

        $normalizedEmail = Str::lower(trim($email));
        if ($normalizedEmail !== '') {
            $limits[self::key($scope, 'email', $normalizedEmail)] = $scope->maxPerEmail();
        }

        foreach ($limits as $key => $maxAttempts) {
            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                return max(1, RateLimiter::availableIn($key));
            }
        }

        foreach (array_keys($limits) as $key) {
            RateLimiter::hit($key, AuthThrottleScope::DECAY_SECONDS);
        }

        return 0;
    }

    private static function key(AuthThrottleScope $scope, string $dimension, string $value): string
    {
        return 'auth-submit:'.$scope->value.':'.$dimension.':'.hash('sha256', $value);
    }
}
