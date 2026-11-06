<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Factories;

use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;
use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Factories\TelegramActionFactory;
use Modules\Notify\Factories\WhatsAppActionFactory;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('sms action resolves default smsfactor driver instance', function () {
    config()->set('sms.default', 'smsfactor');
    config()->set('sms.drivers.smsfactor.token', 'token-123');

    $action = app(SendSmsFactorSMSAction::class);
    Assert::assertSame(SendSmsFactorSMSAction::class, $action::class);
});

test('telegram action factory creates official driver instance', function () {
    config()->set('services.telegram.token', 'telegram-token');

    $action = (new TelegramActionFactory)->create('official');
    Assert::assertSame(SendOfficialTelegramAction::class, $action::class);
});

test('telegram action factory throws for unsupported driver', function () {
    XotBasePest::assertThrows(
        fn () => (new TelegramActionFactory)->create('unsupported'),
        \Exception::class,
    );
});

test('whatsapp action factory creates twilio driver instance', function () {
    config()->set('services.twilio.account_sid', 'sid-123');
    config()->set('services.twilio.auth_token', 'token-123');

    $action = (new WhatsAppActionFactory)->create('twilio');
    Assert::assertSame(SendTwilioWhatsAppAction::class, $action::class);
});

test('whatsapp action factory throws for unsupported driver', function () {
    XotBasePest::assertThrows(
        fn () => (new WhatsAppActionFactory)->create('unsupported'),
        \Exception::class,
    );
});