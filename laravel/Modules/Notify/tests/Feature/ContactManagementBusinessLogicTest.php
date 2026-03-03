<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\Contact;
use Modules\Notify\Models\ContactGroup;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

it('can create contact with basic information', function (): void {
    // Arrange
    $contactData = [
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.com',
        'phone' => '+39 123 456 7890',
        'company' => 'Studio Dentistico Milano',
        'is_active' => true,
    ];

    // Act
    $contact = Contact::create($contactData);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.com',
        'phone' => '+39 123 456 7890',
        'company' => 'Studio Dentistico Milano',
        'is_active' => true,
    ]);

    expect($contact->name)->toBe('Mario Rossi');
    expect($contact->email)->toBe('mario.rossi@example.com');
    expect($contact->is_active)->toBeTrue();
});

it('can create contact group', function (): void {
    // Arrange
    $groupData = [
        'name' => 'Dottori Specialisti',
        'description' => 'Gruppo per dottori specialisti',
        'is_active' => true,
    ];

    // Act
    $group = ContactGroup::create($groupData);

    // Assert
    $this->assertDatabaseHas('contact_groups', [
        'id' => $group->id,
        'name' => 'Dottori Specialisti',
        'description' => 'Gruppo per dottori specialisti',
        'is_active' => true,
    ]);

    expect($group->name)->toBe('Dottori Specialisti');
    expect($group->description)->toBe('Gruppo per dottori specialisti');
    expect($group->is_active)->toBeTrue();
});

it('can manage contact notification preferences', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $preferences = [
        'email' => true,
        'sms' => false,
        'push' => true,
        'frequency' => 'daily',
        'quiet_hours' => [
            'start' => '22:00',
            'end' => '08:00',
        ],
        'timezone' => 'Europe/Rome',
    ];

    // Act
    $contact->update(['preferences' => $preferences]);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'preferences' => json_encode($preferences),
    ]);

    $freshPreferences = $contact->fresh()->preferences;
    expect($freshPreferences['email'])->toBeTrue();
    expect($freshPreferences['sms'])->toBeFalse();
    expect($freshPreferences['push'])->toBeTrue();
    expect($freshPreferences['frequency'])->toBe('daily');
    expect($freshPreferences['quiet_hours']['start'])->toBe('22:00');
    expect($freshPreferences['quiet_hours']['end'])->toBe('08:00');
    expect($freshPreferences['timezone'])->toBe('Europe/Rome');
});

it('can manage contact demographics', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $demographics = [
        'age' => 35,
        'gender' => 'M',
        'location' => 'Milano, Italia',
        'language' => 'it',
        'interests' => ['dentistry', 'healthcare', 'technology'],
        'profession' => 'Dentist',
        'experience_years' => 8,
    ];

    // Act
    $contact->update(['demographics' => $demographics]);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'demographics' => json_encode($demographics),
    ]);

    $freshDemographics = $contact->fresh()->demographics;
    expect($freshDemographics['age'])->toBe(35);
    expect($freshDemographics['gender'])->toBe('M');
    expect($freshDemographics['location'])->toBe('Milano, Italia');
    expect($freshDemographics['language'])->toBe('it');
    expect($freshDemographics['interests'])->toContain('dentistry');
    expect($freshDemographics['profession'])->toBe('Dentist');
    expect($freshDemographics['experience_years'])->toBe(8);
});

it('can manage contact communication history', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $communicationHistory = [
        [
            'type' => 'email',
            'subject' => 'Benvenuto su '.config('app.name', 'Our Platform'),
            'sent_at' => now()->subDays(5)->toISOString(),
            'status' => 'delivered',
            'opened' => true,
            'clicked' => false,
        ],
        [
            'type' => 'sms',
            'message' => 'Promemoria appuntamento domani',
            'sent_at' => now()->subDays(2)->toISOString(),
            'status' => 'delivered',
            'opened' => true,
            'clicked' => true,
        ],
    ];

    // Act
    $contact->update(['communication_history' => $communicationHistory]);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'communication_history' => json_encode($communicationHistory),
    ]);

    $freshHistory = $contact->fresh()->communication_history;
    expect($freshHistory)->toHaveCount(2);
    expect($freshHistory[0]['type'])->toBe('email');
    expect($freshHistory[0]['subject'])->toBe('Benvenuto su '.config('app.name', 'Our Platform'));
    expect($freshHistory[1]['type'])->toBe('sms');
    expect($freshHistory[1]['clicked'])->toBeTrue();
});

it('can manage contact tags', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $tags = [
        'vip' => 'Cliente VIP',
        'new' => 'Nuovo cliente',
        'premium' => 'Piano premium',
        'active' => 'Cliente attivo',
    ];

    // Act
    $contact->update(['tags' => $tags]);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'tags' => json_encode($tags),
    ]);

    $freshTags = $contact->fresh()->tags;
    expect($freshTags)->toHaveCount(4);
    expect($freshTags['vip'])->toBe('Cliente VIP');
    expect($freshTags['new'])->toBe('Nuovo cliente');
    expect($freshTags['premium'])->toBe('Piano premium');
    expect($freshTags['active'])->toBe('Cliente attivo');
});

