<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Database\Factories\NotificationTypeFactory;
use Modules\Notify\Models\NotificationType;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Notification Type Business Logic', function () {
    it('can create notification type with basic information', function () {
        $typeData = [
            'name' => 'Appointment Reminder',
            'slug' => 'appointment-reminder',
            'description' => 'Promemoria per appuntamenti',
            'category' => 'healthcare',
            'is_active' => true,
        ];

        $type = NotificationTypeFactory::new()->createOne($typeData);

        Assert::assertSame('Appointment Reminder', $type->name);
        Assert::assertSame('appointment-reminder', $type->slug);
        Assert::assertSame('Promemoria per appuntamenti', $type->description);
        Assert::assertSame('healthcare', $type->category);
        Assert::assertTrue($type->is_active);

        \assertNotifyTableHas('notification_types', [
            'id' => $type->id,
            'name' => 'Appointment Reminder',
            'slug' => 'appointment-reminder',
            'description' => 'Promemoria per appuntamenti',
            'category' => 'healthcare',
            'is_active' => true,
        ]);
    });

    it('can manage notification type channels', function () {
        $type = NotificationTypeFactory::new()->createOne();
        $channels = [
            'email' => [
                'enabled' => true,
                'priority' => 'high',
                'template' => 'email.appointment-reminder',
            ],
            'sms' => [
                'enabled' => true,
                'max_length' => 160,
            ],
            'push' => [
                'enabled' => false,
            ],
        ];

        $type->update(['channels' => $channels]);

        \assertNotifyTableHas('notification_types', [
            'id' => $type->id,
            'channels' => json_encode($channels),
        ]);

        $fresh = \assertFreshModel($type, NotificationType::class);
        $storedChannels = \assertNotifyArray($fresh->channels);
        $emailChannel = \assertNotifyArray($storedChannels['email'] ?? null);
        $smsChannel = \assertNotifyArray($storedChannels['sms'] ?? null);
        $pushChannel = \assertNotifyArray($storedChannels['push'] ?? null);

        Assert::assertTrue($emailChannel['enabled']);
        Assert::assertSame('high', $emailChannel['priority']);
        Assert::assertTrue($smsChannel['enabled']);
        Assert::assertSame(160, $smsChannel['max_length']);
        Assert::assertFalse($pushChannel['enabled']);
    });

    it('can manage notification type settings', function () {
        $type = NotificationTypeFactory::new()->createOne();
        $settings = [
            'retry_attempts' => 3,
            'retry_delay' => 300,
            'batch_size' => 100,
            'timezone_aware' => true,
            'encryption_required' => false,
        ];

        $type->update(['settings' => $settings]);

        \assertNotifyTableHas('notification_types', [
            'id' => $type->id,
            'settings' => json_encode($settings),
        ]);

        $storedSettings = \assertNotifyArray(\notifyFreshTypeSettings($type));

        Assert::assertSame(3, $storedSettings['retry_attempts']);
        Assert::assertSame(300, $storedSettings['retry_delay']);
        Assert::assertSame(100, $storedSettings['batch_size']);
        Assert::assertTrue($storedSettings['timezone_aware']);
        Assert::assertFalse($storedSettings['encryption_required']);
    });

    it('can assign notification type template reference', function () {
        $type = NotificationTypeFactory::new()->createOne();
        $template = 'emails.appointment-reminder';

        $type->update(['template' => $template]);

        \assertNotifyTableHas('notification_types', [
            'id' => $type->id,
            'template' => $template,
        ]);

        Assert::assertSame($template, \assertFreshModel($type, NotificationType::class)->template);
    });

    it('can search notification types by category and status', function () {
        $healthcareType = NotificationTypeFactory::new()->createOne(['category' => 'healthcare', 'is_active' => true]);
        NotificationTypeFactory::new()->createOne(['category' => 'marketing', 'is_active' => false]);

        $healthcareTypes = NotificationType::query()->where('category', 'healthcare')->get();
        $activeTypes = NotificationType::query()->where('is_active', true)->get();

        Assert::assertCount(1, $healthcareTypes);
        Assert::assertTrue($healthcareTypes->contains($healthcareType));
        Assert::assertTrue($activeTypes->contains($healthcareType));
    });

    it('can duplicate notification type via replicate', function () {
        $originalType = NotificationTypeFactory::new()->createOne([
            'name' => 'Original Type',
            'slug' => 'original-type',
            'category' => 'system',
        ]);

        $duplicateType = $originalType->replicate();
        $duplicateType->name = 'Duplicate Type';
        $duplicateType->slug = 'duplicate-type';
        $duplicateType->save();

        \assertNotifyTableHas('notification_types', [
            'id' => $duplicateType->id,
            'name' => 'Duplicate Type',
            'slug' => 'duplicate-type',
        ]);
    });
});
