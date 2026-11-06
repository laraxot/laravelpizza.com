<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\ContactTypeEnum;
use Modules\Notify\Enums\MediaTypeEnum;
use Modules\Notify\Enums\NotificationTypeEnum;
use Modules\Notify\Enums\SmsDriverEnum;
use Modules\Notify\Enums\TelegramDriverEnum;
use Modules\Notify\Enums\WhatsAppDriverEnum;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('contact type enum exposes expected cases and column definitions', function () {
    Assert::assertCount(6, ContactTypeEnum::cases());
    $defs = ContactTypeEnum::getColumnDefinitions();
    Assert::assertCount(6, $defs);
    foreach (['phone', 'mobile', 'email', 'pec', 'whatsapp', 'fax'] as $key) {
        Assert::assertArrayHasKey($key, $defs);
    }
});

test('media type enum supports options labels and default', function () {
    Assert::assertCount(4, MediaTypeEnum::cases());
    Assert::assertContains(MediaTypeEnum::getDefault(), MediaTypeEnum::cases());
    Assert::assertCount(4, MediaTypeEnum::options());
    Assert::assertCount(4, MediaTypeEnum::labels());
    Assert::assertTrue(MediaTypeEnum::isSupported('image'));
    Assert::assertFalse(MediaTypeEnum::isSupported('invalid'));
});

test('notification type enum maps icon and color', function () {
    foreach (NotificationTypeEnum::cases() as $case) {
        Assert::assertNotEmpty($case->getIcon());
        Assert::assertNotEmpty($case->getColor());
    }
});

test('sms driver enum default and presentation methods return strings', function () {
    config()->set('sms.default', 'smsfactor');

    Assert::assertCount(1, SmsDriverEnum::cases());
    $default = SmsDriverEnum::getDefault();
    Assert::assertContains($default, SmsDriverEnum::cases());
    Assert::assertSame('smsfactor', $default->value);
    foreach (SmsDriverEnum::cases() as $case) {
        Assert::assertNotEmpty($case->getDescription());
    }
});

test('telegram driver enum options and default are consistent', function () {
    config()->set('telegram.default', 'botapi');

    Assert::assertCount(3, TelegramDriverEnum::cases());
    Assert::assertContains(TelegramDriverEnum::getDefault(), TelegramDriverEnum::cases());
    Assert::assertCount(3, TelegramDriverEnum::options());
    Assert::assertCount(3, TelegramDriverEnum::labels());
    Assert::assertTrue(TelegramDriverEnum::isSupported('botapi'));
    Assert::assertFalse(TelegramDriverEnum::isSupported('invalid'));
});

test('whatsapp driver enum options and default are consistent', function () {
    config()->set('whatsapp.default', 'vonage');

    Assert::assertCount(4, WhatsAppDriverEnum::cases());
    Assert::assertContains(WhatsAppDriverEnum::getDefault(), WhatsAppDriverEnum::cases());
    Assert::assertCount(4, WhatsAppDriverEnum::options());
    Assert::assertCount(4, WhatsAppDriverEnum::labels());
    Assert::assertTrue(WhatsAppDriverEnum::isSupported('vonage'));
    Assert::assertFalse(WhatsAppDriverEnum::isSupported('invalid'));
});