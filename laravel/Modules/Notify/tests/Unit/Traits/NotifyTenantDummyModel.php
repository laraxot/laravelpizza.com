<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Traits\HasTenantNotifications;

final class NotifyTenantDummyModel extends Model
{
    use HasTenantNotifications;

    protected $table = 'notification_logs';

    public ?string $tenant_id = null;

    public ?string $currentTenantId = null;

    protected function getTenantId(): ?string
    {
        return $this->currentTenantId;
    }

    /**
     * @return MorphMany<NotificationLog, $this>
     */
    protected function tenantNotificationLogs(): MorphMany
    {
        return $this->morphMany(NotificationLog::class, 'notifiable');
    }
}