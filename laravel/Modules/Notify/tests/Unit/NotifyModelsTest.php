<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Carbon\Carbon;
<<<<<<< HEAD
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationAttachment;
use Modules\Notify\Models\NotificationCampaign;
use Modules\Notify\Models\NotificationChannel;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Models\NotificationPreference;
use Modules\Notify\Models\NotificationRule;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\TestCase;
=======
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
>>>>>>> 40b96bcd6 (.)

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

<<<<<<< HEAD
    expect($notification->read_at)->toBeInstanceOf(Carbon::class);
});

it('can create a notification template', function () {
    $template = NotificationTemplate::factory()->create([
=======
    Assert::assertInstanceOf(Carbon::class, $notification->read_at);
});

it('can create a notification template', function () {
    $template = NotificationTemplateFactory::new()->createOne([
>>>>>>> 40b96bcd6 (.)
        'name' => 'Welcome Email',
        'type' => 'email',
        'subject' => json_encode(['en' => 'Welcome to our platform']),
        'body_html' => json_encode(['en' => 'Welcome {{user.name}}!']),
    ]);

<<<<<<< HEAD
    expect($template)->toBeInstanceOf(NotificationTemplate::class);
    expect($template->name)->toBe('Welcome Email');
    expect($template->type)->toBe('email');
});

it('can create a notification channel', function () {
    $channel = NotificationChannel::factory()->create([
=======
    Assert::assertInstanceOf(NotificationTemplate::class, $template);
    Assert::assertSame('Welcome Email', $template->name);
    Assert::assertSame('email', $template->type->value ?? $template->type);
});

it('can make a notification channel without persisting', function () {
    $channel = NotificationChannelFactory::new()->makeOne([
>>>>>>> 40b96bcd6 (.)
        'name' => 'SMS',
        'driver' => 'sms',
        'is_enabled' => true,
    ]);

<<<<<<< HEAD
    expect($channel)->toBeInstanceOf(NotificationChannel::class);
    expect($channel->name)->toBe('SMS');
    expect($channel->driver)->toBe('sms');
});

it('can create a notification preference', function () {
    $preference = NotificationPreference::factory()->create([
        'user_id' => 1,
        'channel' => 'email',
        'notification_type' => 'welcome',
        'enabled' => true,
    ]);

    expect($preference)->toBeInstanceOf(NotificationPreference::class);
    expect($preference->user_id)->toBe(1);
    expect($preference->channel)->toBe('email');
});

it('can create a notification log', function () {
    $log = NotificationLog::factory()->create([
        'notification_id' => 1,
        'channel' => 'email',
=======
    Assert::assertInstanceOf(NotificationChannel::class, $channel);
    Assert::assertSame('SMS', $channel->name);
    Assert::assertSame('sms', $channel->driver);
});

it('can create a notification log', function () {
    $log = NotificationLogFactory::new()->createOne([
>>>>>>> 40b96bcd6 (.)
        'status' => 'sent',
        'content' => 'Notification sent successfully',
    ]);

<<<<<<< HEAD
    expect($log)->toBeInstanceOf(NotificationLog::class);
    expect($log->status)->toBe('sent');
});

it('can create a notification rule', function () {
    $rule = NotificationRule::factory()->create([
        'name' => 'Admin Notifications',
        'event' => 'user.registered',
        'channel' => 'email',
        'conditions' => json_encode(['user_type' => 'admin']),
    ]);

    expect($rule)->toBeInstanceOf(NotificationRule::class);
    expect($rule->name)->toBe('Admin Notifications');
    expect($rule->event)->toBe('user.registered');
});

it('can create a notification campaign', function () {
    $campaign = NotificationCampaign::factory()->create([
        'name' => 'Weekly Newsletter',
        'type' => 'email',
        'schedule' => 'weekly',
        'status' => 'scheduled',
    ]);

    expect($campaign)->toBeInstanceOf(NotificationCampaign::class);
    expect($campaign->name)->toBe('Weekly Newsletter');
    expect($campaign->status)->toBe('scheduled');
});

it('can create a notification with attachments', function () {
    $notification = Notification::factory()->create([
        'type' => 'App\Notifications\Document',
        'notifiable_type' => 'Modules\User\Models\User',
        'notifiable_id' => 1,
    ]);

    $attachment = $notification->attachments()->create([
        'file_name' => 'document.pdf',
        'file_path' => '/storage/notifications/documents/document.pdf',
        'mime_type' => 'application/pdf',
    ]);

    expect($attachment)->toBeInstanceOf(NotificationAttachment::class);
    expect($attachment->file_name)->toBe('document.pdf');
=======
    Assert::assertInstanceOf(NotificationLog::class, $log);
    Assert::assertSame('sent', $log->status);
>>>>>>> 40b96bcd6 (.)
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

<<<<<<< HEAD
    $data = json_decode($notification->data, true);
    expect($data['user_id'])->toBe(1);
    expect($data['action'])->toBe('profile_updated');
=======
    Assert::assertSame($payload, $notification->data);
>>>>>>> 40b96bcd6 (.)
});
