<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Limite di frequenza di `POST /api/user/login` (D-08, DCP-282), registrato come limiter nominato `user-login` in `UserServiceProvider`.
 *
 * Stesse soglie e stessa chiave del freno G-07 del `LoginWidget` (5 richieste per 60 secondi per `email|IP`, email in minuscolo) e stesso messaggio
 * `user::login.actions.login.throttle`. Una differenza voluta: il widget conta solo i tentativi errati e azzera al successo, il middleware conta
 * ogni richiesta, che per un endpoint API di login e' lo schema standard. Un test blocca la coerenza delle due soglie.
 */
final class BuildApiLoginLimitAction
{
    /** Richieste consentite per email e IP (come `LoginWidget::MAX_ATTEMPTS`). */
    public const int MAX_ATTEMPTS = 5;

    /** Durata della finestra e del blocco, in secondi (come `LoginWidget::DECAY_SECONDS`). */
    public const int DECAY_SECONDS = 60;

    public function execute(Request $request): Limit
    {
        $email = $request->input('email');
        $key = Str::transliterate(Str::lower(is_string($email) ? $email : '').'|'.$request->ip());

        return (new Limit($key, self::MAX_ATTEMPTS, self::DECAY_SECONDS))
            ->response(static function (Request $request, array $headers): JsonResponse {
                $seconds = is_numeric($headers['Retry-After'] ?? null) ? (int) $headers['Retry-After'] : self::DECAY_SECONDS;

                return response()->json([
                    'success' => false,
                    'message' => __('user::login.actions.login.throttle', ['seconds' => $seconds]),
                    'data' => [],
                ], 429, $headers);
            });
    }
}
