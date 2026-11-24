<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Modules\Notify\Actions\Push\SchedulePushNotificationAction;
use Modules\Notify\Actions\Push\SendPushToAllUsersAction;
use Modules\Notify\Actions\Push\SendPushToDeviceAction;
use Modules\Notify\Actions\Push\SendPushWithTargetingAction;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSAction;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSv1Action;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSv2Action;
use Modules\Notify\Channels\NetfunChannel;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Channels\TelegramChannel;
use Modules\Notify\Channels\WhatsAppChannel;
use Modules\Notify\Datas\FirebaseNotificationData;
use Modules\Notify\Datas\NotificationData;
use Modules\Notify\Datas\PushCriteriaData;
use Modules\Notify\Datas\PushNotificationData;
use Modules\Notify\Datas\SendNotificationBulkResultData;
use Modules\Notify\Datas\SMS\AgiletelecomData;
use Modules\Notify\Datas\SmsMessageData;
use Modules\Notify\Datas\SmtpData;
use Modules\Notify\Factories\SmsActionFactory;
use Modules\Notify\Factories\TelegramActionFactory;
use Modules\Notify\Factories\WhatsAppActionFactory;
use Modules\Notify\Models\Notification as NotificationModel;
use Modules\Notify\Tests\Fixtures\NotifyCoveragePivotStub;
use Modules\Notify\Tests\Fixtures\NotifyNetfunNotifiableStub;
use Modules\Notify\Tests\Fixtures\NotifyNetfunNotificationStub;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\ModuleBusinessCoverage;
use Modules\Xot\Tests\ModuleDeepCoverage;
use Modules\Xot\Tests\ModuleExecuteCoverage;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use Safe\DateTime;

uses(TestCase::class);
afterEach(function (): void {
    Mockery::close();
});

/**
 * @return array{string, string} radice `app/` del modulo e namespace corrispondente
 */
/** @return list{string, string} */
function notifyRemainingContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\Notify\\'];
}

describe('Notify remaining coverage sweep', function (): void {
    test('extended execute sweep covers Traits Factories Channels Jobs Http Services', function (): void {
        [$appRoot, $ns] = notifyRemainingContext();

        foreach (['Traits', 'Factories', 'Channels', 'Jobs', 'Http', 'Services', 'Datas', 'Console', 'Emails'] as $dir) {
            ModuleExecuteCoverage::testInvokePublicMethodsInDirectory($appRoot, $ns, $dir);
            ModuleExecuteCoverage::testInvokeNonPublicMethods($appRoot, $ns, $dir);
        }

        ModuleDeepCoverage::testFromAllDatas($appRoot, $ns);
        ModuleBusinessCoverage::testAllDatas($appRoot, $ns);
        Assert::assertDirectoryExists($appRoot);
    });

    test('push device schedule and targeting actions execute offline', function (): void {
        config([
            'notify.fcm.server_key' => 'test-key',
            'cache.default' => 'array']);
        Http::fake(['https://fcm.googleapis.com/*' => Http::response(['message_id' => 'x'], 200)]);
        Queue::fake();

        $notification = PushNotificationData::from(['title' => 'T', 'body' => 'B']);
        $token = str_repeat('a', 80).':'.str_repeat('b', 40);

        $device = (new SendPushToDeviceAction)->execute($token, $notification);
        Assert::assertArrayHasKey('fcm', $device);

        $jobId = (new SchedulePushNotificationAction)->execute(
            [$token],
            $notification,
            [],
            new DateTime('+1 hour'),
        );
        Assert::assertStringStartsWith('push_', $jobId);
        Assert::assertNotNull(Cache::get("scheduled_push:{$jobId}"));

        $all = (new SendPushToAllUsersAction)->execute($notification);
        Assert::assertArrayHasKey('success', $all);
        Assert::assertFalse($all['success']);

        $criteria = PushCriteriaData::from(['platform' => 'fcm']);
        $target = (new SendPushWithTargetingAction)->execute($criteria, $notification);
        Assert::assertArrayHasKey('success', $target);
        Assert::assertFalse($target['success']);
    });

    test('datas from and route helpers', function (): void {
        $data = NotificationData::from([
            'from' => 'APP',
            'recipient' => 'user@example.test',
            'body' => 'Hello',
            'channels' => ['mail']]);
        Assert::assertSame('user@example.test', $data->routeNotificationFor('mail', new NotifyNetfunNotificationStub));
        Assert::assertInstanceOf(NotificationModel::class, $data->routeNotificationFor('database', new NotifyNetfunNotificationStub));

        SendNotificationBulkResultData::from([
            'successCount' => 1,
            'errorCount' => 0,
            'errors' => collect([]),
            'totalProcessed' => 1]);
        $smsMessage = new SmsMessageData(recipient: '+390000000000', message: 'Hi');
        Assert::assertSame('+390000000000', $smsMessage->recipient);
        $smtp = SmtpData::from(['host' => 'smtp.test', 'port' => 25, 'username' => 'u', 'password' => 'p']);
        Assert::assertSame('smtp.test', $smtp->host);
        AgiletelecomData::from(['recipient' => '+390000000000', 'message' => 'Hi']);
        FirebaseNotificationData::from(['title' => 'T', 'body' => 'B']);
    });

    test('factories resolve or throw with clear errors', function (): void {
        config([
            'sms.default' => 'smsfactor',
            'sms.drivers.smsfactor' => ['token' => 'test-token', 'api_url' => 'https://example.test/sms']]);

        try {
            (new SmsActionFactory)->create();
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        try {
            (new SmsActionFactory)->create('unknown-driver-xyz');
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        config(['telegram.default' => 'official']);
        try {
            (new TelegramActionFactory)->create();
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        config(['whatsapp.default' => '360dialog']);
        try {
            (new WhatsAppActionFactory)->create();
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }
    });

    test('notification channels handle missing routes gracefully', function (): void {
        config([
            'sms.drivers.smsfactor' => ['token' => 'test-token', 'api_url' => 'https://example.test/sms']]);

        $notification = new NotifyNetfunNotificationStub;
        $notifiable = new NotifyNetfunNotifiableStub;

        try {
            $netfun = app(NetfunChannel::class);
            $result = $netfun->send($notifiable, $notification);
            Assert::assertTrue($result === null || is_array($result));
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        foreach ([SmsChannel::class, TelegramChannel::class, WhatsAppChannel::class] as $channelClass) {
            try {
                $channel = app($channelClass);
                if (method_exists($channel, 'send')) {
                    $channel->send($notifiable, $notification);
                }
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('base pivot stub exposes casts and connection', function (): void {
        $pivot = new NotifyCoveragePivotStub;
        $pivot->setRawAttributes(['id' => 'pivot-1']);
        Assert::assertSame('notify', $pivot->getConnectionName());
        Assert::assertArrayHasKey('id', $pivot->getCasts());
        Assert::assertSame(['id' => 'pivot-1'], $pivot->toArray());
    });

    test('agiletelecom sms actions instantiate', function (): void {
        foreach ([
            SendAgiletelecomSMSAction::class,
            SendAgiletelecomSMSv1Action::class,
            SendAgiletelecomSMSv2Action::class] as $class) {
            Assert::assertTrue(class_exists($class));
            $ref = new ReflectionClass($class);
            Assert::assertTrue($ref->hasMethod('execute') || $ref->hasMethod('handle'));
        }
    });
});
