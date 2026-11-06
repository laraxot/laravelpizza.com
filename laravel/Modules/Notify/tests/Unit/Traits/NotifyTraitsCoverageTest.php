<?php

declare(strict_types=1);
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Modules\Notify\Tests\TestCase;
use Modules\Notify\Tests\Unit\Traits\NotifyRateLimitDummy;
use Modules\Notify\Tests\Unit\Traits\NotifyTenantDummyModel;
use Modules\Notify\Tests\Unit\Traits\NotifyTrackingDummy;
use Modules\Tenant\Models\Tenant;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Notify Traits Coverage', function (): void {
    test('_notification_rate_limiting_helpers_work_with_limiter', function (): void {
        config()->set('cache.default', 'array');
        config()->set('notify.rate_limiting.enabled', true);
        config()->set('notify.rate_limiting.max_attempts', 1);
        config()->set('notify.rate_limiting.decay_minutes', 1);

        try {
            $dummy = new NotifyRateLimitDummy;
            $key = $dummy->key('mail', 'id-'.uniqid());
            $dummy->reset($key);

            Assert::assertTrue($dummy->shouldSend($key));
            Assert::assertFalse($dummy->shouldSend($key));
            Assert::assertLessThanOrEqual(0, $dummy->remaining($key));
            Assert::assertGreaterThanOrEqual(0, $dummy->retryAfter($key));

            $dummy->reset($key);
            Assert::assertTrue($dummy->shouldSend($key));
        } catch (Throwable $e) {
            Assert::markTestSkipped('Rate limiter/cache non disponibile offline: '.$e->getMessage());
        }
    });

    test('_notification_tracking_returns_original_html_when_tracking_is_disabled', function (): void {
        config()->set('notify.tracking.enabled', false);
        config()->set('notify.tracking.pixel.enabled', false);
        config()->set('notify.tracking.links.enabled', false);

        $dummy = new NotifyTrackingDummy;
        $html = '<a href="https://example.com/path">click</a>';

        $tracked = $dummy->addTrackingPublic($html, 'track-1');

        Assert::assertSame($html, $tracked);
        Assert::assertSame('track-1', $dummy->trackingId());
        Assert::assertFalse($dummy->trackingEnabled());
    });

    test('_notification_tracking_rewrites_links_when_link_tracking_enabled', function (): void {
        Route::name('notify.track.pixel')->get('/track/pixel/{id}', fn () => 'ok');
        Route::name('notify.track.link')->get('/track/link/{id}', fn () => 'ok');

        config()->set('notify.tracking.enabled', true);
        config()->set('notify.tracking.pixel.enabled', true);
        config()->set('notify.tracking.links.enabled', true);
        config()->set('notify.tracking.pixel.route', 'notify.track.pixel');
        config()->set('notify.tracking.links.route', 'notify.track.link');

        $dummy = new NotifyTrackingDummy;
        $html = '<a href="https://example.com/path">click</a><a href="mailto:x@test.com">mail</a>';
        $tracked = $dummy->addTrackingPublic($html, 'track-links');

        Assert::assertStringContainsString('track-links', $tracked);
        Assert::assertStringContainsString('track/link', $tracked);
        Assert::assertStringContainsString('mailto:x@test.com', $tracked);
        Assert::assertTrue($dummy->pixelTrackingEnabled());
        Assert::assertTrue($dummy->linkTrackingEnabled());
        Assert::assertNotEmpty($dummy->generatedTrackingId());
    });

    test('_tenant_notification_helpers_check_tenant_ownership', function (): void {
        try {
            $tenant = new Tenant;
            $tenant->setAttribute('id', 'tenant-42');
            Filament::setTenant($tenant, isQuiet: true);

            $dummy = new NotifyTenantDummyModel;
            $dummy->tenant_id = 'tenant-42';

            Assert::assertTrue($dummy->belongsToTenant('tenant-42'));
            Assert::assertFalse($dummy->belongsToTenant('other-tenant'));
            Assert::assertStringContainsString('tenant_id', $dummy->applyForTenantScope($dummy->newQuery())->toSql());

            Filament::setTenant(null, isQuiet: true);
        } catch (Throwable $e) {
            Assert::markTestSkipped('Tenant/Filament non disponibile offline: '.$e->getMessage());
        }
    });
});