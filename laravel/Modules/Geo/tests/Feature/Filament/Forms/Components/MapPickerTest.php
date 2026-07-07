<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\LightTestCase;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(LightTestCase::class);

it('can instantiate map picker', function () {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field)->toBeInstanceOf(MapPicker::class);
=======
    Assert::assertInstanceOf(MapPicker::class, $field);
>>>>>>> 40b96bcd6 (.)
});

it('can set and get latitude and longitude field names', function () {
    $field = MapPicker::make('location')
<<<<<<< HEAD
        ->latitude('lat_field')
        ->longitude('lng_field');

    expect($field->getLatitudeField())->toBe('lat_field')
        ->and($field->getLongitudeField())->toBe('lng_field');
=======
        ->latitudeColumn('lat_field')
        ->longitudeColumn('lng_field');
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertSame('lat_field', $field->getLatitudeColumn());

    Assert::assertSame('lng_field', $field->getLongitudeColumn());
>>>>>>> 40b96bcd6 (.)
});

it('has default latitude and longitude field names', function () {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field->getLatitudeField())->toBe('latitude')
        ->and($field->getLongitudeField())->toBe('longitude');
=======
    Assert::assertSame('latitude', $field->getLatitudeColumn());

    Assert::assertSame('longitude', $field->getLongitudeColumn());
>>>>>>> 40b96bcd6 (.)
});

it('can set zoom level', function () {
    $field = MapPicker::make('location')
        ->zoom(10);
<<<<<<< HEAD

    expect($field->getZoom())->toBe(10);
=======
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertSame(10, $field->getZoom());
>>>>>>> 40b96bcd6 (.)
});

it('can enable or disable reverse geocoding', function () {
    $field = MapPicker::make('location')
        ->reverseGeocoding(false);
<<<<<<< HEAD

    expect($field->shouldReverseGeocode())->toBeFalse();

    $field->reverseGeocoding(true);
    expect($field->shouldReverseGeocode())->toBeTrue();
=======
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertFalse($field->hasReverseGeocoding());

    $field->reverseGeocoding(true);
    Assert::assertTrue($field->hasReverseGeocoding());
>>>>>>> 40b96bcd6 (.)
});

it('can enable or disable geolocation when empty', function () {
    $field = MapPicker::make('location')
        ->geolocateWhenEmpty(false);
<<<<<<< HEAD

    expect($field->shouldGeolocateWhenEmpty())->toBeFalse();

    $field->geolocateWhenEmpty(true);
    expect($field->shouldGeolocateWhenEmpty())->toBeTrue();
=======
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertFalse($field->getGeolocateWhenEmpty());

    $field->geolocateWhenEmpty(true);
    Assert::assertTrue($field->getGeolocateWhenEmpty());
>>>>>>> 40b96bcd6 (.)
});

it('uses the geo map picker blade view', function () {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field->getView())->toBe('geo::filament.forms.components.map-picker');
=======
    Assert::assertSame('geo::filament.forms.components.map-picker', $field->getView());
>>>>>>> 40b96bcd6 (.)
});
