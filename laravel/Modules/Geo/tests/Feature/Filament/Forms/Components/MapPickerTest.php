<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

it('can instantiate map picker', function () {
    $field = MapPicker::make('location');

    expect($field)->toBeInstanceOf(MapPicker::class);
});

it('can set and get latitude and longitude field names', function () {
    $field = MapPicker::make('location')
        ->latitude('lat_field')
        ->longitude('lng_field');

    expect($field->getLatitudeField())->toBe('lat_field')
        ->and($field->getLongitudeField())->toBe('lng_field');
});

it('has default latitude and longitude field names', function () {
    $field = MapPicker::make('location');

    expect($field->getLatitudeField())->toBe('latitude')
        ->and($field->getLongitudeField())->toBe('longitude');
});

it('can set zoom level', function () {
    $field = MapPicker::make('location')
        ->zoom(10);

    expect($field->getZoom())->toBe(10);
});

it('can enable or disable reverse geocoding', function () {
    $field = MapPicker::make('location')
        ->reverseGeocoding(false);

    expect($field->shouldReverseGeocode())->toBeFalse();

    $field->reverseGeocoding(true);
    expect($field->shouldReverseGeocode())->toBeTrue();
});

it('can enable or disable geolocation when empty', function () {
    $field = MapPicker::make('location')
        ->geolocateWhenEmpty(false);

    expect($field->shouldGeolocateWhenEmpty())->toBeFalse();

    $field->geolocateWhenEmpty(true);
    expect($field->shouldGeolocateWhenEmpty())->toBeTrue();
});

it('uses the geo map picker blade view', function () {
    $field = MapPicker::make('location');

    expect($field->getView())->toBe('geo::filament.forms.components.map-picker');
});
