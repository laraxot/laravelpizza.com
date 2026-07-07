<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Traits;

use Modules\Notify\Traits\HasNotificationRateLimiting;

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