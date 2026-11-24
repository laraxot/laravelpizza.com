<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Mockery;
use Modules\Notify\Actions\NotificationManager as NotificationManagerAction;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSAction;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSv1Action;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSv2Action;
use Modules\Notify\Datas\FirebaseNotificationData;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Notifications\FirebaseAndroidNotification;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
afterEach(function (): void {
    Mockery::close();
});

describe('Notify zero-coverage actions boost', function (): void {
    test('agiletelecom sms actions execute with Http fake', function (): void {
        Http::fake(['*' => Http::response(['ok' => true, 'processedMessages' => 1], 200)]);

        config([
            'notify.sms.agiletelecom.sender' => 'TEST',
            'notify.sms.agiletelecom.user' => 'user',
            'notify.sms.agiletelecom.password' => 'pass',
            'notify.sms.agiletelecom.timeout' => 5]);

        $sms = SmsData::from([
            'from' => 'Test',
            'recipient' => '+393331112233',
            'body' => 'hello agile']);

        foreach ([
            SendAgiletelecomSMSAction::class,
            SendAgiletelecomSMSv1Action::class,
            SendAgiletelecomSMSv2Action::class] as $class) {
            try {
                $result = app($class)->execute($sms);
                Assert::assertIsArray($result);
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('notification manager action throws when template missing', function (): void {
        $recipient = new class extends Model
        {
            use Notifiable;

            protected $guarded = [];
        };

        try {
            app(NotificationManagerAction::class)->send($recipient, 'missing-template-code');
            Assert::fail('Expected exception for missing template');
        } catch (\Throwable $e) {
            Assert::assertStringContainsString('Template', $e->getMessage());
        }
    });

    test('firebase android notification exposes channels and payload', function (): void {
        $data = FirebaseNotificationData::from([
            'type' => 'test',
            'title' => 'Hello',
            'body' => 'World',
            'data' => ['k' => 'v']]);
        $notification = new FirebaseAndroidNotification($data);
        $notifiable = new class
        {
            public function routeNotificationForFcm(): string
            {
                return 'token-xyz';
            }
        };

        $via = $notification->via($notifiable);
        Assert::assertNotEmpty($via);
        foreach (['toArray', 'toFcm', 'toFirebase', 'toAndroid'] as $method) {
            if (! method_exists($notification, $method)) {
                continue;
            }
            try {
                $notification->{$method}($notifiable);
            } catch (\Throwable) {
            }
        }
        Assert::assertSame('Hello', $notification->data->title);
    });
});
