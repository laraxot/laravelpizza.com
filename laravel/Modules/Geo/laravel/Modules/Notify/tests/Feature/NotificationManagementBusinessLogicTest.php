<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Database\Factories\ContactFactory;
use Modules\Notify\Database\Factories\MailTemplateFactory;
use Modules\Notify\Database\Factories\MailTemplateLogFactory;
use Modules\Notify\Database\Factories\MailTemplateVersionFactory;
use Modules\Notify\Database\Factories\NotificationFactory;
use Modules\Notify\Database\Factories\NotificationTemplateFactory;
use Modules\Notify\Database\Factories\NotificationTypeFactory;
use Modules\Notify\Models\Contact;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailTemplateLog;
use Modules\Notify\Models\MailTemplateVersion;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotificationType;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Notification Management Business Logic', function () {
    it('can create notification with core fields', function () {
        $notification = NotificationFactory::new()->createOne([
            'type' => 'email',
            'status' => 'pending',
            'data' => [
                'subject' => 'Test subject',
                'message' => 'Test body',
            ],
            'channels' => ['mail'],
        ]);

        Assert::assertInstanceOf(Notification::class, $notification);
        Assert::assertSame('email', $notification->type);
        Assert::assertSame('pending', $notification->status);

        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'type' => 'email',
            'status' => 'pending',
        ]);
    });

    it('can create notification template with valid schema', function () {
        $template = NotificationTemplateFactory::new()->createOne([
            'name' => 'Welcome Email Template',
            'code' => 'welcome-email',
            'subject' => 'Benvenuto {{user_name}}',
            'body_html' => '<p>Benvenuto {{user_name}}</p>',
            'channels' => ['mail'],
            'variables' => ['user_name'],
            'is_active' => true,
        ]);

        Assert::assertInstanceOf(NotificationTemplate::class, $template);
        Assert::assertSame('Welcome Email Template', $template->name);
        Assert::assertTrue($template->is_active);

        \assertNotifyTableHas('notification_templates', [
            'id' => $template->id,
            'name' => 'Welcome Email Template',
            'code' => 'welcome-email',
            'is_active' => true,
        ]);
    });

    it('can create notification type with valid schema', function () {
        $type = NotificationTypeFactory::new()->createOne([
            'name' => 'welcome_email',
            'slug' => 'welcome-email',
            'description' => 'Email inviata ai nuovi utenti registrati',
            'category' => 'onboarding',
            'is_active' => true,
        ]);

        Assert::assertInstanceOf(NotificationType::class, $type);
        Assert::assertSame('welcome_email', $type->name);
        Assert::assertTrue($type->is_active);

        \assertNotifyTableHas('notification_types', [
            'id' => $type->id,
            'name' => 'welcome_email',
            'slug' => 'welcome-email',
            'is_active' => true,
        ]);
    });

    it('can create contact for notification delivery', function () {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '100',
            'contact_type' => 'email',
            'value' => 'mario.rossi@example.com',
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'email' => 'mario.rossi@example.com',
        ]);

        Assert::assertInstanceOf(Contact::class, $contact);
        Assert::assertSame('mario.rossi@example.com', $contact->value);

        \assertNotifyTableHas('contacts', [
            'id' => $contact->id,
            'contact_type' => 'email',
            'value' => 'mario.rossi@example.com',
        ]);
    });

    it('can track mail template log lifecycle', function () {
        $template = MailTemplateFactory::new()->createOne();
        $log = MailTemplateLogFactory::new()->createOne([
            'template_id' => $template->id,
            'status' => 'sent',
            'data' => ['recipient' => 'patient@example.com'],
            'metadata' => ['campaign_id' => 'welcome_001'],
            'sent_at' => now(),
        ]);

        Assert::assertInstanceOf(MailTemplateLog::class, $log);
        Assert::assertSame('sent', $log->status);
        Assert::assertSame('patient@example.com', \assertNotifyArray($log->data)['recipient']);
        Assert::assertSame('welcome_001', \assertNotifyArray($log->metadata)['campaign_id']);
    });

    it('can create mail template version snapshot', function () {
        $template = MailTemplateFactory::new()->createOne();
        $version = MailTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
            'subject' => 'Versione precedente',
            'html_template' => '<p>Snapshot</p>',
            'text_template' => 'Snapshot',
            'version' => 2,
            'change_notes' => 'Aggiornamento copy',
        ]);

        Assert::assertInstanceOf(MailTemplateVersion::class, $version);
        Assert::assertSame('Versione precedente', $version->subject);
        Assert::assertInstanceOf(MailTemplate::class, $version->template);
        Assert::assertSame($template->id, $version->template->id);
    });

    it('can update notification data payload', function () {
        $notification = NotificationFactory::new()->createOne([
            'type' => 'sms',
            'status' => 'pending',
            'data' => ['message' => 'Old message'],
        ]);

        $payload = ['message' => 'Updated message', 'locale' => 'it'];
        $notification->update(['data' => $payload, 'status' => 'sent', 'sent_at' => now()]);

        $fresh = \assertFreshModel($notification, Notification::class);
        $data = \assertNotifyArray(is_array($fresh->data) ? $fresh->data : null);

        Assert::assertSame('Updated message', $data['message']);
        Assert::assertSame('sent', $fresh->status);
        Assert::assertNotNull($fresh->sent_at);

        \assertNotifyTableHas('notifications', [
            'id' => $notification->id,
            'status' => 'sent',
        ]);
    });

    it('can store notification type channel configuration', function () {
        $channels = [
            'email' => ['enabled' => true],
            'sms' => ['enabled' => false],
        ];

        $type = NotificationTypeFactory::new()->createOne(['channels' => $channels]);

        \assertNotifyTableHas('notification_types', [
            'id' => $type->id,
            'channels' => json_encode($channels),
        ]);

        $stored = \assertNotifyArray(\assertFreshModel($type, NotificationType::class)->channels);
        Assert::assertTrue(\assertNotifyArray($stored['email'] ?? null)['enabled']);
        Assert::assertFalse(\assertNotifyArray($stored['sms'] ?? null)['enabled']);
    });
});
