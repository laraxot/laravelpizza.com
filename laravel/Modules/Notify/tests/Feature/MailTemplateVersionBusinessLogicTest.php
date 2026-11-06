<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailTemplateVersion;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use RuntimeException;

use function Safe\preg_match_all;

uses(\Modules\Notify\Tests\TestCase::class);
/*
 * Scopo: ogni modifica di un MailTemplate lascia una MailTemplateVersion (storico
 * versionato soft-deletable) da cui si puo' ripristinare il contenuto con restoreTemplate().
 *
 * Non portati dalla versione PHPUnit (vedi story phpstan-test-wave-notify-b): storico via
 * `$template->versions` (relazione assente), colonna `mailable` e versioni semver stringa
 * ('1.5.2') su colonna `version` integer. Il corpo originale resta in git.
 */
describe('Mail Template Version Business Logic', function (): void {
    test('can create mail template version with basic information', function (): void {
        $template = MailTemplate::factory()->create();
        $createdBy = 'admin@'.config()->string('app.domain', 'example.com');

        $version = MailTemplateVersion::create([
            'mail_template_id' => $template->id,
            'subject' => 'Conferma Appuntamento - Versione 2.0',
            'html_template' => '<h1>Conferma Appuntamento</h1><p>Gentile {{patient_name}}, il suo appuntamento e\' confermato per il {{appointment_date}}.</p>',
            'text_template' => 'Gentile {{patient_name}}, il suo appuntamento e\' confermato per il {{appointment_date}}.',
            'version' => 2,
            'created_by' => $createdBy,
            'change_notes' => 'Aggiornamento design email e aggiunta variabile appointment_date',
        ]);

        XotBasePest::assertTableHas('notify', 'mail_template_versions', [
            'id' => $version->id,
            'subject' => 'Conferma Appuntamento - Versione 2.0',
            'version' => 2,
            'created_by' => $createdBy,
        ]);

        Assert::assertSame(2, $version->version);
        Assert::assertStringContainsString('{{patient_name}}', $version->html_template);
        Assert::assertStringContainsString('{{appointment_date}}', XotBasePest::assertString($version->text_template));
    });

    test('can manage mail template version relationships', function (): void {
        $template = MailTemplate::factory()->create();
        $version = MailTemplateVersion::factory()->create(['mail_template_id' => $template->id]);

        Assert::assertInstanceOf(MailTemplate::class, $version->template);
        Assert::assertSame($template->id, $version->template->id);
    });

    test('can restore mail template content from version', function (): void {
        $template = MailTemplate::factory()->create([
            'subject' => 'Versione Corrente',
            'html_template' => '<p>Template corrente</p>',
            'text_template' => 'Template corrente',
        ]);
        $version = MailTemplateVersion::factory()->create([
            'mail_template_id' => $template->id,
            'subject' => 'Versione Precedente',
            'html_template' => '<p>Template versione precedente</p>',
            'text_template' => 'Template versione precedente',
            'version' => 1,
        ]);

        $template->update([
            'subject' => 'Versione Aggiornata',
            'html_template' => '<p>Template aggiornato</p>',
            'text_template' => 'Template aggiornato',
        ]);

        $restored = $version->restoreTemplate();

        Assert::assertSame('Versione Precedente', $restored->subject);
        Assert::assertSame('<p>Template versione precedente</p>', $restored->html_template);
        Assert::assertSame('Template versione precedente', $restored->text_template);
    });

    test('throws exception when restoring without template', function (): void {
        $version = MailTemplateVersion::factory()->create([
            'mail_template_id' => 99999,
            'html_template' => '<p>orfana</p>',
            'version' => 1,
        ]);

        expect(fn (): MailTemplate => $version->restoreTemplate())
            ->toThrow(RuntimeException::class, 'Template non trovato per questa versione');
    });

    test('can store metadata and tracking on mail template version', function (): void {
        $template = MailTemplate::factory()->create();
        $createdBy = 'developer@'.config()->string('app.domain', 'example.com');

        $version = MailTemplateVersion::factory()->create([
            'mail_template_id' => $template->id,
            'version' => 3,
            'created_by' => $createdBy,
            'metadata' => ['author' => 'admin@example.com', 'review_status' => 'approved'],
            'change_notes' => 'Correzione bug nella formattazione HTML e ottimizzazione per mobile',
            'html_template' => '<p>v3</p>',
        ]);

        $fresh = XotBasePest::assertFreshModel($version, MailTemplateVersion::class);
        Assert::assertSame(3, $fresh->version);
        Assert::assertSame($createdBy, $fresh->created_by);
        Assert::assertSame('approved', XotBasePest::assertArray($fresh->metadata)['review_status']);
        Assert::assertNotNull($fresh->created_at);
        Assert::assertNotNull($fresh->updated_at);
    });

    test('can handle html and text templates with many variables', function (): void {
        $template = MailTemplate::factory()->create();
        $html = '<html lang="it"><head><title>{{subject}}</title><style>.header { background-color: #001F3F; }</style></head>'
            .'<body><h1>{{clinic_name}}</h1><p>Gentile {{patient_name}},</p><li>{{appointment_date}} {{doctor_name}}</li></body></html>';
        $text = "Gentile {{patient_name}},\nData: {{appointment_date}}\nDottore: {{doctor_name}}\nStudio: {{clinic_name}}\nArrivare 15 minuti prima";

        $version = MailTemplateVersion::factory()->create([
            'mail_template_id' => $template->id,
            'html_template' => $html,
            'text_template' => $text,
            'version' => 4,
        ]);

        foreach (['{{clinic_name}}', '{{patient_name}}', '{{appointment_date}}', '{{doctor_name}}', 'background-color: #001F3F'] as $needle) {
            Assert::assertStringContainsString($needle, $version->html_template);
        }
        $storedText = XotBasePest::assertString($version->text_template);
        foreach (['{{patient_name}}', '{{appointment_date}}', '{{doctor_name}}', '{{clinic_name}}', 'Arrivare 15 minuti prima'] as $needle) {
            Assert::assertStringContainsString($needle, $storedText);
        }
    });

    test('keeps template variables consistent between html and text', function (): void {
        $template = MailTemplate::factory()->create();
        $html = '<p>Gentile {{patient_name}}, appuntamento il {{appointment_date}} con {{doctor_name}}.</p>';
        $text = 'Gentile {{patient_name}}, appuntamento il {{appointment_date}} con {{doctor_name}}.';

        MailTemplateVersion::factory()->create([
            'mail_template_id' => $template->id,
            'html_template' => $html,
            'text_template' => $text,
            'version' => 1,
        ]);

        preg_match_all('/\{\{([^}]+)\}\}/', $html, $htmlMatches);
        preg_match_all('/\{\{([^}]+)\}\}/', $text, $textMatches);
        $htmlVariables = array_unique($htmlMatches[1]);

        Assert::assertEquals($htmlVariables, array_unique($textMatches[1]));
        Assert::assertContains('patient_name', $htmlVariables);
        Assert::assertContains('appointment_date', $htmlVariables);
        Assert::assertContains('doctor_name', $htmlVariables);
    });

    test('can soft delete and restore a version', function (): void {
        $template = MailTemplate::factory()->create();
        $version = MailTemplateVersion::factory()->create([
            'mail_template_id' => $template->id,
            'html_template' => '<p>soft</p>',
            'version' => 1,
        ]);

        Assert::assertFalse($version->trashed());

        $version->delete();
        Assert::assertTrue($version->trashed());
        XotBasePest::assertTableHas('notify', 'mail_template_versions', ['id' => $version->id]);

        $version->restore();
        Assert::assertFalse($version->trashed());
    });

    test('handles nullable fields gracefully', function (): void {
        $template = MailTemplate::factory()->create();

        $version = MailTemplateVersion::factory()->create([
            'mail_template_id' => $template->id,
            'subject' => null,
            'text_template' => null,
            'change_notes' => null,
            'html_template' => '<p>campo obbligatorio</p>',
            'version' => 1,
        ]);

        Assert::assertNull($version->subject);
        Assert::assertNull($version->text_template);
        Assert::assertNull($version->change_notes);
        Assert::assertSame('<p>campo obbligatorio</p>', $version->html_template);
    });
});