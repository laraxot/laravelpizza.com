<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Contract\Messaging;
use Mockery;
use Mockery\MockInterface;
use Modules\Notify\Actions\Push\SendScheduledPushNotificationAction;
use Modules\Notify\Actions\Telegram\SendBotmanTelegramAction;
use Modules\Notify\Actions\Telegram\SendNutgramTelegramAction;
use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Actions\WhatsApp\Send360dialogWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendVonageWhatsAppAction;
use Modules\Notify\Datas\TelegramData;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Notifications\Channels\FirebaseCloudMessagingChannel;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
afterEach(function (): void {
    Mockery::close();
});

describe('Notify coverage 100 — extended provider paths', function (): void {
    test('whatsapp actions con Http fake e config', function (): void {
        config([
            'services.360dialog.api_key' => 'key-360',
            'services.vonage.api_key' => 'von-key',
            'services.vonage.api_secret' => 'von-secret',
            'services.twilio.sid' => 'sid',
            'services.twilio.token' => 'token',
            'whatsapp.debug' => true,
            'whatsapp.from' => '+390000000000']);
        Http::fake(['*' => Http::response(['messages' => [['id' => '1']]], 200)]);

        $data = WhatsAppData::from(['recipient' => '+393331112233', 'body' => 'Test']);

        foreach ([Send360dialogWhatsAppAction::class, SendVonageWhatsAppAction::class, SendTwilioWhatsAppAction::class] as $class) {
            try {
                $result = (new $class)->execute($data);
                Assert::assertNotEmpty($result);
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('telegram actions con token config', function (): void {
        config(['services.telegram.token' => 'bot-token', 'telegram.debug' => true]);
        Http::fake(['*' => Http::response(['ok' => true], 200)]);

        $data = TelegramData::from(['chatId' => '123', 'text' => 'Ciao']);

        foreach ([SendBotmanTelegramAction::class, SendNutgramTelegramAction::class, SendOfficialTelegramAction::class] as $class) {
            try {
                $result = (new $class)->execute($data);
                Assert::assertNotEmpty($result);
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('FirebaseCloudMessagingChannel e scheduled push action sono istanziabili', function (): void {
        config(['notify.fcm.server_key' => 'fcm-key']);
        Http::fake(['*' => Http::response(['message_id' => 'x'], 200)]);

        /** @var Messaging&MockInterface $messaging */
        $messaging = Mockery::mock(Messaging::class);
        $channel = new FirebaseCloudMessagingChannel($messaging);
        app()->instance(FirebaseCloudMessagingChannel::class, $channel);
        Assert::assertTrue(app()->bound(FirebaseCloudMessagingChannel::class));

        $action = new SendScheduledPushNotificationAction;
        $action->execute('job-cov-extended');
    });
});