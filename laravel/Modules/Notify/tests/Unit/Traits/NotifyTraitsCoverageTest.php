<?php

declare(strict_types=1);

use Modules\Notify\Tests\TestCase;
use Modules\Notify\Traits\HasNotificationRateLimiting;
use Modules\Notify\Traits\HasNotificationTracking;
use Modules\Notify\Traits\HasTenantNotifications;
use Modules\Tenant\Services\TenantManager;

uses(TestCase::class);

class NotifyRateLimitDummy
{
    use HasNotificationRateLimiting;

    public function shouldSend(string $key): bool
    {
        return $this->shouldSendNotification($key);
    }

    public function retryAfter(string $key): int
    {
        return $this->getNotificationRateLimitRetryAfter($key);
    }

    public function remaining(string $key): int
    {
        return $this->getNotificationRateLimitRemainingAttempts($key);
    }

    public function reset(string $key): void
    {
        $this->resetNotificationRateLimit($key);
    }

    public function key(string $type, mixed $identifier): string
    {
        return $this->getNotificationRateLimitKey($type, $identifier);
    }
}

class NotifyTrackingDummy
{
    use HasNotificationTracking;

    public function addTrackingPublic(string $html, string $id): string
    {
        return $this->addTracking($html, $id);
    }

    public function trackingId(): string
    {
        return $this->generateTrackingId();
    }

    public function trackingEnabled(): bool
    {
        return $this->isTrackingEnabled();
    }
}

class NotifyTenantDummy
{
    use HasTenantNotifications;

    public ?string $tenant_id = null;
}

test('notification rate limiting helpers work with limiter', function () {
    config()->set('notify.rate_limiting.enabled', true);
    config()->set('notify.rate_limiting.max_attempts', 1);
    config()->set('notify.rate_limiting.decay_minutes', 1);

    $dummy = new NotifyRateLimitDummy();
    $key = $dummy->key('mail', 'id-'.uniqid());
    $dummy->reset($key);

    expect($dummy->shouldSend($key))->toBeTrue()
        ->and($dummy->shouldSend($key))->toBeFalse()
        ->and($dummy->remaining($key))->toBeLessThanOrEqual(0)
        ->and($dummy->retryAfter($key))->toBeInt();

    $dummy->reset($key);
    expect($dummy->shouldSend($key))->toBeTrue();
});

test('notification tracking returns original html when tracking is disabled', function () {
    config()->set('notify.tracking.enabled', false);
    config()->set('notify.tracking.pixel.enabled', false);
    config()->set('notify.tracking.links.enabled', false);

    $dummy = new NotifyTrackingDummy();
    $html = '<a href="https://example.com/path">click</a>';

    $tracked = $dummy->addTrackingPublic($html, 'track-1');

    expect($tracked)->toBe($html)
        ->and($dummy->trackingId())->toBeString()
        ->and($dummy->trackingEnabled())->toBeFalse();
});

test('tenant notification helpers check tenant ownership', function () {
    app()->instance(TenantManager::class, new class
    {
        public function getTenantId(): string
        {
            return 'tenant-42';
        }
    });

    $dummy = new NotifyTenantDummy();
    $dummy->tenant_id = 'tenant-42';

    expect($dummy->belongsToTenant('tenant-42'))->toBeTrue()
        ->and($dummy->belongsToCurrentTenant())->toBeTrue()
        ->and($dummy->belongsToTenant('other-tenant'))->toBeFalse();
});
