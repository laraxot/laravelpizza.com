<?php

declare(strict_types=1);

use Modules\Notify\Helpers\ConfigHelper;
use Modules\Notify\Models\Contact;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotificationType;

describe('Notification Management Business Logic', function () {
    it('can create notification with basic information', function () {
        $testData = ConfigHelper::getTestData();

        $notificationData = [
            'type' => 'email',
            'subject' => $testData['default_subject'],
            'content' => $testData['default_content'],
            'status' => 'pending',
            'priority' => 'normal',
        ];

        $notification = Notification::create($notificationData);

        expect($notification)
            ->toBeInstanceOf(Notification::class)
            ->and($notification->type)
            ->toBe('email')
            ->and($notification->subject)
            ->toBe($testData['default_subject'])
            ->and($notification->status)
            ->toBe('pending');

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'type' => 'email',
            'subject' => $testData['default_subject'],
            'content' => $testData['default_content'],
            'status' => 'pending',
            'priority' => 'normal',
        ]);
    });

    it('can create notification template', function () {
        $testData = ConfigHelper::getTestData();

        $templateData = [
            'name' => 'Welcome Email Template',
            'type' => 'email',
            'subject' => 'Benvenuto {{user_name}}',
            'content' => $testData['default_welcome_content'],
            'variables' => ['user_name', 'company_name'],
            'is_active' => true,
        ];

        $template = NotificationTemplate::create($templateData);

        expect($template)
            ->toBeInstanceOf(NotificationTemplate::class)
            ->and($template->name)
            ->toBe('Welcome Email Template')
            ->and($template->type)
            ->toBe('email')
            ->and($template->is_active)
            ->toBeTrue();

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'name' => 'Welcome Email Template',
            'type' => 'email',
            'subject' => 'Benvenuto {{user_name}}',
            'is_active' => true,
        ]);
    });

    it('can create notification type', function () {
        $typeData = [
            'name' => 'welcome_email',
            'display_name' => 'Email di Benvenuto',
            'description' => 'Email inviata ai nuovi utenti registrati',
            'is_active' => true,
        ];

        $type = NotificationType::create($typeData);

        expect($type)
            ->toBeInstanceOf(NotificationType::class)
            ->and($type->name)
            ->toBe('welcome_email')
            ->and($type->display_name)
            ->toBe('Email di Benvenuto')
            ->and($type->is_active)
            ->toBeTrue();

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'name' => 'welcome_email',
            'display_name' => 'Email di Benvenuto',
            'description' => 'Email inviata ai nuovi utenti registrati',
            'is_active' => true,
        ]);
    });

    it('can create contact for notifications', function () {
        $contactData = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 123 456 7890',
            'preferences' => [
                'email' => true,
                'sms' => false,
                'push' => true,
            ],
            'is_active' => true,
        ];

        $contact = Contact::create($contactData);

        expect($contact)
            ->toBeInstanceOf(Contact::class)
            ->and($contact->name)
            ->toBe('Mario Rossi')
            ->and($contact->email)
            ->toBe('mario.rossi@example.com')
            ->and($contact->is_active)
            ->toBeTrue();

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 123 456 7890',
            'is_active' => true,
        ]);
    });

    it('can update notification status', function () {
        $notification = Notification::factory()->create([
            'status' => 'pending',
        ]);

        $notification->update(['status' => 'sent']);

        expect($notification->fresh()->status)->toBe('sent');

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'status' => 'sent',
        ]);
    });

    it('can delete notification', function () {
        $notification = Notification::factory()->create();

        $notificationId = $notification->id;
        $notification->delete();

        $this->assertDatabaseMissing('notifications', [
            'id' => $notificationId,
        ]);
    });

    it('can create notification with custom data', function () {
        $customData = [
            'user_id' => 123,
            'appointment_date' => '2024-01-15',
            'clinic_name' => ConfigHelper::get('notify.test_data.default_clinic_name'),
        ];

        $notificationData = [
            'type' => 'sms',
            'subject' => 'Promemoria Appuntamento',
            'content' => 'Il tuo appuntamento è fissato per il {{appointment_date}} presso {{clinic_name}}',
            'data' => json_encode($customData),
            'status' => 'pending',
            'priority' => 'high',
        ];

        $notification = Notification::create($notificationData);

        expect($notification)
            ->toBeInstanceOf(Notification::class)
            ->and($notification->type)
            ->toBe('sms')
            ->and($notification->priority)
            ->toBe('high')
            ->and($notification->data)
            ->toBe(json_encode($customData));

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'type' => 'sms',
            'subject' => 'Promemoria Appuntamento',
            'priority' => 'high',
        ]);
    });

    it('can create notification template with variables', function () {
        $templateData = [
            'name' => 'Appointment Reminder Template',
            'type' => 'sms',
            'subject' => 'Promemoria Appuntamento',
            'content' => 'Il tuo appuntamento è fissato per il {{appointment_date}} alle {{appointment_time}} presso {{clinic_name}}',
            'variables' => ['appointment_date', 'appointment_time', 'clinic_name'],
            'is_active' => true,
        ];

        $template = NotificationTemplate::create($templateData);

        expect($template)
            ->toBeInstanceOf(NotificationTemplate::class)
            ->and($template->variables)
            ->toContain('appointment_date')
            ->and($template->variables)
            ->toContain('appointment_time')
            ->and($template->variables)
            ->toContain('clinic_name');

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'name' => 'Appointment Reminder Template',
            'variables' => json_encode(['appointment_date', 'appointment_time', 'clinic_name']),
        ]);
    });

    it('can create notification type with channels', function () {
        $typeData = [
            'name' => 'appointment_reminder',
            'display_name' => 'Promemoria Appuntamento',
            'description' => 'Notifiche per promemoria appuntamenti',
            'channels' => ['email', 'sms', 'push'],
            'is_active' => true,
        ];

        $type = NotificationType::create($typeData);

        expect($type)
            ->toBeInstanceOf(NotificationType::class)
            ->and($type->channels)
            ->toContain('email')
            ->and($type->channels)
            ->toContain('sms')
            ->and($type->channels)
            ->toContain('push');

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'name' => 'appointment_reminder',
            'channels' => json_encode(['email', 'sms', 'push']),
        ]);
    });

    it('can create contact with communication preferences', function () {
        $contactData = [
            'name' => 'Giulia Bianchi',
            'email' => 'giulia.bianchi@example.com',
            'phone' => '+39 987 654 3210',
            'preferences' => [
                'email' => true,
                'sms' => true,
                'push' => false,
                'frequency' => 'daily',
                'quiet_hours' => [
                    'start' => '22:00',
                    'end' => '08:00',
                ],
            ],
            'is_active' => true,
        ];

        $contact = Contact::create($contactData);

        expect($contact)
            ->toBeInstanceOf(Contact::class)
            ->and($contact->preferences['email'])
            ->toBeTrue()
            ->and($contact->preferences['sms'])
            ->toBeTrue()
            ->and($contact->preferences['push'])
            ->toBeFalse()
            ->and($contact->preferences['frequency'])
            ->toBe('daily');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Giulia Bianchi',
            'email' => 'giulia.bianchi@example.com',
            'preferences' => json_encode($contactData['preferences']),
        ]);
    });

    it('can create notification with priority levels', function () {
        $priorities = ['low', 'normal', 'high', 'urgent'];

        foreach ($priorities as $priority) {
            $notificationData = [
                'type' => 'email',
                'subject' => "Test Notification - {$priority} Priority",
                'content' => 'This is a test notification with ' . $priority . ' priority',
                'status' => 'pending',
                'priority' => $priority,
            ];

            $notification = Notification::create($notificationData);

            expect($notification->priority)->toBe($priority);

            $this->assertDatabaseHas('notifications', [
                'id' => $notification->id,
                'priority' => $priority,
            ]);
        }
    });

    it('can create notification with different types', function () {
        $types = ['email', 'sms', 'push', 'database', 'broadcast'];

        foreach ($types as $type) {
            $notificationData = [
                'type' => $type,
                'subject' => "Test {$type} Notification",
                'content' => "This is a test {$type} notification",
                'status' => 'pending',
                'priority' => 'normal',
            ];

            $notification = Notification::create($notificationData);

            expect($notification->type)->toBe($type);

            $this->assertDatabaseHas('notifications', [
                'id' => $notification->id,
                'type' => $type,
            ]);
        }
    });

    it('can create notification template with multiple languages', function () {
        $templateData = [
            'name' => 'Multi-language Welcome Template',
            'type' => 'email',
            'subject' => '{{welcome_subject}}',
            'content' => '{{welcome_content}}',
            'variables' => ['welcome_subject', 'welcome_content', 'user_name', 'company_name'],
            'translations' => [
                'it' => [
                    'welcome_subject' => 'Benvenuto su {{company_name}}',
                    'welcome_content' => 'Ciao {{user_name}}, benvenuto su {{company_name}}!',
                ],
                'en' => [
                    'welcome_subject' => 'Welcome to {{company_name}}',
                    'welcome_content' => 'Hello {{user_name}}, welcome to {{company_name}}!',
                ],
                'de' => [
                    'welcome_subject' => 'Willkommen bei {{company_name}}',
                    'welcome_content' => 'Hallo {{user_name}}, willkommen bei {{company_name}}!',
                ],
            ],
            'is_active' => true,
        ];

        $template = NotificationTemplate::create($templateData);

        expect($template)
            ->toBeInstanceOf(NotificationTemplate::class)
            ->and($template->translations)
            ->toHaveKey('it')
            ->and($template->translations)
            ->toHaveKey('en')
            ->and($template->translations)
            ->toHaveKey('de');

        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'name' => 'Multi-language Welcome Template',
            'translations' => json_encode($templateData['translations']),
        ]);
    });

    it('can create notification type with delivery rules', function () {
        $typeData = [
            'name' => 'marketing_campaign',
            'display_name' => 'Campagna Marketing',
            'description' => 'Notifiche per campagne marketing',
            'channels' => ['email', 'sms'],
            'delivery_rules' => [
                'max_per_day' => 3,
                'max_per_week' => 10,
                'quiet_hours' => [
                    'start' => '22:00',
                    'end' => '08:00',
                ],
                'timezone' => 'Europe/Rome',
                'retry_attempts' => 3,
                'retry_delay' => 300, // 5 minutes
            ],
            'is_active' => true,
        ];

        $type = NotificationType::create($typeData);

        expect($type)
            ->toBeInstanceOf(NotificationType::class)
            ->and($type->delivery_rules['max_per_day'])
            ->toBe(3)
            ->and($type->delivery_rules['max_per_week'])
            ->toBe(10)
            ->and($type->delivery_rules['retry_attempts'])
            ->toBe(3);

        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'name' => 'marketing_campaign',
            'delivery_rules' => json_encode($typeData['delivery_rules']),
        ]);
    });

    it('can create contact with tags and categories', function () {
        $contactData = [
            'name' => 'Marco Verdi',
            'email' => 'marco.verdi@example.com',
            'phone' => '+39 555 123 4567',
            'tags' => ['vip', 'premium', 'newsletter'],
            'categories' => ['healthcare', 'dental', 'orthodontics'],
            'preferences' => [
                'email' => true,
                'sms' => false,
                'push' => true,
                'marketing' => true,
                'newsletter' => true,
            ],
            'metadata' => [
                'source' => 'website_form',
                'campaign' => 'summer_2024',
                'referrer' => 'google_search',
                'landing_page' => '/services/dental-care',
            ],
            'is_active' => true,
        ];

        $contact = Contact::create($contactData);

        expect($contact)
            ->toBeInstanceOf(Contact::class)
            ->and($contact->tags)
            ->toContain('vip')
            ->and($contact->tags)
            ->toContain('premium')
            ->and($contact->categories)
            ->toContain('healthcare')
            ->and($contact->metadata['source'])
            ->toBe('website_form');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Marco Verdi',
            'email' => 'marco.verdi@example.com',
            'tags' => json_encode($contactData['tags']),
            'categories' => json_encode($contactData['categories']),
            'metadata' => json_encode($contactData['metadata']),
        ]);
    });

    it('can create notification with scheduling', function () {
        $scheduledAt = now()->addHour();
        $expiresAt = now()->addDays(7);

        $notificationData = [
            'type' => 'email',
            'subject' => 'Scheduled Notification Test',
            'content' => 'This notification was scheduled to be sent later',
            'status' => 'scheduled',
            'priority' => 'normal',
            'scheduled_at' => $scheduledAt,
            'expires_at' => $expiresAt,
            'timezone' => 'Europe/Rome',
        ];

        $notification = Notification::create($notificationData);

        expect($notification)
            ->toBeInstanceOf(Notification::class)
            ->and($notification->status)
            ->toBe('scheduled')
            ->and($notification->scheduled_at->toDateTimeString())
            ->toBe($scheduledAt->toDateTimeString())
            ->and($notification->expires_at->toDateTimeString())
            ->toBe($expiresAt->toDateTimeString())
            ->and($notification->timezone)
            ->toBe('Europe/Rome');

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'status' => 'scheduled',
            'timezone' => 'Europe/Rome',
        ]);
    });

    it('can create notification with tracking options', function () {
        $notificationData = [
            'type' => 'email',
            'subject' => 'Trackable Notification Test',
            'content' => 'This notification can be tracked for opens and clicks',
            'status' => 'pending',
            'priority' => 'normal',
            'tracking' => [
                'opens' => true,
                'clicks' => true,
                'unsubscribes' => true,
                'bounces' => true,
                'complaints' => true,
            ],
            'tracking_id' => 'track_' . uniqid(),
        ];

        $notification = Notification::create($notificationData);

        expect($notification)
            ->toBeInstanceOf(Notification::class)
            ->and($notification->tracking['opens'])
            ->toBeTrue()
            ->and($notification->tracking['clicks'])
            ->toBeTrue()
            ->and($notification->tracking_id)
            ->toStartWith('track_');

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'tracking' => json_encode($notificationData['tracking']),
        ]);
    });

    it('can create notification with custom headers', function () {
        $notificationData = [
            'type' => 'email',
            'subject' => 'Custom Headers Notification Test',
            'content' => 'This notification has custom headers',
            'status' => 'pending',
            'priority' => 'normal',
            'custom_headers' => [
                'X-Campaign-ID' => 'summer_2024',
                'X-User-Segment' => 'premium',
                'X-Template-Version' => '2.1',
                'X-A/B-Test' => 'variant_b',
            ],
        ];

        $notification = Notification::create($notificationData);

        expect($notification)
            ->toBeInstanceOf(Notification::class)
            ->and($notification->custom_headers['X-Campaign-ID'])
            ->toBe('summer_2024')
            ->and($notification->custom_headers['X-User-Segment'])
            ->toBe('premium')
            ->and($notification->custom_headers['X-Template-Version'])
            ->toBe('2.1');

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'custom_headers' => json_encode($notificationData['custom_headers']),
        ]);
    });

    it('can create notification with attachments', function () {
        $notificationData = [
            'type' => 'email',
            'subject' => 'Attachment Notification Test',
            'content' => 'This notification has attachments',
            'status' => 'pending',
            'priority' => 'normal',
            'attachments' => [
                [
                    'filename' => 'welcome_guide.pdf',
                    'path' => '/storage/documents/welcome_guide.pdf',
                    'mime_type' => 'application/pdf',
                    'size' => 1024000, // 1MB
                ],
                [
                    'filename' => 'company_logo.png',
                    'path' => '/storage/images/company_logo.png',
                    'mime_type' => 'image/png',
                    'size' => 51200, // 50KB
                ],
            ],
        ];

        $notification = Notification::create($notificationData);

        expect($notification)
            ->toBeInstanceOf(Notification::class)
            ->and($notification->attachments)
            ->toHaveCount(2)
            ->and($notification->attachments[0]['filename'])
            ->toBe('welcome_guide.pdf')
            ->and($notification->attachments[1]['filename'])
            ->toBe('company_logo.png');

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'attachments' => json_encode($notificationData['attachments']),
        ]);
    });

    it('can create notification with recipient groups', function () {
        $notificationData = [
            'type' => 'email',
            'subject' => 'Group Notification Test',
            'content' => 'This notification is sent to a group of recipients',
            'status' => 'pending',
            'priority' => 'normal',
            'recipient_groups' => [
                'all_users' => true,
                'premium_users' => true,
                'new_users' => false,
                'inactive_users' => false,
            ],
            'group_filters' => [
                'user_type' => ['patient', 'doctor'],
                'registration_date' => [
                    'start' => '2024-01-01',
                    'end' => '2024-12-31',
                ],
                'last_activity' => [
                    'min_days' => 30,
                ],
            ],
        ];

        $notification = Notification::create($notificationData);

        expect($notification)
            ->toBeInstanceOf(Notification::class)
            ->and($notification->recipient_groups['all_users'])
            ->toBeTrue()
            ->and($notification->recipient_groups['premium_users'])
            ->toBeTrue()
            ->and($notification->group_filters['user_type'])
            ->toContain('patient')
            ->and($notification->group_filters['user_type'])
            ->toContain('doctor');

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'recipient_groups' => json_encode($notificationData['recipient_groups']),
            'group_filters' => json_encode($notificationData['group_filters']),
        ]);
    });
});
