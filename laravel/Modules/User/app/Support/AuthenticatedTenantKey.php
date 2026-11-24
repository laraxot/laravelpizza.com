<?php

declare(strict_types=1);

namespace Modules\User\Support;

use Illuminate\Support\Facades\Context;
use Modules\Xot\Contracts\UserContract;

/**
 * Chiave del tenant dell'utente autenticato, come fallback quando non c'e' un
 * tenant Filament corrente (pannelli operativi senza tenancy: cameriere, cassa,
 * cucina, bar, HACCP).
 *
 * Il personale appartiene a un solo ristorante: si prende il primo tenant.
 * Se un domani un utente potra' appartenere a piu' ristoranti, serve una
 * selezione esplicita del ristorante corrente.
 *
 * Il risultato e' memoizzato in Context (per richiesta, sicuro sotto Octane)
 * per non ripetere la query su `tenant_user` a ogni apply() dello scope.
 *
 * @deprecated Il duplicato canonico e' {@see \Modules\User\Infrastructure\Tenant\AuthenticatedTenantKey}.
 */
final class AuthenticatedTenantKey
{
    private function __construct() {}

    public static function resolve(): string|int|null
    {
        $user = auth()->user();

        if (! $user instanceof UserContract) {
            return null;
        }

        $authId = $user->getAuthIdentifier();
        if (! \is_string($authId) && ! \is_int($authId)) {
            return null;
        }
        $userKey = (string) $authId;

        /** @var string|int|null */
        return Context::remember('user.authenticated_tenant_key.'.$userKey, static function () use ($user): string|int|null {
            $key = $user->tenants()->first()?->getKey();

            return \is_string($key) || \is_int($key) ? $key : null;
        });
    }
}
