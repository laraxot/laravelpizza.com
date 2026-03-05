<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Filament\Resources\TreatmentResource;

test('treatment_resource_extends_xot_base_resource', function () {
    expect(is_subclass_of(TreatmentResource::class, Modules\Xot\Filament\Resources\XotBaseResource::class))->toBeTrue();
});

test('treatment_resource_model_is_treatment', function () {
    $resource = new TreatmentResource();
    expect($resource->getModel())->toBe(Modules\Gdpr\Models\Treatment::class);
});

test('treatment_resource_has_form_schema', function () {
    expect(method_exists(TreatmentResource::class, 'getFormSchema'))->toBeTrue();
});

test('treatment_resource_has_pages', function () {
    expect(method_exists(TreatmentResource::class, 'getPages'))->toBeTrue();
    $pages = TreatmentResource::getPages();
    expect($pages)->toBeArray();
});
