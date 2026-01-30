<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotificationTemplateVersion;
use RuntimeException;
use Tests\TestCase;

class NotificationTemplateVersionBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_template_version_with_basic_information(): void
    {
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

        $this->assertEquals('2.0', $version->version);
        $this->assertEquals(['email', 'sms'], $version->channels);
        $this->assertEquals(['patient_name', 'appointment_date', 'doctor_name'], $version->variables);
        $this->assertEquals(['is_confirmed' => true], $version->conditions);
    }

    /** @test */
    public function it_can_manage_template_version_relationships(): void
    {
        $template = NotificationTemplate::factory()->create();
        $version = NotificationTemplateVersion::factory()->create([
            'template_id' => $template->id,
        ]);

        $this->assertInstanceOf(NotificationTemplate::class, $version->template);
        $this->assertEquals($template->id, $version->template->id);
    }

    /** @test */
    public function it_can_restore_template_from_version(): void
    {
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

        $this->assertEquals('Versione Precedente', $restoredTemplate->subject);
        $this->assertEquals('<p>Contenuto versione precedente</p>', $restoredTemplate->body_html);
        $this->assertEquals('Contenuto versione precedente', $restoredTemplate->body_text);
        $this->assertEquals(['email'], $restoredTemplate->channels);
        $this->assertEquals(['patient_name'], $restoredTemplate->variables);
        $this->assertEquals(['is_active' => true], $restoredTemplate->conditions);
    }

    /** @test */
    public function it_throws_exception_when_restoring_without_template(): void
    {
        $version = NotificationTemplateVersion::factory()->create([
            'template_id' => 99999, // Template inesistente
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Template not found for version '.$version->id);

        $version->restore();
    }

    /** @test */
    public function it_can_manage_version_metadata(): void
    {
        $template = NotificationTemplate::factory()->create();

        $version = NotificationTemplateVersion::factory()->create([
            'template_id' => $template->id,
            'version' => '1.5',
            'change_notes' => 'Correzione bug nella formattazione email',
        ]);

        $this->assertEquals('1.5', $version->version);
        $this->assertEquals('Correzione bug nella formattazione email', $version->change_notes);
    }

    /** @test */
    public function it_can_handle_complex_channel_configurations(): void
    {
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

        $this->assertEquals($complexChannels, $version->channels);
        $this->assertTrue($version->channels['email']['enabled']);
        $this->assertFalse($version->channels['push']['enabled']);
    }

    /** @test */
    public function it_can_manage_conditional_logic(): void
    {
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

        $this->assertEquals($conditions, $version->conditions);
        $this->assertContains('patient', $version->conditions['user_type']);
        $this->assertEquals('confirmed', $version->conditions['appointment_status']);
    }

    /** @test */
    public function it_can_handle_template_variables_validation(): void
    {
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

        $this->assertEquals($variables, $version->variables);
        $this->assertContains('patient_name', $version->variables['required']);
        $this->assertEquals('d/m/Y H:i', $version->variables['formatting']['date_format']);
    }

    /** @test */
    public function it_can_manage_version_history(): void
    {
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

        $this->assertCount(3, $template->versions);
        $this->assertEquals('1.0', $version1->version);
        $this->assertEquals('1.1', $version2->version);
        $this->assertEquals('2.0', $version3->version);
    }

    /** @test */
    public function it_can_handle_version_rollback_scenarios(): void
    {
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

        $this->assertEquals('Versione Stabile', $restoredTemplate->subject);
        $this->assertEquals('<p>Contenuto stabile</p>', $restoredTemplate->body_html);
        $this->assertEquals('Contenuto stabile', $restoredTemplate->body_text);
        $this->assertEquals(['email'], $restoredTemplate->channels);
        $this->assertEquals(['patient_name'], $restoredTemplate->variables);
        $this->assertEquals(['is_active' => true], $restoredTemplate->conditions);
    }

    /** @test */
    public function it_can_manage_version_metadata_and_tracking(): void
    {
        $template = NotificationTemplate::factory()->create();

        $version = NotificationTemplateVersion::factory()->create([
            'template_id' => $template->id,
            'version' => '1.2.3',
            'change_notes' => 'Hotfix per problema di formattazione SMS',
        ]);

        // Verifica che i metadati siano preservati
        $this->assertEquals('1.2.3', $version->version);
        $this->assertEquals('Hotfix per problema di formattazione SMS', $version->change_notes);
        $this->assertNotNull($version->created_at);
        $this->assertNotNull($version->updated_at);
    }

    /** @test */
    public function it_can_handle_empty_or_null_values_gracefully(): void
    {
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

        $this->assertNull($version->subject);
        $this->assertNull($version->body_html);
        $this->assertNull($version->body_text);
        $this->assertNull($version->channels);
        $this->assertNull($version->variables);
        $this->assertNull($version->conditions);
        $this->assertNull($version->change_notes);
    }
}
