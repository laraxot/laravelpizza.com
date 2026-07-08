<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Factories\SmsActionFactory;
use Modules\Notify\Notifications\Channels\NetfunChannel;
use Modules\Notify\Notifications\Channels\TelegramChannel;
use Modules\Notify\Notifications\ThemeNotification;
use Modules\Notify\Tests\Fixtures\NetfunChannelNotifiableDummy;
use Modules\Notify\Tests\TestCase;
use Mockery;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeThemeNotificationDummy(): ThemeNotification
{
    return new class('name', []) extends ThemeNotification
    {
        public function toSms(CanThemeNotificationContract $notifiable): SmsData
        {
            return SmsData::from([
                'from' => 'Xot',
                'recipient' => '+391234567890',
                'body' => 'Body',
            ]);
        }
    };
}

function makeTelegramNotificationDummy(): Notification
{
    return new class extends Notification
    {
        /** @return array{text: string} */
        public function toTelegram(object $notifiable): array
        {
            return ['text' => 'hello'];
        }
    };
}

function makeTelegramNotifiableDummy(): object
{
    return new class
    {
        public function routeNotificationForTelegram(): string
        {
            return 'chat-123';
        }
    };
}

test('netfun notifications channel sends and increases counter', function () {
    config()->set('sms.default', 'smsfactor');
    config()->set('sms.drivers.smsfactor.token', 'token-123');

    app()->instance(SmsActionFactory::class, new class extends SmsActionFactory
    {
        public function create(?string $driver = null): SmsActionContract
        {
            return new class implements SmsActionContract
            {
                /** @return array{status_code: int, status_txt: string} */
                public function execute(SmsData $smsData): array
                {
                    return ['status_code' => 200, 'status_txt' => 'ok'];
                }
            };
        }
    });

    $channel = new NetfunChannel;
    $notifiable = new NetfunChannelNotifiableDummy;
    $notification = makeThemeNotificationDummy();

    $channel->send($notifiable, $notification);

    Assert::assertArrayHasKey('sms', $notifiable->increased);
    Assert::assertSame(200, \notifyArrayGet($notifiable->increased, 'sms', 'status_code'));
});

test('telegram notifications channel logs when recipient and method are valid', function () {
    Log::shouldReceive('info')->once();

    $channel = new TelegramChannel;
    $channel->send(makeTelegramNotifiableDummy(), makeTelegramNotificationDummy());
});

test('telegram notifications channel throws when notification has no toTelegram method', function () {
    $channel = new TelegramChannel;

    \assertNotifyThrows(
        fn () => $channel->send(makeTelegramNotifiableDummy(), new class extends Notification {}),
        \Exception::class,
    );
});
