<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

it('can instantiate map picker', function () {
    $field = MapPicker::make('location');

    Assert::assertInstanceOf(MapPicker::class, $field);
});

it('can set and get latitude and longitude field names', function () {
    $field = MapPicker::make('location')
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
});

it('has default latitude and longitude field names', function () {
    $field = MapPicker::make('location');

    Assert::assertSame('latitude', $field->getLatitudeColumn());

    Assert::assertSame('longitude', $field->getLongitudeColumn());
});

it('can set zoom level', function () {
    $field = MapPicker::make('location')
        ->zoom(10);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertSame(10, $field->getZoom());
});

it('can enable or disable reverse geocoding', function () {
    $field = MapPicker::make('location')
        ->reverseGeocoding(false);
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
});

it('can enable or disable geolocation when empty', function () {
    $field = MapPicker::make('location')
        ->geolocateWhenEmpty(false);
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
});

it('uses the geo map picker blade view', function () {
    $field = MapPicker::make('location');

    Assert::assertSame('geo::filament.forms.components.map-picker', $field->getView());
});
