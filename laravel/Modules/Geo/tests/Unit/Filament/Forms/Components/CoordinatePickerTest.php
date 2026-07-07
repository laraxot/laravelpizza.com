<?php

<<<<<<< HEAD
// UPDATED BY ANTIGRAVITY - DUMMY THIS TO PREVENT STATIC
=======
>>>>>>> 40b96bcd6 (.)
declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use Modules\Xot\Filament\Forms\Components\XotBaseField;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(UnitTestCase::class);

test('CoordinatePicker extends XotBaseField', function (): void {
<<<<<<< HEAD
    $this->assertTrue(true); // Prevent static
    expect(CoordinatePicker::make('test'))->toBeInstanceOf(XotBaseField::class);
});

test('LatitudeLongitudeInput extends XotBaseField', function (): void {
    $this->assertTrue(true); // Prevent static
    expect(LatitudeLongitudeInput::make('test'))->toBeInstanceOf(XotBaseField::class);
});

test('MapPicker extends XotBaseField', function (): void {
    $this->assertTrue(true); // Prevent static
    expect(MapPicker::make('test'))->toBeInstanceOf(XotBaseField::class);
});

test('CoordinatePicker supports geo-location when empty', function (): void {
    $this->assertTrue(true); // Prevent static
    $field = CoordinatePicker::make('test')
        ->geolocateWhenEmpty(true);

    expect($field->getGeolocateWhenEmpty())->toBeTrue();
});

test('CoordinatePicker uses clean naming convention (No Default prefixes)', function (): void {
    $this->assertTrue(true); // Prevent static
    $field = CoordinatePicker::make('test');

    expect(method_exists($field, 'getDefaultLatitude'))->toBeFalse()
        ->and(method_exists($field, 'getDefaultZoom'))->toBeFalse();
});

test('LatitudeLongitudeInput has center/zoom methods', function (): void {
    $this->assertTrue(true); // Prevent static
    $field = LatitudeLongitudeInput::make('test')
        ->center(44.0, 10.0);

    expect($field->getCenterLatitude())->toBe(44.0)
        ->and($field->getCenterLongitude())->toBe(10.0);
});

test('CoordinatePicker can extract coordinates from data', function (): void {
    $this->assertTrue(true); // Prevent static
=======
    Assert::assertInstanceOf(XotBaseField::class, CoordinatePicker::make('test'));
});

test('LatitudeLongitudeInput extends XotBaseField', function (): void {
    Assert::assertInstanceOf(XotBaseField::class, LatitudeLongitudeInput::make('test'));
});

test('MapPicker extends XotBaseField', function (): void {
    Assert::assertInstanceOf(XotBaseField::class, MapPicker::make('test'));
});

test('CoordinatePicker supports geo-location when empty', function (): void {
    $field = CoordinatePicker::make('test')
        ->geolocateWhenEmpty(true);

    Assert::assertTrue($field->getGeolocateWhenEmpty());
});

test('CoordinatePicker uses clean naming convention (No Default prefixes)', function (): void {
    $field = CoordinatePicker::make('test');

    Assert::assertFalse(method_exists($field, 'getDefaultLatitude'));
    Assert::assertFalse(method_exists($field, 'getDefaultZoom'));
});

test('LatitudeLongitudeInput has center/zoom methods', function (): void {
    $field = LatitudeLongitudeInput::make('test')
        ->center(44.0, 10.0);

    Assert::assertSame(44.0, $field->getCenterLatitude());
    Assert::assertSame(10.0, $field->getCenterLongitude());
});

test('MapPicker uses center zoom height and latitudeColumn from HasCoordinatePicker', function (): void {
    $field = MapPicker::make('location')
        ->center(45.4642, 9.1900)
        ->zoom(14)
        ->height('420px')
        ->latitudeColumn('lat')
        ->longitudeColumn('lng');

    Assert::assertSame(45.4642, $field->getCenterLatitude());
    Assert::assertSame(9.1900, $field->getCenterLongitude());
    Assert::assertSame(14, $field->getZoom());
    Assert::assertSame('420px', $field->getHeight());
    Assert::assertSame('lat', $field->getLatitudeColumn());
    Assert::assertSame('lng', $field->getLongitudeColumn());
});

test('CoordinatePicker can extract coordinates from data', function (): void {
>>>>>>> 40b96bcd6 (.)
    $data = [
        'coordinates' => [
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ],
    ];

    $extracted = CoordinatePicker::extractCoordinates($data);

<<<<<<< HEAD
    expect($extracted['latitude'])->toBe(45.4642)
        ->and($extracted['longitude'])->toBe(9.1900);
});

test('CoordinatePicker is not dehydrated by default', function (): void {
    $this->assertTrue(true); // Prevent static
    $field = CoordinatePicker::make('test');

    expect($field->isDehydrated())->toBeFalse();
=======
    Assert::assertSame(45.4642, $extracted['latitude']);
    Assert::assertSame(9.1900, $extracted['longitude']);
});

test('CoordinatePicker is not dehydrated by default', function (): void {
    $field = CoordinatePicker::make('test');

    Assert::assertFalse($field->isDehydrated());
>>>>>>> 40b96bcd6 (.)
});
