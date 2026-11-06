<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Gdpr\Models\Consent;
use PHPUnit\Framework\Assert;

test('consent_fillable_attributes', function (): void {
    $consent = new Consent();
    $fillable = $consent->getFillable();

    assertFillableContains([
        'subject_id',
        'treatment_id',
        'user_id',
        'user_type',
        'type',
        'accepted_at',
    ], $fillable);
});

test('consent_has_treatment_relationship_method', function (): void {
    $consent = new Consent();

    Assert::assertTrue((new \ReflectionClass($consent))->hasMethod('treatment'));
});

test('consent_is_not_incrementing', function (): void {
    $consent = new Consent();

    Assert::assertFalse($consent->getIncrementing());
});

test('consent_is_uuid', function (): void {
    $consent = new Consent();
    $traits = class_uses_recursive($consent);

    Assert::assertArrayHasKey(HasUuids::class, $traits);
});