it('can manage contact custom fields', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $customFields = [
        'specialization' => 'Ortodonzia',
        'university' => 'Università di Milano',
        'certifications' => ['Invisalign', 'Lingual'],
        'preferred_contact_time' => 'mattina',
        'emergency_contact' => '+39 987 654 3210',
        'notes' => 'Cliente molto soddisfatto del servizio',
    ];

    // Act
    $contact->update(['custom_fields' => $customFields]);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'custom_fields' => json_encode($customFields),
    ]);

    $freshCustomFields = $contact->fresh()->custom_fields;
    expect($freshCustomFields['specialization'])->toBe('Ortodonzia');
    expect($freshCustomFields['university'])->toBe('Università di Milano');
    expect($freshCustomFields['certifications'])->toContain('Invisalign');
    expect($freshCustomFields['preferred_contact_time'])->toBe('mattina');
    expect($freshCustomFields['emergency_contact'])->toBe('+39 987 654 3210');
});

it('can manage contact subscription status', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $subscriptionData = [
        'subscribed' => true,
        'subscription_date' => now()->subMonths(3),
        'unsubscribe_date' => null,
        'unsubscribe_reason' => null,
        'subscription_source' => 'website_form',
        'double_optin' => true,
        'last_activity' => now()->subDays(1),
    ];

    // Act
    $contact->update($subscriptionData);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'subscribed' => true,
        'subscription_source' => 'website_form',
        'double_optin' => true,
    ]);

    expect($contact->fresh()->subscribed)->toBeTrue();
    expect($contact->fresh()->subscription_source)->toBe('website_form');
    expect($contact->fresh()->double_optin)->toBeTrue();
    expect($contact->fresh()->subscription_date)->not->toBeNull();
    expect($contact->fresh()->unsubscribe_date)->toBeNull();

    // Act - Unsubscribe
    $contact->update([
        'subscribed' => false,
        'unsubscribe_date' => now(),
        'unsubscribe_reason' => 'Troppe email',
    ]);

    // Assert
    expect($contact->fresh()->subscribed)->toBeFalse();
    expect($contact->fresh()->unsubscribe_date)->not->toBeNull();
    expect($contact->fresh()->unsubscribe_reason)->toBe('Troppe email');
});

it('can manage contact engagement score', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $engagementData = [
        'engagement_score' => 85,
        'last_interaction' => now()->subDays(2),
        'interaction_count' => 15,
        'response_rate' => 78.5,
        'preferred_channel' => 'email',
        'engagement_level' => 'high',
        'lifetime_value' => 2500.00,
    ];

    // Act
    $contact->update($engagementData);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'engagement_score' => 85,
        'interaction_count' => 15,
        'response_rate' => 78.5,
        'preferred_channel' => 'email',
        'engagement_level' => 'high',
        'lifetime_value' => 2500.00,
    ]);

    expect($contact->fresh()->engagement_score)->toBe(85);
    expect($contact->fresh()->interaction_count)->toBe(15);
    expect($contact->fresh()->response_rate)->toBe(78.5);
    expect($contact->fresh()->preferred_channel)->toBe('email');
    expect($contact->fresh()->engagement_level)->toBe('high');
    expect($contact->fresh()->lifetime_value)->toBe(2500.00);
});

it('can manage contact privacy settings', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $privacySettings = [
        'gdpr_consent' => true,
        'consent_date' => now()->subMonths(6),
        'data_processing_consent' => true,
        'marketing_consent' => true,
        'third_party_sharing' => false,
        'data_retention_preference' => '5_years',
        'right_to_be_forgotten' => false,
        'data_portability' => true,
    ];

    // Act
    $contact->update(['privacy_settings' => $privacySettings]);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'privacy_settings' => json_encode($privacySettings),
    ]);

    $freshPrivacy = $contact->fresh()->privacy_settings;
    expect($freshPrivacy['gdpr_consent'])->toBeTrue();
    expect($freshPrivacy['data_processing_consent'])->toBeTrue();
    expect($freshPrivacy['marketing_consent'])->toBeTrue();
    expect($freshPrivacy['third_party_sharing'])->toBeFalse();
    expect($freshPrivacy['data_retention_preference'])->toBe('5_years');
    expect($freshPrivacy['data_portability'])->toBeTrue();
});

