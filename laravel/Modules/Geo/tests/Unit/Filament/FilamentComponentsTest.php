<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;
use Modules\Geo\Filament\Forms\Components\AddressField;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Filament\Widgets\LatLngWidget;
use Modules\Geo\Filament\Widgets\LocationWidget;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('AddressField can be instantiated', function () {
    $field = AddressField::make('address');

    Assert::assertSame(AddressField::class, (new \ReflectionClass($field))->getName());
});

test('MapPicker can be instantiated', function () {
    $field = MapPicker::make('map_picker')
        ->latitudeColumn('latitude')
        ->longitudeColumn('longitude');

    Assert::assertSame('map_picker', $field->getName());
    Assert::assertSame('latitude', $field->getLatitudeColumn());
    Assert::assertSame('longitude', $field->getLongitudeColumn());
});

test('LocationWidget can be instantiated', function () {
    Assert::assertTrue(class_exists(LocationWidget::class));
});

test('LatLngWidget can be instantiated', function () {
    Assert::assertTrue(class_exists(LatLngWidget::class));
});

test('GeoMapWidget can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoMapWidget::class));
});

test('UpdateCoordinatesBulkAction can be instantiated', function () {
    $action = UpdateCoordinatesBulkAction::make('update_coordinates');

    Assert::assertSame('update_coordinates', $action->getName());
});
