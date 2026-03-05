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

uses(TestCase::class);

test('contact type enum exposes expected cases and column definitions', function () {
    expect(ContactTypeEnum::cases())->toHaveCount(6);

    $defs = ContactTypeEnum::getColumnDefinitions();
    expect($defs)->toHaveCount(6)
        ->and($defs)->toHaveKey('phone')
        ->and($defs)->toHaveKey('mobile')
        ->and($defs)->toHaveKey('email')
        ->and($defs)->toHaveKey('pec')
        ->and($defs)->toHaveKey('whatsapp')
        ->and($defs)->toHaveKey('fax');
});

test('media type enum supports options labels and default', function () {
    expect(MediaTypeEnum::cases())->toHaveCount(4)
        ->and(MediaTypeEnum::options())->toHaveCount(4)
        ->and(MediaTypeEnum::labels())->toHaveCount(4)
        ->and(MediaTypeEnum::isSupported('image'))->toBeTrue()
        ->and(MediaTypeEnum::isSupported('invalid'))->toBeFalse()
        ->and(MediaTypeEnum::getDefault())->toBe(MediaTypeEnum::IMAGE);
});

test('notification type enum maps icon and color', function () {
    expect(NotificationTypeEnum::EMAIL->icon())->toBe('heroicon-o-envelope')
        ->and(NotificationTypeEnum::SMS->icon())->toBe('heroicon-o-device-phone-mobile')
        ->and(NotificationTypeEnum::PUSH->icon())->toBe('heroicon-o-bell')
        ->and(NotificationTypeEnum::EMAIL->color())->toBe('success')
        ->and(NotificationTypeEnum::SMS->color())->toBe('warning')
        ->and(NotificationTypeEnum::PUSH->color())->toBe('info');
});

test('sms driver enum default and presentation methods return strings', function () {
    config()->set('sms.default', 'twilio');

    expect(SmsDriverEnum::cases())->toHaveCount(7)
        ->and(SmsDriverEnum::getDefault())->toBe(SmsDriverEnum::TWILIO);

    foreach (SmsDriverEnum::cases() as $case) {
        expect($case->getLabel())->toBeString()
            ->and($case->getColor())->toBeString()
            ->and($case->getIcon())->toBeString()
            ->and($case->getDescription())->toBeString();
    }
});

test('telegram driver enum options and default are consistent', function () {
    config()->set('telegram.default', 'botapi');

    expect(TelegramDriverEnum::cases())->toHaveCount(3)
        ->and(TelegramDriverEnum::options())->toHaveCount(3)
        ->and(TelegramDriverEnum::labels())->toHaveCount(3)
        ->and(TelegramDriverEnum::isSupported('botapi'))->toBeTrue()
        ->and(TelegramDriverEnum::isSupported('invalid'))->toBeFalse()
        ->and(TelegramDriverEnum::getDefault())->toBe(TelegramDriverEnum::BOTAPI);
});

test('whatsapp driver enum options and default are consistent', function () {
    config()->set('whatsapp.default', 'vonage');

    expect(WhatsAppDriverEnum::cases())->toHaveCount(4)
        ->and(WhatsAppDriverEnum::options())->toHaveCount(4)
        ->and(WhatsAppDriverEnum::labels())->toHaveCount(4)
        ->and(WhatsAppDriverEnum::isSupported('vonage'))->toBeTrue()
        ->and(WhatsAppDriverEnum::isSupported('invalid'))->toBeFalse()
        ->and(WhatsAppDriverEnum::getDefault())->toBe(WhatsAppDriverEnum::VONAGE);
});
