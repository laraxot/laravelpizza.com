<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailTemplateVersion;
use Modules\Notify\Tests\TestCase;
use RuntimeException;

uses(TestCase::class);

it('can create mail template version with basic information', function (): void {
    $template = MailTemplate::factory()->create();

    $versionData = [
        'template_id' => $template->id,
        'mailable' => 'AppointmentConfirmation',
        'subject' => 'Conferma Appuntamento - Versione 2.0',
        'html_template' => '<!DOCTYPE html><html><body><h1>Conferma Appuntamento</h1><p>Gentile {{patient_name}}, il suo appuntamento è confermato per il {{appointment_date}}.</p></body></html>',
        'text_template' => 'Conferma Appuntamento\n\nGentile {{patient_name}}, il suo appuntamento è confermato per il {{appointment_date}}.',
        'version' => '2.0',
        'created_by' => 'admin@'.config('app.domain', 'example.com'),
        'change_notes' => 'Aggiornamento design email e aggiunta variabile appointment_date',
    ];

    $version = MailTemplateVersion::create($versionData);

    $this->assertDatabaseHas('mail_template_versions', [
        'id' => $version->id,
        'template_id' => $template->id,
        'mailable' => 'AppointmentConfirmation',
        'subject' => 'Conferma Appuntamento - Versione 2.0',
        'version' => '2.0',
        'created_by' => 'admin@'.config('app.domain', 'example.com'),
        'change_notes' => 'Aggiornamento design email e aggiunta variabile appointment_date',
    ]);

    expect($version->version)->toBe('2.0');
    expect($version->mailable)->toBe('AppointmentConfirmation');
    expect($version->html_template)->toContain('{{patient_name}}');
    expect($version->text_template)->toContain('{{appointment_date}}');
});

it('can manage mail template version relationships', function (): void {
    $template = MailTemplate::factory()->create();
    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
    ]);

    expect($version->template)->toBeInstanceOf(MailTemplate::class);
    expect($version->template->id)->toBe($template->id);
});

it('can restore mail template from version', function (): void {
    $template = MailTemplate::factory()->create([
        'subject' => 'Versione Corrente',
        'html_template' => '<p>Template corrente</p>',
        'text_template' => 'Template corrente',
    ]);

    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'subject' => 'Versione Precedente',
        'html_template' => '<p>Template versione precedente</p>',
        'text_template' => 'Template versione precedente',
    ]);

    // Aggiorna il template corrente
    $template->update([
        'subject' => 'Versione Aggiornata',
        'html_template' => '<p>Template aggiornato</p>',
        'text_template' => 'Template aggiornato',
    ]);

    // Restaura dalla versione
    $restoredTemplate = $version->restore();

    expect($restoredTemplate->subject)->toBe('Versione Precedente');
    expect($restoredTemplate->html_template)->toBe('<p>Template versione precedente</p>');
    expect($restoredTemplate->text_template)->toBe('Template versione precedente');
});

it('throws exception when restoring without template', function (): void {
    $version = MailTemplateVersion::factory()->create([
        'template_id' => 99999, // Template inesistente
    ]);

    expect(fn () => $version->restore())
        ->toThrow(RuntimeException::class, 'Template non trovato per questa versione');
});

it('can manage version metadata and tracking', function (): void {
    $template = MailTemplate::factory()->create();

    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.5.2',
        'created_by' => 'developer@'.config('app.domain', 'example.com'),
        'change_notes' => 'Correzione bug nella formattazione HTML e ottimizzazione per mobile',
    ]);

    expect($version->version)->toBe('1.5.2');
    expect($version->created_by)->toBe('developer@'.config('app.domain', 'example.com'));
    expect($version->change_notes)->toBe('Correzione bug nella formattazione HTML e ottimizzazione per mobile');
    expect($version->created_at)->not->toBeNull();
    expect($version->updated_at)->not->toBeNull();
});

