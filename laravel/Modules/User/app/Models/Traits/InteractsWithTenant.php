<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Scopes\TenantScope;
use Modules\User\Models\Tenant;

/**
 * @property TeamContract $currentTeam
 */
trait InteractsWithTenant
{
    /**
     * Tenant corrente.
     */
    protected ?Model $currentTenant = null;

    /**
     * Relazione con il tenant a cui appartiene il modello.
     *
     * @return BelongsTo<Model, self>
     *
     * @phpstan-return BelongsTo<Model, $this>
     */
    public function tenant(): BelongsTo
    {
        $tenant = $this->getTenant();
        if (null === $tenant) {
            $this->loadTenantFromSession();
            $tenant = $this->getTenant();
        }

        $tenantClass = config('tenant.tenant_model', Tenant::class);

        // @phpstan-ignore argument.type, argument.templateType
        return $this->belongsTo($tenantClass, 'tenant_id');
    }

    /**
     * Ottiene il tenant corrente.
     */
    protected function getTenant(): ?Model
    {
        return $this->currentTenant;
    }

    /**
     * Carica il tenant dalla sessione.
     */
    protected function loadTenantFromSession(): void
    {
        try {
            $this->currentTenant = Filament::getTenant();
        } catch (\Throwable $e) {
            // Se Filament non è disponibile, lascia il tenant come null
            $this->currentTenant = null;
        }
    }

    /**
     * The "booted" method of the model.
     */
    protected static function bootInteractsWithTenant(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(static function ($model): void {
            // PHPStan Level 10: Verifica se il modello ha tenant_id
            // Uso isFillable() invece di property_exists() per Eloquent magic properties
            if (null !== $model && $model instanceof Model && $model->isFillable('tenant_id')) {
                $tenant = Filament::getTenant();
                if (null !== $tenant) {
                    // Usa setAttribute() invece di assegnazione diretta per PHPStan
                    $model->setAttribute('tenant_id', $tenant->getKey());
                }
            }
        });
    }

    /**
     * Interact with the user's first name.
     */
    protected function setTenantIdAttribute(?int $value): void
    {
        $tenant = Filament::getTenant();
        if (null === $value && null !== $tenant) {
            $tenantId = $tenant->getKey();
            if (is_int($tenantId)) {
                $value = $tenantId;
            }
        }

        if (null !== $value) {
            $this->attributes['tenant_id'] = $value;
        }
    }

    /**
     * Applica lo scope del tenant.
     */
    protected function applyTenantScope(): void
    {
        $tenant = $this->getTenant();
        if (null === $tenant) {
            $this->loadTenantFromSession();
            $tenant = $this->getTenant();
        }

        if (null !== $tenant) {
            $tenantId = $tenant->getKey();
            if (null !== $tenantId) {
                static::addGlobalScope(new TenantScope());
            }
        }
    }
}
