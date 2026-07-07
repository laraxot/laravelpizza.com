<?php

declare(strict_types=1);

use Modules\Geo\Filament\Forms\Components\MapPicker;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

test('map picker resolves explicit coordinate fields', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('data.map_picker')
<<<<<<< HEAD
        ->latitude('latitude')
        ->longitude('longitude')
        ->zoom(12);

    expect($field->getLatitudeField())->toBe('latitude')
        ->and($field->getLongitudeField())->toBe('longitude')
        ->and($field->getLatitudeStatePath())->toBe('data.latitude')
        ->and($field->getLongitudeStatePath())->toBe('data.longitude')
        ->and($field->getZoom())->toBe(12);
=======
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
>>>>>>> 40b96bcd6 (.)
});

test('map picker accepts absolute coordinate paths', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('data.map_picker')
<<<<<<< HEAD
        ->latitude('filters.latitude')
        ->longitude('filters.longitude')
        ->geolocateWhenEmpty(false)
        ->reverseGeocoding(false);

    expect($field->getLatitudeStatePath())->toBe('filters.latitude')
        ->and($field->getLongitudeStatePath())->toBe('filters.longitude')
        ->and($field->shouldGeolocateWhenEmpty())->toBeFalse()
        ->and($field->shouldReverseGeocode())->toBeFalse();
=======
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
>>>>>>> 40b96bcd6 (.)
});

test('map picker keeps bare coordinate paths at root level', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('map_picker')
<<<<<<< HEAD
        ->latitude('latitude')
        ->longitude('longitude');

    expect($field->getLatitudeStatePath())->toBe('latitude')
        ->and($field->getLongitudeStatePath())->toBe('longitude');
=======
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
>>>>>>> 40b96bcd6 (.)
});
