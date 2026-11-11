<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Notifications;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
/**
 * Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 17
 * (2026-09-15): un survey senza `sms_template` configurato non lanciava
 * eccezioni, ma faceva costruire un `SmsData` con corpo vuoto — che
 * `SmsChannel::send()` avrebbe spedito per davvero al gateway. Chiamato qui
 * `toSms()` direttamente (non via `Notification::fake()`, che lo
 * salterebbe del tutto e non proteggerebbe questo fix — verificato in
 * `SendInviteActionTest.php`): nessuna chiamata reale possibile, la catena
 * si ferma dentro `RecordNotification`/`SpatieEmail` (solo query DB sulla
 * connessione `notify`, gia' transazionata dal `TestCase` del modulo, e
 * render Mustache locale) e non raggiunge mai `SmsChannel`/il driver.
 */
function makeSmsRoutableNotifiable(?string $phone): object
{
    return new class($phone)
    {
        public function __construct(private readonly ?string $phone) {}

        public function routeNotificationFor(string $channel): ?string
        {
            return $channel === 'sms' ? $this->phone : null;
        }
    };
}

it('returns null when the resolved MailTemplate has no sms_template (Difetto 17)', function (): void {
    $slug = 'pest-record-notification-empty-sms-'.uniqid();

    MailTemplate::query()->create([
        'mailable' => SpatieEmail::class,
        'slug' => $slug,
        'subject' => 'Pest',
        'html_template' => '<p>Pest</p>',
        'html_layout_path' => 'base.html',
        'sms_template' => null,
    ]);

    $record = new class extends Model
    {
        protected $guarded = [];
    };
    $notification = new RecordNotification($record, $slug);
    $notifiable = makeSmsRoutableNotifiable('+393331234567');

    $result = $notification->toSms($notifiable);

    Assert::assertNull($result);
});

it('returns a SmsData with a real body when the resolved MailTemplate has sms_template', function (): void {
    $slug = 'pest-record-notification-real-sms-'.uniqid();

    MailTemplate::query()->create([
        'mailable' => SpatieEmail::class,
        'slug' => $slug,
        'subject' => 'Pest',
        'html_template' => '<p>Pest</p>',
        'html_layout_path' => 'base.html',
        'sms_template' => 'Ciao {{ first_name }}, il tuo invito e\' pronto.',
    ]);

    $record = new class extends Model
    {
        protected $guarded = [];
    };
    $notification = new RecordNotification($record, $slug);
    $notifiable = makeSmsRoutableNotifiable('+393331234567');

    $result = $notification->toSms($notifiable);

    Assert::assertInstanceOf(SmsData::class, $result);
    Assert::assertNotSame('', trim($result->body));
});

it('returns null when there is no phone to route to', function (): void {
    $slug = 'pest-record-notification-no-phone-'.uniqid();

    $record = new class extends Model
    {
        protected $guarded = [];
    };
    $notification = new RecordNotification($record, $slug);
    $notifiable = makeSmsRoutableNotifiable(null);

    $result = $notification->toSms($notifiable);

    Assert::assertNull($result);
});