it('can handle complex html templates', function (): void {
    $template = MailTemplate::factory()->create();

    $complexHtmlTemplate = '
    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{subject}}</title>
        <style>
            .header { background-color: #001F3F; color: white; padding: 20px; }
            .content { padding: 20px; }
            .footer { background-color: #f8f9fa; padding: 15px; text-align: center; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>{{clinic_name}}</h1>
        </div>
        <div class="content">
            <h2>{{subject}}</h2>
            <p>Gentile {{patient_name}},</p>
            <p>{{message}}</p>
            <ul>
                <li><strong>Data:</strong> {{appointment_date}}</li>
                <li><strong>Ora:</strong> {{appointment_time}}</li>
                <li><strong>Dottore:</strong> {{doctor_name}}</li>
            </ul>
        </div>
        <div class="footer">
            <p>&copy; {{current_year}} {{clinic_name}}. Tutti i diritti riservati.</p>
        </div>
    </body>
    </html>';

    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'html_template' => $complexHtmlTemplate,
        'version' => '3.0',
    ]);

    expect($version->html_template)->toContain('{{clinic_name}}');
    expect($version->html_template)->toContain('{{patient_name}}');
    expect($version->html_template)->toContain('{{appointment_date}}');
    expect($version->html_template)->toContain('{{doctor_name}}');
    expect($version->html_template)->toContain('background-color: #001F3F');
});

it('can handle text template variants', function (): void {
    $template = MailTemplate::factory()->create();

    $textTemplate = '
    CONFERMA APPUNTAMENTO
    =====================
    
    Gentile {{patient_name}},
    
    Il suo appuntamento è confermato per:
    
    Data: {{appointment_date}}
    Ora: {{appointment_time}}
    Dottore: {{doctor_name}}
    Studio: {{clinic_name}}
    Indirizzo: {{clinic_address}}
    
    IMPORTANTE:
    - Arrivare 15 minuti prima dell\'appuntamento
    - Portare documenti di identità
    - In caso di cancellazione, avvisare almeno 24h prima
    
    Per modifiche o cancellazioni:
    Telefono: {{clinic_phone}}
    Email: {{clinic_email}}
    
    Cordiali saluti,
    {{clinic_name}}
    ';

    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'text_template' => $textTemplate,
        'version' => '2.1',
    ]);

    expect($version->text_template)->toContain('{{patient_name}}');
    expect($version->text_template)->toContain('{{appointment_date}}');
    expect($version->text_template)->toContain('{{doctor_name}}');
    expect($version->text_template)->toContain('{{clinic_name}}');
    expect($version->text_template)->toContain('Arrivare 15 minuti prima');
});

it('can manage version history and rollback', function (): void {
    $template = MailTemplate::factory()->create([
        'subject' => 'Versione Corrente',
        'html_template' => '<p>Template corrente</p>',
        'text_template' => 'Template corrente',
    ]);

    // Crea multiple versioni
    $version1 = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.0',
        'subject' => 'Versione Iniziale',
        'html_template' => '<p>Template iniziale</p>',
        'text_template' => 'Template iniziale',
        'change_notes' => 'Prima versione del template',
    ]);

    $version2 = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.1',
        'subject' => 'Versione 1.1',
        'html_template' => '<p>Template versione 1.1</p>',
        'text_template' => 'Template versione 1.1',
        'change_notes' => 'Aggiunta variabile clinic_address',
    ]);

    $version3 = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '2.0',
        'subject' => 'Versione 2.0',
        'html_template' => '<p>Template versione 2.0</p>',
        'text_template' => 'Template versione 2.0',
        'change_notes' => 'Rifattorizzazione completa del template',
    ]);

    expect($template->versions)->toHaveCount(3);
    expect($version1->version)->toBe('1.0');
    expect($version2->version)->toBe('1.1');
    expect($version3->version)->toBe('2.0');

    // Test rollback alla versione 1.1
    $restoredTemplate = $version2->restore();
    expect($restoredTemplate->subject)->toBe('Versione 1.1');
    expect($restoredTemplate->html_template)->toBe('<p>Template versione 1.1</p>');
    expect($restoredTemplate->text_template)->toBe('Template versione 1.1');
});

