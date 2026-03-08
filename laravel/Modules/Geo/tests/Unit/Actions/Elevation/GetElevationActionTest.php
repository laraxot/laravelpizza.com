<?php

declare(strict_types=1);

use Modules\Geo\Actions\Elevation\GetElevationAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\ElevationException;
use Modules\Geo\Services\GoogleMapsService;

beforeEach(function () {
    $mockGoogleMapsService = Mockery::mock(GoogleMapsService::class);
    $action = new GetElevationAction($this->mockGoogleMapsService);
});

afterEach(function () {
    Mockery::close();
});

it('gets elevation for valid location', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $mockResponse = [
        'results' => [
            ['elevation' => 120.5, 'resolution' => 5.0],
        ],
    ];

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->with(45.4642, 9.1900)
        ->andReturn($mockResponse);

    // Act
    $result = $action->execute($location);

    // Assert
    expect($result)->toBe(120.5);
});

it('throws exception for invalid latitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 100.0, // Invalid latitude > 90
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida');
});

it('throws exception for invalid longitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 200.0, // Invalid longitude > 180
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida');
});

it('throws exception for negative latitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: -100.0,
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida');
});

it('throws exception for negative longitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: -200.0,
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida');
});

it('throws exception for empty response', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andReturn(['results' => []]);

    // Act & Assert
    expect(fn () => $action->execute($location));
});

it('throws exception for invalid response structure', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andReturn(['results' => ['invalid']]);

    // Act & Assert
    expect(fn () => $action->execute($location));
});

it('throws exception when service throws generic exception', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andThrow(new Exception('Network error'));

    // Act & Assert
    expect(fn () => $action->execute($location
        ->toThrow(ElevationException::class, 'Errore nel recupero dell\'elevazione');
});

it('formats elevation correctly', function (): void {
    // Act
    $result = $action->formatElevation(1234.5);

    // Assert
    expect($result)->toBe('1234.5 m s.l.m.');
});

it('formats elevation with zero value', function (): void {
    // Act
    $result = $action->formatElevation(0);

    // Assert
    expect($result)->toBe('0.0 m s.l.m.');
});

it('formats negative elevation correctly', function (): void {
    // Act (for locations below sea level like Dead Sea)
    $result = $action->formatElevation(-430.0);

    // Assert
    expect($result)->toBe('-430.0 m s.l.m.');
});

it('handles high elevation correctly', function (): void {
    // Act (Mount Everest)
    $result = $action->formatElevation(8848.0);

    // Assert
    expect($result)->toBe('8848.0 m s.l.m.');
});

it('handles boundary latitude values', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 90.0, // North pole
        longitude: 0.0,
        address: 'North Pole',
    );

    $mockResponse = [
        'results' => [
            ['elevation' => 0.0, 'resolution' => 1.0],
        ],
    ];

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andReturn($mockResponse);

    // Act
    $result = $action->execute($location);

    // Assert
    expect($result)->toBe(0.0);
});
