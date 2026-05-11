<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Filament\Forms\Components\LocationPicker;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

uses(UnitTestCase::class);

// ---------------------------------------------------------------------------
// Istanziazione e configurazione base
// ---------------------------------------------------------------------------

test('MapPicker can be instantiated', function (): void {
    $field = MapPicker::make('location');

    expect($field)->toBeInstanceOf(MapPicker::class);
});

test('MapPicker extends XotBaseField', function (): void {
    $field = MapPicker::make('location');

    expect($field)->toBeInstanceOf(XotBaseField::class);
});

test('MapPicker default state is location array with nullable coordinates', function (): void {
    $field = MapPicker::make('location');

    $default = $field->getDefaultState();

    expect($default)->toBeArray()
        ->and($default)->toHaveKeys(['latitude', 'longitude'])
        ->and($default['latitude'])->toBeNull()
        ->and($default['longitude'])->toBeNull();
});

test('MapPicker supports fluent defaults and presentation options', function (): void {
    $field = MapPicker::make('location')
        ->defaultLocation(45.4642, 9.1900)
        ->zoom(14)
        ->height('420px')
        ->showSearch(false);

    expect($field->getLatitude())->toBe(45.4642)
        ->and($field->getLongitude())->toBe(9.1900)
        ->and($field->getZoom())->toBe(14)
        ->and($field->getHeight())->toBe('420px')
        ->and($field->isSearchVisible())->toBeFalse();
});

test('MapPicker uses dedicated blade view', function (): void {
    $field = MapPicker::make('location');

    expect($field->getView())->toBe('geo::filament.forms.components.map-picker');
});

test('MapPicker is dehydrated to form state', function (): void {
    $field = MapPicker::make('location');

    expect($field->isDehydrated())->toBeTrue();
});

test('MapPicker getZoom defaults to 13 when zoom not configured', function (): void {
    $field = MapPicker::make('location');

    expect($field->getZoom())->toBe(13);
});

// ---------------------------------------------------------------------------
// LocationPicker alias
// ---------------------------------------------------------------------------

test('LocationPicker is a MapPicker subclass', function (): void {
    expect(LocationPicker::make('location'))->toBeInstanceOf(MapPicker::class);
});

test('LocationPicker uses map-picker blade view (inherited)', function (): void {
    $field = LocationPicker::make('location');

    expect($field->getView())->toBe('geo::filament.forms.components.map-picker');
});

// ---------------------------------------------------------------------------
// NUOVI TEST — colonne DB configurabili
// ---------------------------------------------------------------------------

test('MapPicker latitudeColumn and longitudeColumn default to standard names', function (): void {
    $field = MapPicker::make('location');

    expect($field->getLatitudeColumn())->toBe('latitude')
        ->and($field->getLongitudeColumn())->toBe('longitude');
});

test('MapPicker latitudeColumn and longitudeColumn setters override defaults', function (): void {
    $field = MapPicker::make('location')
        ->latitudeColumn('lat')
        ->longitudeColumn('lng');

    expect($field->getLatitudeColumn())->toBe('lat')
        ->and($field->getLongitudeColumn())->toBe('lng');
});

test('MapPicker latitudeColumn fluent setter returns same instance', function (): void {
    $field = MapPicker::make('location');

    expect($field->latitudeColumn('coord_lat'))->toBe($field);
});

test('MapPicker longitudeColumn fluent setter returns same instance', function (): void {
    $field = MapPicker::make('location');

    expect($field->longitudeColumn('coord_lng'))->toBe($field);
});

// ---------------------------------------------------------------------------
// NUOVI TEST — geocodeAddress (forward geocoding)
// ---------------------------------------------------------------------------

test('MapPicker geocodeAddress returns expected keys on success', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            [
                'lat' => '45.4642',
                'lon' => '9.1900',
                'display_name' => 'Milano, Lombardia, Italia',
            ],
        ], 200),
    ]);

    $field = MapPicker::make('location');
    $result = $field->geocodeAddress('Milano');

    expect($result)->toHaveKeys(['latitude', 'longitude', 'display_name'])
        ->and($result['latitude'])->toBe(45.4642)
        ->and($result['longitude'])->toBe(9.19)
        ->and($result['display_name'])->toBe('Milano, Lombardia, Italia');
});

test('MapPicker geocodeAddress returns default location when Nominatim returns empty', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([], 200),
    ]);

    $field = MapPicker::make('location')->defaultLocation(41.9028, 12.4964);
    $result = $field->geocodeAddress('nonexistent place xyz');

    expect($result['latitude'])->toBe(41.9028)
        ->and($result['longitude'])->toBe(12.4964)
        ->and($result['display_name'])->toBe('Not found');
});

test('MapPicker geocodeAddress returns default location on HTTP exception', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response(null, 500),
    ]);

    $field = MapPicker::make('location');
    $result = $field->geocodeAddress('anywhere');

    expect($result)->toHaveKeys(['latitude', 'longitude', 'display_name']);
});

// ---------------------------------------------------------------------------
// NUOVI TEST — reverseGeocode
// ---------------------------------------------------------------------------

test('MapPicker reverseGeocode returns address string', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'display_name' => 'Via Roma, Milano, Italia',
        ], 200),
    ]);

    $field = MapPicker::make('location');
    $result = $field->reverseGeocode(45.4642, 9.19);

    expect($result)->toBeString()->toBe('Via Roma, Milano, Italia');
});

test('MapPicker reverseGeocode returns empty string on failure', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response(null, 500),
    ]);

    $field = MapPicker::make('location');
    $result = $field->reverseGeocode(0.0, 0.0);

    expect($result)->toBeString()->toBe('');
});
