<?php

declare(strict_types=1);

use Modules\Geo\Filament\Forms\Components\MapPicker;
use PHPUnit\Framework\Assert;

test('map picker resolves explicit coordinate fields', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('data.map_picker')
        ->latitudeColumn('latitude')
        ->longitudeColumn('longitude')
        ->zoom(12);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertSame('latitude', $field->getLatitudeColumn());

    Assert::assertSame('longitude', $field->getLongitudeColumn());

    Assert::assertSame('data.latitude', $field->getLatitudeColumn());

    Assert::assertSame('data.longitude', $field->getLongitudeColumn());

    Assert::assertSame(12, $field->getZoom());
});

test('map picker accepts absolute coordinate paths', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('data.map_picker')
        ->latitudeColumn('filters.latitude')
        ->longitudeColumn('filters.longitude')
        ->geolocateWhenEmpty(false)
        ->reverseGeocoding(false);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertSame('filters.latitude', $field->getLatitudeColumn());

    Assert::assertSame('filters.longitude', $field->getLongitudeColumn());

    Assert::assertFalse($field->getGeolocateWhenEmpty());

    Assert::assertFalse($field->hasReverseGeocoding());
});

test('map picker keeps bare coordinate paths at root level', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('map_picker')
        ->latitudeColumn('latitude')
        ->longitudeColumn('longitude');
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertSame('latitude', $field->getLatitudeColumn());

    Assert::assertSame('longitude', $field->getLongitudeColumn());
});
