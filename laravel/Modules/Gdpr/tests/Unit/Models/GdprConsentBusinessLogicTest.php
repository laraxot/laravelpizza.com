<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;

describe('Consent Business Logic', function () {
    it('records consent with required metadata', function () {
        $user = User::factory()->create();
        $treatment = Treatment::firstOrCreate(
            ['name' => 'privacy_policy'],
            ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
        );

        $consent = Consent::create([
            'subject_id' => $user->id,
            'user_id' => $user->id,
            'user_type' => get_class($user),
            'treatment_id' => $treatment->id,
            'type' => 'privacy_policy',
            'accepted_at' => now(),
        ]);

        expect($consent)
            ->toBeInstanceOf(Consent::class)
            ->and($consent->subject_id)
            ->toBe($user->id)
            ->and($consent->type)
            ->toBe('privacy_policy')
            ->and($consent->accepted_at)
            ->not->toBeNull();
    });

    it('distinguishes accepted from declined consents', function () {
        $user = User::factory()->create();

        $accepted = Consent::create([
            'subject_id' => $user->id,
            'type' => 'privacy_policy',
            'accepted_at' => now(),
        ]);

        $declined = Consent::create([
            'subject_id' => $user->id,
            'type' => 'marketing_consent',
            'accepted_at' => null,
        ]);

        expect($accepted->accepted_at)->not->toBeNull();
        expect($declined->accepted_at)->toBeNull();
    });

    it('can track multiple consents per user', function () {
        $user = User::factory()->create();

        $privacyTreatment = Treatment::firstOrCreate(
            ['name' => 'privacy_policy'],
            ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
        );
        $termsTreatment = Treatment::firstOrCreate(
            ['name' => 'terms_conditions'],
            ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
        );
        $marketingTreatment = Treatment::firstOrCreate(
            ['name' => 'marketing_consent'],
            ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
        );

        Consent::create([
            'subject_id' => $user->id,
            'treatment_id' => $privacyTreatment->id,
            'type' => 'privacy_policy',
            'accepted_at' => now(),
        ]);

        Consent::create([
            'subject_id' => $user->id,
            'treatment_id' => $termsTreatment->id,
            'type' => 'terms_conditions',
            'accepted_at' => now(),
        ]);

        Consent::create([
            'subject_id' => $user->id,
            'treatment_id' => $marketingTreatment->id,
            'type' => 'marketing_consent',
            'accepted_at' => null,
        ]);

        $userConsents = Consent::where('subject_id', $user->id)->get();
        expect($userConsents)->toHaveCount(3);

        $acceptedCount = $userConsents->whereNotNull('accepted_at')->count();
        expect($acceptedCount)->toBe(2);
    });

    it('stores consent timestamps correctly', function () {
        $user = User::factory()->create();

        $consent = Consent::create([
            'subject_id' => $user->id,
            'type' => 'privacy_policy',
            'accepted_at' => now(),
        ]);

        expect($consent->created_at)->not->toBeNull();
        expect($consent->updated_at)->not->toBeNull();
    });

    it('links consent to correct treatment', function () {
        $user = User::factory()->create();
        $treatment = Treatment::firstOrCreate(
            ['name' => 'marketing_consent'],
            ['description' => 'Marketing Consent', 'weight' => 3, 'active' => true, 'required' => false]
        );

        $consent = Consent::create([
            'subject_id' => $user->id,
            'treatment_id' => $treatment->id,
            'type' => 'marketing_consent',
            'accepted_at' => null,
        ]);

        $freshConsent = Consent::find($consent->id);
        expect($freshConsent->treatment_id)->toBe($treatment->id);
        expect($freshConsent->treatment)->toBeInstanceOf(Treatment::class);
        expect($freshConsent->treatment->name)->toBe('marketing_consent');
    });
});
