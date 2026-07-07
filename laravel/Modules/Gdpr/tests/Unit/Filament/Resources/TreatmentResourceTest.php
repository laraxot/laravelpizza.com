<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

use Modules\Gdpr\Filament\Resources\TreatmentResource;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('treatment_resource_extends_xot_base_resource', function (): void {
    Assert::assertInstanceOf(XotBaseResource::class, new TreatmentResource());
});

test('treatment_resource_model_is_treatment', function (): void {
    $resource = new TreatmentResource();

    Assert::assertSame(Treatment::class, $resource->getModel());
});

test('treatment_resource_has_form_schema', function (): void {
    Assert::assertTrue((new \ReflectionClass(TreatmentResource::class))->hasMethod('getFormSchema'));
});

test('treatment_resource_has_pages', function (): void {
    Assert::assertTrue((new \ReflectionClass(TreatmentResource::class))->hasMethod('getPages'));
    $pages = TreatmentResource::getPages();

    Assert::assertNotEmpty($pages);
});
