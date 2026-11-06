<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

use Modules\Gdpr\Filament\Resources\ProfileResource;
use Modules\Gdpr\Models\Profile;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;

use function Safe\class_parents;

test('profile_resource_extends_xot_base_resource', function (): void {
    Assert::assertArrayHasKey(XotBaseResource::class, class_parents(ProfileResource::class));
});

test('profile_resource_model_is_profile', function (): void {
    $resource = new ProfileResource;

    Assert::assertSame(Profile::class, $resource->getModel());
});

test('profile_resource_has_form_schema', function (): void {
    Assert::assertTrue((new \ReflectionClass(ProfileResource::class))->hasMethod('getFormSchema'));
});

test('profile_resource_has_pages', function (): void {
    Assert::assertTrue((new \ReflectionClass(ProfileResource::class))->hasMethod('getPages'));
    $pages = ProfileResource::getPages();

    Assert::assertNotEmpty($pages);
});
