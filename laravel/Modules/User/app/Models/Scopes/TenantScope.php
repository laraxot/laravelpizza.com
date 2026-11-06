<?php

declare(strict_types=1);

namespace Modules\User\Models\Scopes;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Limita le query ai record del tenant Filament corrente.
 *
 * Fuori da un pannello con tenancy (pannelli di gestione del super admin, console,
 * code) `Filament::getTenant()` e' null e lo scope non filtra: la gestione vede tutto.
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
        $tenantId = Filament::getTenant()?->getKey();
        if ($tenantId === null) {
            return;
        }

        $builder->where($model->qualifyColumn('tenant_id'), '=', $tenantId);
    }
}
