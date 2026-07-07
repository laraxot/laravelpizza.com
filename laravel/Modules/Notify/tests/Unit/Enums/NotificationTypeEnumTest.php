<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\NotificationTypeEnum;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

it('has correct cases', function (): void {
    Assert::assertCount(3, NotificationTypeEnum::cases());

    Assert::assertSame('email', NotificationTypeEnum::EMAIL->value);
    Assert::assertSame('sms', NotificationTypeEnum::SMS->value);
    Assert::assertSame('push', NotificationTypeEnum::PUSH->value);
});

it('label returns localized string', function (): void {
    Assert::assertNotEmpty(NotificationTypeEnum::EMAIL->getLabel());
    Assert::assertNotEmpty(NotificationTypeEnum::SMS->getLabel());
    Assert::assertNotEmpty(NotificationTypeEnum::PUSH->getLabel());
});

it('icon returns non empty string', function (): void {
    Assert::assertNotEmpty(NotificationTypeEnum::EMAIL->getIcon());
    Assert::assertNotEmpty(NotificationTypeEnum::SMS->getIcon());
    Assert::assertNotEmpty(NotificationTypeEnum::PUSH->getIcon());
});

it('color returns non empty string', function (): void {
    Assert::assertNotEmpty(NotificationTypeEnum::EMAIL->getColor());
    Assert::assertNotEmpty(NotificationTypeEnum::SMS->getColor());
    Assert::assertNotEmpty(NotificationTypeEnum::PUSH->getColor());
});

it('each case has unique value', function (): void {
    $values = array_map(static fn ($case) => $case->value, NotificationTypeEnum::cases());
    $uniqueValues = array_unique($values);

    Assert::assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
});

it('cases returns all enum instances', function (): void {
    $cases = NotificationTypeEnum::cases();
    Assert::assertCount(3, $cases);

    foreach ($cases as $case) {
        Assert::assertInstanceOf(NotificationTypeEnum::class, $case);
    }
});

it('all cases have required methods', function (): void {
    foreach (NotificationTypeEnum::cases() as $case) {
        Assert::assertNotEmpty($case->getLabel());
        Assert::assertNotEmpty($case->getIcon());
        Assert::assertNotEmpty($case->getColor());
    }
});
