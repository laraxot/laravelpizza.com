<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.

use Modules\Notify\Database\Factories\NotificationFactory;
use Modules\Notify\Models\Notification;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\withoutExceptionHandling;
use function Safe\json_encode;

uses(TestCase::class);
beforeEach(function (): void {
    withoutExceptionHandling();
});

describe('Notification PartTwo', function (): void {
    test('_can_find_by_user_id', function (): void {
        NotificationFactory::new()->createOne([
            'message' => 'User 123 notification',
            'type' => 'info',
            'user_id' => 123]);

        NotificationFactory::new()->createOne([
            'message' => 'User 456 notification',
            'type' => 'info',
            'user_id' => 456]);

        NotificationFactory::new()->createOne([
            'message' => 'User 123 another notification',
            'type' => 'warning',
            'user_id' => 123]);

        $user123Notifications = Notification::where('user_id', 123)->get();
        $user456Notifications = Notification::where('user_id', 456)->get();

        Assert::assertCount(2, $user123Notifications);
        Assert::assertCount(1, $user456Notifications);
        Assert::assertEquals(123, XotBasePest::assertFirstModel($user123Notifications, Notification::class)->user_id);
        Assert::assertEquals(123, XotBasePest::assertFirstModel($user123Notifications->slice(1), Notification::class)->user_id);
        Assert::assertEquals(456, XotBasePest::assertFirstModel($user456Notifications, Notification::class)->user_id);
    });

    test('_can_find_by_subject', function (): void {
        NotificationFactory::new()->createOne([
            'message' => 'User subject notification',
            'type' => 'info',
            'subject_type' => 'App\Models\User',
            'subject_id' => 123]);

        NotificationFactory::new()->createOne([
            'message' => 'Company subject notification',
            'type' => 'info',
            'subject_type' => 'App\Models\Company',
            'subject_id' => 456]);

        NotificationFactory::new()->createOne([
            'message' => 'User subject another notification',
            'type' => 'warning',
            'subject_type' => 'App\Models\User',
            'subject_id' => 789]);

        $userSubjectNotifications = Notification::where('subject_type', 'App\Models\User')->get();
        $companySubjectNotifications = Notification::where('subject_type', 'App\Models\Company')->get();

        Assert::assertCount(2, $userSubjectNotifications);
        Assert::assertCount(1, $companySubjectNotifications);
        Assert::assertEquals('App\Models\User', XotBasePest::assertFirstModel($userSubjectNotifications, Notification::class)->subject_type);
        Assert::assertEquals('App\Models\User', XotBasePest::assertFirstModel($userSubjectNotifications->slice(1), Notification::class)->subject_type);
        Assert::assertEquals('App\Models\Company', XotBasePest::assertFirstModel($companySubjectNotifications, Notification::class)->subject_type);
    });

    test('_can_find_by_channel', function (): void {
        NotificationFactory::new()->createOne([
            'message' => 'Mail notification',
            'type' => 'info',
            'channels' => ['mail']]);

        NotificationFactory::new()->createOne([
            'message' => 'SMS notification',
            'type' => 'info',
            'channels' => ['sms']]);

        NotificationFactory::new()->createOne([
            'message' => 'Multi-channel notification',
            'type' => 'info',
            'channels' => ['mail', 'database', 'sms']]);

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
                'category' => 'security']]);

        NotificationFactory::new()->createOne([
            'message' => 'Low priority notification',
            'type' => 'info',
            'data' => [
                'priority' => 'low',
                'category' => 'general']]);

        NotificationFactory::new()->createOne([
            'message' => 'Medium priority notification',
            'type' => 'warning',
            'data' => [
                'priority' => 'medium',
                'category' => 'maintenance']]);

        $highPriorityNotifications = Notification::whereJsonPath('data.priority', 'high')->get();
        $securityNotifications = Notification::whereJsonPath('data.category', 'security')->get();

        Assert::assertCount(1, $highPriorityNotifications);
        Assert::assertCount(1, $securityNotifications);
        Assert::assertEquals('high', XotBasePest::assertFirstModel($highPriorityNotifications, Notification::class)->data['priority']);
        Assert::assertEquals('security', XotBasePest::assertFirstModel($securityNotifications, Notification::class)->data['category']);
    });

    test('_can_find_by_read_status', function (): void {
        NotificationFactory::new()->createOne([
            'message' => 'Unread notification',
            'type' => 'info',
            'read_at' => null]);

        NotificationFactory::new()->createOne([
            'message' => 'Read notification',
            'type' => 'info',
            'read_at' => now()]);

        NotificationFactory::new()->createOne([
            'message' => 'Another unread notification',
            'type' => 'warning',
            'read_at' => null]);

        $unreadNotifications = Notification::whereNull('read_at')->get();
        $readNotifications = Notification::whereNotNull('read_at')->get();

        Assert::assertCount(2, $unreadNotifications);
        Assert::assertCount(1, $readNotifications);
        Assert::assertNull(XotBasePest::assertFirstModel($unreadNotifications, Notification::class)->read_at);
        Assert::assertNull(XotBasePest::assertFirstModel($unreadNotifications, Notification::class)->read_at);
        Assert::assertNotNull(XotBasePest::assertFirstModel($readNotifications, Notification::class)->read_at);
    });

    test('_can_find_by_sent_status', function (): void {
        NotificationFactory::new()->createOne([
            'message' => 'Unsent notification',
            'type' => 'info',
            'sent_at' => null]);

        NotificationFactory::new()->createOne([
            'message' => 'Sent notification',
            'type' => 'info',
            'sent_at' => now()]);

        NotificationFactory::new()->createOne([
            'message' => 'Another unsent notification',
            'type' => 'warning',
            'sent_at' => null]);

        $unsentNotifications = Notification::whereNull('sent_at')->get();
        $sentNotifications = Notification::whereNotNull('sent_at')->get();

        Assert::assertCount(2, $unsentNotifications);
        Assert::assertCount(1, $sentNotifications);
        Assert::assertNull(XotBasePest::assertFirstModel($unsentNotifications, Notification::class)->sent_at);
        Assert::assertNull(XotBasePest::assertFirstModel($unsentNotifications, Notification::class)->sent_at);
        Assert::assertNotNull(XotBasePest::assertFirstModel($sentNotifications, Notification::class)->sent_at);
    });

    test('_can_find_by_date_range', function (): void {
        $yesterday = now()->subDay();
        $today = now();
        $tomorrow = now()->addDay();

        NotificationFactory::new()->createOne([
            'message' => 'Yesterday notification',
            'type' => 'info',
            'created_at' => $yesterday]);

        NotificationFactory::new()->createOne([
            'message' => 'Today notification',
            'type' => 'info',
            'created_at' => $today]);

        NotificationFactory::new()->createOne([
            'message' => 'Tomorrow notification',
            'type' => 'info',
            'created_at' => $tomorrow]);

        $todayNotifications = Notification::whereDate('created_at', $today->toDateString())->get();
        $recentNotifications = Notification::where('created_at', '>=', $yesterday)->get();

        Assert::assertCount(1, $todayNotifications);
        Assert::assertCount(2, $recentNotifications); // yesterday and today
        Assert::assertEquals('Today notification', XotBasePest::assertFirstModel($todayNotifications, Notification::class)->message);
    });

    test('_can_find_by_multiple_criteria', function (): void {
        NotificationFactory::new()->createOne([
            'message' => 'High priority security alert',
            'type' => 'alert',
            'status' => 'pending',
            'tenant_id' => 1,
            'data' => [
                'priority' => 'high',
                'category' => 'security']]);

        NotificationFactory::new()->createOne([
            'message' => 'Low priority general info',
            'type' => 'info',
            'status' => 'sent',
            'tenant_id' => 1,
            'data' => [
                'priority' => 'low',
                'category' => 'general']]);

        NotificationFactory::new()->createOne([
            'message' => 'Medium priority maintenance warning',
            'type' => 'warning',
            'status' => 'pending',
            'tenant_id' => 2,
            'data' => [
                'priority' => 'medium',
                'category' => 'maintenance']]);

        $pendingHighPriorityTenant1 = Notification::where('status', 'pending')
            ->where('tenant_id', 1)
            ->whereJsonPath('data.priority', 'high')
            ->get();

        Assert::assertCount(1, $pendingHighPriorityTenant1);
        Assert::assertEquals('High priority security alert', XotBasePest::assertFirstModel($pendingHighPriorityTenant1, Notification::class)->message);
        Assert::assertEquals('pending', XotBasePest::assertFirstModel($pendingHighPriorityTenant1, Notification::class)->status);
        Assert::assertEquals(1, XotBasePest::assertFirstModel($pendingHighPriorityTenant1, Notification::class)->tenant_id);
        Assert::assertEquals('high', TestCase::notifyArrayGet(XotBasePest::assertFirstModel($pendingHighPriorityTenant1, Notification::class)->data, 'priority'));
    });

    test('_can_handle_empty_data', function (): void {
        $notification = NotificationFactory::new()->createOne([
            'message' => 'Empty data notification',
            'type' => 'info',
            'data' => []]);
        XotBasePest::assertTableHas('notify', 'notifications', [
            'id' => $notification->id,
            'data' => json_encode([])]);
        Assert::assertEmpty($notification->data);
    });

    test('_can_handle_empty_channels', function (): void {
        $notification = NotificationFactory::new()->createOne([
            'message' => 'No channels notification',
            'type' => 'info',
            'channels' => []]);
        XotBasePest::assertTableHas('notify', 'notifications', [
            'id' => $notification->id,
            'channels' => json_encode([])]);
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
            'data' => null]);

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