<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Tenant;

use Illuminate\Support\Facades\Context;
use Modules\Xot\Contracts\UserContract;

/**
 * Chiave del tenant dell'utente autenticato, come fallback quando non c'e' un
 * tenant Filament corrente — cioe' nei pannelli operativi che non usano la
 * tenancy di Filament.
 *
 * Prende il **primo** tenant dell'utente, perche' l'assunzione e' che una
 * persona appartenga a una sola organizzazione. Se un utente potra' appartenere
 * a piu' organizzazioni, questa classe non basta piu': serve una selezione
 * esplicita di quella corrente, e questo `first()` diventa un bug silenzioso
 * che sceglie a caso.
 *
 * Il risultato e' memoizzato in `Context` (per richiesta, sicuro sotto Octane)
 * per non ripetere la query su `tenant_user` a ogni `apply()` dello scope: e'
 * chiamata da `Models\Scopes\TenantScope` e da `Models\Traits\InteractsWithTenant`,
 * quindi sta nel percorso di ogni query sui modelli con tenancy.
 *
 * Stava in `app/Support/`, dove la regola di progetto non la vuole: `Support`
 * non dice niente sul ciclo di vita di cio' che contiene. Non e' diventata una
 * Action perche' non e' un caso d'uso ma un risolutore sincrono dentro uno
 * scope Eloquent, e il piano
 * (`Modules/Xot/docs/plans/support-to-queueable-actions.md`) lo dice:
 * «A class is not made queueable merely because it was previously placed in a
 * Support folder». Il namespace di ruolo segue il precedente
 * `Modules\Geo\Infrastructure\Config` (base_quaeris_fila5#247).
 *
 * Nota per chi lavora sugli altri progetti che condividono questo modulo: il
 * docblock precedente elencava i pannelli di un altro progetto («cameriere,
 * cassa, cucina, bar, HACCP» e «ristorante»). Il codice e' generico, quella
 * descrizione no.
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
