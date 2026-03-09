<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Filament\Resources\ProfileResource;

test('profile_resource_extends_xot_base_resource', function () {
    expect(is_subclass_of(ProfileResource::class, Modules\Xot\Filament\Resources\XotBaseResource::class))->toBeTrue();
});

test('profile_resource_model_is_profile', function () {
    $resource = new ProfileResource();
    expect($resource->getModel())->toBe(Modules\Gdpr\Models\Profile::class);
});

test('profile_resource_has_form_schema', function () {
    expect(method_exists(ProfileResource::class, 'getFormSchema'))->toBeTrue();
});

test('profile_resource_has_pages', function () {
    expect(method_exists(ProfileResource::class, 'getPages'))->toBeTrue();
    $pages = ProfileResource::getPages();
    expect($pages)->toBeArray();
});
