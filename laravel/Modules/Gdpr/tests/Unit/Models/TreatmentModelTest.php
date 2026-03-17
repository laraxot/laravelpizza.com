<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

uses(\Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\Treatment;

test('treatment_fillable_attributes', function () {
    $treatment = new Treatment();
    $fillable = $treatment->getFillable();

    expect($fillable)->toContain('id');
    expect($fillable)->toContain('active');
    expect($fillable)->toContain('required');
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('description');
    expect($fillable)->toContain('documentVersion');
    expect($fillable)->toContain('documentUrl');
    expect($fillable)->toContain('weight');
});

test('treatment_is_not_incrementing', function () {
    $treatment = new Treatment();

    expect($treatment->getIncrementing())->toBeFalse();
});

test('treatment_is_uuid', function () {
    $treatment = new Treatment();
    $traits = class_uses_recursive($treatment);

    expect($traits)->toHaveKey('Illuminate\Database\Eloquent\Concerns\HasUuids');
});

test('treatment_extends_base_model', function () {
    $treatment = new Treatment();

    expect($treatment)->toBeInstanceOf(Modules\Gdpr\Models\BaseModel::class);
});
