<?php

declare(strict_types=1);

use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\EmailTemplate;
use Modules\Notify\Models\Theme;
use Modules\Notify\Helpers\ConfigHelper;

describe('Template Management Business Logic', function () {
    it('can create email template with basic information', function () {
        $templateData = [
            'name' => 'Appointment Confirmation',
            'subject' => 'Conferma Appuntamento - {{appointment_date}}',
            'content' => 'Gentile {{patient_name}}, il suo appuntamento è confermato per il {{appointment_date}}.',
            'variables' => ['patient_name', 'appointment_date', 'doctor_name'],
            'is_active' => true,
        ];

        $template = EmailTemplate::create($templateData);

        expect($template->name)->toBe('Appointment Confirmation')
            ->and($template->subject)->toBe('Conferma Appuntamento - {{appointment_date}}')
            ->and($template->is_active)->toBeTrue();

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'name' => 'Appointment Confirmation',
            'subject' => 'Conferma Appuntamento - {{appointment_date}}',
            'is_active' => true,
        ]);
    });

    it('can create theme for templates', function () {
        $testData = ConfigHelper::getTestData();
        $themeData = [
            'name' => $testData['theme_name'] ?? (config('app.name', 'Our Platform') . ' Default'),
            'description' => $testData['theme_description'] ?? ('Tema predefinito per ' . config('app.name', 'Our Platform')),
            'colors' => [
                'primary' => '#001F3F',
                'secondary' => '#3B82F6',
                'accent' => '#F59E0B',
            ],
            'fonts' => [
                'heading' => 'Segoe UI, Arial, sans-serif',
                'body' => 'Georgia, serif',
            ],
            'is_active' => true,
        ];

        $theme = Theme::create($themeData);

        expect($theme->name)->toBe($themeData['name'])
            ->and($theme->colors['primary'])->toBe('#001F3F')
            ->and($theme->fonts['heading'])->toBe('Segoe UI, Arial, sans-serif')
            ->and($theme->is_active)->toBeTrue();

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'name' => $themeData['name'],
            'description' => $themeData['description'],
            'is_active' => true,
        ]);
    });

    it('can manage template variables', function () {
        $template = EmailTemplate::factory()->create();
        $variables = [
            'patient_name' => 'Nome del paziente',
            'appointment_date' => 'Data appuntamento',
            'doctor_name' => 'Nome del dottore',
            'studio_name' => 'Nome dello studio',
            'appointment_time' => 'Orario appuntamento',
        ];

        $template->update(['variables' => $variables]);

        expect($template->fresh()->variables)->toHaveCount(5)
            ->and($template->fresh()->variables['patient_name'])->toBe('Nome del paziente')
            ->and($template->fresh()->variables['appointment_date'])->toBe('Data appuntamento')
            ->and($template->fresh()->variables['doctor_name'])->toBe('Nome del dottore');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'variables' => json_encode($variables),
        ]);
    });

    it('can manage template versions', function () {
        $template = EmailTemplate::factory()->create();
        $versionData = [
            'version' => '2.1.0',
            'changelog' => [
                'Added new variable: studio_address',
                'Updated subject line format',
                'Fixed typo in content',
            ],
            'is_current' => true,
        ];

        $template->update($versionData);

        expect($template->fresh()->version)->toBe('2.1.0')
            ->and($template->fresh()->is_current)->toBeTrue()
            ->and($template->fresh()->changelog)->toHaveCount(3);

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'version' => '2.1.0',
            'is_current' => true,
        ]);
    });

    it('can manage template categories', function () {
        $template = EmailTemplate::factory()->create();
        $categories = [
            'appointments' => 'Appuntamenti',
            'reminders' => 'Promemoria',
            'confirmations' => 'Conferme',
            'notifications' => 'Notifiche',
        ];

        $template->update(['categories' => $categories]);

        expect($template->fresh()->categories)->toHaveCount(4)
            ->and($template->fresh()->categories['appointments'])->toBe('Appuntamenti')
            ->and($template->fresh()->categories['reminders'])->toBe('Promemoria');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'categories' => json_encode($categories),
        ]);
    });

    it('can manage template permissions', function () {
        $template = EmailTemplate::factory()->create();
        $permissions = [
            'roles' => ['admin', 'doctor'],
            'users' => [1, 2, 3],
            'teams' => ['studio_milano', 'studio_roma'],
            'access_level' => 'restricted',
        ];

        $template->update(['permissions' => $permissions]);

        expect($template->fresh()->permissions['roles'])->toContain('admin')
            ->and($template->fresh()->permissions['roles'])->toContain('doctor')
            ->and($template->fresh()->permissions['access_level'])->toBe('restricted');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'permissions' => json_encode($permissions),
        ]);
    });

    it('can manage template localization', function () {
        $template = EmailTemplate::factory()->create();
        $localizationData = [
            'default_locale' => 'it',
            'supported_locales' => ['it', 'en', 'de'],
            'translations' => [
                'it' => [
                    'subject' => 'Conferma Appuntamento - {{appointment_date}}',
                    'content' => 'Gentile {{patient_name}}, il suo appuntamento è confermato.',
                ],
                'en' => [
                    'subject' => 'Appointment Confirmation - {{appointment_date}}',
                    'content' => 'Dear {{patient_name}}, your appointment is confirmed.',
                ],
                'de' => [
                    'subject' => 'Terminbestätigung - {{appointment_date}}',
                    'content' => 'Sehr geehrte/r {{patient_name}}, Ihr Termin ist bestätigt.',
                ],
            ],
        ];

        $template->update($localizationData);

        expect($template->fresh()->default_locale)->toBe('it')
            ->and($template->fresh()->supported_locales)->toHaveCount(3)
            ->and($template->fresh()->translations['it']['subject'])->toBe('Conferma Appuntamento - {{appointment_date}}')
            ->and($template->fresh()->translations['en']['subject'])->toBe('Appointment Confirmation - {{appointment_date}}');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'default_locale' => 'it',
            'supported_locales' => json_encode(['it', 'en', 'de']),
        ]);
    });

    it('can manage template metadata', function () {
        $template = EmailTemplate::factory()->create();
        $metadata = [
            'author' => 'Team ' . config('app.name', 'Our Platform'),
            'created_date' => '2024-01-15',
            'last_modified' => '2024-12-01',
            'tags' => ['appointment', 'confirmation', 'patient'],
            'priority' => 'high',
            'estimated_reading_time' => '2 minutes',
        ];

        $template->update(['metadata' => $metadata]);

        expect($template->fresh()->metadata['author'])->toBe('Team ' . config('app.name', 'Our Platform'))
            ->and($template->fresh()->metadata['created_date'])->toBe('2024-01-15')
            ->and($template->fresh()->metadata['priority'])->toBe('high')
            ->and($template->fresh()->metadata['tags'])->toContain('appointment');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'metadata' => json_encode($metadata),
        ]);
    });

    it('can manage template workflow', function () {
        $template = EmailTemplate::factory()->create(['status' => 'draft']);
        $workflowData = [
            'status' => 'pending_review',
            'reviewer_id' => 5,
            'review_notes' => 'Template approvato con modifiche minori',
            'approval_date' => now(),
            'published_date' => null,
        ];

        $template->update($workflowData);

        expect($template->fresh()->status)->toBe('pending_review')
            ->and($template->fresh()->reviewer_id)->toBe(5)
            ->and($template->fresh()->review_notes)->toBe('Template approvato con modifiche minori');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'status' => 'pending_review',
            'reviewer_id' => 5,
        ]);

        // Publish template
        $template->update([
            'status' => 'published',
            'published_date' => now(),
        ]);

        expect($template->fresh()->status)->toBe('published')
            ->and($template->fresh()->published_date)->not->toBeNull();
    });

    it('can manage template analytics', function () {
        $template = EmailTemplate::factory()->create();
        $analyticsData = [
            'usage_count' => 1250,
            'success_rate' => 98.5,
            'bounce_rate' => 1.2,
            'open_rate' => 85.3,
            'click_rate' => 12.7,
            'last_used' => now()->subDays(2),
            'performance_score' => 92,
        ];

        $template->update($analyticsData);

        expect($template->fresh()->usage_count)->toBe(1250)
            ->and($template->fresh()->success_rate)->toBe(98.5)
            ->and($template->fresh()->open_rate)->toBe(85.3)
            ->and($template->fresh()->performance_score)->toBe(92);

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'usage_count' => 1250,
            'success_rate' => 98.5,
            'bounce_rate' => 1.2,
            'open_rate' => 85.3,
            'click_rate' => 12.7,
            'performance_score' => 92,
        ]);
    });

    it('can manage template compatibility', function () {
        $template = EmailTemplate::factory()->create();
        $compatibilityData = [
            'email_clients' => ['gmail', 'outlook', 'apple_mail'],
            'browsers' => ['chrome', 'firefox', 'safari', 'edge'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'min_supported_version' => '1.0.0',
            'compatibility_notes' => 'Testato su tutti i client principali',
        ];

        $template->update($compatibilityData);

        expect($template->fresh()->email_clients)->toHaveCount(3)
            ->and($template->fresh()->browsers)->toHaveCount(4)
            ->and($template->fresh()->devices)->toHaveCount(3)
            ->and($template->fresh()->min_supported_version)->toBe('1.0.0');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'email_clients' => json_encode(['gmail', 'outlook', 'apple_mail']),
            'browsers' => json_encode(['chrome', 'firefox', 'safari', 'edge']),
            'devices' => json_encode(['desktop', 'tablet', 'mobile']),
            'min_supported_version' => '1.0.0',
        ]);
    });

    it('can manage template archiving', function () {
        $template = EmailTemplate::factory()->create(['is_active' => true]);
        $archiveData = [
            'is_active' => false,
            'archived_at' => now(),
            'archive_reason' => 'Sostituito da nuovo template',
            'replacement_template_id' => 15,
        ];

        $template->update($archiveData);

        expect($template->fresh()->is_active)->toBeFalse()
            ->and($template->fresh()->archived_at)->not->toBeNull()
            ->and($template->fresh()->archive_reason)->toBe('Sostituito da nuovo template')
            ->and($template->fresh()->replacement_template_id)->toBe(15);

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'is_active' => false,
            'archived_at' => $template->archived_at,
            'archive_reason' => 'Sostituito da nuovo template',
            'replacement_template_id' => 15,
        ]);
    });

    it('can search templates by category', function () {
        $appointmentTemplate = EmailTemplate::factory()->create(['categories' => ['appointments' => 'Appuntamenti']]);
        $reminderTemplate = EmailTemplate::factory()->create(['categories' => ['reminders' => 'Promemoria']]);
        $confirmationTemplate = EmailTemplate::factory()->create(['categories' => ['confirmations' => 'Conferme']]);

        $appointmentTemplates = EmailTemplate::whereJsonContains('categories->appointments', 'Appuntamenti')->get();
        $reminderTemplates = EmailTemplate::whereJsonContains('categories->reminders', 'Promemoria')->get();

        expect($appointmentTemplates)->toHaveCount(1)
            ->and($reminderTemplates)->toHaveCount(1)
            ->and($appointmentTemplates->contains($appointmentTemplate))->toBeTrue()
            ->and($reminderTemplates->contains($reminderTemplate))->toBeTrue();
    });

    it('can search templates by status', function () {
        $draftTemplate = EmailTemplate::factory()->create(['status' => 'draft']);
        $publishedTemplate = EmailTemplate::factory()->create(['status' => 'published']);
        $archivedTemplate = EmailTemplate::factory()->create(['status' => 'archived']);

        $publishedTemplates = EmailTemplate::where('status', 'published')->get();
        $draftTemplates = EmailTemplate::where('status', 'draft')->get();

        expect($publishedTemplates)->toHaveCount(1)
            ->and($draftTemplates)->toHaveCount(1)
            ->and($publishedTemplates->contains($publishedTemplate))->toBeTrue()
            ->and($draftTemplates->contains($draftTemplate))->toBeTrue();
    });

    it('can get templates with related data', function () {
        $template = EmailTemplate::factory()->create();
        $theme = Theme::factory()->create();

        $template->update(['theme_id' => $theme->id]);

        $templateWithTheme = EmailTemplate::with('theme')->find($template->id);

        expect($templateWithTheme)->not->toBeNull()
            ->and($templateWithTheme->relationLoaded('theme'))->toBeTrue()
            ->and($templateWithTheme->theme->id)->toBe($theme->id);
    });

    it('can manage template duplication', function () {
        $originalTemplate = EmailTemplate::factory()->create([
            'name' => 'Original Template',
            'version' => '1.0.0',
        ]);

        $duplicateTemplate = $originalTemplate->replicate();
        $duplicateTemplate->name = 'Duplicate Template';
        $duplicateTemplate->version = '1.0.1';
        $duplicateTemplate->save();

        expect($duplicateTemplate->id)->not->toBe($originalTemplate->id)
            ->and($duplicateTemplate->name)->toBe('Duplicate Template')
            ->and($duplicateTemplate->version)->toBe('1.0.1');

        $this->assertDatabaseHas('email_templates', [
            'id' => $duplicateTemplate->id,
            'name' => 'Duplicate Template',
            'version' => '1.0.1',
        ]);
    });

    it('can manage template validation', function () {
        $template = EmailTemplate::factory()->create();
        $validationData = [
            'validation_rules' => [
                'patient_name' => 'required|string|max:100',
                'appointment_date' => 'required|date|after:today',
                'doctor_name' => 'required|string|max:100',
            ],
            'validation_messages' => [
                'patient_name.required' => 'Il nome del paziente è obbligatorio',
                'appointment_date.required' => 'La data dell\'appuntamento è obbligatoria',
                'appointment_date.after' => 'La data deve essere futura',
            ],
        ];

        $template->update($validationData);

        expect($template->fresh()->validation_rules['patient_name'])->toBe('required|string|max:100')
            ->and($template->fresh()->validation_messages['patient_name.required'])->toBe('Il nome del paziente è obbligatorio');

        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'validation_rules' => json_encode($validationData['validation_rules']),
            'validation_messages' => json_encode($validationData['validation_messages']),
        ]);
    });
});
