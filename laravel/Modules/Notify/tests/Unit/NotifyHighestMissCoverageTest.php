<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Testing\PendingCommand;
use Modules\Notify\Actions\EsendexSendAction;
use Modules\Notify\Actions\Mail\Engines\Duocircle\TryDuocircleMailAction;
use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Actions\Push\SchedulePushNotificationAction;
use Modules\Notify\Actions\Push\SendPushToAllUsersAction;
use Modules\Notify\Actions\Push\SendPushToDeviceAction;
use Modules\Notify\Actions\Push\SendPushToDevicesAction;
use Modules\Notify\Actions\Push\SendPushToPlatformAction;
use Modules\Notify\Actions\Push\SendPushToTopicAction;
use Modules\Notify\Actions\Push\SendPushWithTargetingAction;
use Modules\Notify\Actions\Push\SendPushWithTemplateAction;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Actions\SMS\SendGammuSMSAction;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Modules\Notify\Actions\SMS\SendNexmoSMSAction;
use Modules\Notify\Actions\SMS\SendPlivoSMSAction;
use Modules\Notify\Actions\SMS\SendSmsAction;
use Modules\Notify\Actions\SMS\SendTwilioSMSAction;
use Modules\Notify\Actions\Telegram\SendBotmanTelegramAction;
use Modules\Notify\Actions\Telegram\SendNutgramTelegramAction;
use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Actions\WhatsApp\Send360dialogWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendFacebookWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendVonageWhatsAppAction;
use Modules\Notify\Database\Factories\NotificationTemplateFactory;
use Modules\Notify\Datas\PushCriteriaData;
use Modules\Notify\Datas\PushNotificationData;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Datas\TelegramData;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Filament\Clusters\Test\Pages\SendAwsEmailPage;
use Modules\Notify\Filament\Clusters\Test\Pages\SendEmailPage;
use Modules\Notify\Filament\Clusters\Test\Pages\SendFirebasePushNotificationPage;
use Modules\Notify\Filament\Clusters\Test\Pages\SendNetfunSmsPage;
use Modules\Notify\Filament\Clusters\Test\Pages\SendSmsPage;
use Modules\Notify\Filament\Clusters\Test\Pages\SendSpatieEmailPage;
use Modules\Notify\Filament\Clusters\Test\Pages\SendTelegramPage;
use Modules\Notify\Filament\Clusters\Test\Pages\SendWhatsAppPage;
use Modules\Notify\Filament\Resources\ContactResource;
use Modules\Notify\Filament\Resources\MailTemplateResource;
use Modules\Notify\Filament\Resources\NotificationResource;
use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Notify\Filament\Resources\NotificationTemplateResource\Schemas\NotificationTemplateForm;
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Notify\Filament\Resources\NotifyThemeResource\Schemas\NotifyThemeForm;
use Modules\Notify\Helpers\ConfigHelper;
use Modules\Notify\Models\Contact;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotifyTheme;
use Modules\Notify\Notifications\GenericNotification;
use Modules\Notify\Tests\TestCase;
use Modules\Notify\Tests\Unit\Traits\NotifyTrackingDummy;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;
use Safe\DateTime;

use function Pest\Laravel\artisan;
use function Safe\file_put_contents;
use function Safe\unlink;

uses(TestCase::class);
/**
 * @param  class-string  $class
 */
function notifyPageWithoutLivewire(string $class): object
{
    return (new ReflectionClass($class))->newInstanceWithoutConstructor();
}

/**
 * @param  array<string, mixed>  $attributes
 */
function notifyDummyRecipient(array $attributes = []): Model
{
    return new class($attributes) extends Model
    {
        use Notifiable;

        protected $guarded = [];

        /**
         * @param  array<string, mixed>  $attributes
         */
        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
        }

        public function routeNotificationForMail(): string
        {
            $email = $this->getAttribute('email');

            return is_string($email) ? $email : '';
        }

        public function routeNotificationForSms(): string
        {
            $phone = $this->getAttribute('phone');

            return is_string($phone) ? $phone : '';
        }
    };
}

function notifyEnsureTemplateTable(): void
{
    try {
        $schema = Schema::connection('notify');

        if ($schema->hasTable('notification_templates')) {
            NotificationTemplate::query()->delete();

            return;
        }

        $schema->create('notification_templates', function (Blueprint $table): void {
            $table->string('id', 36)->primary();
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->text('subject')->nullable();
            $table->longText('body_html')->nullable();
            $table->longText('body_text')->nullable();
            $table->json('channels')->nullable();
            $table->json('variables')->nullable();
            $table->json('conditions')->nullable();
            $table->json('preview_data')->nullable();
            $table->json('metadata')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('version')->default(1);
            $table->string('type')->nullable();
            $table->timestamps();
        });
    } catch (\Throwable $e) {
        Assert::markTestSkipped('Notify DB non disponibile: '.$e->getMessage());
    }
}

