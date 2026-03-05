<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Datas\NotificationData;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Notifications\Channels\NetfunChannel;
use Modules\Notify\Notifications\Channels\TelegramChannel;
use Modules\Notify\Notifications\ThemeNotification;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

class NetfunChannelNotifiableDummy extends Model implements CanThemeNotificationContract
{
    protected $guarded = [];

    public array $increased = [];

    public function getNotificationData(string $name, array $view_params = []): NotificationData
    {
        return NotificationData::from([
            'from' => 'Xot',
            'recipient' => 'dummy@example.test',
            'body' => 'body',
            'channels' => ['sms'],
        ]);
    }

    public function getModel(): Model
    {
        return $this;
    }

    public function sendEmailCallback() {}

    public function sendSmsCallback() {}

    public function increase(string $what, array $data): void
    {
        $this->increased[$what] = $data;
    }
}

class ThemeNotificationDummy extends ThemeNotification
{
    public function toSms(CanThemeNotificationContract $notifiable): SmsData
    {
        return SmsData::from([
            'from' => 'Xot',
            'recipient' => '+391234567890',
            'body' => 'Body',
        ]);
    }
}

class TelegramNotificationDummy extends Notification
{
    public function toTelegram(object $notifiable): array
    {
        return ['text' => 'hello'];
    }
}

class TelegramNotifiableDummy
{
    public function routeNotificationForTelegram(): string
    {
        return 'chat-123';
    }
}

test('netfun notifications channel sends and increases counter', function () {
    app()->instance(NetfunSendAction::class, new class extends NetfunSendAction
    {
        public function __construct() {}

        public function execute(SmsData $smsData): array
        {
            return ['status_code' => 200, 'status_txt' => 'ok'];
        }
    });

    $channel = new NetfunChannel();
    $notifiable = new NetfunChannelNotifiableDummy();
    $notification = new ThemeNotificationDummy('name', []);

    $channel->send($notifiable, $notification);

    expect($notifiable->increased)->toHaveKey('sms')
        ->and($notifiable->increased['sms']['status_code'])->toBe(200);
});

test('telegram notifications channel logs when recipient and method are valid', function () {
    Log::shouldReceive('info')->once();

    $channel = new TelegramChannel();
    $channel->send(new TelegramNotifiableDummy(), new TelegramNotificationDummy());

    expect(true)->toBeTrue();
});

test('telegram notifications channel throws when notification has no toTelegram method', function () {
    $channel = new TelegramChannel();

    $channel->send(new TelegramNotifiableDummy(), new class extends Notification {});
})->throws(Exception::class);
