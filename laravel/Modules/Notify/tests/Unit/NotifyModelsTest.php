<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Modules\Notify\Tests\TestCase;
use Modules\Notify\Models\Notification;

uses(TestCase::class)->in(__DIR__);

it('can create a notification', function () {
    $notification = Notification::factory()->create([
        'type' => 'App\Notifications\UserRegistered',
        'notifiable_type' => 'Modules\User\Models\User',
        'notifiable_id' => 1,
        'data' => json_encode(['message' => 'User registered']),
    ]);

    expect($notification)->toBeInstanceOf(Notification::class);
    expect($notification->type)->toBe('App\Notifications\UserRegistered');
    expect($notification->notifiable_type)->toBe('Modules\User\Models\User');
    expect($notification->notifiable_id)->toBe(1);
});

it('can create a notification with read status', function () {
    $notification = Notification::factory()->create([
        'type' => 'App\Notifications\Welcome',
        'notifiable_type' => 'Modules\User\Models\User',
        'notifiable_id' => 1,
        'read_at' => now(),
    ]);

    expect($notification->read_at)->toBeInstanceOf(\Carbon\Carbon::class);
});

it('can create a notification template', function () {
    $template = \Modules\Notify\Models\NotificationTemplate::factory()->create([
        'name' => 'Welcome Email',
        'type' => 'email',
        'subject' => 'Welcome to our platform',
        'body' => 'Welcome {{user.name}}!',
    ]);

    expect($template)->toBeInstanceOf(\Modules\Notify\Models\NotificationTemplate::class);
    expect($template->name)->toBe('Welcome Email');
    expect($template->type)->toBe('email');
});

it('can create a notification channel', function () {
    $channel = \Modules\Notify\Models\NotificationChannel::factory()->create([
        'name' => 'SMS',
        'driver' => 'sms',
        'enabled' => true,
    ]);

    expect($channel)->toBeInstanceOf(\Modules\Notify\Models\NotificationChannel::class);
    expect($channel->name)->toBe('SMS');
    expect($channel->driver)->toBe('sms');
});

it('can create a notification preference', function () {
    $preference = \Modules\Notify\Models\NotificationPreference::factory()->create([
        'user_id' => 1,
        'channel' => 'email',
        'notification_type' => 'welcome',
        'enabled' => true,
    ]);

    expect($preference)->toBeInstanceOf(\Modules\Notify\Models\NotificationPreference::class);
    expect($preference->user_id)->toBe(1);
    expect($preference->channel)->toBe('email');
});

it('can create a notification log', function () {
    $log = \Modules\Notify\Models\NotificationLog::factory()->create([
        'notification_id' => 1,
        'channel' => 'email',
        'status' => 'sent',
        'message' => 'Notification sent successfully',
    ]);

    expect($log)->toBeInstanceOf(\Modules\Notify\Models\NotificationLog::class);
    expect($log->status)->toBe('sent');
});

it('can create a notification rule', function () {
    $rule = \Modules\Notify\Models\NotificationRule::factory()->create([
        'name' => 'Admin Notifications',
        'event' => 'user.registered',
        'channel' => 'email',
        'conditions' => json_encode(['user_type' => 'admin']),
    ]);

    expect($rule)->toBeInstanceOf(\Modules\Notify\Models\NotificationRule::class);
    expect($rule->name)->toBe('Admin Notifications');
    expect($rule->event)->toBe('user.registered');
});

it('can create a notification campaign', function () {
    $campaign = \Modules\Notify\Models\NotificationCampaign::factory()->create([
        'name' => 'Weekly Newsletter',
        'type' => 'email',
        'schedule' => 'weekly',
        'status' => 'scheduled',
    ]);

    expect($campaign)->toBeInstanceOf(\Modules\Notify\Models\NotificationCampaign::class);
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

    expect($attachment)->toBeInstanceOf(\Modules\Notify\Models\NotificationAttachment::class);
    expect($attachment->file_name)->toBe('document.pdf');
});

it('can create a notification with custom data', function () {
    $notification = Notification::factory()->create([
        'type' => 'App\Notifications\Custom',
        'notifiable_type' => 'Modules\User\Models\User',
        'notifiable_id' => 1,
        'data' => json_encode([
            'user_id' => 1,
            'action' => 'profile_updated',
            'details' => ['field' => 'email', 'old_value' => 'old@example.com'],
        ]),
    ]);

    $data = json_decode($notification->data, true);
    expect($data['user_id'])->toBe(1);
    expect($data['action'])->toBe('profile_updated');
});