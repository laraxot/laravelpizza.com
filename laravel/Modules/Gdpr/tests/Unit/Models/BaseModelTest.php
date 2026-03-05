<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\BaseModel;
use Modules\Gdpr\Models\Consent;

test('consent_extends_base_model', function () {
    $consent = new Consent();

    expect($consent)->toBeInstanceOf(BaseModel::class);
});

test('base_model_is_abstract', function () {
    $reflection = new ReflectionClass(BaseModel::class);

    expect($reflection->isAbstract())->toBeTrue();
});

test('base_model_uses_gdpr_connection', function () {
    $model = new class extends BaseModel
    {
    };

    expect($model->getConnectionName())->toBe('gdpr');
});
