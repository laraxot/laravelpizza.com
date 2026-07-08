<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Database\Factories\NotificationTemplateFactory;
use Modules\Notify\Database\Factories\NotificationTemplateVersionFactory;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use RuntimeException;

uses(TestCase::class);

describe('Notification Template Version Business Logic', function (): void {
    test('_can_create_template_version_with_basic_information', function (): void {
        /** @var TestCase $this */
        $template = NotificationTemplateFactory::new()->createOne();

        $version = NotificationTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
            'subject' => 'Versione 2 - Conferma Appuntamento',
            'body_html' => '<p>Gentile {{patient_name}}</p>',
            'body_text' => 'Gentile {{patient_name}}',
            'channels' => ['mail'],
            'variables' => ['patient_name', 'appointment_date'],
            'conditions' => ['is_confirmed' => true],
            'version' => 2,
            'change_notes' => 'Aggiornamento copy',
        ]);
        \assertNotifyTableHas('notification_template_versions', [
            'id' => $version->id,
            'template_id' => $template->id,
            'subject' => 'Versione 2 - Conferma Appuntamento',
            'version' => 2,
        ]);

        Assert::assertSame(2, $version->version);
        Assert::assertSame(['mail'], $version->channels);
        Assert::assertSame(['patient_name', 'appointment_date'], $version->variables);
        Assert::assertSame(['is_confirmed' => true], $version->conditions);
    });

    test('_can_manage_template_version_relationships', function (): void {
        $template = NotificationTemplateFactory::new()->createOne();
        $version = NotificationTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
        ]);

        Assert::assertInstanceOf(NotificationTemplate::class, $version->template);
        Assert::assertSame($template->id, $version->template->id);
    });

    test('_can_restore_template_from_version', function (): void {
        $template = NotificationTemplateFactory::new()->createOne([
            'subject' => 'Versione Originale',
            'body_html' => '<p>Contenuto originale</p>',
        ]);

        $version = NotificationTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
            'subject' => 'Versione Precedente',
            'body_html' => '<p>Contenuto versione precedente</p>',
            'body_text' => 'Contenuto versione precedente',
            'channels' => ['mail'],
            'variables' => ['patient_name'],
            'conditions' => ['is_active' => true],
            'version' => 1,
        ]);

        $template->update([
            'subject' => 'Versione Corrente',
            'body_html' => '<p>Contenuto corrente</p>',
        ]);

        $restoredTemplate = $version->restoreTemplate();

        Assert::assertSame('Versione Precedente', $restoredTemplate->subject);
        Assert::assertSame('<p>Contenuto versione precedente</p>', $restoredTemplate->body_html);
        Assert::assertSame('Contenuto versione precedente', $restoredTemplate->body_text);
        Assert::assertSame(['mail'], $restoredTemplate->channels);
        Assert::assertSame(['patient_name'], $restoredTemplate->variables);
        Assert::assertSame(['is_active' => true], $restoredTemplate->conditions);
    });

    test('_throws_exception_when_restoring_without_template', function (): void {
        /** @var TestCase $this */
        $version = NotificationTemplateVersionFactory::new()->createOne([
            'template_id' => 999999,
        ]);
        $this->expectApplicationException(RuntimeException::class);
        $version->restoreTemplate();
    });
});
