<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\Scopes\TenantScope;
use Modules\Xot\Datas\XotData;

/**
 * Modello che appartiene a un tenant (colonna `tenant_id`).
 *
 * - `tenant()` e' la relazione di ownership che Filament cerca di default
 *   (nome camelCase del modello tenant): i pannelli con tenancy la usano per
 *   lo scoping delle resource e per associare i nuovi record.
 * - `TenantScope` copre anche le query fuori dalle resource (widget, select,
 *   azioni, relation manager) quando c'e' un tenant corrente.
 * - Alla creazione, se `tenant_id` non e' valorizzato, prende il tenant corrente.
 *
 * Il tenant ha chiave stringa (UUID, vedi `BaseTenant`): niente cast o controlli
 * su int, altrimenti l'associazione salta e il record resta senza tenant.
 *
 * @see https://filamentphp.com/docs/5.x/users/tenancy
 */
trait InteractsWithTenant
{
    /**
     * Relazione con il tenant a cui appartiene il modello.
     *
     * @return BelongsTo<Model, self>
     *
     * @phpstan-return BelongsTo<Model, $this>
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(XotData::make()->getTenantClass(), 'tenant_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function bootInteractsWithTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(static function (Model $model): void {
            if (filled($model->getAttribute('tenant_id'))) {
                return;
            }

            $tenantId = Filament::getTenant()?->getKey();
            if ($tenantId !== null) {
                $model->setAttribute('tenant_id', $tenantId);
            }
        });
    }
}
