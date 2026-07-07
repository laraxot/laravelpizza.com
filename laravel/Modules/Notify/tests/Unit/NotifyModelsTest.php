<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Carbon\Carbon;
use Modules\Notify\Database\Factories\NotificationChannelFactory;
use Modules\Notify\Database\Factories\NotificationFactory;
use Modules\Notify\Database\Factories\NotificationLogFactory;
use Modules\Notify\Database\Factories\NotificationTemplateFactory;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationChannel;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(\Modules\Notify\Tests\TestCase::class);

it('can create a notification', function () {
    $notification = NotificationFactory::new()->createOne([
        'type' => 'App\Notifications\UserRegistered',
        'notifiable_type' => 'Modules\User\Models\User',
        'notifiable_id' => 1,
        'data' => json_encode(['message' => 'User registered']),
    ]);

    Assert::assertInstanceOf(Notification::class, $notification);
    Assert::assertSame('App\Notifications\UserRegistered', $notification->type);
    Assert::assertSame('Modules\User\Models\User', $notification->notifiable_type);
    Assert::assertSame(1, $notification->notifiable_id);
});

it('can create a notification with read status', function () {
    $notification = NotificationFactory::new()->createOne([
        'type' => 'App\Notifications\Welcome',
        'notifiable_type' => 'Modules\User\Models\User',
        'notifiable_id' => 1,
        'read_at' => now(),
    ]);

    Assert::assertInstanceOf(Carbon::class, $notification->read_at);
});

it('can create a notification template', function () {
    $template = NotificationTemplateFactory::new()->createOne([
        'name' => 'Welcome Email',
        'type' => 'email',
        'subject' => json_encode(['en' => 'Welcome to our platform']),
        'body_html' => json_encode(['en' => 'Welcome {{user.name}}!']),
    ]);

    Assert::assertInstanceOf(NotificationTemplate::class, $template);
    Assert::assertSame('Welcome Email', $template->name);
    Assert::assertSame('email', $template->type->value ?? $template->type);
});

it('can make a notification channel without persisting', function () {
    $channel = NotificationChannelFactory::new()->makeOne([
        'name' => 'SMS',
        'driver' => 'sms',
        'is_enabled' => true,
    ]);

    Assert::assertInstanceOf(NotificationChannel::class, $channel);
    Assert::assertSame('SMS', $channel->name);
    Assert::assertSame('sms', $channel->driver);
});

it('can create a notification log', function () {
    $log = NotificationLogFactory::new()->createOne([
        'status' => 'sent',
        'content' => 'Notification sent successfully',
    ]);

    Assert::assertInstanceOf(NotificationLog::class, $log);
    Assert::assertSame('sent', $log->status);
});

it('can create a notification with custom data', function () {
    $payload = [
        'user_id' => 1,
        'action' => 'profile_updated',
        'details' => ['field' => 'email', 'old_value' => 'old@example.com'],
    ];

    $notification = NotificationFactory::new()->createOne([
        'type' => 'App\Notifications\Custom',
        'notifiable_type' => 'Modules\User\Models\User',
        'notifiable_id' => (string) \Illuminate\Support\Str::uuid(),
        'data' => $payload,
    ]);

    Assert::assertSame($payload, $notification->data);
});
