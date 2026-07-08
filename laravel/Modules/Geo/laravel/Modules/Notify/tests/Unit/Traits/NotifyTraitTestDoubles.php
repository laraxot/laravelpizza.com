<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Traits\HasNotificationRateLimiting;
use Modules\Notify\Traits\HasNotificationTracking;
use Modules\Notify\Traits\HasTenantNotifications;

final class NotifyRateLimitDummy
{
    use HasNotificationRateLimiting;

    public function key(string $type, mixed $identifier): string
    {
        return $this->getNotificationRateLimitKey($type, $identifier);
    }

    public function reset(string $key): void
    {
        $this->resetNotificationRateLimit($key);
    }

    public function shouldSend(string $key): bool
    {
        return $this->shouldSendNotification($key);
    }

    public function remaining(string $key): int
    {
        return $this->getNotificationRateLimitRemainingAttempts($key);
    }

    public function retryAfter(string $key): int
    {
        return $this->getNotificationRateLimitRetryAfter($key);
    }
}

final class NotifyTrackingDummy
{
    use HasNotificationTracking;

    private string $trackingId = '';

    public function addTrackingPublic(string $html, string $trackingId): string
    {
        $this->trackingId = $trackingId;

        return $this->addTracking($html, $trackingId);
    }

    public function trackingId(): string
    {
        return $this->trackingId;
    }

    public function trackingEnabled(): bool
    {
        return $this->isTrackingEnabled();
    }
}

final class NotifyTenantDummyModel extends Model
{
    use HasTenantNotifications;

    protected $table = 'notification_logs';

    public ?string $tenant_id = null;

    /**
     * @return MorphMany<NotificationLog, $this>
     */
    protected function tenantNotificationLogs(): MorphMany
    {
        return $this->morphMany(NotificationLog::class, 'notifiable');
    }
}
