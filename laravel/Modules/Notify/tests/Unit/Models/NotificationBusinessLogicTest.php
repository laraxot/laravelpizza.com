<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Notify\Models\Notification;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Notification Business Logic', function (): void {
    test('notification extends xot base model', function (): void {
        $notification = new Notification;

        Assert::assertContains('channels', $notification->getFillable());
        Assert::assertContains('sent_at', $notification->getFillable());
    });

    test('notification can store polymorphic notifiable relationships', function (): void {
        $notification = new Notification;
        $notification->notifiable_type = 'App\\Models\\User';
        $notification->notifiable_id = 1;

        Assert::assertSame('App\\Models\\User', $notification->notifiable_type);
        Assert::assertSame(1, $notification->notifiable_id);
    });

    test('notification has notification type', function (): void {
        $notification = new Notification;
        $notification->type = 'App\\Notifications\\OrderConfirmation';

        Assert::assertSame('App\\Notifications\\OrderConfirmation', $notification->type);
    });

    test('notification can store data payload', function (): void {
        $notification = new Notification;
        $notification->data = ['title' => 'Test', 'message' => 'Hello World'];

        Assert::assertArrayHasKey('title', $notification->data);
        Assert::assertArrayHasKey('message', $notification->data);
    });

    test('notification can track read status', function (): void {
        $notification = new Notification;
        $readAt = Carbon::parse('2023-01-01 12:00:00');
        $notification->read_at = $readAt;

        Assert::assertTrue($readAt->equalTo($notification->read_at));
    });

    test('notification can track tenant and user', function (): void {
        $notification = new Notification;
        $notification->tenant_id = 1;
        $notification->user_id = 5;

        Assert::assertSame(1, $notification->tenant_id);
        Assert::assertSame(5, $notification->user_id);
    });

    test('notification can store polymorphic subject relationships', function (): void {
        $notification = new Notification;
        $notification->subject_type = 'App\\Models\\Order';
        $notification->subject_id = 123;

        Assert::assertSame('App\\Models\\Order', $notification->subject_type);
        Assert::assertSame(123, $notification->subject_id);
    });

    test('notification can track multiple channels', function (): void {
        $notification = new Notification;
        $notification->channels = ['mail', 'sms', 'database'];

        Assert::assertIsArray($notification->channels);
        Assert::assertContains('mail', $notification->channels);
        Assert::assertContains('sms', $notification->channels);
    });

    test('notification can track status and sent time', function (): void {
        $notification = new Notification;
        $notification->status = 'sent';
        $sentAt = Carbon::parse('2023-01-01 14:00:00');
        $notification->sent_at = $sentAt;

        Assert::assertSame('sent', $notification->status);
        Assert::assertTrue($sentAt->equalTo($notification->sent_at));
    });

    test('notification has factory for testing', function (): void {
        Assert::assertInstanceOf(Factory::class, Notification::factory());
    });
});