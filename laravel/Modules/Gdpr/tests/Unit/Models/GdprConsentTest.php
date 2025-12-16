<?php

declare(strict_types=1);

use Modules\Gdpr\Models\GdprConsent;
use Modules\User\Models\User;

test('gdpr consent can be created', function () {
    $user = User::factory()->create();

    $consent = createGdprConsent([
        'user_id' => $user->id,
        'consent_type' => 'privacy_policy',
        'consented_at' => now(),
        'ip_address' => '192.168.1.1',
    ]);

    expect($consent)
        ->toBeGdprConsent()
        ->and($consent->consent_type)
        ->toBe('privacy_policy')
        ->and($consent->ip_address)
        ->toBe('192.168.1.1')
        ->and($consent->consented_at)
        ->not->toBeNull();
});

test('gdpr consent belongs to user', function () {
    $user = User::factory()->create();
    $consent = createGdprConsent(['user_id' => $user->id]);

    expect($consent->user)->toBeInstanceOf(User::class)->and($consent->user->id)->toBe($user->id);
});

test('gdpr consent can be withdrawn', function () {
    $consent = createGdprConsent(['withdrawn_at' => null]);

    $consent->withdraw();

    expect($consent->fresh()->withdrawn_at)->not->toBeNull();
});

test('gdpr consent scope active works', function () {
    createGdprConsent(['withdrawn_at' => null]); // Active
    createGdprConsent(['withdrawn_at' => now()]); // Withdrawn

    $activeCount = GdprConsent::active()->count();

    expect($activeCount)->toBe(1);
});
