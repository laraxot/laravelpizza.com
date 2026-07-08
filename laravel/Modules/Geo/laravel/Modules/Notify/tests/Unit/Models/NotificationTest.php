<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use function Safe\json_encode;
use PHPUnit\Framework\Assert;
use Modules\Notify\Models\Notification;
use Modules\Notify\Tests\TestCase;
use Modules\Notify\Database\Factories\NotificationFactory;
use function Pest\Laravel\get;

uses(\Modules\Notify\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Notify\Tests\TestCase $this */
$this->disableExceptionHandling();
});

describe('Notification', function (): void {
    test('_can_create_notification', function (): void {
        /** @var \Modules\Notify\Tests\TestCase $this */
$notification = NotificationFactory::new()->createOne([
            'message' => 'Test notification message',
            'type' => 'info',
            'tenant_id' => 1,
            'user_id' => 123,
            'subject_type' => 'App\Models\User',
            'subject_id' => 456,
            'channels' => ['mail', 'database'],
            'status' => 'pending',
            'sent_at' => now(),
            'data' => [
                'title' => 'Test Title',
                'body' => 'Test Body',
                'action_url' => 'https://example.com',
                'priority' => 'high',
            ],
        ]);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'message' => 'Test notification message',
            'type' => 'info',
            'tenant_id' => 1,
            'user_id' => 123,
            'subject_type' => 'App\Models\User',
            'subject_id' => 456,
            'status' => 'pending',
        ]);

        Assert::assertInstanceOf(Notification::class, $notification);
    });

    test('_has_correct_fillable_fields', function (): void {
$notification = new Notification;

        $expectedFillable = [
            'message',
            'type',
            'read_at',
            'tenant_id',
            'user_id',
            'subject_type',
            'subject_id',
            'channels',
            'status',
            'sent_at',
            'data',
        ];

        Assert::assertEquals($expectedFillable, $notification->getFillable());
    });

    test('_has_correct_casts', function (): void {
$notification = new Notification;

        $expectedCasts = [
            'read_at' => 'datetime',
            'sent_at' => 'datetime',
            'data' => 'array',
            'channels' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];

        Assert::assertEquals($expectedCasts, $notification->getCasts());
    });

    test('_can_store_json_data', function (): void {
$data = [
            'title' => 'Welcome to our platform',
            'body' => 'Thank you for joining us!',
            'action_url' => 'https://example.com/welcome',
            'priority' => 'high',
            'category' => 'welcome',
            'metadata' => [
                'source' => 'registration',
                'campaign' => 'new_users_2024',
                'tags' => ['welcome', 'onboarding'],
            ],
        ];

        $notification = NotificationFactory::new()->createOne([
            'message' => 'Welcome notification',
            'type' => 'welcome',
            'data' => $data,
        ]);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'data' => json_encode($data),
        ]);
        Assert::assertEquals('Welcome to our platform', $notification->data['title']);
        Assert::assertEquals('Thank you for joining us!', $notification->data['body']);
        Assert::assertEquals('high', $notification->data['priority']);
        Assert::assertEquals('registration', \notifyArrayGet($notification->data, 'metadata', 'source'));
        Assert::assertEquals(['welcome', 'onboarding'], \notifyArrayGet($notification->data, 'metadata', 'tags'));
    });

    test('_can_store_channels_array', function (): void {
$channels = ['mail', 'database', 'sms', 'push'];

        $notification = NotificationFactory::new()->createOne([
            'message' => 'Multi-channel notification',
            'type' => 'alert',
            'channels' => $channels,
        ]);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'channels' => json_encode($channels),
        ]);
        $storedChannels = \assertNotifyArray($notification->channels);
        Assert::assertCount(4, $storedChannels);
        Assert::assertContains('mail', $storedChannels);
        Assert::assertContains('database', $storedChannels);
        Assert::assertContains('sms', $storedChannels);
        Assert::assertContains('push', $storedChannels);
    });

    test('_can_mark_as_read', function (): void {
$notification = NotificationFactory::new()->createOne([
            'message' => 'Unread notification',
            'type' => 'info',
        ]);

        Assert::assertNull($notification->read_at);

        $notification->update(['read_at' => now()]);

        Assert::assertNotNull(\assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->read_at);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'read_at' => \assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->read_at,
        ]);
    });

    test('_can_mark_as_sent', function (): void {
$notification = NotificationFactory::new()->createOne([
            'message' => 'Pending notification',
            'type' => 'info',
            'status' => 'pending',
        ]);

        Assert::assertNull($notification->sent_at);

        $notification->update([
            'sent_at' => now(),
            'status' => 'sent',
        ]);

        Assert::assertNotNull(\assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->sent_at);
        Assert::assertEquals('sent', \assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->status);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'sent_at' => \assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->sent_at,
            'status' => 'sent',
        ]);
    });

    test('_can_update_notification', function (): void {
$notification = NotificationFactory::new()->createOne([
            'message' => 'Original message',
            'type' => 'info',
            'status' => 'pending',
        ]);

        $notification->update([
            'message' => 'Updated message',
            'type' => 'warning',
            'status' => 'sent',
            'data' => ['updated' => true],
        ]);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'message' => 'Updated message',
            'type' => 'warning',
            'status' => 'sent',
        ]);

        Assert::assertEquals('Updated message', \assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->message);
        Assert::assertEquals('warning', \assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->type);
        Assert::assertEquals('sent', \assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->status);
        Assert::assertEquals(['updated' => true], \assertFreshModel($notification, \Modules\Notify\Models\Notification::class)->data);
    });

    test('_can_find_by_type', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'Info notification',
            'type' => 'info',
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Warning notification',
            'type' => 'warning',
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Error notification',
            'type' => 'error',
        ]);

        $infoNotifications = Notification::where('type', 'info')->get();
        $warningNotifications = Notification::where('type', 'warning')->get();
        $errorNotifications = Notification::where('type', 'error')->get();

        Assert::assertCount(1, $infoNotifications);
        Assert::assertCount(1, $warningNotifications);
        Assert::assertCount(1, $errorNotifications);
        Assert::assertEquals('info', \assertFirstModel($infoNotifications, \Modules\Notify\Models\Notification::class)->type);
        Assert::assertEquals('warning', \assertFirstModel($warningNotifications, \Modules\Notify\Models\Notification::class)->type);
        Assert::assertEquals('error', \assertFirstModel($errorNotifications, \Modules\Notify\Models\Notification::class)->type);
    });

    test('_can_find_by_status', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'Pending notification',
            'type' => 'info',
            'status' => 'pending',
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Sent notification',
            'type' => 'info',
            'status' => 'sent',
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Failed notification',
            'type' => 'info',
            'status' => 'failed',
        ]);

        $pendingNotifications = Notification::where('status', 'pending')->get();
        $sentNotifications = Notification::where('status', 'sent')->get();
        $failedNotifications = Notification::where('status', 'failed')->get();

        Assert::assertCount(1, $pendingNotifications);
        Assert::assertCount(1, $sentNotifications);
        Assert::assertCount(1, $failedNotifications);
        Assert::assertEquals('pending', \assertFirstModel($pendingNotifications, \Modules\Notify\Models\Notification::class)->status);
        Assert::assertEquals('sent', \assertFirstModel($sentNotifications, \Modules\Notify\Models\Notification::class)->status);
        Assert::assertEquals('failed', \assertFirstModel($failedNotifications, \Modules\Notify\Models\Notification::class)->status);
    });

    test('_can_find_by_tenant_id', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'Tenant 1 notification',
            'type' => 'info',
            'tenant_id' => 1,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Tenant 2 notification',
            'type' => 'info',
            'tenant_id' => 2,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Tenant 1 another notification',
            'type' => 'warning',
            'tenant_id' => 1,
        ]);

        $tenant1Notifications = Notification::where('tenant_id', 1)->get();
        $tenant2Notifications = Notification::where('tenant_id', 2)->get();

        Assert::assertCount(2, $tenant1Notifications);
        Assert::assertCount(1, $tenant2Notifications);
        Assert::assertEquals(1, \assertFirstModel($tenant1Notifications, \Modules\Notify\Models\Notification::class)->tenant_id);
        Assert::assertEquals(1, \assertFirstModel($tenant1Notifications->slice(1), \Modules\Notify\Models\Notification::class)->tenant_id);
        Assert::assertEquals(2, \assertFirstModel($tenant2Notifications, \Modules\Notify\Models\Notification::class)->tenant_id);
    });

    test('_can_find_by_user_id', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'User 123 notification',
            'type' => 'info',
            'user_id' => 123,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'User 456 notification',
            'type' => 'info',
            'user_id' => 456,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'User 123 another notification',
            'type' => 'warning',
            'user_id' => 123,
        ]);

        $user123Notifications = Notification::where('user_id', 123)->get();
        $user456Notifications = Notification::where('user_id', 456)->get();

        Assert::assertCount(2, $user123Notifications);
        Assert::assertCount(1, $user456Notifications);
        Assert::assertEquals(123, \assertFirstModel($user123Notifications, \Modules\Notify\Models\Notification::class)->user_id);
        Assert::assertEquals(123, \assertFirstModel($user123Notifications->slice(1), \Modules\Notify\Models\Notification::class)->user_id);
        Assert::assertEquals(456, \assertFirstModel($user456Notifications, \Modules\Notify\Models\Notification::class)->user_id);
    });

    test('_can_find_by_subject', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'User subject notification',
            'type' => 'info',
            'subject_type' => 'App\Models\User',
            'subject_id' => 123,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Company subject notification',
            'type' => 'info',
            'subject_type' => 'App\Models\Company',
            'subject_id' => 456,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'User subject another notification',
            'type' => 'warning',
            'subject_type' => 'App\Models\User',
            'subject_id' => 789,
        ]);

        $userSubjectNotifications = Notification::where('subject_type', 'App\Models\User')->get();
        $companySubjectNotifications = Notification::where('subject_type', 'App\Models\Company')->get();

        Assert::assertCount(2, $userSubjectNotifications);
        Assert::assertCount(1, $companySubjectNotifications);
        Assert::assertEquals('App\Models\User', \assertFirstModel($userSubjectNotifications, \Modules\Notify\Models\Notification::class)->subject_type);
        Assert::assertEquals('App\Models\User', \assertFirstModel($userSubjectNotifications->slice(1), \Modules\Notify\Models\Notification::class)->subject_type);
        Assert::assertEquals('App\Models\Company', \assertFirstModel($companySubjectNotifications, \Modules\Notify\Models\Notification::class)->subject_type);
    });

    test('_can_find_by_channel', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'Mail notification',
            'type' => 'info',
            'channels' => ['mail'],
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'SMS notification',
            'type' => 'info',
            'channels' => ['sms'],
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Multi-channel notification',
            'type' => 'info',
            'channels' => ['mail', 'database', 'sms'],
        ]);

        $mailNotifications = Notification::whereJsonContains('channels', 'mail')->get();
        $smsNotifications = Notification::whereJsonContains('channels', 'sms')->get();
        $databaseNotifications = Notification::whereJsonContains('channels', 'database')->get();

        Assert::assertCount(2, $mailNotifications);
        Assert::assertCount(2, $smsNotifications);
        Assert::assertCount(1, $databaseNotifications);
    });

    test('_can_find_by_data_pattern', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'High priority notification',
            'type' => 'alert',
            'data' => [
                'priority' => 'high',
                'category' => 'security',
            ],
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Low priority notification',
            'type' => 'info',
            'data' => [
                'priority' => 'low',
                'category' => 'general',
            ],
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Medium priority notification',
            'type' => 'warning',
            'data' => [
                'priority' => 'medium',
                'category' => 'maintenance',
            ],
        ]);

        $highPriorityNotifications = Notification::whereJsonPath('data.priority', 'high')->get();
        $securityNotifications = Notification::whereJsonPath('data.category', 'security')->get();

        Assert::assertCount(1, $highPriorityNotifications);
        Assert::assertCount(1, $securityNotifications);
        Assert::assertEquals('high', \assertFirstModel($highPriorityNotifications, \Modules\Notify\Models\Notification::class)->data['priority']);
        Assert::assertEquals('security', \assertFirstModel($securityNotifications, \Modules\Notify\Models\Notification::class)->data['category']);
    });

    test('_can_find_by_read_status', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'Unread notification',
            'type' => 'info',
            'read_at' => null,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Read notification',
            'type' => 'info',
            'read_at' => now(),
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Another unread notification',
            'type' => 'warning',
            'read_at' => null,
        ]);

        $unreadNotifications = Notification::whereNull('read_at')->get();
        $readNotifications = Notification::whereNotNull('read_at')->get();

        Assert::assertCount(2, $unreadNotifications);
        Assert::assertCount(1, $readNotifications);
        Assert::assertNull(\assertFirstModel($unreadNotifications, \Modules\Notify\Models\Notification::class)->read_at);
        Assert::assertNull(\assertFirstModel($unreadNotifications, \Modules\Notify\Models\Notification::class)->read_at);
        Assert::assertNotNull(\assertFirstModel($readNotifications, \Modules\Notify\Models\Notification::class)->read_at);
    });

    test('_can_find_by_sent_status', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'Unsent notification',
            'type' => 'info',
            'sent_at' => null,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Sent notification',
            'type' => 'info',
            'sent_at' => now(),
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Another unsent notification',
            'type' => 'warning',
            'sent_at' => null,
        ]);

        $unsentNotifications = Notification::whereNull('sent_at')->get();
        $sentNotifications = Notification::whereNotNull('sent_at')->get();

        Assert::assertCount(2, $unsentNotifications);
        Assert::assertCount(1, $sentNotifications);
        Assert::assertNull(\assertFirstModel($unsentNotifications, \Modules\Notify\Models\Notification::class)->sent_at);
        Assert::assertNull(\assertFirstModel($unsentNotifications, \Modules\Notify\Models\Notification::class)->sent_at);
        Assert::assertNotNull(\assertFirstModel($sentNotifications, \Modules\Notify\Models\Notification::class)->sent_at);
    });

    test('_can_find_by_date_range', function (): void {
$yesterday = now()->subDay();
        $today = now();
        $tomorrow = now()->addDay();

        NotificationFactory::new()->createOne([
            'message' => 'Yesterday notification',
            'type' => 'info',
            'created_at' => $yesterday,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Today notification',
            'type' => 'info',
            'created_at' => $today,
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Tomorrow notification',
            'type' => 'info',
            'created_at' => $tomorrow,
        ]);

        $todayNotifications = Notification::whereDate('created_at', $today->toDateString())->get();
        $recentNotifications = Notification::where('created_at', '>=', $yesterday)->get();

        Assert::assertCount(1, $todayNotifications);
        Assert::assertCount(2, $recentNotifications); // yesterday and today
        Assert::assertEquals('Today notification', \assertFirstModel($todayNotifications, \Modules\Notify\Models\Notification::class)->message);
    });

    test('_can_find_by_multiple_criteria', function (): void {
NotificationFactory::new()->createOne([
            'message' => 'High priority security alert',
            'type' => 'alert',
            'status' => 'pending',
            'tenant_id' => 1,
            'data' => [
                'priority' => 'high',
                'category' => 'security',
            ],
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Low priority general info',
            'type' => 'info',
            'status' => 'sent',
            'tenant_id' => 1,
            'data' => [
                'priority' => 'low',
                'category' => 'general',
            ],
        ]);

        NotificationFactory::new()->createOne([
            'message' => 'Medium priority maintenance warning',
            'type' => 'warning',
            'status' => 'pending',
            'tenant_id' => 2,
            'data' => [
                'priority' => 'medium',
                'category' => 'maintenance',
            ],
        ]);

        $pendingHighPriorityTenant1 = Notification::where('status', 'pending')
            ->where('tenant_id', 1)
            ->whereJsonPath('data.priority', 'high')
            ->get();

        Assert::assertCount(1, $pendingHighPriorityTenant1);
        Assert::assertEquals('High priority security alert', \assertFirstModel($pendingHighPriorityTenant1, \Modules\Notify\Models\Notification::class)->message);
        Assert::assertEquals('pending', \assertFirstModel($pendingHighPriorityTenant1, \Modules\Notify\Models\Notification::class)->status);
        Assert::assertEquals(1, \assertFirstModel($pendingHighPriorityTenant1, \Modules\Notify\Models\Notification::class)->tenant_id);
        Assert::assertEquals('high', \notifyArrayGet(\assertFirstModel($pendingHighPriorityTenant1, \Modules\Notify\Models\Notification::class)->data, 'priority'));
    });

    test('_can_handle_empty_data', function (): void {
$notification = NotificationFactory::new()->createOne([
            'message' => 'Empty data notification',
            'type' => 'info',
            'data' => [],
        ]);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'data' => json_encode([]),
        ]);
        Assert::assertEmpty($notification->data);
    });

    test('_can_handle_empty_channels', function (): void {
$notification = NotificationFactory::new()->createOne([
            'message' => 'No channels notification',
            'type' => 'info',
            'channels' => [],
        ]);
        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'channels' => json_encode([]),
        ]);
        Assert::assertEmpty($notification->channels);
    });

    test('_can_handle_null_values', function (): void {
$notification = NotificationFactory::new()->createOne([
            'message' => 'Null values notification',
            'type' => 'info',
            'tenant_id' => null,
            'user_id' => null,
            'subject_type' => null,
            'subject_id' => null,
            'channels' => null,
            'status' => null,
            'sent_at' => null,
            'data' => null,
        ]);

        Assert::assertNull($notification->tenant_id);
        Assert::assertNull($notification->user_id);
        Assert::assertNull($notification->subject_type);
        Assert::assertNull($notification->subject_id);
        Assert::assertNull($notification->channels);
        Assert::assertNull($notification->status);
        Assert::assertNull($notification->sent_at);
        Assert::assertNull($notification->data);
    });
});
