<?php

declare(strict_types=1);

use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Event;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

it('can create and manage gdpr consents', function (): void {
    // Arrange
    $user = User::factory()->create();

    // Act - Create consent with fields that exist in the actual table
    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => null, // Optional foreign key
    ]);

    // Assert
    $this->assertDatabaseHas('consents', [
        'id' => $consent->id,
        'subject_id' => $user->id,
    ]);

    expect($consent->subject_id)->toBe($user->id);
});

it('can work with gdpr treatments', function (): void {
    // Act
    $treatment = Treatment::create([
        'name' => 'Email Marketing',
        'description' => 'Processing personal data for email marketing purposes',
        'weight' => 10,
        'active' => true,
        'required' => false,
    ]);

    // Assert
    $this->assertDatabaseHas('treatments', [
        'id' => $treatment->id,
        'name' => 'Email Marketing',
        'active' => true,
    ]);

    expect($treatment->name)->toBe('Email Marketing');
    expect($treatment->active)->toBeTrue();
    expect($treatment->required)->toBeFalse();
});

it('can link consents to treatments', function (): void {
    // Arrange
    $user = User::factory()->create();
    $treatment = Treatment::create([
        'name' => 'Data Analytics',
        'description' => 'Processing data for analytics',
        'weight' => 5,
        'active' => true,
        'required' => true,
    ]);

    // Act
    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => $treatment->id,
    ]);

    // Assert
    $this->assertDatabaseHas('consents', [
        'id' => $consent->id,
        'treatment_id' => $treatment->id,
        'subject_id' => $user->id,
    ]);

    expect($consent->treatment_id)->toBe($treatment->id);
    expect($consent->subject_id)->toBe($user->id);
});

it('can manage gdpr events', function (): void {
    // Arrange
    $user = User::factory()->create();

    // Act
    $event = Event::create([
        'subject_id' => $user->id,
        'action' => 'consent_given',
        'ip' => '192.168.1.1',
        'payload' => json_encode([
            'consent_type' => 'marketing',
            'user_agent' => 'Test Browser',
        ]),
    ]);

    // Assert
    $this->assertDatabaseHas('gdpr_events', [
        'id' => $event->id,
        'subject_id' => $user->id,
        'action' => 'consent_given',
        'ip' => '192.168.1.1',
    ]);

    expect($event->subject_id)->toBe($user->id);
    expect($event->action)->toBe('consent_given');
    expect($event->ip)->toBe('192.168.1.1');
});

it('can track gdpr audit trail', function (): void {
    // Arrange
    $user = User::factory()->create();

    // Act - Create multiple consents
    $consent1 = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => null,
    ]);

    $consent2 = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => null,
    ]);

    // Create events
    Event::create([
        'subject_id' => $user->id,
        'action' => 'consent_given',
        'ip' => '192.168.1.1',
        'payload' => json_encode(['type' => 'marketing']),
    ]);

    Event::create([
        'subject_id' => $user->id,
        'action' => 'consent_withdrawn',
        'ip' => '192.168.1.1',
        'payload' => json_encode(['type' => 'analytics']),
    ]);

    // Assert
    $userConsents = Consent::where('subject_id', $user->id)->get();
    $userEvents = Event::where('subject_id', $user->id)->get();

    expect($userConsents)->toHaveCount(2);
    expect($userEvents)->toHaveCount(2);
});

it('can handle different treatment types', function (): void {
    // Act
    $treatment1 = Treatment::create([
        'name' => 'Marketing Communications',
        'description' => 'Email marketing based on explicit consent',
        'weight' => 1,
        'active' => true,
        'required' => false,
    ]);

    $treatment2 = Treatment::create([
        'name' => 'Service Delivery',
        'description' => 'Processing necessary for service delivery',
        'weight' => 2,
        'active' => true,
        'required' => true,
    ]);

    $treatment3 = Treatment::create([
        'name' => 'Analytics',
        'description' => 'Analytics based on legitimate interests',
        'weight' => 3,
        'active' => false,
        'required' => false,
    ]);

    // Assert
    expect($treatment1->name)->toBe('Marketing Communications');
    expect($treatment1->required)->toBeFalse();

    expect($treatment2->name)->toBe('Service Delivery');
    expect($treatment2->required)->toBeTrue();

    expect($treatment3->name)->toBe('Analytics');
    expect($treatment3->active)->toBeFalse();
});

it('can manage treatment weights', function (): void {
    // Act
    $treatmentLow = Treatment::create([
        'name' => 'Low Priority',
        'description' => 'Treatment with low priority',
        'weight' => 1,
        'active' => true,
        'required' => false,
    ]);

    $treatmentHigh = Treatment::create([
        'name' => 'High Priority',
        'description' => 'Treatment with high priority',
        'weight' => 100,
        'active' => true,
        'required' => true,
    ]);

    // Assert
    expect($treatmentLow->weight)->toBe(1);
    expect($treatmentHigh->weight)->toBe(100);

    // Check ordering by weight
    $treatments = Treatment::orderBy('weight', 'asc')->get();
    expect($treatments->first()->name)->toBe('Low Priority');
    expect($treatments->last()->name)->toBe('High Priority');
});