it('can search contacts by preferences', function (): void {
    // Arrange
    $emailContact = Contact::factory()->create([
        'preferences' => ['email' => true, 'sms' => false],
    ]);
    $smsContact = Contact::factory()->create([
        'preferences' => ['email' => false, 'sms' => true],
    ]);
    $bothContact = Contact::factory()->create([
        'preferences' => ['email' => true, 'sms' => true],
    ]);

    // Act
    $emailOnlyContacts = Contact::whereJsonContains('preferences->email', true)
        ->whereJsonContains('preferences->sms', false)
        ->get();

    $smsOnlyContacts = Contact::whereJsonContains('preferences->sms', true)
        ->whereJsonContains('preferences->email', false)
        ->get();

    // Assert
    expect($emailOnlyContacts)->toHaveCount(1);
    expect($smsOnlyContacts)->toHaveCount(1);
    expect($emailOnlyContacts->contains($emailContact))->toBeTrue();
    expect($smsOnlyContacts->contains($smsContact))->toBeTrue();
});

it('can search contacts by tags', function (): void {
    // Arrange
    $vipContact = Contact::factory()->create([
        'tags' => ['vip' => 'Cliente VIP', 'premium' => 'Piano premium'],
    ]);
    $newContact = Contact::factory()->create([
        'tags' => ['new' => 'Nuovo cliente', 'active' => 'Cliente attivo'],
    ]);

    // Act
    $vipContacts = Contact::whereJsonContains('tags->vip', 'Cliente VIP')->get();
    $newContacts = Contact::whereJsonContains('tags->new', 'Nuovo cliente')->get();

    // Assert
    expect($vipContacts)->toHaveCount(1);
    expect($newContacts)->toHaveCount(1);
    expect($vipContacts->contains($vipContact))->toBeTrue();
    expect($newContacts->contains($newContact))->toBeTrue();
});

it('can search contacts by engagement level', function (): void {
    // Arrange
    $highEngagementContact = Contact::factory()->create(['engagement_level' => 'high']);
    $mediumEngagementContact = Contact::factory()->create(['engagement_level' => 'medium']);
    $lowEngagementContact = Contact::factory()->create(['engagement_level' => 'low']);

    // Act
    $highEngagementContacts = Contact::where('engagement_level', 'high')->get();
    $mediumEngagementContacts = Contact::where('engagement_level', 'medium')->get();

    // Assert
    expect($highEngagementContacts)->toHaveCount(1);
    expect($mediumEngagementContacts)->toHaveCount(1);
    expect($highEngagementContacts->contains($highEngagementContact))->toBeTrue();
    expect($mediumEngagementContacts->contains($mediumEngagementContact))->toBeTrue();
});

it('can get contacts with related data', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $group = ContactGroup::factory()->create();

    $contact->update(['group_id' => $group->id]);

    // Act
    $contactWithGroup = Contact::with('group')->find($contact->id);

    // Assert
    expect($contactWithGroup)->not->toBeNull();
    expect($contactWithGroup->relationLoaded('group'))->toBeTrue();
    expect($contactWithGroup->group->id)->toBe($group->id);
});

it('can manage contact import export', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $importData = [
        'import_source' => 'csv_upload',
        'import_date' => now()->subDays(10),
        'import_batch_id' => 'batch_001',
        'import_notes' => 'Importazione da sistema legacy',
        'export_history' => [
            [
                'export_date' => now()->subDays(5)->toISOString(),
                'export_format' => 'csv',
                'export_reason' => 'Backup mensile',
                'exported_by' => 'admin_user',
            ],
        ],
    ];

    // Act
    $contact->update($importData);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'import_source' => 'csv_upload',
        'import_batch_id' => 'batch_001',
    ]);

    expect($contact->fresh()->import_source)->toBe('csv_upload');
    expect($contact->fresh()->import_batch_id)->toBe('batch_001');
    expect($contact->fresh()->import_notes)->toBe('Importazione da sistema legacy');
    expect($contact->fresh()->export_history)->toHaveCount(1);
    expect($contact->fresh()->export_history[0]['export_format'])->toBe('csv');
});

it('can manage contact activity tracking', function (): void {
    // Arrange
    $contact = Contact::factory()->create();
    $activityData = [
        'last_activity' => now()->subHours(2),
        'activity_count' => 25,
        'activity_types' => ['email_open', 'link_click', 'form_submit'],
        'favorite_pages' => ['/dashboard', '/appointments', '/profile'],
        'session_duration' => 1800, // 30 minutes
        'bounce_rate' => 15.5,
        'conversion_rate' => 8.2,
    ];

    // Act
    $contact->update($activityData);

    // Assert
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'activity_count' => 25,
        'session_duration' => 1800,
        'bounce_rate' => 15.5,
        'conversion_rate' => 8.2,
    ]);

    $freshActivity = $contact->fresh();
    expect($freshActivity->activity_count)->toBe(25);
    expect($freshActivity->activity_types)->toHaveCount(3);
    expect($freshActivity->activity_types)->toContain('email_open');
    expect($freshActivity->favorite_pages)->toContain('/dashboard');
    expect($freshActivity->session_duration)->toBe(1800);
    expect($freshActivity->bounce_rate)->toBe(15.5);
    expect($freshActivity->conversion_rate)->toBe(8.2);
});
