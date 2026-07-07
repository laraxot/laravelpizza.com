<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Datas\NotificationData;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Notifications\EmailDataNotification;
use Modules\Notify\Notifications\GenericNotification;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Notify\Notifications\SmsNotification;
use Modules\Notify\Notifications\TelegramNotification;
use Modules\Notify\Notifications\ThemeNotification;
use Modules\Notify\Notifications\TicketAssignedNotification;
use Modules\Notify\Notifications\TicketStatusChangedNotification;
use Modules\Notify\Notifications\WhatsAppNotification;
use Modules\Notify\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(\Modules\Notify\Tests\TestCase::class);

function makeThemeNotifiableDummy(): CanThemeNotificationContract
{
    return new class extends Model implements CanThemeNotificationContract
    {
        protected $guarded = [];

        public bool $emailCallbackCalled = false;

        public bool $smsCallbackCalled = false;

        public function getNotificationData(string $name, array $view_params = []): NotificationData
        {
            return NotificationData::from([
                'from' => 'System',
                'recipient' => 'user@example.test',
                'body' => 'Body',
                'channels' => ['mail', 'sms'],
            ]);
        }

        public function getModel(): Model
        {
            return $this;
        }

        public function sendEmailCallback(): void
        {
            $this->emailCallbackCalled = true;
        }

        public function sendSmsCallback(): void
        {
            $this->smsCallbackCalled = true;
        }

        public function increase(string $what, array $data): void {}
    };
}

function makeGenericNotifiableDummy(): Model
{
    return new class extends Model
    {
        protected $guarded = [];

        public function getFullName(): string
        {
            return 'Mario Rossi';
        }

        public function routeNotificationForTwilio(mixed $notification): string
        {
            return '+39000111222';
        }
    };
}

test('email data notification exposes mail channel and array payload', function () {
        /** @var \Modules\Notify\Tests\TestCase $this */
    $emailData = EmailData::from([
        'recipient' => 'recipient@example.test',
        'from' => 'Sender Name',
        'from_email' => 'from@example.test',
        'subject' => 'Subject',
        'body_html' => '<p>Body</p>',
        'body' => 'Body',
    ]);

    $notification = new EmailDataNotification($emailData);

    Assert::assertSame(['mail'], $notification->via(new \stdClass));
    Assert::assertEquals([
        'recipient' => 'recipient@example.test',
        'subject' => 'Subject',
        'from' => 'Sender Name',
        'from_email' => 'from@example.test',
        'body' => 'Body',
    ], \assertNotifyArray($notification->toArray(new \stdClass)));
});

test('sms notification builds sms payload and provider config', function () {
    $notification = new SmsNotification('Test SMS', [
        'recipient' => '+39123',
        'from' => 'Xot',
        'provider' => 'netfun',
    ]);

    $sms = $notification->toSms(new \stdClass);

    Assert::assertInstanceOf(SmsData::class, $sms);
    Assert::assertSame(['sms'], $notification->via(new \stdClass));
    Assert::assertSame('+39123', $sms->recipient);
    Assert::assertSame('netfun', $notification->getProvider());
    Assert::assertArrayHasKey('provider', $notification->getConfig());
});

test('telegram notification uses telegram channel class and returns message', function () {
    $notification = new TelegramNotification('Hello telegram');

    $channels = \assertNotifyArray($notification->via(new \stdClass));
    Assert::assertCount(1, $channels);
    Assert::assertNotEmpty($channels[0] ?? null);
    Assert::assertNotEmpty($notification->toTelegram(new \stdClass));
});

test('whatsapp notification exposes whatsapp channel and provider', function () {
    $notification = new WhatsAppNotification('Hello WA', [
        'recipient' => '+39999',
        'provider' => 'twilio',
    ]);

    $wa = $notification->toWhatsApp(new \stdClass);

    Assert::assertInstanceOf(WhatsAppData::class, $wa);
    Assert::assertSame(['whatsapp'], $notification->via(new \stdClass));
    Assert::assertSame('+39999', $wa->recipient);
    Assert::assertSame('twilio', $notification->getProvider());
});

test('theme notification returns channels and array payload', function () {
    $notification = new ThemeNotification('welcome-email', ['foo' => 'bar']);
    $notifiable = makeThemeNotifiableDummy();

    Assert::assertSame(['mail', 'sms'], $notification->via($notifiable));
    Assert::assertSame([
        'foo' => 'bar',
        '_name' => 'welcome-email',
    ], $notification->toArray($notifiable));
    Assert::assertTrue(in_array(Queueable::class, class_uses($notification), true));
});

test('generic notification supports channels mail twilio and database payload', function () {
    $notification = new GenericNotification(
        'System alert',
        'Body text',
        ['mail', 'database'],
        ['action_text' => 'Open', 'action_url' => 'https://example.test']
    );

    $notifiable = makeGenericNotifiableDummy();

    $mail = $notification->toMail($notifiable);
    $twilio = $notification->toTwilio($notifiable);
    $database = $notification->toDatabase($notifiable);

    Assert::assertInstanceOf(MailMessage::class, $mail);
    Assert::assertArrayHasKey('content', $twilio);
    Assert::assertArrayHasKey('to', $twilio);
    Assert::assertSame('+39000111222', $twilio['to']);
    Assert::assertArrayHasKey('title', $database);
    Assert::assertArrayHasKey('message', $database);
    Assert::assertArrayHasKey('data', $database);
    Assert::assertArrayHasKey('created_at', $database);
    Assert::assertSame(['mail', 'database'], $notification->via($notifiable));
});

test('record notification manages channels and merged payloads', function () {
    $record = new class extends Model
    {
        protected $table = 'notify_record_dummy';
    };

    $notification = new RecordNotification($record, 'My Slug Name');

    $notifiable = new class
    {
        public function routeNotificationFor(string $channel): ?string
        {
            return match ($channel) {
                'mail' => 'dest@example.test',
                'sms' => '+391234',
                default => null,
            };
        }
    };

    $channels = $notification->via($notifiable);

    Assert::assertCount(2, $channels);
    Assert::assertContains('mail', $channels);

    $notification->mergeData(['a' => 'b'])->addAttachments([['name' => 'file.pdf', 'path' => base_path('storage/app/f.pdf')]]);

    Assert::assertArrayHasKey('a', $notification->data);
    Assert::assertSame('b', $notification->data['a']);
    Assert::assertCount(1, $notification->attachments);
});

test('ticket notifications expose channels and array payload', function () {
    $user = new User;
    $user->id = 'user-1';
    $user->name = 'Assigner User';

    $assigned = new TicketAssignedNotification((object) ['id' => 10], $user);
    $changed = new TicketStatusChangedNotification((object) ['id' => 10], 'open', 'closed');

    Assert::assertSame(['mail', 'database'], $assigned->via(new \stdClass));
    Assert::assertArrayHasKey('assigned_by', $assigned->toArray(new \stdClass));
    Assert::assertSame('user-1', $assigned->toArray(new \stdClass)['assigned_by']);
    Assert::assertSame(['mail', 'database'], $changed->via(new \stdClass));
    Assert::assertArrayHasKey('old_status', $changed->toArray(new \stdClass));
    Assert::assertSame('open', $changed->toArray(new \stdClass)['old_status']);
    Assert::assertSame('closed', $changed->toArray(new \stdClass)['new_status']);
});
