<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\DistanceCalculationException;

beforeEach(function () {
    $this->mockDistanceMatrixAction = Mockery::mock(CalculateDistanceMatrixAction::class);
    $this->action = new CalculateDistanceAction($this->mockDistanceMatrixAction);
});

afterEach(function () {
    Mockery::close();
});

it('calculates distance between two valid locations', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $expectedResponse = [
        [
            [
                'distance' => ['text' => '572 km', 'value' => 572000],
                'duration' => ['text' => '5 ore 30 min', 'value' => 19800],
                'status' => 'OK',
            ],
        ],
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->with(Mockery::type(Collection::class), Mockery::type(Collection::class))
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($origin, $destination);

    // Assert
    expect($result)
        ->toBeArray()
        ->and($result['distance']['text'])
        ->toBe('572 km')
        ->and($result['distance']['value'])
        ->toBe(572000)
        ->and($result['duration']['text'])
        ->toBe('5 ore 30 min')
        ->and($result['duration']['value'])
        ->toBe(19800)
        ->and($result['status'])
        ->toBe('OK');
});

it('throws exception for invalid latitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 100.0, // Invalid latitude > 90
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida: 100.000000');
});

it('throws exception for invalid longitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 200.0, // Invalid longitude > 180
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida: 200.000000');
});

it('throws exception for negative latitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: -100.0, // Invalid latitude < -90
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida: -100.000000');
});

it('throws exception for negative longitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: -200.0, // Invalid longitude < -180
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida: -200.000000');
});

it('throws exception for empty response', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn([]);

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))->toThrow(DistanceCalculationException::class);
});

it('throws exception for malformed response', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $malformedResponse = [['invalid_structure']];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($malformedResponse);

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))->toThrow(DistanceCalculationException::class);
});

it('throws exception when distance matrix fails', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andThrow(new Exception('API Error'));

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(DistanceCalculationException::class, 'Errore nel calcolo della distanza: API Error');
});

it('formats distance in meters correctly', function (): void {
    // Arrange
    $meters = 500;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('500 m');
});

it('formats distance in kilometers correctly', function (): void {
    // Arrange
    $meters = 1500;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('1.5 km');
});

it('formats distance with decimal kilometers', function (): void {
    // Arrange
    $meters = 2500;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('2.5 km');
});

it('formats exact kilometer distance', function (): void {
    // Arrange
    $meters = 1000;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('1.0 km');
});

it('throws exception for negative distance', function (): void {
    // Arrange
    $negativeMeters = -100;

    // Act & Assert
    expect(fn () => $this->action->formatDistance($negativeMeters))
        ->toThrow(InvalidArgumentException::class, 'La distanza non può essere negativa');
});

it('handles zero distance', function (): void {
    // Arrange
    $zeroMeters = 0;

    // Act
    $result = $this->action->formatDistance($zeroMeters);

    // Assert
    expect($result)->toBe('0 m');
});

it('handles very small distances', function (): void {
    // Arrange
    $smallMeters = 1;

    // Act
    $result = $this->action->formatDistance($smallMeters);

    // Assert
    expect($result)->toBe('1 m');
});

it('handles very large distances', function (): void {
    // Arrange
    $largeMeters = 999999;

    // Act
    $result = $this->action->formatDistance($largeMeters);

    // Assert
    expect($result)->toBe('1000.0 km');
});

it('handles boundary latitude values', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 90.0, // Boundary value
        longitude: 9.1900,
        address: 'Boundary Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $expectedResponse = [
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($origin, $destination);

    // Assert
    expect($result)->toBeArray()->and($result['status'])->toBe('OK');
});

it('handles boundary longitude values', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 180.0, // Boundary value
        address: 'Boundary Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $expectedResponse = [
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($origin, $destination);

    // Assert
    expect($result)->toBeArray()->and($result['status'])->toBe('OK');
});

it('handles same origin and destination', function (): void {
    // Arrange
    $sameLocation = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $expectedResponse = [
        [
            [
                'distance' => ['text' => '0 m', 'value' => 0],
                'duration' => ['text' => '0 min', 'value' => 0],
                'status' => 'OK',
            ],
        ],
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($sameLocation, $sameLocation);

    // Assert
    expect($result)
        ->toBeArray()
        ->and($result['distance']['value'])
        ->toBe(0)
        ->and($result['duration']['value'])
        ->toBe(0);
});
