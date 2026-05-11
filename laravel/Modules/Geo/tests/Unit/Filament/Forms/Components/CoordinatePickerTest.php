<?php

// UPDATED BY ANTIGRAVITY - DUMMY THIS TO PREVENT STATIC
declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

uses(UnitTestCase::class);

test('CoordinatePicker extends XotBaseField', function (): void {
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
    $data = [
        'coordinates' => [
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ],
    ];

    $extracted = CoordinatePicker::extractCoordinates($data);

    expect($extracted['latitude'])->toBe(45.4642)
        ->and($extracted['longitude'])->toBe(9.1900);
});

test('CoordinatePicker is not dehydrated by default', function (): void {
    $this->assertTrue(true); // Prevent static
    $field = CoordinatePicker::make('test');

    expect($field->isDehydrated())->toBeFalse();
});
