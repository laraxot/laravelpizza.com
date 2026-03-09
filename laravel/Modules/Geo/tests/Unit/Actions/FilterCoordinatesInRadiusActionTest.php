<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;

beforeEach(function () {
    $mockDistanceMatrixAction = Mockery::mock(CalculateDistanceMatrixAction::class);
    $mockCalculateDistanceAction = new CalculateDistanceAction($this->mockDistanceMatrixAction);
    $action = new FilterCoordinatesInRadiusAction($this->mockCalculateDistanceAction);
});

afterEach(function () {
    Mockery::close();
});

it('filters coordinates within radius', function (): void {
    // Arrange
    $centerLat = 45.4642;
    $centerLng = 9.1900;
    $radius = 5000; // 5km in meters

    $coordinates = [
        ['latitude' => '45.4700', 'longitude' => '9.2000'], // ~1km away
        ['latitude' => '45.5000', 'longitude' => '9.2500'], // ~7km away
        ['latitude' => '45.4650', 'longitude' => '9.1910'], // ~200m away
    ];

    // The filter calls calculateDistanceAction->execute for each coordinate pair
    $mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->times(3)
        ->andReturn(
            [
                [
                    ['distance' => ['value' => 1000], 'duration' => ['value' => 100], 'status' => 'OK'],
                ],
            ], // 1km
            [
                [
                    ['distance' => ['value' => 7000], 'duration' => ['value' => 500], 'status' => 'OK'],
                ],
            ], // 7km
            [
                [
                    ['distance' => ['value' => 200], 'duration' => ['value' => 30], 'status' => 'OK'],
                ],
            ]  // 200m
        );

    // Act
    $result = $action->execute($centerLat, $centerLng, $coordinates, $radius);

    // Assert - note: result keeps original order
    expect($result)->toHaveCount(2);
});

it('returns empty array when no coordinates within radius', function (): void {
    // Arrange
    $centerLat = 45.4642;
    $centerLng = 9.1900;
    $radius = 1000; // 1km

    $coordinates = [
        ['latitude' => '45.5000', 'longitude' => '9.2500'], // ~10km away
        ['latitude' => '45.5100', 'longitude' => '9.2600'], // ~12km away
    ];

    $mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->times(2)
        ->andReturn(
            [
                [
                    ['distance' => ['value' => 10000], 'duration' => ['value' => 600], 'status' => 'OK'],
                ],
            ],
            [
                [
                    ['distance' => ['value' => 12000], 'duration' => ['value' => 800], 'status' => 'OK'],
                ],
            ]
        );

    // Act
    $result = $action->execute($centerLat, $centerLng, $coordinates, $radius);

    // Assert
    expect($result)->toHaveCount(0);
});

it('returns all coordinates when all within radius', function (): void {
    // Arrange
    $centerLat = 45.4642;
    $centerLng = 9.1900;
    $radius = 50000; // 50km

    $coordinates = [
        ['latitude' => '45.4700', 'longitude' => '9.2000'],
        ['latitude' => '45.5000', 'longitude' => '9.2500'],
        ['latitude' => '45.4800', 'longitude' => '9.2100'],
    ];

    $mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->times(3)
        ->andReturn(
            [
                [
                    ['distance' => ['value' => 1000], 'duration' => ['value' => 100], 'status' => 'OK'],
                ],
            ],
            [
                [
                    ['distance' => ['value' => 8000], 'duration' => ['value' => 400], 'status' => 'OK'],
                ],
            ],
            [
                [
                    ['distance' => ['value' => 3000], 'duration' => ['value' => 200], 'status' => 'OK'],
                ],
            ]
        );

    // Act
    $result = $action->execute($centerLat, $centerLng, $coordinates, $radius);

    // Assert
    expect($result)->toHaveCount(3);
});

it('handles empty coordinates array', function (): void {
    // Arrange
    $centerLat = 45.4642;
    $centerLng = 9.1900;
    $radius = 5000;
    $coordinates = [];

    // Act
    $result = $action->execute($centerLat, $centerLng, $coordinates, $radius);

    // Assert
    expect($result)->toHaveCount(0);
});

it('filters exactly at boundary', function (): void {
    // Arrange
    $centerLat = 45.4642;
    $centerLng = 9.1900;
    $radius = 5000; // 5km

    $coordinates = [
        ['latitude' => '45.4700', 'longitude' => '9.2000'], // exactly 5km
    ];

    $mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn(
            [
                [
                    ['distance' => ['value' => 5000], 'duration' => ['value' => 300], 'status' => 'OK'],
                ],
            ]
        ); // exactly at boundary

    // Act
    $result = $action->execute($centerLat, $centerLng, $coordinates, $radius);

    // Assert - should be included since <=
    expect($result)->toHaveCount(1);
});
