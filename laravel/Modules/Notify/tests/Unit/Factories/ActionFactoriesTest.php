<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Factories;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Factories\SmsActionFactory;
use Modules\Notify\Factories\TelegramActionFactory;
use Modules\Notify\Factories\WhatsAppActionFactory;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('sms action factory creates default smsfactor driver instance', function () {
    config()->set('sms.default', 'smsfactor');
    config()->set('sms.drivers.smsfactor.token', 'token-123');

    $factory = new SmsActionFactory;
<<<<<<< HEAD
    $action = $factory->create('netfun');
=======
    $action = $factory->create();
>>>>>>> 40b96bcd6 (.)

    Assert::assertInstanceOf(SmsActionContract::class, $action);
});

test('sms action factory throws for unsupported driver', function () {
<<<<<<< HEAD
    $factory = new SmsActionFactory;

    $factory->create('definitely-unsupported-driver');
})->throws(\Exception::class);
=======
    \assertNotifyThrows(
        fn () => (new SmsActionFactory)->create('definitely-unsupported-driver'),
        \Exception::class,
    );
});
>>>>>>> 40b96bcd6 (.)

test('telegram action factory throws when selected class does not implement interface', function () {
    config()->set('services.telegram.token', 'telegram-token');

<<<<<<< HEAD
    $factory = new TelegramActionFactory;
    $factory->create('official');
})->throws(\Exception::class);

test('telegram action factory throws for unsupported driver', function () {
    $factory = new TelegramActionFactory;
    $factory->create('unsupported');
})->throws(\Exception::class);
=======
    \assertNotifyThrows(
        fn () => (new TelegramActionFactory)->create('official'),
        \Exception::class,
    );
});

test('telegram action factory throws for unsupported driver', function () {
    \assertNotifyThrows(
        fn () => (new TelegramActionFactory)->create('unsupported'),
        \Exception::class,
    );
});
>>>>>>> 40b96bcd6 (.)

test('whatsapp action factory creates twilio driver instance', function () {
    config()->set('services.twilio.account_sid', 'sid-123');
    config()->set('services.twilio.auth_token', 'token-123');

    $factory = new WhatsAppActionFactory;
    $action = $factory->create('twilio');

    Assert::assertInstanceOf(WhatsAppProviderActionInterface::class, $action);
});

test('whatsapp action factory throws for unsupported driver', function () {
<<<<<<< HEAD
    $factory = new WhatsAppActionFactory;

    $factory->create('unsupported');
})->throws(\Exception::class);
=======
    \assertNotifyThrows(
        fn () => (new WhatsAppActionFactory)->create('unsupported'),
        \Exception::class,
    );
});
>>>>>>> 40b96bcd6 (.)
