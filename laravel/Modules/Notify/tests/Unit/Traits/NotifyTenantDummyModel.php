<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Traits\HasTenantNotifications;

final class NotifyTenantDummyModel extends Model
{
    use HasTenantNotifications;

    protected $table = 'notification_logs';

    public ?string $tenant_id = null;

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function applyForTenantScope(Builder $query, ?string $tenantId = null): Builder
    {
        return $this->scopeForTenant($query, $tenantId);
    }

    /**
     * @return MorphMany<NotificationLog, $this>
     */
    protected function tenantNotificationLogs(): MorphMany
    {
        return $this->morphMany(NotificationLog::class, 'notifiable');
    }
}
