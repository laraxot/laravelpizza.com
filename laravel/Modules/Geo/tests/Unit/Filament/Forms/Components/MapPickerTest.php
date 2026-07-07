<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Filament\Forms\Components\LocationPicker;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use Modules\Xot\Filament\Forms\Components\XotBaseField;
<<<<<<< HEAD

uses(UnitTestCase::class);

// ---------------------------------------------------------------------------
// Istanziazione e configurazione base
// ---------------------------------------------------------------------------

test('MapPicker can be instantiated', function (): void {
    $field = MapPicker::make('location');

    expect($field)->toBeInstanceOf(MapPicker::class);
=======
use PHPUnit\Framework\Assert;

uses(UnitTestCase::class);
test('MapPicker can be instantiated', function (): void {
    $field = MapPicker::make('location');

    Assert::assertInstanceOf(MapPicker::class, $field);
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker extends XotBaseField', function (): void {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field)->toBeInstanceOf(XotBaseField::class);
=======
    Assert::assertInstanceOf(XotBaseField::class, $field);
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker default state is location array with nullable coordinates', function (): void {
    $field = MapPicker::make('location');

    $default = $field->getDefaultState();

<<<<<<< HEAD
    expect($default)->toBeArray()
        ->and($default)->toHaveKeys(['latitude', 'longitude'])
        ->and($default['latitude'])->toBeNull()
        ->and($default['longitude'])->toBeNull();
=======
    Assert::assertIsArray($default);
    Assert::assertNull($default['latitude']);
    Assert::assertNull($default['longitude']);
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker supports fluent defaults and presentation options', function (): void {
    $field = MapPicker::make('location')
<<<<<<< HEAD
        ->defaultLocation(45.4642, 9.1900)
        ->zoom(14)
        ->height('420px')
        ->showSearch(false);

    expect($field->getLatitude())->toBe(45.4642)
        ->and($field->getLongitude())->toBe(9.1900)
        ->and($field->getZoom())->toBe(14)
        ->and($field->getHeight())->toBe('420px')
        ->and($field->isSearchVisible())->toBeFalse();
=======
        ->center(45.4642, 9.1900)
        ->zoom(14)
        ->height('420px')
        ->showSearch(false);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertSame(45.4642, $field->getCenterLatitude());
    Assert::assertSame(9.1900, $field->getCenterLongitude());
    Assert::assertSame(14, $field->getZoom());
    Assert::assertSame('420px', $field->getHeight());
    Assert::assertFalse($field->isSearchVisible());
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker uses dedicated blade view', function (): void {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field->getView())->toBe('geo::filament.forms.components.map-picker');
});

test('MapPicker is dehydrated to form state', function (): void {
    $field = MapPicker::make('location');

    expect($field->isDehydrated())->toBeTrue();
=======
    Assert::assertSame('geo::filament.forms.components.map-picker', $field->getView());
});

test('MapPicker is not dehydrated by default', function (): void {
    $field = MapPicker::make('location');

    Assert::assertFalse($field->isDehydrated());
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker getZoom defaults to 13 when zoom not configured', function (): void {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field->getZoom())->toBe(13);
});

// ---------------------------------------------------------------------------
// LocationPicker alias
// ---------------------------------------------------------------------------

test('LocationPicker is a MapPicker subclass', function (): void {
    expect(LocationPicker::make('location'))->toBeInstanceOf(MapPicker::class);
=======
    Assert::assertSame(13, $field->getZoom());
});

test('LocationPicker is a MapPicker subclass', function (): void {
    Assert::assertInstanceOf(MapPicker::class, LocationPicker::make('location'));
>>>>>>> 40b96bcd6 (.)
});

test('LocationPicker uses map-picker blade view (inherited)', function (): void {
    $field = LocationPicker::make('location');

<<<<<<< HEAD
    expect($field->getView())->toBe('geo::filament.forms.components.map-picker');
});

// ---------------------------------------------------------------------------
// NUOVI TEST — colonne DB configurabili
// ---------------------------------------------------------------------------

test('MapPicker latitudeColumn and longitudeColumn default to standard names', function (): void {
    $field = MapPicker::make('location');

    expect($field->getLatitudeColumn())->toBe('latitude')
        ->and($field->getLongitudeColumn())->toBe('longitude');
=======
    Assert::assertSame('geo::filament.forms.components.map-picker', $field->getView());
});

test('MapPicker latitudeColumn and longitudeColumn default to standard names', function (): void {
    $field = MapPicker::make('location');

    Assert::assertSame('latitude', $field->getLatitudeColumn());
    Assert::assertSame('longitude', $field->getLongitudeColumn());
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker latitudeColumn and longitudeColumn setters override defaults', function (): void {
    $field = MapPicker::make('location')
        ->latitudeColumn('lat')
        ->longitudeColumn('lng');
<<<<<<< HEAD

    expect($field->getLatitudeColumn())->toBe('lat')
        ->and($field->getLongitudeColumn())->toBe('lng');
=======
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);

    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertSame('lat', $field->getLatitudeColumn());
    Assert::assertSame('lng', $field->getLongitudeColumn());
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker latitudeColumn fluent setter returns same instance', function (): void {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field->latitudeColumn('coord_lat'))->toBe($field);
=======
    Assert::assertSame($field, $field->latitudeColumn('coord_lat'));
>>>>>>> 40b96bcd6 (.)
});

test('MapPicker longitudeColumn fluent setter returns same instance', function (): void {
    $field = MapPicker::make('location');

<<<<<<< HEAD
    expect($field->longitudeColumn('coord_lng'))->toBe($field);
});

// ---------------------------------------------------------------------------
// NUOVI TEST — geocodeAddress (forward geocoding)
// ---------------------------------------------------------------------------

test('MapPicker geocodeAddress returns expected keys on success', function (): void {
=======
    Assert::assertSame($field, $field->longitudeColumn('coord_lng'));
});

test('MapPicker searchAddress returns nominatim results on success', function (): void {
>>>>>>> 40b96bcd6 (.)
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
<<<<<<< HEAD
    $result = $field->geocodeAddress('Milano');

    expect($result)->toHaveKeys(['latitude', 'longitude', 'display_name'])
        ->and($result['latitude'])->toBe(45.4642)
        ->and($result['longitude'])->toBe(9.19)
        ->and($result['display_name'])->toBe('Milano, Lombardia, Italia');
});

test('MapPicker geocodeAddress returns default location when Nominatim returns empty', function (): void {
=======
    $results = $field->searchAddress('Milano');

    Assert::assertCount(1, $results);
    $first = $results[0];
    Assert::assertSame('45.4642', $first['lat']);
    Assert::assertSame('9.1900', $first['lon']);
    Assert::assertSame('Milano, Lombardia, Italia', $first['display_name']);
});

test('MapPicker searchAddress returns empty array when Nominatim returns empty', function (): void {
>>>>>>> 40b96bcd6 (.)
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([], 200),
    ]);

<<<<<<< HEAD
    $field = MapPicker::make('location')->defaultLocation(41.9028, 12.4964);
    $result = $field->geocodeAddress('nonexistent place xyz');

    expect($result['latitude'])->toBe(41.9028)
        ->and($result['longitude'])->toBe(12.4964)
        ->and($result['display_name'])->toBe('Not found');
});

