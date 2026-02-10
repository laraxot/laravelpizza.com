<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Gdpr\Models\BaseModel;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;

test('base model extends eloquent model', function () {
    $consent = new Consent();
    expect($consent)->toBeInstanceOf(Model::class);
    expect($consent)->toBeInstanceOf(BaseModel::class);
});

test('consent model uses gdpr connection', function () {
    $consent = new Consent();
    expect($consent->getConnectionName())->toBe('gdpr');
});

test('treatment model uses gdpr connection', function () {
    $treatment = new Treatment();
    expect($treatment->getConnectionName())->toBe('gdpr');
});

test('consent model has timestamps enabled', function () {
    $consent = new Consent();
    expect($consent->usesTimestamps())->toBeTrue();
});

test('treatment model has timestamps enabled', function () {
    $treatment = new Treatment();
    expect($treatment->usesTimestamps())->toBeTrue();
});

test('consent model is not incrementing', function () {
    $consent = new Consent();
    expect($consent->getIncrementing())->toBeFalse();
});

test('treatment model is not incrementing', function () {
    $treatment = new Treatment();
    expect($treatment->getIncrementing())->toBeFalse();
});
