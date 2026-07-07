<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Traits;

use Modules\Notify\Traits\HasNotificationTracking;

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