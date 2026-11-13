<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies\Concerns;

/**
 * Per i moduli in cui il ruolo del pannello (`{modulo}::admin`) serve solo a entrare e cosa si puo'
 * fare lo dicono permessi operativi (es. Roosko: operatore, accettazione, responsabile tecnico).
 *
 * Senza questo trait `XotBasePolicy::before()` concede ogni abilita' a chi ha `{modulo}::admin`
 * (ADR module-admin-role-policy-bypass): in un impianto di rifiuti l'operatore di piazzale, che ha
 * il ruolo del pannello per usare la pagina di scansione, poteva rettificare pesi ed eliminare
 * conferimenti. Il super-admin resta escluso dai controlli come sempre.
 */
trait RequiresOperationalPermissions
{
    protected static function moduleAdminRole(): ?string
    {
        return null;
    }
}
