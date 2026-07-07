<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Event;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Gdpr\Tests\TestCase $this */
    gdprAssertDatabaseAvailable();
});

it('can create and manage gdpr consents', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();

    // Act - Create consent with fields that exist in the actual table
    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => null, // Optional foreign key
    ]);

    // Assert
    assertGdprTableHas('consents', [
        'id' => $consent->id,
        'subject_id' => $user->id,
    ]);

    Assert::assertSame($user->id, $consent->subject_id);
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
    assertGdprTableHas('treatments', [
        'id' => $treatment->id,
        'name' => 'Email Marketing',
        'active' => true,
    ]);

    Assert::assertSame('Email Marketing', $treatment->name);
    Assert::assertTrue($treatment->active);
    Assert::assertFalse($treatment->required);
});

it('can link consents to treatments', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();
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
    assertGdprTableHas('consents', [
        'id' => $consent->id,
        'treatment_id' => $treatment->id,
        'subject_id' => $user->id,
    ]);

    Assert::assertSame($treatment->id, $consent->treatment_id);
    Assert::assertSame($user->id, $consent->subject_id);
});

it('can manage gdpr events', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();

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
    assertGdprTableHas('gdpr_events', [
        'id' => $event->id,
        'subject_id' => $user->id,
        'action' => 'consent_given',
        'ip' => '192.168.1.1',
    ]);

    Assert::assertSame($user->id, $event->subject_id);
    Assert::assertSame('consent_given', $event->action);
    Assert::assertSame('192.168.1.1', $event->ip);
});

it('can track gdpr audit trail', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();

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

    Assert::assertCount(2, $userConsents);
    Assert::assertCount(2, $userEvents);
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
    Assert::assertSame('Marketing Communications', $treatment1->name);
    Assert::assertFalse($treatment1->required);
    Assert::assertSame('Service Delivery', $treatment2->name);
    Assert::assertTrue($treatment2->required);
    Assert::assertSame('Analytics', $treatment3->name);
    Assert::assertFalse($treatment3->active);
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
    Assert::assertSame(1, $treatmentLow->weight);
    Assert::assertSame(100, $treatmentHigh->weight);
    // Check ordering by weight
    $treatments = Treatment::orderBy('weight', 'asc')->get();
    $first = $treatments->first();
    $last = $treatments->last();
    Assert::assertNotNull($first);
    Assert::assertNotNull($last);
    Assert::assertSame('Low Priority', $first->name);
    Assert::assertSame('High Priority', $last->name);
});

it('can manage consent with treatment relationships', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();
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
    assertGdprTableHas('consents', [
        'id' => $consent->id,
        'subject_id' => $user->id,
        'treatment_id' => $treatment->id,
    ]);

    Assert::assertSame($user->id, $consent->subject_id);
    Assert::assertSame($treatment->id, $consent->treatment_id);
});

it('can manage multiple consents per subject', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();
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
    Assert::assertCount(2, $userConsents);
    $consentTreatmentIds = $userConsents->pluck('treatment_id')->all();
    Assert::assertContains($treatment1->id, $consentTreatmentIds);
    Assert::assertContains($treatment2->id, $consentTreatmentIds);
});

it('can create events with detailed payloads', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();

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
    assertGdprTableHas('gdpr_events', [
        'id' => $event->id,
        'subject_id' => $user->id,
        'action' => 'data_access_request',
        'ip' => '203.0.113.1',
    ]);

    $payload = json_decode((string) $event->payload, true);
    Assert::assertIsArray($payload);
    Assert::assertSame('access', $payload['request_type']);
    $categories = $payload['data_categories'];
    Assert::assertIsArray($categories);
    Assert::assertContains('personal', $categories);
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
    Assert::assertSame('2.1', $treatmentWithDoc->documentVersion);
    Assert::assertSame('/docs/privacy-policy-v2.1.pdf', $treatmentWithDoc->documentUrl);
    Assert::assertNull($treatmentWithoutDoc->documentVersion);
    Assert::assertNull($treatmentWithoutDoc->documentUrl);
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
    Assert::assertTrue($activeTreatment->active);
    Assert::assertFalse($inactiveTreatment->active);
    $activeTreatments = Treatment::where('active', true)->get();
    Assert::assertTrue($activeTreatments->contains('id', $activeTreatment->id));
    Assert::assertFalse($activeTreatments->contains('id', $inactiveTreatment->id));
});

it('can manage consent timestamps', function (): void {
    // Arrange
    $user = UserFactory::new()->createOne();

    // Act
    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => null,
    ]);

    // Assert
    Assert::assertNotNull($consent->created_at);
    Assert::assertNotNull($consent->updated_at);
    // Created and updated should be close to now
    $now = now();
    Assert::assertTrue($consent->created_at->between($now->subMinute(), $now->addMinute()));
});
