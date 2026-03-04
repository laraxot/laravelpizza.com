<?php

declare(strict_types=1);

use Modules\Geo\Services\GoogleMapsService;

beforeEach(function () {
    $this->service = new GoogleMapsService();
});

it('can be instantiated', function (): void {
    expect($this->service)->toBeInstanceOf(GoogleMapsService::class);
});

it('has correct constants defined', function (): void {
    $reflection = new ReflectionClass(GoogleMapsService::class);
    expect($reflection->hasConstant('GEOCODING_URL'))->toBeTrue();
    expect($reflection->hasConstant('DISTANCE_MATRIX_URL'))->toBeTrue();
    expect($reflection->hasConstant('ELEVATION_URL'))->toBeTrue();

    // Test that the constants have the correct values
    expect($reflection->getConstant('GEOCODING_URL'))->toBe('https://maps.googleapis.com/maps/api/geocode/json');
    expect($reflection->getConstant('DISTANCE_MATRIX_URL'))->toBe('https://maps.googleapis.com/maps/api/distancematrix/json');
    expect($reflection->getConstant('ELEVATION_URL'))->toBe('https://maps.googleapis.com/maps/api/elevation/json');
});

it('has required methods', function (): void {
    expect(method_exists($this->service, 'reverseGeocode'))->toBeTrue();
    expect(method_exists($this->service, 'getDistanceMatrix'))->toBeTrue();
    expect(method_exists($this->service, 'getElevation'))->toBeTrue();
});
