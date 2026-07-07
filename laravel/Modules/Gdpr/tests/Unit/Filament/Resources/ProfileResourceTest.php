<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Gdpr\Filament\Resources\ProfileResource;
use Modules\Gdpr\Tests\TestCase;
=======
use Modules\Gdpr\Filament\Resources\ProfileResource;
use Modules\Gdpr\Models\Profile;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(TestCase::class);

test('profile_resource_extends_xot_base_resource', function (): void {
    Assert::assertInstanceOf(XotBaseResource::class, new ProfileResource());
});

test('profile_resource_model_is_profile', function (): void {
    $resource = new ProfileResource();

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
