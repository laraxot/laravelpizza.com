<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Filament\Resources\ConsentResource;
use Modules\Gdpr\Models\Consent;

test('consent_resource_extends_xot_base_resource', function () {
    expect(is_subclass_of(ConsentResource::class, Modules\Xot\Filament\Resources\XotBaseResource::class))->toBeTrue();
});

test('consent_resource_model_is_consent', function () {
    $resource = new ConsentResource();
    expect($resource->getModel())->toBe(Consent::class);
});

test('consent_resource_has_form_schema', function () {
    expect(method_exists(ConsentResource::class, 'getFormSchema'))->toBeTrue();
});

test('consent_resource_has_table_columns', function () {
    expect(method_exists(ConsentResource::class, 'getTableColumns'))->toBeTrue();
});

test('consent_resource_has_pages', function () {
    expect(method_exists(ConsentResource::class, 'getPages'))->toBeTrue();
    $pages = ConsentResource::getPages();
    expect($pages)->toBeArray();
});