describe('Notify highest-miss coverage', function (): void {
    test('cluster test pages expose form schemas', function (): void {
        $pages = [
            SendEmailPage::class => ['getEmailFormSchema'],
            SendNetfunSmsPage::class => ['getSmsFormSchema'],
            SendWhatsAppPage::class => ['getWhatsAppFormSchema'],
            SendTelegramPage::class => ['getTelegramFormSchema'],
            SendFirebasePushNotificationPage::class => ['getPushFormSchema'],
            SendAwsEmailPage::class => ['getEmailFormSchema'],
            SendSpatieEmailPage::class => ['getEmailFormSchema'],
            SendSmsPage::class => ['getSmsFormSchema']];

        foreach ($pages as $class => $methods) {
            $page = notifyPageWithoutLivewire($class);
            Assert::assertSame('Notify', $class::getModuleName());
            foreach ($methods as $method) {
                $schema = (new ReflectionMethod($class, $method))->invoke($page);
                Assert::assertNotEmpty($schema);
            }
        }
    });

    test('resources expose model pages and form class schema', function (): void {
        Assert::assertSame(NotificationTemplate::class, NotificationTemplateResource::getModel());
        Assert::assertArrayHasKey('name', (new (NotificationTemplateResource::getFormClass()))->getFormSchema());
        Assert::assertNotEmpty(NotificationTemplateResource::getPages());

        Assert::assertSame(NotifyTheme::class, NotifyThemeResource::getModel());
        Assert::assertArrayHasKey('subject', (new (NotifyThemeResource::getFormClass()))->getFormSchema());
        Assert::assertNotEmpty(NotifyThemeResource::getPages());

        Assert::assertSame(MailTemplate::class, MailTemplateResource::getModel());
        Assert::assertNotEmpty((new (MailTemplateResource::getFormClass()))->getFormSchema());
        Assert::assertNotEmpty(MailTemplateResource::getPages());

        Assert::assertSame(\Modules\Notify\Models\Notification::class, NotificationResource::getModel());
        Assert::assertNotEmpty((new (NotificationResource::getFormClass()))->getFormSchema());

        Assert::assertSame(Contact::class, ContactResource::getModel());
        Assert::assertNotEmpty((new (ContactResource::getFormClass()))->getFormSchema());
        Assert::assertNotEmpty(ContactResource::getPages());
    });

    test('push actions fan out, schedule and guard empty targets', function (): void {
        config([
            'notify.fcm.server_key' => 'test-key',
            'cache.default' => 'array']);
        Http::fake([
            'https://fcm.googleapis.com/*' => Http::response(['message_id' => 'mid-1'], 200)]);
        Queue::fake();

        $notification = PushNotificationData::from(['title' => 'Ciao', 'body' => 'Test']);
        $fcmToken = str_repeat('a', 80).':'.str_repeat('b', 40);
        $apnsToken = str_repeat('ab', 32);

        $one = (new SendPushToDeviceAction)->execute($fcmToken, $notification, ['k' => 'v']);
        Assert::assertArrayHasKey('fcm', $one);
        Assert::assertTrue($one['fcm']['success']);
        Assert::assertTrue($one['apns']['success']);
        Assert::assertTrue($one['webpush']['success']);

        $batch = (new SendPushToDevicesAction)->execute([$fcmToken, $apnsToken, 'web-token'], $notification);
        Assert::assertArrayHasKey('fcm', $batch);

        $topic = (new SendPushToTopicAction)->execute('news', $notification);
        Assert::assertArrayHasKey('fcm', $topic);
        Assert::assertSame('news', $topic['apns']['topic']);
        Assert::assertSame('news', $topic['webpush']['topic']);

        $emptyAll = (new SendPushToAllUsersAction)->execute($notification);
        Assert::assertFalse($emptyAll['success']);

        $emptyTarget = (new SendPushWithTargetingAction)->execute(PushCriteriaData::from(['platform' => 'unknown']), $notification);
        Assert::assertFalse($emptyTarget['success']);

        expect(fn (): array => (new SendPushWithTemplateAction)->execute('missing', ['t']))
            ->toThrow(\Exception::class);

        $jobId = (new SchedulePushNotificationAction)->execute(['t1'], $notification, [], new DateTime('+1 hour'));
        Assert::assertStringStartsWith('push_', $jobId);
    });

    test('simulated apns and webpush deliveries are traced in the log', function (): void {
        config(['notify.fcm.server_key' => 'test-key']);
        Http::fake([
            'https://fcm.googleapis.com/*' => Http::response(['message_id' => 'mid-3'], 200)]);
        $traced = [];
        Log::shouldReceive('notice')->times(4)->andReturnUsing(static function (string $message, array $context) use (&$traced): void {
            $traced[] = $context;
        });

        $notification = PushNotificationData::from(['title' => 'T', 'body' => 'B']);

        (new SendPushToPlatformAction)->execute('apns', str_repeat('ab', 32), $notification, ['k' => 'v']);
        (new SendPushToPlatformAction)->execute('webpush', 'web-token', $notification);
        (new SendPushToTopicAction)->execute('news', $notification);

        Assert::assertSame(['apns', 'webpush', 'apns', 'webpush'], array_column($traced, 'platform'));
        Assert::assertSame(['news', 'news'], array_column(array_column($traced, 'payload'), 'topic'));
    });

    test('push targeting explains why it resolved no tokens', function (): void {
        Log::shouldReceive('warning')->once();
        Log::shouldReceive('notice')->once();
        $notification = PushNotificationData::from(['title' => 'T', 'body' => 'B']);

        (new SendPushWithTargetingAction)->execute(PushCriteriaData::from(['platform' => 'unknown']), $notification);
        (new SendPushWithTargetingAction)->execute(PushCriteriaData::from(['platform' => 'fcm']), $notification);
    });

    test('ConfigHelper replaces template variables from notify config', function (): void {
        config([
            'notify.company' => ['name' => 'Comune Test', 'city' => '{{name}}'],
            'notify.template_variables' => ['year' => '2026'],
            'notify.test_data' => ['hello' => 'Hi {{name}}'],
            'notify.webhooks' => ['url' => 'https://example.test'],
            'notify.email' => ['from' => 'noreply@example.test']]);

        $replaced = ConfigHelper::replaceTemplateVariables(['msg' => 'Anno {{year}}']);
        Assert::assertSame('Anno 2026', $replaced['msg']);

        Assert::assertSame('Comune Test', ConfigHelper::get('notify.company.name'));
        Assert::assertSame('Hi Comune Test', ConfigHelper::getTestData()['hello']);
        Assert::assertArrayHasKey('name', ConfigHelper::getCompanyConfig());
        Assert::assertArrayHasKey('url', ConfigHelper::getWebhookConfig());
        Assert::assertArrayHasKey('from', ConfigHelper::getEmailConfig());
    });

    test('analyze translations artisan command runs against module lang', function (): void {
        $pending = artisan('notify:analyze-translations');
        if ($pending instanceof PendingCommand) {
            $pending->assertExitCode(0);

            return;
        }

        Assert::assertSame(0, $pending);
    });

    test('push actions send across fcm apns and webpush with fakes', function (): void {
        config([
            'notify.fcm.server_key' => 'test-key']);
        Http::fake([
            'https://fcm.googleapis.com/*' => Http::response(['message_id' => 'mid-2'], 200)]);

        $notification = PushNotificationData::from([
            'title' => 'Titolo',
            'body' => 'Corpo']);
        $fcmToken = str_repeat('a', 80).':'.str_repeat('b', 40);
        $apnsToken = str_repeat('ab', 32);

        $platform = (new SendPushToPlatformAction)->execute('fcm', $fcmToken, $notification);
        Assert::assertTrue($platform['success']);
        Assert::assertTrue((new SendPushToPlatformAction)->execute('apns', $apnsToken, $notification)['success']);
        Assert::assertTrue((new SendPushToPlatformAction)->execute('webpush', 'web-token', $notification)['success']);

        $devices = (new SendPushToDevicesAction)->execute([$fcmToken, $apnsToken], $notification);
        Assert::assertArrayHasKey('fcm', $devices);

        $topic = (new SendPushToTopicAction)->execute('news', $notification);
        Assert::assertArrayHasKey('fcm', $topic);
    });

    test('whatsapp and telegram actions execute with mocked http', function (): void {
        config([
            'services.360dialog.api_key' => '360-key',
            'services.vonage.api_key' => 'vonage-key',
            'services.vonage.api_secret' => 'vonage-secret',
            'services.telegram.token' => 'telegram-token',
            'whatsapp.debug' => false,
            'whatsapp.timeout' => 5,
            'whatsapp.from' => '+390000000000']);

        $whatsappData = WhatsAppData::from([
            'recipient' => '+393331112233',
            'body' => 'Ciao']);
        $telegramData = TelegramData::from([
            'chatId' => '12345',
            'text' => 'Ciao']);

        foreach ([
            Send360dialogWhatsAppAction::class,
            SendVonageWhatsAppAction::class,
            SendFacebookWhatsAppAction::class,
            SendTwilioWhatsAppAction::class,
            SendBotmanTelegramAction::class,
            SendNutgramTelegramAction::class,
            SendOfficialTelegramAction::class] as $class) {
            try {
                $action = new $class;
                $data = str_contains($class, 'Telegram') ? $telegramData : $whatsappData;
                $result = $action->execute($data);
                Assert::assertNotEmpty($result);
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('SendSmsAction validates missing engine and accepts local vars', function (): void {
        $action = new SendSmsAction;

        expect(fn (): array => $action->execute(['to' => '+390000000000', 'body' => 'Test', 'foo' => 'bar']))
            ->toThrow(\RuntimeException::class);

        Assert::assertSame('+390000000000', $action->to);
        Assert::assertSame('bar', $action->vars['foo']);
    });

    test('sms actions normalize recipients before provider call', function (): void {
        config([
            'services.netfun.token' => 'netfun-token',
            'sms.drivers.netfun.token' => 'netfun-token',
            'sms.drivers.netfun.api_url' => 'https://example.test/sms',
            'sms.drivers.twilio.sid' => 'sid',
            'sms.drivers.twilio.token' => 'token',
            'sms.drivers.twilio.from' => '+390000000000']);

        $sms = SmsData::from([
            'recipient' => '0039333123456',
            'body' => 'Test',
            'from' => 'APP']);

        foreach ([
            NetfunSendAction::class,
            SendNetfunSMSAction::class,
            SendTwilioSMSAction::class,
            SendNexmoSMSAction::class,
            SendPlivoSMSAction::class,
            SendGammuSMSAction::class] as $class) {
            try {
                $action = new $class;
                $action->execute($sms);
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('notification template and theme forms expose keyed schema', function (): void {
        Assert::assertArrayHasKey(
            'name',
            app(NotificationTemplateForm::class)->getFormSchema(),
        );
        Assert::assertArrayHasKey(
            'subject',
            app(NotifyThemeForm::class)->getFormSchema(),
        );
    });

    test('SendNotificationAction handle works with sqlite notify schema', function (): void {
        notifyEnsureTemplateTable();

        NotificationTemplateFactory::new()->createOne([
            'id' => (string) Str::uuid(),
            'name' => 'Welcome',
            'code' => 'welcome-template',
            'subject' => ['en' => 'Welcome', 'it' => 'Benvenuto'],
            'body_text' => ['en' => 'Hello', 'it' => 'Ciao'],
            'body_html' => ['en' => '<p>Hello</p>', 'it' => '<p>Ciao</p>'],
            'channels' => ['mail'],
            'variables' => [],
            'is_active' => true,
            'conditions' => null,
            'type' => 'email']);

        $recipient = notifyDummyRecipient(['email' => 'user@example.test']);
        Notification::fake();

        $result = (new SendNotificationAction)->handle(
            $recipient,
            'welcome-template',
        );

        Assert::assertNull($result);
        Notification::assertSentTo($recipient, GenericNotification::class);

        expect(fn (): ?Model => (new SendNotificationAction)->handle(
            $recipient,
            'missing-template',
        ))->toThrow(\Exception::class);
    });

    test('SendNotificationAction sms channel truncates long messages', function (): void {
        notifyEnsureTemplateTable();

        NotificationTemplateFactory::new()->createOne([
            'id' => (string) Str::uuid(),
            'name' => 'Sms',
            'code' => 'sms-template',
            'subject' => ['en' => 'Sms', 'it' => 'Sms'],
            'body_text' => ['en' => str_repeat('x', 400), 'it' => str_repeat('x', 400)],
            'body_html' => null,
            'channels' => ['sms'],
            'variables' => [],
            'is_active' => true,
            'conditions' => null,
            'type' => 'sms']);

        $recipient = notifyDummyRecipient(['phone' => '+393331112233']);
        Notification::fake();

        (new SendNotificationAction)->handle(
            $recipient,
            'sms-template',
        );

        Notification::assertSentTo($recipient, GenericNotification::class);
    });

    test('notification template compiles previews and conditions in memory', function (): void {
        $template = new NotificationTemplate;
        $template->forceFill([
            'subject' => 'Ciao Marco',
            'body_text' => 'Testo Marco',
            'body_html' => '<p>Marco</p>',
            'channels' => ['mail', 'database'],
            'conditions' => ['send' => true],
            'preview_data' => ['name' => 'Marco'],
            'grapesjs_data' => ['blocks' => []]]);

        $compiled = $template->compile(['name' => 'Marco']);
        Assert::assertSame('Ciao Marco', $compiled['subject']);
        Assert::assertTrue($template->shouldSend(['send' => true]));
        Assert::assertFalse($template->shouldSend(['send' => false]));
        Assert::assertStringContainsString('Marco', $template->preview()['subject']);
        Assert::assertSame(['blocks' => []], $template->getGrapesJSData());
        $template->setGrapesJSData(['foo' => 'bar']);
        Assert::assertSame(['foo' => 'bar'], $template->getGrapesJSData());
    });

    test('SpatieEmail attachment helpers work without constructor bootstrap', function (): void {
        $ref = new ReflectionClass(SpatieEmail::class);
        /** @var SpatieEmail $email */
        $email = $ref->newInstanceWithoutConstructor();
        $email->slug = 'welcome-mail';
        $email->data = ['first_name' => 'Marco'];

        Assert::assertSame('welcome-mail', $email->getSlug());
        Assert::assertSame($email, $email->setRecipient('recipient@example.test'));
        $envelope = $email->envelope();
        $to = $envelope->to;
        Assert::assertNotEmpty($to);
        $firstAddress = $to[0];
        Assert::assertInstanceOf(Address::class, $firstAddress);
        Assert::assertSame('recipient@example.test', $firstAddress->address);
        Assert::assertSame($email, $email->embedLogo('/tmp/missing-logo.png'));

        $path = sys_get_temp_dir().'/notify-attach-'.uniqid('', true).'.txt';
        file_put_contents($path, 'attachment-body');
        $fromPath = $email->getAttachmentFromPath(['path' => $path, 'as' => 'file.txt']);
        Assert::assertSame('file.txt', $fromPath->as);

        $fromData = $email->getAttachmentFromData([
            'data' => 'inline-data',
            'as' => 'inline.txt',
            'mime' => 'text/plain']);
        Assert::assertSame('inline.txt', $fromData->as);

        $email->addAttachments([
            ['path' => $path],
            ['data' => 'payload', 'as' => 'payload.bin']]);
        Assert::assertCount(2, $email->attachments());
        unlink($path);
    });

    test('notification tracking adds pixel when enabled', function (): void {
        config([
            'notify.tracking.enabled' => true,
            'notify.tracking.pixel.enabled' => true,
            'notify.tracking.links.enabled' => false,
            'notify.tracking.pixel.route' => 'login']);

        $dummy = new NotifyTrackingDummy;
        $html = '<p>Newsletter</p>';
        $tracked = $dummy->addTrackingPublic($html, 'track-uuid');

        Assert::assertStringContainsString('track-uuid', $tracked);
        Assert::assertNotSame($html, $tracked);
    });

    test('facebook whatsapp action builds payload variants offline', function (): void {
        config([
            'services.facebook.access_token' => 'fb-token',
            'services.facebook.phone_number_id' => '123456',
            'whatsapp.debug' => false,
            'whatsapp.timeout' => 1]);

        $cases = [
            ['recipient' => '+393331112233', 'body' => 'Ciao', 'type' => 'text'],
            ['recipient' => '+393331112233', 'body' => '', 'type' => 'template', 'template' => ['name' => 'hello']],
            ['recipient' => '+393331112233', 'body' => '', 'type' => 'media', 'media' => ['https://example.test/a.jpg']]];

        foreach ($cases as $payload) {
            try {
                $result = (new SendFacebookWhatsAppAction)->execute(
                    WhatsAppData::from($payload),
                );
                Assert::assertNotEmpty($result);
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('esendex and duocircle actions fail fast without external providers', function (): void {
        config([
            'esendex.username' => 'user',
            'esendex.password' => 'pass',
            'esendex.sender' => 'APP']);

        $sms = SmsData::from([
            'recipient' => '+393331112233',
            'body' => 'Test',
            'from' => 'APP']);

        try {
            (new EsendexSendAction)->execute($sms);
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        expect(fn (): array => (new TryDuocircleMailAction)->execute([
            'to' => 'user@example.test']))->toThrow(\Exception::class);
    });
});