<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Carbon\Carbon;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailTemplateLog;

describe('Mail Template Log Business Logic', function () {
    it('can create mail template log with basic information', function () {
        $template = MailTemplate::factory()->create();

        $logData = [
            'template_id' => $template->id,
            'mailable_type' => 'App\Mail\AppointmentConfirmation',
            'mailable_id' => 123,
            'status' => 'sent',
            'status_message' => 'Email inviata con successo',
            'data' => [
                'recipient' => 'patient@example.com',
                'subject' => 'Conferma Appuntamento',
                'variables' => [
                    'patient_name' => 'Mario Rossi',
                    'appointment_date' => '2024-12-15 10:00:00',
                ],
            ],
            'metadata' => [
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'campaign_id' => 'appointment_confirmation_001',
            ],
            'sent_at' => now(),
        ];

        $log = MailTemplateLog::create($logData);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'template_id' => $template->id,
            'mailable_type' => 'App\Mail\AppointmentConfirmation',
            'mailable_id' => 123,
            'status' => 'sent',
            'status_message' => 'Email inviata con successo',
        ]);

        expect($log->status)
            ->toBe('sent')
            ->and($log->status_message)
            ->toBe('Email inviata con successo')
            ->and($log->data['recipient'])
            ->toBe('patient@example.com')
            ->and($log->data['variables']['patient_name'])
            ->toBe('Mario Rossi')
            ->and($log->metadata['campaign_id'])
            ->toBe('appointment_confirmation_001');
    });

    it('can manage mail template log relationships', function () {
        $template = MailTemplate::factory()->create();
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
        ]);

        expect($log->template)->toBeInstanceOf(MailTemplate::class)->and($log->template->id)->toBe($template->id);
    });

    it('can track email lifecycle events', function () {
        $template = MailTemplate::factory()->create();

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        // Simula invio
        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // Simula consegna
        $log->update([
            'status' => 'delivered',
            'delivered_at' => now()->addMinutes(2),
        ]);

        // Simula apertura
        $log->update([
            'status' => 'opened',
            'opened_at' => now()->addMinutes(5),
        ]);

        // Simula click
        $log->update([
            'status' => 'clicked',
            'clicked_at' => now()->addMinutes(7),
        ]);

        expect($log->status)
            ->toBe('clicked')
            ->and($log->sent_at)
            ->not->toBeNull()->and($log->delivered_at)
            ->not->toBeNull()->and($log->opened_at)
            ->not->toBeNull()->and($log->clicked_at)
            ->not->toBeNull();
    });

    it('can handle email failure scenarios', function () {
        $template = MailTemplate::factory()->create();

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        // Simula fallimento
        $log->update([
            'status' => 'failed',
            'status_message' => 'Indirizzo email non valido: invalid@email',
            'failed_at' => now(),
            'metadata' => [
                'error_code' => 'INVALID_EMAIL',
                'retry_count' => 3,
                'last_attempt' => now()->toISOString(),
            ],
        ]);

        expect($log->status)
            ->toBe('failed')
            ->and($log->status_message)
            ->toBe('Indirizzo email non valido: invalid@email')
            ->and($log->failed_at)
            ->not->toBeNull()->and($log->metadata['error_code'])->toBe('INVALID_EMAIL')->and(
                $log->metadata['retry_count'],
            )->toBe(3);
    });

    it('can manage mailable polymorphic relationships', function () {
        $template = MailTemplate::factory()->create();

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'mailable_type' => 'App\Models\Appointment',
            'mailable_id' => 456,
        ]);

        expect($log->mailable_type)
            ->toBe('App\Models\Appointment')
            ->and($log->mailable_id)
            ->toBe(456)
            ->and($log->mailable())
            ->toBeInstanceOf(MorphTo::class);
    });

    it('can handle complex data structures', function () {
        $template = MailTemplate::factory()->create();

        $complexData = [
            'recipient' => [
                'email' => 'patient@example.com',
                'name' => 'Mario Rossi',
                'preferences' => [
                    'language' => 'it',
                    'timezone' => 'Europe/Rome',
                    'notification_frequency' => 'daily',
                ],
            ],
            'template_data' => [
                'subject' => 'Conferma Appuntamento',
                'variables' => [
                    'patient_name' => 'Mario Rossi',
                    'appointment_date' => '2024-12-15 10:00:00',
                    'doctor_name' => 'Dr. Bianchi',
                    'clinic_name' => 'Studio Dentistico ' . config('app.name', 'Our Platform'),
                    'clinic_address' => 'Via Roma 123, Milano',
                    'clinic_phone' => '+39 02 1234567',
                ],
                'attachments' => [
                    'consent_form.pdf',
                    'medical_history.pdf',
                ],
            ],
            'delivery_options' => [
                'priority' => 'high',
                'tracking' => true,
                'bounce_handling' => 'automatic',
            ],
        ];

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'data' => $complexData,
        ]);

        expect($log->data['recipient']['email'])
            ->toBe('patient@example.com')
            ->and($log->data['recipient']['name'])
            ->toBe('Mario Rossi')
            ->and($log->data['recipient']['preferences']['language'])
            ->toBe('it')
            ->and($log->data['template_data']['variables']['doctor_name'])
            ->toBe('Dr. Bianchi')
            ->and($log->data['template_data']['attachments'])
            ->toContain('consent_form.pdf')
            ->and($log->data['delivery_options']['priority'])
            ->toBe('high');
    });

    it('can manage metadata for analytics', function () {
        $template = MailTemplate::factory()->create();

        $analyticsMetadata = [
            'campaign_id' => 'appointment_confirmation_q4_2024',
            'segment' => 'new_patients',
            'source' => 'website_registration',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)',
            'ip_address' => '192.168.1.100',
            'geolocation' => [
                'country' => 'IT',
                'region' => 'Lombardia',
                'city' => 'Milano',
                'timezone' => 'Europe/Rome',
            ],
            'device_info' => [
                'type' => 'mobile',
                'os' => 'iOS',
                'browser' => 'Safari',
                'screen_resolution' => '390x844',
            ],
            'engagement_metrics' => [
                'delivery_time' => 2.5,
                'open_rate' => 0.85,
                'click_rate' => 0.12,
                'bounce_rate' => 0.03,
            ],
        ];

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'metadata' => $analyticsMetadata,
        ]);

        expect($log->metadata['campaign_id'])
            ->toBe('appointment_confirmation_q4_2024')
            ->and($log->metadata['segment'])
            ->toBe('new_patients')
            ->and($log->metadata['geolocation']['country'])
            ->toBe('IT')
            ->and($log->metadata['geolocation']['city'])
            ->toBe('Milano')
            ->and($log->metadata['device_info']['type'])
            ->toBe('mobile')
            ->and($log->metadata['engagement_metrics']['open_rate'])
            ->toBe(0.85);
    });

    it('can handle delivery status transitions', function () {
        $template = MailTemplate::factory()->create();

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        // Transizione: pending -> sent
        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
            'status_message' => 'Email inviata al server SMTP',
        ]);

        expect($log->status)->toBe('sent')->and($log->sent_at)->not->toBeNull();

        // Transizione: sent -> delivered
        $log->update([
            'status' => 'delivered',
            'delivered_at' => now()->addMinutes(1),
            'status_message' => 'Email consegnata alla casella di posta',
        ]);

        expect($log->status)->toBe('delivered')->and($log->delivered_at)->not->toBeNull();

        // Transizione: delivered -> opened
        $log->update([
            'status' => 'opened',
            'opened_at' => now()->addMinutes(3),
            'status_message' => 'Email aperta dal destinatario',
        ]);

        expect($log->status)->toBe('opened')->and($log->opened_at)->not->toBeNull();
    });

    it('can handle bounce and complaint scenarios', function () {
        $template = MailTemplate::factory()->create();

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'sent',
        ]);

        // Simula bounce
        $log->update([
            'status' => 'bounced',
            'status_message' => 'Indirizzo email inesistente',
            'metadata' => [
                'bounce_type' => 'hard',
                'bounce_reason' => 'Address does not exist',
                'bounce_subtype' => 'BadDestination',
                'action' => 'failed',
                'diagnostic_code' => 'smtp; 550 5.1.1 User unknown',
            ],
        ]);

        expect($log->status)
            ->toBe('bounced')
            ->and($log->status_message)
            ->toBe('Indirizzo email inesistente')
            ->and($log->metadata['bounce_type'])
            ->toBe('hard')
            ->and($log->metadata['bounce_reason'])
            ->toBe('Address does not exist');

        // Simula complaint
        $log->update([
            'status' => 'complained',
            'status_message' => 'Email segnalata come spam',
            'metadata' => [
                'complaint_type' => 'abuse',
                'complaint_reason' => 'Not spam',
                'complaint_date' => now()->toISOString(),
                'action' => 'suppressed',
            ],
        ]);

        expect($log->status)
            ->toBe('complained')
            ->and($log->status_message)
            ->toBe('Email segnalata come spam')
            ->and($log->metadata['complaint_type'])
            ->toBe('abuse');
    });

    it('can manage retry logic', function () {
        $template = MailTemplate::factory()->create();

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'failed',
            'metadata' => [
                'retry_count' => 0,
                'max_retries' => 3,
                'last_error' => 'Connection timeout',
            ],
        ]);

        // Primo retry
        $log->update([
            'status' => 'retrying',
            'metadata' => [
                'retry_count' => 1,
                'max_retries' => 3,
                'last_error' => 'Connection timeout',
                'retry_scheduled_at' => now()->addMinutes(5)->toISOString(),
            ],
        ]);

        expect($log->status)->toBe('retrying')->and($log->metadata['retry_count'])->toBe(1);

        // Secondo retry
        $log->update([
            'status' => 'retrying',
            'metadata' => [
                'retry_count' => 2,
                'max_retries' => 3,
                'last_error' => 'SMTP server unavailable',
                'retry_scheduled_at' => now()->addMinutes(15)->toISOString(),
            ],
        ]);

        expect($log->metadata['retry_count'])->toBe(2);

        // Terzo retry fallito
        $log->update([
            'status' => 'failed',
            'status_message' => 'Tutti i tentativi falliti',
            'metadata' => [
                'retry_count' => 3,
                'max_retries' => 3,
                'last_error' => 'SMTP server permanently unavailable',
                'final_failure' => true,
            ],
        ]);

        expect($log->status)
            ->toBe('failed')
            ->and($log->status_message)
            ->toBe('Tutti i tentativi falliti')
            ->and($log->metadata['retry_count'])
            ->toBe(3)
            ->and($log->metadata['final_failure'])
            ->toBeTrue();
    });

    it('can handle empty or null values gracefully', function () {
        $template = MailTemplate::factory()->create();

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status_message' => null,
            'data' => null,
            'metadata' => null,
            'sent_at' => null,
            'delivered_at' => null,
            'failed_at' => null,
            'opened_at' => null,
            'clicked_at' => null,
        ]);

        expect($log->status_message)
            ->toBeNull()
            ->and($log->data)
            ->toBeNull()
            ->and($log->metadata)
            ->toBeNull()
            ->and($log->sent_at)
            ->toBeNull()
            ->and($log->delivered_at)
            ->toBeNull()
            ->and($log->failed_at)
            ->toBeNull()
            ->and($log->opened_at)
            ->toBeNull()
            ->and($log->clicked_at)
            ->toBeNull();
    });

    it('can validate timestamp consistency', function () {
        $template = MailTemplate::factory()->create();

        $now = now();
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'sent_at' => $now,
            'delivered_at' => $now->addMinutes(1),
            'opened_at' => $now->addMinutes(3),
            'clicked_at' => $now->addMinutes(5),
        ]);

        // Verifica che i timestamp siano in ordine cronologico
        expect($log->sent_at->lt($log->delivered_at))
            ->toBeTrue()
            ->and($log->delivered_at->lt($log->opened_at))
            ->toBeTrue()
            ->and($log->opened_at->lt($log->clicked_at))
            ->toBeTrue();

        // Verifica che i timestamp non siano nel futuro
        expect($log->sent_at->lte(now()))
            ->toBeTrue()
            ->and($log->delivered_at->lte(now()))
            ->toBeTrue()
            ->and($log->opened_at->lte(now()))
            ->toBeTrue()
            ->and($log->clicked_at->lte(now()))
            ->toBeTrue();
    });
});
