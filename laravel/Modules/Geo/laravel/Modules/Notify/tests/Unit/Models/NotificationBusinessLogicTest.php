<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;
use Modules\Notify\Models\Notification;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Notification Business Logic', function () {
    test('notification extends xot base model', function () {
        $notification = new Notification;

        Assert::assertInstanceOf(Notification::class, $notification);
    });

    test('notification can store polymorphic notifiable relationships', function () {
        $notification = new Notification([
            'notifiable_type' => 'App\\Models\\User',
            'notifiable_id' => 1,
        ]);

        Assert::assertSame('App\\Models\\User', $notification->notifiable_type);
        Assert::assertSame(1, $notification->notifiable_id);
    });

    test('notification has notification type', function () {
        $notification = new Notification([
            'type' => 'App\\Notifications\\OrderConfirmation',
        ]);

        Assert::assertSame('App\\Notifications\\OrderConfirmation', $notification->type);
    });

    test('notification can store data payload', function () {
        $notification = new Notification([
            'data' => ['title' => 'Test', 'message' => 'Hello World'],
        ]);

        $data = \assertNotifyArray($notification->data);
        Assert::assertSame('Test', $data['title']);
    });

    test('notification can track read status', function () {
        $notification = new Notification([
            'read_at' => '2023-01-01 12:00:00',
        ]);

        Assert::assertSame('2023-01-01 12:00:00', (string) $notification->read_at);
    });

    test('notification can track tenant and user', function () {
        $notification = new Notification([
            'tenant_id' => 1,
            'user_id' => 5,
        ]);

        Assert::assertSame(1, $notification->tenant_id);
        Assert::assertSame(5, $notification->user_id);
    });

    test('notification can store polymorphic subject relationships', function () {
        $notification = new Notification([
            'subject_type' => 'App\\Models\\Order',
            'subject_id' => 123,
        ]);

        Assert::assertSame('App\\Models\\Order', $notification->subject_type);
        Assert::assertSame(123, $notification->subject_id);
    });

    test('notification can track multiple channels', function () {
        $notification = new Notification([
            'channels' => ['mail', 'sms', 'database'],
        ]);

        $channels = \assertNotifyArray($notification->channels);
        Assert::assertContains('mail', $channels);
        Assert::assertContains('sms', $channels);
    });

    test('notification can track status and sent time', function () {
        $notification = new Notification([
            'status' => 'sent',
            'sent_at' => '2023-01-01 14:00:00',
        ]);

        Assert::assertSame('sent', $notification->status);
        Assert::assertSame('2023-01-01 14:00:00', (string) $notification->sent_at);
    });

    test('notification has factory for testing', function () {
        $reflection = new \ReflectionClass(Notification::class);

        Assert::assertTrue($reflection->hasMethod('factory'));
    });
});
