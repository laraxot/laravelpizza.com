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

uses(TestCase::class);

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

        public function routeNotificationForTwilio($notification): string
        {
            return '+39000111222';
        }
    };
}

test('email data notification exposes mail channel and array payload', function () {
    $emailData = EmailData::from([
        'recipient' => 'recipient@example.test',
        'from' => 'Sender Name',
        'from_email' => 'from@example.test',
        'subject' => 'Subject',
        'body_html' => '<p>Body</p>',
        'body' => 'Body',
    ]);

    $notification = new EmailDataNotification($emailData);

    expect($notification->via(new \stdClass))->toBe(['mail'])
        ->and($notification->toArray(new \stdClass))->toMatchArray([
            'recipient' => 'recipient@example.test',
            'subject' => 'Subject',
        ]);
});

test('sms notification builds sms payload and provider config', function () {
    $notification = new SmsNotification('Test SMS', [
        'recipient' => '+39123',
        'from' => 'Xot',
        'provider' => 'netfun',
    ]);

    $sms = $notification->toSms(new \stdClass);

    expect($notification->via(new \stdClass))->toBe(['sms'])
        ->and($sms)->toBeInstanceOf(SmsData::class)
        ->and($sms->recipient)->toBe('+39123')
        ->and($notification->getProvider())->toBe('netfun')
        ->and($notification->getConfig())->toHaveKey('provider');
});

test('telegram notification uses telegram channel class and returns message', function () {
    $notification = new TelegramNotification('Hello telegram');

    expect($notification->via(new \stdClass))->toHaveCount(1)
        ->and($notification->toTelegram(new \stdClass))->toBe('Hello telegram')
        ->and($notification->toArray(new \stdClass))->toBeArray();
});

test('whatsapp notification exposes whatsapp channel and provider', function () {
    $notification = new WhatsAppNotification('Hello WA', [
        'recipient' => '+39999',
        'provider' => 'twilio',
    ]);

    $wa = $notification->toWhatsApp(new \stdClass);

    expect($notification->via(new \stdClass))->toBe(['whatsapp'])
        ->and($wa)->toBeInstanceOf(WhatsAppData::class)
        ->and($wa->recipient)->toBe('+39999')
        ->and($notification->getProvider())->toBe('twilio');
});

test('theme notification returns channels and array payload', function () {
    $notification = new ThemeNotification('welcome-email', ['foo' => 'bar']);
    $notifiable = makeThemeNotifiableDummy();

    expect($notification->via($notifiable))->toBe(['mail', 'sms'])
        ->and($notification->toArray($notifiable))->toMatchArray([
            '_name' => 'welcome-email',
            'foo' => 'bar',
        ])
        ->and(in_array(Queueable::class, class_uses($notification), true))->toBeTrue();
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

    expect($notification->via($notifiable))->toBe(['mail', 'database'])
        ->and($mail)->toBeInstanceOf(MailMessage::class)
        ->and($twilio)->toHaveKeys(['content', 'to'])
        ->and($twilio['to'])->toBe('+39000111222')
        ->and($database)->toHaveKeys(['title', 'message', 'data', 'created_at']);
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

    expect($channels)->toHaveCount(2)
        ->and($channels[0])->toBe('mail');

    $notification->mergeData(['a' => 'b'])->addAttachments([['name' => 'file.pdf', 'path' => base_path('storage/app/f.pdf')]]);

    expect($notification->data)->toMatchArray(['a' => 'b'])
        ->and($notification->attachments)->toHaveCount(1);
});

test('ticket notifications expose channels and array payload', function () {
    $user = new User;
    $user->id = 'user-1';
    $user->name = 'Assigner User';

    $assigned = new TicketAssignedNotification((object) ['id' => 10], $user);
    $changed = new TicketStatusChangedNotification((object) ['id' => 10], 'open', 'closed');

    expect($assigned->via(new \stdClass))->toBe(['mail', 'database'])
        ->and($assigned->toArray(new \stdClass))->toMatchArray(['assigned_by' => 'user-1'])
        ->and($changed->via(new \stdClass))->toBe(['mail', 'database'])
        ->and($changed->toArray(new \stdClass))->toMatchArray(['old_status' => 'open', 'new_status' => 'closed']);
});
