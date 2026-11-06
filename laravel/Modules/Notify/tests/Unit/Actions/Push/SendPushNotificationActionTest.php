<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\Push;

use Illuminate\Support\Facades\Http;
use Modules\Notify\Actions\Push\SendPushToDeviceAction;
use Modules\Notify\Actions\Push\SendPushToDevicesAction;
use Modules\Notify\Actions\Push\SendPushToTopicAction;
use Modules\Notify\Datas\PushNotificationData;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);
beforeEach(function (): void {
    config(['notify.fcm.server_key' => 'test-key']);
    // Nessuna richiesta reale; ogni test registra il proprio stub FCM (un fake '*' qui vincerebbe su quelli)
    Http::preventStrayRequests();
});

describe('Push delivery actions (device, batch, topic)', function (): void {
    it('sends push notification to single device on all platforms', function (): void {
        Http::fake([
            'fcm.googleapis.com/fcm/send*' => Http::response([
                'message_id' => 'msg-123',
            ], 200),
        ]);

        $pushData = PushNotificationData::from([
            'title' => 'Test Title',
            'body' => 'Test body',
        ]);

        $fcmToken = str_repeat('a', 80).':'.str_repeat('b', 40);
        $results = app(SendPushToDeviceAction::class)->execute($fcmToken, $pushData, ['key' => 'value']);

        Assert::assertSame(['fcm', 'apns', 'webpush'], array_keys($results));
        Assert::assertTrue($results['fcm']['success']);
    });

    it('sends push notification to multiple devices grouped by platform', function (): void {
        Http::fake([
            'fcm.googleapis.com/fcm/send*' => Http::response(['message_id' => 'msg-1'], 200),
        ]);

        $pushData = PushNotificationData::from([
            'title' => 'Broadcast',
            'body' => 'To multiple devices',
        ]);

        $fcmToken = str_repeat('c', 80).':'.str_repeat('d', 40);
        $results = app(SendPushToDevicesAction::class)->execute([$fcmToken, 'web-token-abc'], $pushData);

        Assert::assertArrayHasKey('fcm', $results);
        Assert::assertSame(1, $results['fcm']['sent']);
        Assert::assertSame(0, $results['fcm']['failed']);
    });

    it('sends push notification to topic on all platforms', function (): void {
        Http::fake([
            'fcm.googleapis.com/fcm/send*' => Http::response([
                'message_id' => 'topic-msg-123',
            ], 200),
        ]);

        $pushData = PushNotificationData::from([
            'title' => 'Topic Message',
            'body' => 'For all subscribers',
        ]);

        $results = app(SendPushToTopicAction::class)->execute('news', $pushData);

        Assert::assertArrayHasKey('fcm', $results);
        Assert::assertTrue($results['fcm']['success']);
    });

    it('records FCM failure when token is not registered', function (): void {
        Http::fake([
            'fcm.googleapis.com/fcm/send*' => Http::response([
                'success' => 0,
                'failure' => 1,
                'results' => [['error' => 'NotRegistered']],
            ], 200),
        ]);

        $pushData = PushNotificationData::from([
            'title' => 'Test',
            'body' => 'Test',
        ]);

        $fcmToken = str_repeat('e', 80).':'.str_repeat('f', 40);
        $results = app(SendPushToDeviceAction::class)->execute($fcmToken, $pushData);

        Assert::assertFalse($results['fcm']['success']);
    });

    it('passes custom data payload to FCM', function (): void {
        Http::fake([
            'fcm.googleapis.com/fcm/send*' => Http::response(['message_id' => 'msg-1'], 200),
        ]);

        $pushData = PushNotificationData::from([
            'title' => 'Data Test',
            'body' => 'With data',
        ]);

        $fcmToken = str_repeat('g', 80).':'.str_repeat('h', 40);
        $results = app(SendPushToDeviceAction::class)->execute(
            $fcmToken,
            $pushData,
            ['action' => 'open_order', 'order_id' => 123],
        );

        Assert::assertTrue($results['fcm']['success']);
    });

    it('honours priority and TTL on the notification payload', function (): void {
        Http::fake([
            'fcm.googleapis.com/fcm/send*' => Http::response(['message_id' => 'msg-1'], 200),
        ]);

        $pushData = new PushNotificationData(
            title: 'High Priority',
            body: 'Urgent',
            priority: 'high',
            ttl: 3600,
        );

        $fcmToken = str_repeat('i', 80).':'.str_repeat('j', 40);
        $results = app(SendPushToDeviceAction::class)->execute($fcmToken, $pushData);

        Assert::assertTrue($results['fcm']['success']);
    });
});