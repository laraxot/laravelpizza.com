<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

/**
 * URL assoluto del link di reset password nell'email (SEC-007).
 *
 * La radice viene da `config('app.url')`, mai dalla richiesta: `url()` usa l'header `Host`, che chi chiede il reset puo' scegliere,
 * e il link nella casella della vittima punterebbe a un dominio dell'attaccante. Il percorso e' relativo (`route(..., false)`),
 * quindi non dipende dalla richiesta.
 */
final class BuildPasswordResetUrlAction
{
    public function execute(string $token): string
    {
        $root = config('app.url');

        return rtrim(is_string($root) ? $root : '', '/').route('password.reset', ['token' => $token], false);
    }
}