test('MapPicker geocodeAddress returns default location on HTTP exception', function (): void {
=======
    $field = MapPicker::make('location')->center(41.9028, 12.4964);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    $results = $field->searchAddress('nonexistent place xyz');

    Assert::assertSame([], $results);
});

test('MapPicker searchAddress returns empty array on HTTP error', function (): void {
>>>>>>> 40b96bcd6 (.)
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response(null, 500),
    ]);

    $field = MapPicker::make('location');
<<<<<<< HEAD
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
=======
    $results = $field->searchAddress('anywhere');

    Assert::assertSame([], $results);
});

test('MapPicker reverseGeocode returns structured address', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'display_name' => 'Via Roma, Milano, Italia',
            'address' => ['road' => 'Via Roma'],
>>>>>>> 40b96bcd6 (.)
        ], 200),
    ]);

    $field = MapPicker::make('location');
    $result = $field->reverseGeocode(45.4642, 9.19);

<<<<<<< HEAD
    expect($result)->toBeString()->toBe('Via Roma, Milano, Italia');
});

test('MapPicker reverseGeocode returns empty string on failure', function (): void {
=======
    Assert::assertIsArray($result);
    Assert::assertSame('Via Roma, Milano, Italia', $result['display_name']);
});

test('MapPicker reverseGeocode returns null on failure', function (): void {
>>>>>>> 40b96bcd6 (.)
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response(null, 500),
    ]);

    $field = MapPicker::make('location');
    $result = $field->reverseGeocode(0.0, 0.0);

<<<<<<< HEAD
    expect($result)->toBeString()->toBe('');
=======
    Assert::assertNull($result);
>>>>>>> 40b96bcd6 (.)
});
