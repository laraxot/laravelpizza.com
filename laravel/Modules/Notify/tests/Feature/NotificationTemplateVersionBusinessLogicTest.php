<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotificationTemplateVersion;
use Modules\Notify\Tests\TestCase;
use RuntimeException;

uses(TestCase::class);

it('can create template version with basic information', function (): void {
    $template = NotificationTemplate::factory()->create();

    $versionData = [
        'template_id' => $template->id,
        'subject' => 'Versione 2.0 - Conferma Appuntamento',
        'body_html' => '<h1>Conferma Appuntamento</h1><p>Gentile {{patient_name}}, il suo appuntamento è confermato.</p>',
        'body_text' => 'Conferma Appuntamento\n\nGentile {{patient_name}}, il suo appuntamento è confermato.',
        'channels' => ['email', 'sms'],
        'variables' => ['patient_name', 'appointment_date', 'doctor_name'],
        'conditions' => ['is_confirmed' => true],
        'version' => '2.0',
        'change_notes' => 'Aggiornamento design e aggiunta variabile doctor_name',
    ];

    $version = NotificationTemplateVersion::create($versionData);

    $this->assertDatabaseHas('notification_template_versions', [
        'id' => $version->id,
        'template_id' => $template->id,
        'subject' => 'Versione 2.0 - Conferma Appuntamento',
        'version' => '2.0',
        'change_notes' => 'Aggiornamento design e aggiunta variabile doctor_name',
    ]);

    expect($version->version)->toBe('2.0');
    expect($version->channels)->toBe(['email', 'sms']);
    expect($version->variables)->toBe(['patient_name', 'appointment_date', 'doctor_name']);
    expect($version->conditions)->toBe(['is_confirmed' => true]);
});

it('can manage template version relationships', function (): void {
    $template = NotificationTemplate::factory()->create();
    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
    ]);

    expect($version->template)->toBeInstanceOf(NotificationTemplate::class);
    expect($version->template->id)->toBe($template->id);
});

it('can restore template from version', function (): void {
    $template = NotificationTemplate::factory()->create([
        'subject' => 'Versione Originale',
        'body_html' => '<p>Contenuto originale</p>',
    ]);

    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'subject' => 'Versione Precedente',
        'body_html' => '<p>Contenuto versione precedente</p>',
        'body_text' => 'Contenuto versione precedente',
        'channels' => ['email'],
        'variables' => ['patient_name'],
        'conditions' => ['is_active' => true],
    ]);

    // Aggiorna il template corrente
    $template->update([
        'subject' => 'Versione Corrente',
        'body_html' => '<p>Contenuto corrente</p>',
    ]);

    // Restaura dalla versione
    $restoredTemplate = $version->restore();

    expect($restoredTemplate->subject)->toBe('Versione Precedente');
    expect($restoredTemplate->body_html)->toBe('<p>Contenuto versione precedente</p>');
    expect($restoredTemplate->body_text)->toBe('Contenuto versione precedente');
    expect($restoredTemplate->channels)->toBe(['email']);
    expect($restoredTemplate->variables)->toBe(['patient_name']);
    expect($restoredTemplate->conditions)->toBe(['is_active' => true]);
});

it('throws exception when restoring without template', function (): void {
    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => 99999, // Template inesistente
    ]);

    expect(fn () => $version->restore())
        ->toThrow(RuntimeException::class, 'Template not found for version '.$version->id);
});

it('can manage version metadata', function (): void {
    $template = NotificationTemplate::factory()->create();

    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.5',
        'change_notes' => 'Correzione bug nella formattazione email',
    ]);

    expect($version->version)->toBe('1.5');
    expect($version->change_notes)->toBe('Correzione bug nella formattazione email');
});

it('can handle complex channel configurations', function (): void {
    $template = NotificationTemplate::factory()->create();

    $complexChannels = [
        'email' => [
            'enabled' => true,
            'priority' => 'high',
            'template' => 'email.confirmation',
        ],
        'sms' => [
            'enabled' => true,
            'priority' => 'normal',
            'max_length' => 160,
        ],
        'push' => [
            'enabled' => false,
            'priority' => 'low',
        ],
    ];

    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'channels' => $complexChannels,
    ]);

    expect($version->channels)->toBe($complexChannels);
    expect($version->channels['email']['enabled'])->toBeTrue();
    expect($version->channels['push']['enabled'])->toBeFalse();
});

