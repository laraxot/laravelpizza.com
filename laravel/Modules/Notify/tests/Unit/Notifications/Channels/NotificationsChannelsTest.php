<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use Modules\Notify\Notifications\Channels\NetfunChannel;
use Modules\Notify\Notifications\Channels\TelegramChannel;
use Modules\Notify\Notifications\ThemeNotification;
use Modules\Notify\Tests\Fixtures\NetfunChannelNotifiableDummy;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
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
                'body' => 'Body']);
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

    app()->instance(SendSmsFactorSMSAction::class, new class implements SmsActionContract
    {
        /** @return array{status_code: int, status_txt: string} */
        public function execute(SmsData $smsData): array
        {
            return ['status_code' => 200, 'status_txt' => 'ok'];
        }
    });

    $channel = new NetfunChannel;
    $notifiable = new NetfunChannelNotifiableDummy;
    $notification = makeThemeNotificationDummy();

    $channel->send($notifiable, $notification);

    Assert::assertArrayHasKey('sms', $notifiable->increased);
    Assert::assertSame(200, TestCase::notifyArrayGet($notifiable->increased, 'sms', 'status_code'));
});

test('telegram notifications channel logs when recipient and method are valid', function () {
    Log::shouldReceive('debug')->once()->withArgs(function (string $message, array $context): bool {
        return str_contains($message, 'Telegram') && isset($context['chat_id']);
    });
    Log::shouldReceive('info')->zeroOrMoreTimes();

    $channel = new TelegramChannel;
    $channel->send(makeTelegramNotifiableDummy(), makeTelegramNotificationDummy());
});

test('telegram notifications channel throws when notification has no toTelegram method', function () {
    $channel = new TelegramChannel;

    XotBasePest::assertThrows(
        fn () => $channel->send(makeTelegramNotifiableDummy(), new class extends Notification {}),
        \Exception::class,
    );
});