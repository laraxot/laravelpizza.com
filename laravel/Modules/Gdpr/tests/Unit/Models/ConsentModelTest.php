<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

uses(\Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\Consent;

test('consent_fillable_attributes', function () {
    $consent = new Consent();
    $fillable = $consent->getFillable();

    expect($fillable)->toContain('subject_id');
    expect($fillable)->toContain('treatment_id');
    expect($fillable)->toContain('user_id');
    expect($fillable)->toContain('user_type');
    expect($fillable)->toContain('type');
    expect($fillable)->toContain('accepted_at');
});

test('consent_has_treatment_relationship_method', function () {
    $consent = new Consent();

    expect(method_exists($consent, 'treatment'))->toBeTrue();
});

test('consent_is_not_incrementing', function () {
    $consent = new Consent();

    expect($consent->getIncrementing())->toBeFalse();
});

test('consent_is_uuid', function () {
    $consent = new Consent();
    $traits = class_uses_recursive($consent);

    expect($traits)->toHaveKey('Illuminate\Database\Eloquent\Concerns\HasUuids');
});
