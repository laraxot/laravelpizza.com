<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Filament\Forms\Components\LocationPicker;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use Modules\Xot\Filament\Forms\Components\XotBaseField;
use PHPUnit\Framework\Assert;

uses(UnitTestCase::class);
test('MapPicker can be instantiated', function (): void {
    $field = MapPicker::make('location');

    Assert::assertInstanceOf(MapPicker::class, $field);
});

test('MapPicker extends XotBaseField', function (): void {
    $field = MapPicker::make('location');

    Assert::assertInstanceOf(XotBaseField::class, $field);
});

test('MapPicker default state is location array with nullable coordinates', function (): void {
    $field = MapPicker::make('location');

    $default = $field->getDefaultState();

    Assert::assertIsArray($default);
    Assert::assertNull($default['latitude']);
    Assert::assertNull($default['longitude']);
});

test('MapPicker supports fluent defaults and presentation options', function (): void {
    $field = MapPicker::make('location')
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
});

test('MapPicker uses dedicated blade view', function (): void {
    $field = MapPicker::make('location');

    Assert::assertSame('geo::filament.forms.components.map-picker', $field->getView());
});

test('MapPicker is not dehydrated by default', function (): void {
    $field = MapPicker::make('location');

    Assert::assertFalse($field->isDehydrated());
});

test('MapPicker getZoom defaults to 13 when zoom not configured', function (): void {
    $field = MapPicker::make('location');

    Assert::assertSame(13, $field->getZoom());
});

test('LocationPicker is a MapPicker subclass', function (): void {
    Assert::assertInstanceOf(MapPicker::class, LocationPicker::make('location'));
});

test('LocationPicker uses map-picker blade view (inherited)', function (): void {
    $field = LocationPicker::make('location');

    Assert::assertSame('geo::filament.forms.components.map-picker', $field->getView());
});

test('MapPicker latitudeColumn and longitudeColumn default to standard names', function (): void {
    $field = MapPicker::make('location');

    Assert::assertSame('latitude', $field->getLatitudeColumn());
    Assert::assertSame('longitude', $field->getLongitudeColumn());
});

test('MapPicker latitudeColumn and longitudeColumn setters override defaults', function (): void {
    $field = MapPicker::make('location')
        ->latitudeColumn('lat')
        ->longitudeColumn('lng');
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
});

test('MapPicker latitudeColumn fluent setter returns same instance', function (): void {
    $field = MapPicker::make('location');

    Assert::assertSame($field, $field->latitudeColumn('coord_lat'));
});

test('MapPicker longitudeColumn fluent setter returns same instance', function (): void {
    $field = MapPicker::make('location');

    Assert::assertSame($field, $field->longitudeColumn('coord_lng'));
});

test('MapPicker searchAddress returns nominatim results on success', function (): void {
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
    $results = $field->searchAddress('Milano');

    Assert::assertCount(1, $results);
    $first = $results[0];
    Assert::assertSame('45.4642', $first['lat']);
    Assert::assertSame('9.1900', $first['lon']);
    Assert::assertSame('Milano, Lombardia, Italia', $first['display_name']);
});

test('MapPicker searchAddress returns empty array when Nominatim returns empty', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([], 200),
    ]);

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
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response(null, 500),
    ]);

    $field = MapPicker::make('location');
    $results = $field->searchAddress('anywhere');

    Assert::assertSame([], $results);
});

test('MapPicker reverseGeocode returns structured address', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([
            'display_name' => 'Via Roma, Milano, Italia',
            'address' => ['road' => 'Via Roma'],
        ], 200),
    ]);

    $field = MapPicker::make('location');
    $result = $field->reverseGeocode(45.4642, 9.19);

    Assert::assertIsArray($result);
    Assert::assertSame('Via Roma, Milano, Italia', $result['display_name']);
});

test('MapPicker reverseGeocode returns null on failure', function (): void {
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response(null, 500),
    ]);

    $field = MapPicker::make('location');
    $result = $field->reverseGeocode(0.0, 0.0);

    Assert::assertNull($result);
});
