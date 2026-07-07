<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Database\Factories\MailTemplateFactory;
use Modules\Notify\Database\Factories\MailTemplateVersionFactory;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailTemplateVersion;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Mail Template Version Business Logic', function (): void {
    test('_can_create_mail_template_version_with_basic_information', function (): void {
$template = MailTemplateFactory::new()->createOne();

        $version = MailTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
            'subject' => 'Conferma Appuntamento - Versione 2',
            'html_template' => '<p>Gentile {{patient_name}}</p>',
            'text_template' => 'Gentile {{patient_name}}',
            'version' => 2,
            'change_notes' => 'Aggiornamento copy',
        ]);
        \assertNotifyTableHas('mail_template_versions', [
            'id' => $version->id,
            'subject' => 'Conferma Appuntamento - Versione 2',
            'version' => 2,
        ]);

        Assert::assertSame(2, $version->version);
        Assert::assertStringContainsString('{{patient_name}}', $version->html_template);
        Assert::assertSame('Aggiornamento copy', $version->change_notes);
    });

    test('_can_manage_mail_template_version_relationships', function (): void {
$template = MailTemplateFactory::new()->createOne();
        $version = MailTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
        ]);

        Assert::assertInstanceOf(MailTemplate::class, $version->template);
        Assert::assertSame($template->id, $version->template->id);
    });

    test('_can_store_metadata_on_mail_template_version', function (): void {
$template = MailTemplateFactory::new()->createOne();
        $metadata = [
            'author' => 'admin@example.com',
            'review_status' => 'approved',
        ];

        $version = MailTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
            'metadata' => $metadata,
            'version' => 1,
            'html_template' => '<p>v1</p>',
        ]);

        $fresh = $version->fresh();
        Assert::assertInstanceOf(MailTemplateVersion::class, $fresh);
        Assert::assertSame('approved', \assertNotifyArray($fresh->metadata)['review_status']);
    });

    test('_can_update_template_content_from_version_fields', function (): void {
$template = MailTemplateFactory::new()->createOne([
            'subject' => 'Versione Corrente',
            'html_template' => '<p>Template corrente</p>',
            'text_template' => 'Template corrente',
        ]);

        $version = MailTemplateVersionFactory::new()->createOne([
            'template_id' => $template->id,
            'subject' => 'Versione Precedente',
            'html_template' => '<p>Template versione precedente</p>',
            'text_template' => 'Template versione precedente',
            'version' => 1,
        ]);

        $template->update([
            'subject' => $version->subject,
            'html_template' => $version->html_template,
            'text_template' => $version->text_template,
        ]);

        $freshTemplate = \assertFreshModel($template, \Modules\Notify\Models\MailTemplate::class);
        Assert::assertInstanceOf(MailTemplate::class, $freshTemplate);
        Assert::assertSame('Versione Precedente', $freshTemplate->subject);
        Assert::assertSame('<p>Template versione precedente</p>', $freshTemplate->html_template);
    });
});
