<?php

declare(strict_types=1);

namespace Modules\Notify\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Notify\Models\NotificationLog;
use Modules\Tenant\Services\TenantManager;

trait HasTenantNotifications
{
    /**
     * Ottiene tutte le notifiche per il tenant corrente.
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(NotificationLog::class, 'notifiable')->where('tenant_id', $this->getTenantId());
    }

    /**
     * Ottiene le notifiche non lette per il tenant corrente.
     */
    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Ottiene le notifiche lette per il tenant corrente.
     */
    public function readNotifications(): MorphMany
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * Scope per filtrare le notifiche per tenant.
     */
    public function scopeForTenant(Builder $query, ?string $tenantId = null): Builder
    {
        $tenantId ??= $this->getTenantId();

        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Verifica se il modello appartiene al tenant specificato.
     */
    public function belongsToTenant(string $tenantId): bool
    {
        return $this->tenant_id === $tenantId;
    }

    /**
     * Verifica se il modello appartiene al tenant corrente.
     */
    public function belongsToCurrentTenant(): bool
    {
        return $this->belongsToTenant($this->getTenantId());
    }

    /**
     * Boot del trait.
     */
    public static function bootHasTenantNotifications(): void
    {
        static::creating(function (Model $model) {
            if (! isset($model->tenant_id)) {
                $model->tenant_id = $model->getTenantId();
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            /** @var Model $model */
            $model = $builder->getModel();
            $builder->where($model->getTable().'.tenant_id', $model->getTenantId());
        });
    }

    /**
     * Ottiene l'ID del tenant corrente.
     */
    protected function getTenantId(): ?string
    {
        /** @var TenantManager */
        $tenantManager = app(TenantManager::class);

        return $tenantManager->getTenantId();
    }
}
