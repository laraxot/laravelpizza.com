<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;

test('consent can be created with subject and treatment', function () {
    $user = User::factory()->create();
    $treatment = Treatment::firstOrCreate(
        ['name' => 'privacy_policy'],
        ['description' => 'Privacy Policy', 'weight' => 1, 'active' => true, 'required' => true]
    );

    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => $treatment->id,
        'user_id' => $user->id,
        'user_type' => get_class($user),
        'type' => 'privacy_policy',
        'accepted_at' => now(),
    ]);

    expect($consent)
        ->toBeConsent()
        ->and($consent->type)
        ->toBe('privacy_policy')
        ->and($consent->accepted_at)
        ->not->toBeNull();
});

test('consent belongs to treatment', function () {
    $user = User::factory()->create();
    $treatment = Treatment::firstOrCreate(
        ['name' => 'terms_conditions'],
        ['description' => 'Terms and Conditions', 'weight' => 2, 'active' => true, 'required' => true]
    );

    $consent = Consent::create([
        'subject_id' => $user->id,
        'treatment_id' => $treatment->id,
        'type' => 'terms_conditions',
    ]);

    expect($consent->treatment)->toBeInstanceOf(Treatment::class);
    expect($consent->treatment->id)->toBe($treatment->id);
});

test('consent can be created without accepted_at (declined)', function () {
    $user = User::factory()->create();

    $consent = Consent::create([
        'subject_id' => $user->id,
        'type' => 'marketing_consent',
        'accepted_at' => null,
    ]);

    expect($consent->accepted_at)->toBeNull();
});

test('consent has uuid primary key', function () {
    $user = User::factory()->create();

    $consent = Consent::create([
        'subject_id' => $user->id,
        'type' => 'privacy_policy',
    ]);

    expect($consent->id)->toBeString();
    expect(strlen($consent->id))->toBe(36);
});

test('consent fillable fields are correct', function () {
    $consent = new Consent();

    expect($consent->getFillable())->toContain('subject_id');
    expect($consent->getFillable())->toContain('treatment_id');
    expect($consent->getFillable())->toContain('user_id');
    expect($consent->getFillable())->toContain('user_type');
    expect($consent->getFillable())->toContain('type');
    expect($consent->getFillable())->toContain('accepted_at');
});