it('can manage conditional logic', function (): void {
    $template = NotificationTemplate::factory()->create();

    $conditions = [
        'user_type' => ['patient', 'doctor'],
        'appointment_status' => 'confirmed',
        'notification_preference' => 'all',
        'time_zone' => 'Europe/Rome',
        'language' => ['it', 'en'],
    ];

    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'conditions' => $conditions,
    ]);

    expect($version->conditions)->toBe($conditions);
    expect($version->conditions['user_type'])->toContain('patient');
    expect($version->conditions['appointment_status'])->toBe('confirmed');
});

it('can handle template variables validation', function (): void {
    $template = NotificationTemplate::factory()->create();

    $variables = [
        'required' => ['patient_name', 'appointment_date', 'doctor_name'],
        'optional' => ['clinic_address', 'phone_number'],
        'conditional' => ['emergency_contact', 'insurance_info'],
        'formatting' => [
            'date_format' => 'd/m/Y H:i',
            'currency' => 'EUR',
            'timezone' => 'Europe/Rome',
        ],
    ];

    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'variables' => $variables,
    ]);

    expect($version->variables)->toBe($variables);
    expect($version->variables['required'])->toContain('patient_name');
    expect($version->variables['formatting']['date_format'])->toBe('d/m/Y H:i');
});

it('can manage version history', function (): void {
    $template = NotificationTemplate::factory()->create();

    // Crea multiple versioni
    $version1 = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.0',
        'change_notes' => 'Versione iniziale',
    ]);

    $version2 = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.1',
        'change_notes' => 'Aggiunta variabile clinic_address',
    ]);

    $version3 = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '2.0',
        'change_notes' => 'Rifattorizzazione completa del template',
    ]);

    expect($template->versions)->toHaveCount(3);
    expect($version1->version)->toBe('1.0');
    expect($version2->version)->toBe('1.1');
    expect($version3->version)->toBe('2.0');
});

it('can handle version rollback scenarios', function (): void {
    $template = NotificationTemplate::factory()->create([
        'subject' => 'Versione Corrente',
        'body_html' => '<p>Contenuto corrente</p>',
    ]);

    $stableVersion = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.0',
        'subject' => 'Versione Stabile',
        'body_html' => '<p>Contenuto stabile</p>',
        'body_text' => 'Contenuto stabile',
        'channels' => ['email'],
        'variables' => ['patient_name'],
        'conditions' => ['is_active' => true],
    ]);

    // Simula un aggiornamento problematico
    $template->update([
        'subject' => 'Versione Problematica',
        'body_html' => '<p>Contenuto con bug</p>',
    ]);

    // Rollback alla versione stabile
    $restoredTemplate = $stableVersion->restore();

    expect($restoredTemplate->subject)->toBe('Versione Stabile');
    expect($restoredTemplate->body_html)->toBe('<p>Contenuto stabile</p>');
    expect($restoredTemplate->body_text)->toBe('Contenuto stabile');
    expect($restoredTemplate->channels)->toBe(['email']);
    expect($restoredTemplate->variables)->toBe(['patient_name']);
    expect($restoredTemplate->conditions)->toBe(['is_active' => true]);
});

it('can manage version metadata and tracking', function (): void {
    $template = NotificationTemplate::factory()->create();

    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'version' => '1.2.3',
        'change_notes' => 'Hotfix per problema di formattazione SMS',
    ]);

    // Verifica che i metadati siano preservati
    expect($version->version)->toBe('1.2.3');
    expect($version->change_notes)->toBe('Hotfix per problema di formattazione SMS');
    expect($version->created_at)->not->toBeNull();
    expect($version->updated_at)->not->toBeNull();
});

it('can handle empty or null values gracefully', function (): void {
    $template = NotificationTemplate::factory()->create();

    $version = NotificationTemplateVersion::factory()->create([
        'template_id' => $template->id,
        'subject' => null,
        'body_html' => null,
        'body_text' => null,
        'channels' => null,
        'variables' => null,
        'conditions' => null,
        'change_notes' => null,
    ]);

    expect($version->subject)->toBeNull();
    expect($version->body_html)->toBeNull();
    expect($version->body_text)->toBeNull();
    expect($version->channels)->toBeNull();
    expect($version->variables)->toBeNull();
    expect($version->conditions)->toBeNull();
    expect($version->change_notes)->toBeNull();
});
