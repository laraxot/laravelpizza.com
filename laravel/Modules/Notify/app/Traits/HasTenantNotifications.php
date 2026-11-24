<?php

declare(strict_types=1);

namespace Modules\Notify\Traits;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Notify\Models\NotificationLog;
use Webmozart\Assert\Assert;

/**
 * Trait HasTenantNotifications.
 *
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
 * Log di notifica multi-tenant (NotificationLog), non le database notifications Laravel.
 * Evitare di combinarlo con Illuminate\Notifications\Notifiable sullo stesso modello
 * (collisioni su notifications() / unreadNotifications()).
 *
 * Generics: MorphMany/Builder usano `$this` (non TModel) perche morphMany()
 * restituisce MorphMany<Related, $this> e TModel concreto diverge da $this in PHPStan.
 *
 * @property string|int|null $tenant_id
 *
 * @see Modules/Notify/docs/contracts/has-tenant-notifications.md
<<<<<<< HEAD
=======
=======
 * Fornisce funzionalità per la gestione delle notifiche per tenant.
 *
 * Usato da test/unit helpers (es. NotifyTenantDummyModel); non ignorare trait.unused.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
 */
trait HasTenantNotifications
{
    /**
     * @return MorphMany<NotificationLog, $this>
     */
    public function notifications(): MorphMany
    {
        return $this->tenantNotificationLogs();
    }

    /**
     * @return MorphMany<NotificationLog, $this>
     */
    public function unreadNotifications(): MorphMany
    {
        return $this->tenantNotificationLogs()->whereNull('read_at');
    }

    /**
     * @return MorphMany<NotificationLog, $this>
     */
    public function readNotifications(): MorphMany
    {
        return $this->tenantNotificationLogs()->whereNotNull('read_at');
    }

    /**
<<<<<<< HEAD
     * @param  Builder<$this>  $query
     * @return Builder<$this>
=======
<<<<<<< HEAD
     * @param  Builder<$this>  $query
     * @return Builder<$this>
=======
     * @param  Builder<static>  $query
     * @return Builder<static>
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
        return (string) $this->tenant_id === $tenantId;
=======
<<<<<<< HEAD
        return (string) $this->tenant_id === $tenantId;
=======
        return $this->tenant_id === $tenantId;
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    }

    /**
     * Verifica se il modello appartiene al tenant corrente.
     */
    public function belongsToCurrentTenant(): bool
    {
        $currentTenantId = $this->getTenantId();

        return $currentTenantId !== null && $this->belongsToTenant($currentTenantId);
    }

    /**
     * Boot del trait.
     */
    public static function bootHasTenantNotifications(): void
    {
        static::creating(function (Model $model): void {
            if (! $model instanceof static) {
                return;
            }

            if (! isset($model->tenant_id)) {
                $model->tenant_id = $model->getTenantId();
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder): void {
<<<<<<< HEAD
            /** @var Builder<static> $builder */
=======
<<<<<<< HEAD
            /** @var Builder<static> $builder */
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
            $model = $builder->getModel();

            if (! $model instanceof static) {
                return;
            }

            $tenantId = $model->getTenantId();

            if ($tenantId !== null) {
                $builder->where($model->getTable().'.tenant_id', $tenantId);
            }
        });
    }

    /**
     * Relazione morph verso NotificationLog filtrata per tenant corrente.
     *
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
     * @return MorphMany<NotificationLog, $this>
     */
    protected function tenantNotificationLogs(): MorphMany
    {
        /** @var MorphMany<NotificationLog, $this> $relation */
        $relation = $this->morphMany(NotificationLog::class, 'notifiable');

        return $relation->where('tenant_id', $this->getTenantId());
<<<<<<< HEAD
=======
=======
     * @return MorphMany<NotificationLog, static>
     */
    protected function tenantNotificationLogs(): MorphMany
    {
        return $this->morphMany(NotificationLog::class, 'notifiable')->where('tenant_id', $this->getTenantId());
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    }

    /**
     * Ottiene l'ID del tenant corrente.
     */
    protected function getTenantId(): ?string
    {
        try {
            $tenant = Filament::getTenant();
        } catch (\Throwable) {
            return null;
        }

        if ($tenant === null) {
            return null;
        }

        $key = $tenant->getKey();

        if ($key === null) {
            return null;
        }

        Assert::scalar($key);

        return (string) $key;
    }
}
