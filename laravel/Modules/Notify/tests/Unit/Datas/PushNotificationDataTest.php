<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas;

use Modules\Notify\Datas\PushNotificationData;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('PushNotificationData DTO', function (): void {
    it('creates with notification fields for FCM and Web Push', function (): void {
        $dto = new PushNotificationData(
            title: 'Test Title',
            body: 'Test body',
            icon: 'ic_notification',
            sound: 'default',
            badge: 1,
            priority: 'high',
            ttl: 3600,
            actions: [['action' => 'open', 'title' => 'Open']],
            requireInteraction: true,
            silent: false,
        );

        Assert::assertSame('Test Title', $dto->title);
        Assert::assertSame('Test body', $dto->body);
        Assert::assertSame('ic_notification', $dto->icon);
        Assert::assertSame('default', $dto->sound);
        Assert::assertSame(1, $dto->badge);
        Assert::assertSame('high', $dto->priority);
        Assert::assertSame(3600, $dto->ttl);
        Assert::assertCount(1, $dto->actions ?? []);
        Assert::assertTrue($dto->requireInteraction);
        Assert::assertFalse($dto->silent);
    });

    it('creates with minimal title and body', function (): void {
        $dto = new PushNotificationData(
            title: 'Minimal',
            body: 'Test',
        );

        Assert::assertSame('Minimal', $dto->title);
        Assert::assertSame('Test', $dto->body);
        Assert::assertNull($dto->icon);
        Assert::assertNull($dto->priority);
        Assert::assertNull($dto->ttl);
    });

    it('serializes to array via Spatie Data', function (): void {
        $dto = new PushNotificationData(
            title: 'FCM Test',
            body: 'FCM Body',
            icon: '/icons/icon-192x192.png',
            sound: 'default',
            priority: 'high',
            ttl: 3600,
        );

        $array = $dto->toArray();

        Assert::assertSame('FCM Test', $array['title']);
        Assert::assertSame('FCM Body', $array['body']);
        Assert::assertSame('/icons/icon-192x192.png', $array['icon']);
        Assert::assertSame('high', $array['priority']);
        Assert::assertSame(3600, $array['ttl']);
    });

    it('accepts string badge for Web Push icon URL', function (): void {
        $dto = new PushNotificationData(
            title: 'Web',
            body: 'Push',
            badge: 'https://example.com/badge.png',
        );

        Assert::assertSame('https://example.com/badge.png', $dto->badge);
    });
});
