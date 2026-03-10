<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Factories;

=======
>>>>>>> 8e583cd (.)
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Factories\SmsActionFactory;
use Modules\Notify\Factories\TelegramActionFactory;
use Modules\Notify\Factories\WhatsAppActionFactory;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('sms action factory creates netfun driver instance', function () {
    config()->set('sms.drivers.netfun.token', 'token-123');

    $factory = new SmsActionFactory();
    $action = $factory->create('netfun');

    expect($action)->toBeInstanceOf(SmsActionContract::class);
});

test('sms action factory throws for unsupported driver', function () {
    $factory = new SmsActionFactory();

    $factory->create('definitely-unsupported-driver');
})->throws(Exception::class);

test('telegram action factory throws when selected class does not implement interface', function () {
    config()->set('services.telegram.token', 'telegram-token');

    $factory = new TelegramActionFactory();
    $factory->create('official');
})->throws(Exception::class);

test('telegram action factory throws for unsupported driver', function () {
    $factory = new TelegramActionFactory();
    $factory->create('unsupported');
})->throws(Exception::class);

test('whatsapp action factory creates twilio driver instance', function () {
    config()->set('services.twilio.account_sid', 'sid-123');
    config()->set('services.twilio.auth_token', 'token-123');

    $factory = new WhatsAppActionFactory();
    $action = $factory->create('twilio');

    expect($action)->toBeInstanceOf(WhatsAppProviderActionInterface::class);
});

test('whatsapp action factory throws for unsupported driver', function () {
    $factory = new WhatsAppActionFactory();

    $factory->create('unsupported');
})->throws(Exception::class);