it('can handle mailable class management', function (): void {
    $template = MailTemplate::factory()->create();

    $mailableClasses = [
        'AppointmentConfirmation',
        'AppointmentReminder',
        'AppointmentCancellation',
        'PatientRegistration',
        'PasswordReset',
        'NewsletterSubscription',
    ];

    foreach ($mailableClasses as $index => $mailableClass) {
        $version = MailTemplateVersion::factory()->create([
            'template_id' => $template->id,
            'mailable' => $mailableClass,
            'version' => '1.'.$index,
            'subject' => 'Template per '.$mailableClass,
            'html_template' => '<p>Template per '.$mailableClass.'</p>',
        ]);

        expect($version->mailable)->toBe($mailableClass);
        expect($version->subject)->toBe('Template per '.$mailableClass);
    }
});

it('can manage soft deletes', function (): void {
    $template = MailTemplate::factory()->create();
    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
    ]);

    // Verifica che il modello supporti soft delete
    expect($version->trashed())->toBeFalse();

    // Soft delete
    $version->delete();

    expect($version->trashed())->toBeTrue();
    $this->assertDatabaseHas('mail_template_versions', [
        'id' => $version->id,
        'deleted_at' => $version->deleted_at,
    ]);

    // Restore
    $version->restore();
    expect($version->trashed())->toBeFalse();
});

it('can handle empty or null values gracefully', function (): void {
    $template = MailTemplate::factory()->create();

    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'subject' => null,
        'text_template' => null,
        'change_notes' => null,
    ]);

    expect($version->subject)->toBeNull();
    expect($version->text_template)->toBeNull();
    expect($version->change_notes)->toBeNull();
    expect($version->html_template)->not->toBeNull(); // Campo obbligatorio
    expect($version->version)->not->toBeNull(); // Campo obbligatorio
});

it('can validate template variable consistency', function (): void {
    $template = MailTemplate::factory()->create();

    $htmlTemplate = '<p>Gentile {{patient_name}}, il suo appuntamento è confermato per il {{appointment_date}} con il dottore {{doctor_name}}.</p>';
    $textTemplate = 'Gentile {{patient_name}}, il suo appuntamento è confermato per il {{appointment_date}} con il dottore {{doctor_name}}.';

    $version = MailTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'html_template' => $htmlTemplate,
        'text_template' => $textTemplate,
        'version' => '1.0',
    ]);

    // Verifica che le variabili siano consistenti tra HTML e testo
    $extractVariables = function (string $template): array {
        preg_match_all('/\{\{([^}]+)\}\}/', $template, $matches);

        return array_unique($matches[1] ?? []);
    };

    $htmlVariables = $extractVariables($htmlTemplate);
    $textVariables = $extractVariables($textTemplate);

    expect($htmlVariables)->toBe($textVariables);
    expect($htmlVariables)->toContain('patient_name');
    expect($htmlVariables)->toContain('appointment_date');
    expect($htmlVariables)->toContain('doctor_name');
});

it('can manage version numbering schemes', function (): void {
    $template = MailTemplate::factory()->create();

    $versionSchemes = [
        '1.0' => 'Versione iniziale',
        '1.1' => 'Correzione bug minori',
        '1.2.1' => 'Hotfix critico',
        '2.0' => 'Rifattorizzazione completa',
        '2.1.3' => 'Aggiornamento sicurezza',
        '3.0.0' => 'Nuova versione major',
    ];

    foreach ($versionSchemes as $versionNumber => $description) {
        $version = MailTemplateVersion::factory()->create([
            'template_id' => $template->id,
            'version' => $versionNumber,
            'change_notes' => $description,
        ]);

        expect($version->version)->toBe($versionNumber);
        expect($version->change_notes)->toBe($description);
    }
});
