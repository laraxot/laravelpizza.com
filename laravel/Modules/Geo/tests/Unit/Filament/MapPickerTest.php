<?php

declare(strict_types=1);

use Modules\Geo\Filament\Forms\Components\MapPicker;

test('map picker resolves explicit coordinate fields', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('data.map_picker')
        ->latitude('latitude')
        ->longitude('longitude')
        ->zoom(12);

    expect($field->getLatitudeField())->toBe('latitude')
        ->and($field->getLongitudeField())->toBe('longitude')
        ->and($field->getLatitudeStatePath())->toBe('data.latitude')
        ->and($field->getLongitudeStatePath())->toBe('data.longitude')
        ->and($field->getZoom())->toBe(12);
});

test('map picker accepts absolute coordinate paths', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('data.map_picker')
        ->latitude('filters.latitude')
        ->longitude('filters.longitude')
        ->geolocateWhenEmpty(false)
        ->reverseGeocoding(false);

    expect($field->getLatitudeStatePath())->toBe('filters.latitude')
        ->and($field->getLongitudeStatePath())->toBe('filters.longitude')
        ->and($field->shouldGeolocateWhenEmpty())->toBeFalse()
        ->and($field->shouldReverseGeocode())->toBeFalse();
});

test('map picker keeps bare coordinate paths at root level', function (): void {
    $field = MapPicker::make('map_picker')
        ->statePath('map_picker')
        ->latitude('latitude')
        ->longitude('longitude');

    expect($field->getLatitudeStatePath())->toBe('latitude')
        ->and($field->getLongitudeStatePath())->toBe('longitude');
});
