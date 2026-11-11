<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\Xot\Datas\XotData;

/**
 * Trait HasTenants.
 *
 * Provides tenant functionality for User models implementing multi-tenancy.
 *
 * @property TeamContract $currentTeam
 */
trait HasTenants
{
    /**
     * Check if the user can access a specific tenant.
     */
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->tenants()->whereKey($tenant)->exists();
    }

    /**
     * Get tenants for the given panel.
     *
     * @return array<Model>|Collection<int, Model>
     */
    public function getTenants(Panel $_panel): array|Collection
    {
        /** @var Collection<int, Model> $result */
        $result = $this->tenants->map(
            static fn (Model $tenant): Model => $tenant,
        );

        return $result;
    }

    /**
     * Get all of the tenants the user belongs to.
     *
     * @return BelongsToMany<Model, Model&static>
     *
     * @phpstan-return BelongsToMany<Model, Model&static, Pivot, 'pivot'>
     */
    public function tenants(): BelongsToMany
    {
        $xot = XotData::make();
        /** @var class-string<Model> */
        $tenant_class = $xot->getTenantClass();

        /** @var BelongsToMany<Model, Model&static, Pivot, 'pivot'> $relation */
        $relation = $this->belongsToManyX($tenant_class);

        return $relation;
    }
}
