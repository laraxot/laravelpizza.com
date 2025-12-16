<?php

declare(strict_types=1);

use Modules\Notify\Helpers\ConfigHelper;
use Modules\Notify\Models\NotificationType;

describe('Notification Type Business Logic', function () {
    it('can create notification type with basic information', function () {
        $typeData = [
            'name' => 'Appointment Reminder',
            'slug' => 'appointment-reminder',
            'description' => 'Promemoria per appuntamenti',
            'category' => 'healthcare',
            'is_active' => true,
        ];

        $type = NotificationType::create($typeData);

        expect($type->name)
            ->toBe('Appointment Reminder')
            ->and($type->slug)
            ->toBe('appointment-reminder')
            ->and($type->description)
            ->toBe('Promemoria per appuntamenti')
            ->and($type->category)
            ->toBe('healthcare')
            ->and($type->is_active)
            ->toBeTrue();

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'name' => 'Appointment Reminder',
            'slug' => 'appointment-reminder',
            'description' => 'Promemoria per appuntamenti',
            'category' => 'healthcare',
            'is_active' => true,
        ]);
    });

    it('can manage notification type channels', function () {
        $type = NotificationType::factory()->create();
        $channels = [
            'email' => [
                'enabled' => true,
                'priority' => 'high',
                'template' => 'email.appointment-reminder',
                'subject' => 'Promemoria Appuntamento',
            ],
            'sms' => [
                'enabled' => true,
                'priority' => 'medium',
                'template' => 'sms.appointment-reminder',
                'max_length' => 160,
            ],
            'push' => [
                'enabled' => false,
                'priority' => 'low',
                'template' => 'push.appointment-reminder',
            ],
        ];

        $type->update(['channels' => $channels]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'channels' => json_encode($channels),
        ]);

        expect($type->fresh()->channels['email']['enabled'])
            ->toBeTrue()
            ->and($type->fresh()->channels['email']['priority'])
            ->toBe('high')
            ->and($type->fresh()->channels['email']['template'])
            ->toBe('email.appointment-reminder')
            ->and($type->fresh()->channels['sms']['enabled'])
            ->toBeTrue()
            ->and($type->fresh()->channels['sms']['max_length'])
            ->toBe(160)
            ->and($type->fresh()->channels['push']['enabled'])
            ->toBeFalse();
    });

    it('can manage notification type settings', function () {
        $type = NotificationType::factory()->create();
        $settings = [
            'retry_attempts' => 3,
            'retry_delay' => 300, // 5 minutes
            'expiration_time' => 86400, // 24 hours
            'batch_size' => 100,
            'throttle_limit' => 10,
            'throttle_window' => 3600, // 1 hour
            'timezone_aware' => true,
            'localization_support' => true,
            'audit_logging' => true,
            'encryption_required' => false,
        ];

        $type->update(['settings' => $settings]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'settings' => json_encode($settings),
        ]);

        expect($type->fresh()->settings['retry_attempts'])
            ->toBe(3)
            ->and($type->fresh()->settings['retry_delay'])
            ->toBe(300)
            ->and($type->fresh()->settings['expiration_time'])
            ->toBe(86400)
            ->and($type->fresh()->settings['batch_size'])
            ->toBe(100)
            ->and($type->fresh()->settings['throttle_limit'])
            ->toBe(10)
            ->and($type->fresh()->settings['timezone_aware'])
            ->toBeTrue()
            ->and($type->fresh()->settings['localization_support'])
            ->toBeTrue()
            ->and($type->fresh()->settings['audit_logging'])
            ->toBeTrue()
            ->and($type->fresh()->settings['encryption_required'])
            ->toBeFalse();
    });

    it('can manage notification type templates', function () {
        $type = NotificationType::factory()->create();
        $templates = [
            'email' => [
                'subject' => 'Promemoria Appuntamento - {{appointment_date}}',
                'body' => 'Gentile {{patient_name}}, le ricordiamo l\'appuntamento per il {{appointment_date}} alle {{appointment_time}}.',
                'variables' => ['patient_name', 'appointment_date', 'appointment_time'],
                'html_template' => 'emails.appointment-reminder',
                'text_template' => 'emails.appointment-reminder-text',
            ],
            'sms' => [
                'message' =>

                        'Promemoria: appuntamento {{appointment_date}} alle {{appointment_time}}. ' .
                        config('app.name', 'Our Platform')
                    ,
                'variables' => ['appointment_date', 'appointment_time'],
                'max_length' => 160,
            ],
            'push' => [
                'title' => 'Promemoria Appuntamento',
                'body' => 'Appuntamento domani alle {{appointment_time}}',
                'variables' => ['appointment_time'],
                'action_url' => '/appointments/{{appointment_id}}',
            ],
        ];

        $type->update(['templates' => $templates]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'templates' => json_encode($templates),
        ]);

        expect($type->fresh()->templates['email']['subject'])
            ->toBe('Promemoria Appuntamento - {{appointment_date}}')
            ->and($type->fresh()->templates['email']['variables'])
            ->toContain('patient_name')
            ->and($type->fresh()->templates['email']['html_template'])
            ->toBe('emails.appointment-reminder')
            ->and($type->fresh()->templates['sms']['message'])
            ->toBe('Promemoria: appuntamento {{appointment_date}} alle {{appointment_time}}. ' .
                config('app.name', 'Our Platform'))
            ->and($type->fresh()->templates['sms']['max_length'])
            ->toBe(160)
            ->and($type->fresh()->templates['push']['title'])
            ->toBe('Promemoria Appuntamento');
    });

    it('can manage notification type rules', function () {
        $type = NotificationType::factory()->create();
        $rules = [
            'frequency' => [
                'max_per_day' => 3,
                'max_per_week' => 10,
                'max_per_month' => 30,
                'quiet_hours' => [
                    'start' => '22:00',
                    'end' => '08:00',
                ],
            ],
            'conditions' => [
                'require_consent' => true,
                'min_advance_notice' => 3600, // 1 hour
                'max_advance_notice' => 604800, // 1 week
                'user_preferences_override' => true,
            ],
            'validation' => [
                'required_fields' => ['patient_name', 'appointment_date', 'appointment_time'],
                'optional_fields' => ['notes', 'location'],
                'field_formats' => [
                    'appointment_date' => 'Y-m-d',
                    'appointment_time' => 'H:i',
                ],
            ],
        ];

        $type->update(['rules' => $rules]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'rules' => json_encode($rules),
        ]);

        expect($type->fresh()->rules['frequency']['max_per_day'])
            ->toBe(3)
            ->and($type->fresh()->rules['frequency']['max_per_week'])
            ->toBe(10)
            ->and($type->fresh()->rules['frequency']['quiet_hours']['start'])
            ->toBe('22:00')
            ->and($type->fresh()->rules['frequency']['quiet_hours']['end'])
            ->toBe('08:00')
            ->and($type->fresh()->rules['conditions']['require_consent'])
            ->toBeTrue()
            ->and($type->fresh()->rules['conditions']['min_advance_notice'])
            ->toBe(3600)
            ->and($type->fresh()->rules['validation']['required_fields'])
            ->toContain('patient_name')
            ->and($type->fresh()->rules['validation']['field_formats']['appointment_date'])
            ->toBe('Y-m-d');
    });

    it('can manage notification type permissions', function () {
        $type = NotificationType::factory()->create();
        $permissions = [
            'roles' => ['admin', 'doctor', 'nurse'],
            'permissions' => ['notifications.create', 'notifications.send'],
            'user_groups' => ['active_patients', 'premium_members'],
            'restrictions' => [
                'max_recipients' => 1000,
                'geographic_limits' => ['IT', 'EU'],
                'time_restrictions' => ['business_hours_only'],
            ],
        ];

        $type->update(['permissions' => $permissions]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'permissions' => json_encode($permissions),
        ]);

        expect($type->fresh()->permissions['roles'])
            ->toContain('admin')
            ->and($type->fresh()->permissions['roles'])
            ->toContain('doctor')
            ->and($type->fresh()->permissions['permissions'])
            ->toContain('notifications.create')
            ->and($type->fresh()->permissions['user_groups'])
            ->toContain('active_patients')
            ->and($type->fresh()->permissions['restrictions']['max_recipients'])
            ->toBe(1000)
            ->and($type->fresh()->permissions['restrictions']['geographic_limits'])
            ->toContain('IT')
            ->and($type->fresh()->permissions['restrictions']['time_restrictions'])
            ->toContain('business_hours_only');
    });

    it('can manage notification type metrics', function () {
        $type = NotificationType::factory()->create();
        $metrics = [
            'delivery_rate' => 98.5,
            'open_rate' => 45.2,
            'click_rate' => 12.8,
            'bounce_rate' => 1.5,
            'spam_complaints' => 0.1,
            'unsubscribe_rate' => 2.3,
            'total_sent' => 15000,
            'total_delivered' => 14775,
            'total_opened' => 6683,
            'total_clicked' => 1891,
            'last_sent' => now()->subHours(2),
            'average_response_time' => 2.5, // minutes
        ];

        $type->update(['metrics' => $metrics]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'metrics' => json_encode($metrics),
        ]);

        expect($type->fresh()->metrics['delivery_rate'])
            ->toBe(98.5)
            ->and($type->fresh()->metrics['open_rate'])
            ->toBe(45.2)
            ->and($type->fresh()->metrics['click_rate'])
            ->toBe(12.8)
            ->and($type->fresh()->metrics['bounce_rate'])
            ->toBe(1.5)
            ->and($type->fresh()->metrics['total_sent'])
            ->toBe(15000)
            ->and($type->fresh()->metrics['total_delivered'])
            ->toBe(14775)
            ->and($type->fresh()->metrics['total_opened'])
            ->toBe(6683)
            ->and($type->fresh()->metrics['total_clicked'])
            ->toBe(1891)
            ->and($type->fresh()->metrics['average_response_time'])
            ->toBe(2.5);
    });

    it('can manage notification type scheduling', function () {
        $type = NotificationType::factory()->create();
        $scheduling = [
            'scheduling_enabled' => true,
            'timezone_aware' => true,
            'default_timezone' => 'Europe/Rome',
            'business_hours' => [
                'monday' => ['09:00', '18:00'],
                'tuesday' => ['09:00', '18:00'],
                'wednesday' => ['09:00', '18:00'],
                'thursday' => ['09:00', '18:00'],
                'friday' => ['09:00', '17:00'],
                'saturday' => ['09:00', '12:00'],
                'sunday' => ['closed'],
            ],
            'holidays' => [
                '2024-12-25' => 'Natale',
                '2024-12-26' => 'Santo Stefano',
                '2025-01-01' => 'Capodanno',
            ],
            'advance_notice' => [
                'min_hours' => 1,
                'max_days' => 7,
                'preferred_time' => '09:00',
            ],
        ];

        $type->update(['scheduling' => $scheduling]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'scheduling' => json_encode($scheduling),
        ]);

        expect($type->fresh()->scheduling['scheduling_enabled'])
            ->toBeTrue()
            ->and($type->fresh()->scheduling['timezone_aware'])
            ->toBeTrue()
            ->and($type->fresh()->scheduling['default_timezone'])
            ->toBe('Europe/Rome')
            ->and($type->fresh()->scheduling['business_hours']['monday'])
            ->toBe(['09:00', '18:00'])
            ->and($type->fresh()->scheduling['business_hours']['sunday'])
            ->toBe(['closed'])
            ->and($type->fresh()->scheduling['holidays']['2024-12-25'])
            ->toBe('Natale')
            ->and($type->fresh()->scheduling['advance_notice']['min_hours'])
            ->toBe(1)
            ->and($type->fresh()->scheduling['advance_notice']['max_days'])
            ->toBe(7)
            ->and($type->fresh()->scheduling['advance_notice']['preferred_time'])
            ->toBe('09:00');
    });

    it('can manage notification type integrations', function () {
        $type = NotificationType::factory()->create();
        $integrations = [
            'external_services' => [
                'email_provider' => 'SendGrid',
                'sms_provider' => 'Twilio',
                'push_provider' => 'Firebase',
            ],
            'webhooks' => [
                'delivery_webhook' =>
                    'https://api.' . config('app.domain', 'example.com') . '/webhooks/notification-delivered',
                'bounce_webhook' =>
                    'https://api.' . config('app.domain', 'example.com') . '/webhooks/notification-bounced',
                'click_webhook' =>
                    'https://api.' . config('app.domain', 'example.com') . '/webhooks/notification-clicked',
            ],
            'api_endpoints' => [
                'send' => 'POST /api/v1/notifications/send',
                'status' => 'GET /api/v1/notifications/{id}/status',
                'cancel' => 'DELETE /api/v1/notifications/{id}',
            ],
            'third_party' => [
                'crm_integration' => 'Salesforce',
                'analytics' => 'Google Analytics',
                'monitoring' => 'Sentry',
            ],
        ];

        $type->update(['integrations' => $integrations]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'integrations' => json_encode($integrations),
        ]);

        expect($type->fresh()->integrations['external_services']['email_provider'])
            ->toBe('SendGrid')
            ->and($type->fresh()->integrations['external_services']['sms_provider'])
            ->toBe('Twilio')
            ->and($type->fresh()->integrations['external_services']['push_provider'])
            ->toBe('Firebase')
            ->and($type->fresh()->integrations['webhooks']['delivery_webhook'])
            ->toBe('https://api.' . config('app.domain', 'example.com') . '/webhooks/notification-delivered')
            ->and($type->fresh()->integrations['api_endpoints']['send'])
            ->toBe('POST /api/v1/notifications/send')
            ->and($type->fresh()->integrations['third_party']['crm_integration'])
            ->toBe('Salesforce');
    });

    it('can search notification types by category', function () {
        $healthcareType = NotificationType::factory()->create(['category' => 'healthcare']);
        $marketingType = NotificationType::factory()->create(['category' => 'marketing']);
        $systemType = NotificationType::factory()->create(['category' => 'system']);

        $healthcareTypes = NotificationType::where('category', 'healthcare')->get();
        $marketingTypes = NotificationType::where('category', 'marketing')->get();

        expect($healthcareTypes)
            ->toHaveCount(1)
            ->and($marketingTypes)
            ->toHaveCount(1)
            ->and($healthcareTypes->contains($healthcareType))
            ->toBeTrue()
            ->and($marketingTypes->contains($marketingType))
            ->toBeTrue();
    });

    it('can search notification types by status', function () {
        $activeType = NotificationType::factory()->create(['is_active' => true]);
        $inactiveType = NotificationType::factory()->create(['is_active' => false]);

        $activeTypes = NotificationType::where('is_active', true)->get();
        $inactiveTypes = NotificationType::where('is_active', false)->get();

        expect($activeTypes)
            ->toHaveCount(1)
            ->and($inactiveTypes)
            ->toHaveCount(1)
            ->and($activeTypes->contains($activeType))
            ->toBeTrue()
            ->and($inactiveTypes->contains($inactiveType))
            ->toBeTrue();
    });

    it('can search notification types by channel enabled', function () {
        $emailType = NotificationType::factory()->create([
            'channels' => ['email' => ['enabled' => true], 'sms' => ['enabled' => false]],
        ]);
        $smsType = NotificationType::factory()->create([
            'channels' => ['email' => ['enabled' => false], 'sms' => ['enabled' => true]],
        ]);

        $emailTypes = NotificationType::whereJsonContains('channels->email->enabled', true)->get();
        $smsTypes = NotificationType::whereJsonContains('channels->sms->enabled', true)->get();

        expect($emailTypes)
            ->toHaveCount(1)
            ->and($smsTypes)
            ->toHaveCount(1)
            ->and($emailTypes->contains($emailType))
            ->toBeTrue()
            ->and($smsTypes->contains($smsType))
            ->toBeTrue();
    });

    it('can manage notification type archiving', function () {
        $type = NotificationType::factory()->create(['is_active' => true]);
        $archiveData = [
            'is_active' => false,
            'archived_at' => now(),
            'archive_reason' => 'Sostituito da nuovo tipo',
            'replacement_type_id' => 15,
        ];

        $type->update($archiveData);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'is_active' => false,
            'archived_at' => $type->archived_at,
            'archive_reason' => 'Sostituito da nuovo tipo',
            'replacement_type_id' => 15,
        ]);

        expect($type->fresh()->is_active)
            ->toBeFalse()
            ->and($type->fresh()->archived_at)
            ->not->toBeNull()->and($type->fresh()->archive_reason)->toBe(
                'Sostituito da nuovo tipo',
            )->and($type->fresh()->replacement_type_id)->toBe(15);
    });

    it('can manage notification type duplication', function () {
        $originalType = NotificationType::factory()->create([
            'name' => 'Original Type',
            'slug' => 'original-type',
            'version' => '1.0.0',
        ]);

        $duplicateType = $originalType->replicate();
        $duplicateType->name = 'Duplicate Type';
        $duplicateType->slug = 'duplicate-type';
        $duplicateType->version = '1.0.1';
        $duplicateType->save();

        $this->assertDatabaseHas('notification_types', [
            'id' => $duplicateType->id,
            'name' => 'Duplicate Type',
            'slug' => 'duplicate-type',
            'version' => '1.0.1',
        ]);

        expect($originalType->id)
            ->not
            ->toBe($duplicateType->id)
            ->and($duplicateType->name)
            ->toBe('Duplicate Type')
            ->and($duplicateType->slug)
            ->toBe('duplicate-type')
            ->and($duplicateType->version)
            ->toBe('1.0.1');
    });
});
