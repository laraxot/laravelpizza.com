<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Models\NotificationType;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('NotificationType Business Logic', function (): void {
    test('notification type extends eloquent model', function (): void {
        $notificationType = new NotificationType;

        Assert::assertContains('slug', $notificationType->getFillable());
        Assert::assertFalse($notificationType->exists);
    });

    test('notification type has expected fillable fields', function (): void {
        $notificationType = new NotificationType;
        $expectedFillable = [
            'name',
            'slug',
            'description',
            'category',
            'is_active',
            'channels',
            'settings',
            'template',
        ];

        Assert::assertSame($expectedFillable, $notificationType->getFillable());
    });

    test('notification type can store basic information', function (): void {
        $notificationType = new NotificationType;
        $notificationType->name = 'Email Verification';
        $notificationType->description = 'Email verification notification type';
        $notificationType->template = 'email-verification-template';

        Assert::assertSame('Email Verification', $notificationType->name);
        Assert::assertSame('Email verification notification type', $notificationType->description);
        Assert::assertSame('email-verification-template', $notificationType->template);
    });

    test('notification type model can be instantiated without errors', function (): void {
        $notificationType = new NotificationType;
        Assert::assertFalse($notificationType->exists);
    });

    test('notification type can be queried', function (): void {
        $query = NotificationType::query();
        Assert::assertInstanceOf(Builder::class, $query);
    });
});
