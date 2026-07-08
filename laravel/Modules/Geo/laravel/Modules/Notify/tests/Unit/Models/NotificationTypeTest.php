<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Modules\Notify\Database\Factories\NotificationTypeFactory;
use Modules\Notify\Models\NotificationType;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
    $this->disableExceptionHandling();
});

describe('Notification Type', function (): void {
    test('_can_create_notification_type', function (): void {
        /** @var TestCase $this */
        $notificationType = NotificationTypeFactory::new()->createOne([
            'name' => 'Email Notification',
            'description' => 'Email notification type for sending emails',
            'template' => 'email_template_1',
        ]);
        \assertNotifyTableHas('notification_types', [
            'id' => $notificationType->id,
            'name' => 'Email Notification',
            'description' => 'Email notification type for sending emails',
            'template' => 'email_template_1',
        ]);

        Assert::assertInstanceOf(NotificationType::class, $notificationType);
    });

    test('_has_correct_fillable_fields', function (): void {
        $notificationType = new NotificationType();

        $expectedFillable = [
            'name',
            'description',
            'template',
        ];

        Assert::assertEquals($expectedFillable, $notificationType->getFillable());
    });

    test('_can_update_notification_type', function (): void {
        /** @var TestCase $this */
        $notificationType = NotificationTypeFactory::new()->createOne([
            'name' => 'Original Name',
            'description' => 'Original description',
            'template' => 'original_template',
        ]);

        $notificationType->update([
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'template' => 'updated_template',
        ]);
        \assertNotifyTableHas('notification_types', [
            'id' => $notificationType->id,
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'template' => 'updated_template',
        ]);

        $fresh = $this->freshModel($notificationType, NotificationType::class);
        Assert::assertEquals('Updated Name', $fresh->name);
        Assert::assertEquals('Updated description', $fresh->description);
        Assert::assertEquals('updated_template', $fresh->template);
    });

    test('_can_find_by_name', function (): void {
        $notificationType = NotificationTypeFactory::new()->createOne([
            'name' => 'SMS Notification',
            'description' => 'SMS notification type',
            'template' => 'sms_template',
        ]);

        $found = NotificationType::where('name', 'SMS Notification')->first();

        Assert::assertNotNull($found);
        Assert::assertEquals($notificationType->id, $found->id);
        Assert::assertEquals('SMS Notification', $found->name);
        Assert::assertEquals('SMS notification type', $found->description);
        Assert::assertEquals('sms_template', $found->template);
    });

    test('_can_find_by_template', function (): void {
        NotificationTypeFactory::new()->createOne([
            'name' => 'Email Type 1',
            'description' => 'First email template',
            'template' => 'email_template_1',
        ]);

        NotificationTypeFactory::new()->createOne([
            'name' => 'Email Type 2',
            'description' => 'Second email template',
            'template' => 'email_template_2',
        ]);

        $template1Types = NotificationType::where('template', 'email_template_1')->get();
        $template2Types = NotificationType::where('template', 'email_template_2')->get();

        Assert::assertCount(1, $template1Types);
        Assert::assertCount(1, $template2Types);
        Assert::assertEquals('email_template_1', \assertFirstModel($template1Types, NotificationType::class)->template);
        Assert::assertEquals('email_template_2', \assertFirstModel($template2Types, NotificationType::class)->template);
    });

    test('_can_find_by_description_pattern', function (): void {
        NotificationTypeFactory::new()->createOne([
            'name' => 'Email Type',
            'description' => 'Email notification type for users',
            'template' => 'email_template',
        ]);

        NotificationTypeFactory::new()->createOne([
            'name' => 'SMS Type',
            'description' => 'SMS notification type for users',
            'template' => 'sms_template',
        ]);

        NotificationTypeFactory::new()->createOne([
            'name' => 'Push Type',
            'description' => 'Push notification type for mobile',
            'template' => 'push_template',
        ]);

        $userTypes = NotificationType::where('description', 'like', '%for users%')->get();
        $mobileTypes = NotificationType::where('description', 'like', '%mobile%')->get();

        Assert::assertCount(2, $userTypes);
        Assert::assertCount(1, $mobileTypes);
        $firstUserType = \assertFirstModel($userTypes, NotificationType::class);
        $secondUserType = \assertFirstModel($userTypes->slice(1), NotificationType::class);
        $mobileType = \assertFirstModel($mobileTypes, NotificationType::class);
        Assert::assertStringContainsString('for users', (string) $firstUserType->description);
        Assert::assertStringContainsString('for users', (string) $secondUserType->description);
        Assert::assertStringContainsString('mobile', (string) $mobileType->description);
    });

    test('_can_handle_null_values', function (): void {
        $notificationType = NotificationTypeFactory::new()->createOne([
            'name' => 'No Description Type',
            'description' => null,
            'template' => null,
        ]);

        Assert::assertNull($notificationType->description);
        Assert::assertNull($notificationType->template);
        \assertNotifyTableHas('notification_types', [
            'id' => $notificationType->id,
            'description' => null,
            'template' => null,
        ]);
    });

    test('_can_create_multiple_types', function (): void {
        $types = [
            ['name' => 'Email', 'description' => 'Email notifications', 'template' => 'email'],
            ['name' => 'SMS', 'description' => 'SMS notifications', 'template' => 'sms'],
            ['name' => 'Push', 'description' => 'Push notifications', 'template' => 'push'],
            ['name' => 'Database', 'description' => 'Database notifications', 'template' => 'database'],
            ['name' => 'Slack', 'description' => 'Slack notifications', 'template' => 'slack'],
        ];

        foreach ($types as $typeData) {
            NotificationTypeFactory::new()->createOne($typeData);
        }

        Assert::assertSame(5, NotificationType::query()->count());

        $emailType = NotificationType::where('name', 'Email')->first();
        $smsType = NotificationType::where('name', 'SMS')->first();
        $pushType = NotificationType::where('name', 'Push')->first();
        Assert::assertInstanceOf(NotificationType::class, $emailType);
        Assert::assertInstanceOf(NotificationType::class, $smsType);
        Assert::assertInstanceOf(NotificationType::class, $pushType);

        Assert::assertEquals('Email notifications', $emailType->description);
        Assert::assertEquals('SMS notifications', $smsType->description);
        Assert::assertEquals('Push notifications', $pushType->description);
        Assert::assertEquals('email', $emailType->template);
        Assert::assertEquals('sms', $smsType->template);
        Assert::assertEquals('push', $pushType->template);
    });

    test('_can_find_by_multiple_criteria', function (): void {
        NotificationTypeFactory::new()->createOne([
            'name' => 'High Priority Email',
            'description' => 'High priority email notifications',
            'template' => 'high_priority_email',
        ]);

        NotificationTypeFactory::new()->createOne([
            'name' => 'Low Priority Email',
            'description' => 'Low priority email notifications',
            'template' => 'low_priority_email',
        ]);

        NotificationTypeFactory::new()->createOne([
            'name' => 'High Priority SMS',
            'description' => 'High priority SMS notifications',
            'template' => 'high_priority_sms',
        ]);

        $highPriorityEmailTypes = NotificationType::where('name', 'like', '%High Priority%')
            ->where('description', 'like', '%email%')
            ->get();

        Assert::assertCount(1, $highPriorityEmailTypes);
        Assert::assertEquals('High Priority Email', \assertFirstModel($highPriorityEmailTypes, NotificationType::class)->name);
        Assert::assertEquals('High priority email notifications', \assertFirstModel($highPriorityEmailTypes, NotificationType::class)->description);
        Assert::assertEquals('high_priority_email', \assertFirstModel($highPriorityEmailTypes, NotificationType::class)->template);
    });
});
