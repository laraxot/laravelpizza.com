<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

use Modules\Gdpr\Filament\Resources\ConsentResource;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('consent_resource_extends_xot_base_resource', function (): void {
    Assert::assertInstanceOf(XotBaseResource::class, new ConsentResource());
});

test('consent_resource_model_is_consent', function (): void {
    $resource = new ConsentResource();

    Assert::assertSame(Consent::class, $resource->getModel());
});

test('consent_resource_has_form_schema', function (): void {
    Assert::assertTrue((new \ReflectionClass(ConsentResource::class))->hasMethod('getFormSchema'));
});

test('consent_resource_has_table_columns', function (): void {
    Assert::assertTrue((new \ReflectionClass(ConsentResource::class))->hasMethod('getTableColumns'));
});

test('consent_resource_has_pages', function (): void {
    Assert::assertTrue((new \ReflectionClass(ConsentResource::class))->hasMethod('getPages'));
    $pages = ConsentResource::getPages();

    Assert::assertNotEmpty($pages);
});