it('can manage consent with treatment relationships', function (): void {
    // Arrange
    $user = User::factory()->create();
    $treatment = Treatment::create([
        'name' => 'Email Consent',
        'description' => 'Consent for email communications',
        'weight' => 5,
        'active' => true,
        'required' => false,
    ]);

    // Act
    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => $treatment->id,
    ]);

    // Assert
    $this->assertDatabaseHas('consents', [
        'id' => $consent->id,
        'subject_id' => $user->id,
        'treatment_id' => $treatment->id,
    ]);

    expect($consent->subject_id)->toBe($user->id);
    expect($consent->treatment_id)->toBe($treatment->id);
});

it('can manage multiple consents per subject', function (): void {
    // Arrange
    $user = User::factory()->create();
    $treatment1 = Treatment::create([
        'name' => 'Treatment 1',
        'description' => 'First treatment',
        'weight' => 1,
        'active' => true,
        'required' => false,
    ]);

    $treatment2 = Treatment::create([
        'name' => 'Treatment 2',
        'description' => 'Second treatment',
        'weight' => 2,
        'active' => true,
        'required' => false,
    ]);

    // Act
    $consents = [
        Consent::create([
            'subject_id' => $user->id,
            'treatment_id' => $treatment1->id,
        ]),
        Consent::create([
            'subject_id' => $user->id,
            'treatment_id' => $treatment2->id,
        ]),
    ];

    // Assert
    $userConsents = Consent::where('subject_id', $user->id)->get();
    expect($userConsents)->toHaveCount(2);

    $consentTreatmentIds = $userConsents->pluck('treatment_id')->toArray();
    expect($consentTreatmentIds)->toContain($treatment1->id);
    expect($consentTreatmentIds)->toContain($treatment2->id);
});

it('can create events with detailed payloads', function (): void {
    // Arrange
    $user = User::factory()->create();

    // Act
    $event = Event::create([
        'subject_id' => $user->id,
        'action' => 'data_access_request',
        'ip' => '203.0.113.1',
        'payload' => json_encode([
            'request_type' => 'access',
            'data_categories' => ['personal', 'contact'],
            'request_date' => now()->toISOString(),
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'session_id' => 'session_'.uniqid(),
        ]),
    ]);

    // Assert
    $this->assertDatabaseHas('gdpr_events', [
        'id' => $event->id,
        'subject_id' => $user->id,
        'action' => 'data_access_request',
        'ip' => '203.0.113.1',
    ]);

    $payload = json_decode($event->payload, true);
    expect($payload['request_type'])->toBe('access');
    expect($payload['data_categories'])->toContain('personal');
});

it('can handle treatment document references', function (): void {
    // Act
    $treatmentWithDoc = Treatment::create([
        'name' => 'Policy Update',
        'description' => 'Updated privacy policy treatment',
        'weight' => 10,
        'active' => true,
        'required' => true,
        'documentVersion' => '2.1',
        'documentUrl' => '/docs/privacy-policy-v2.1.pdf',
    ]);

    $treatmentWithoutDoc = Treatment::create([
        'name' => 'Internal Processing',
        'description' => 'Internal data processing',
        'weight' => 5,
        'active' => true,
        'required' => false,
        'documentVersion' => null,
        'documentUrl' => null,
    ]);

    // Assert
    expect($treatmentWithDoc->documentVersion)->toBe('2.1');
    expect($treatmentWithDoc->documentUrl)->toBe('/docs/privacy-policy-v2.1.pdf');

    expect($treatmentWithoutDoc->documentVersion)->toBeNull();
    expect($treatmentWithoutDoc->documentUrl)->toBeNull();
});

it('can manage treatment active status', function (): void {
    // Act
    $activeTreatment = Treatment::create([
        'name' => 'Active Treatment',
        'description' => 'Currently active treatment',
        'weight' => 1,
        'active' => true,
        'required' => false,
    ]);

    $inactiveTreatment = Treatment::create([
        'name' => 'Inactive Treatment',
        'description' => 'Inactive treatment',
        'weight' => 2,
        'active' => false,
        'required' => false,
    ]);

    // Assert
    expect($activeTreatment->active)->toBeTrue();
    expect($inactiveTreatment->active)->toBeFalse();

    $activeTreatments = Treatment::where('active', true)->get();
    expect($activeTreatments)->toContain($activeTreatment);
    expect($activeTreatments)->not->toContain($inactiveTreatment);
});

it('can manage consent timestamps', function (): void {
    // Arrange
    $user = User::factory()->create();

    // Act
    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => null,
    ]);

    // Assert
    expect($consent->created_at)->not->toBeNull();
    expect($consent->updated_at)->not->toBeNull();

    // Created and updated should be close to now
    $now = now();
    expect($consent->created_at->between($now->subMinute(), $now->addMinute()))->toBeTrue();
});
