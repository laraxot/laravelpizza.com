<?php

declare(strict_types=1);

namespace Modules\User\Models\Scopes;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Modules\User\Support\AuthenticatedTenantKey;

/**
 * Limita le query ai record del tenant corrente.
 *
 * Il tenant corrente e' quello Filament (pannelli con tenancy); in assenza si
 * ripiega sul tenant dell'utente autenticato, cosi' anche i pannelli operativi
 * senza tenancy (cameriere, cassa, cucina, bar, HACCP) vedono solo il proprio
 * ristorante. Solo senza utente autenticato (console, code, guest) lo scope non
 * filtra: la gestione vede tutto.
 *
 * La colonna e' qualificata con la tabella del modello: senza, una join con un'altra
 * tabella che ha `tenant_id` rende la condizione ambigua (errore SQL) o, peggio,
 * la applica alla tabella sbagliata.
 *
 * @implements Scope<Model>
 */
class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenantId = Filament::getTenant()?->getKey() ?? AuthenticatedTenantKey::resolve();
        if ($tenantId === null) {
            return;
        }

        $builder->where($model->qualifyColumn('tenant_id'), '=', $tenantId);
    }
}
