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

    Assert::assertSame('latitude', $field->getLatitudeColumn());

    Assert::assertSame('longitude', $field->getLongitudeColumn());

    // The columns are record attribute names: they are not prefixed with the field's statePath ('data.').
    Assert::assertNotSame('data.latitude', $field->getLatitudeColumn());

    Assert::assertSame(12, $field->getZoom());
});

test('map picker accepts absolute coordinate paths', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('data.map_picker')
        ->latitudeColumn('filters.latitude')
        ->longitudeColumn('filters.longitude')
        ->geolocateWhenEmpty(false)
        ->reverseGeocoding(false);

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

    Assert::assertSame('latitude', $field->getLatitudeColumn());

    Assert::assertSame('longitude', $field->getLongitudeColumn());
});
