<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

use Modules\Gdpr\Filament\Resources\EventResource;
use Modules\Gdpr\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;

use function Safe\class_parents;

test('event_resource_extends_xot_base_resource', function (): void {
    Assert::assertArrayHasKey(XotBaseResource::class, class_parents(EventResource::class));
});

test('event_resource_model_is_event', function (): void {
    $resource = new EventResource;

    Assert::assertSame(Event::class, $resource->getModel());
});

test('event_resource_has_form_schema', function (): void {
    Assert::assertTrue((new \ReflectionClass(EventResource::class))->hasMethod('getFormSchema'));
});

test('event_resource_has_pages', function (): void {
    Assert::assertTrue((new \ReflectionClass(EventResource::class))->hasMethod('getPages'));
    $pages = EventResource::getPages();

    Assert::assertNotEmpty($pages);
});

test('event_resource_has_relations', function (): void {
    Assert::assertTrue((new \ReflectionClass(EventResource::class))->hasMethod('getRelations'));
});
