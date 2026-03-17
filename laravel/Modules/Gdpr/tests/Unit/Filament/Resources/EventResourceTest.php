<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

uses(\Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Filament\Resources\EventResource;
use Modules\Gdpr\Models\Event;

test('event_resource_extends_xot_base_resource', function () {
    expect(is_subclass_of(EventResource::class, Modules\Xot\Filament\Resources\XotBaseResource::class))->toBeTrue();
});

test('event_resource_model_is_event', function () {
    $resource = new EventResource();
    expect($resource->getModel())->toBe(Event::class);
});

test('event_resource_has_form_schema', function () {
    expect(method_exists(EventResource::class, 'getFormSchema'))->toBeTrue();
});

test('event_resource_has_pages', function () {
    expect(method_exists(EventResource::class, 'getPages'))->toBeTrue();
    $pages = EventResource::getPages();
    expect($pages)->toBeArray();
});

test('event_resource_has_relations', function () {
    expect(method_exists(EventResource::class, 'getRelations'))->toBeTrue();
});
