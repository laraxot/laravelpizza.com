<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetCoordinatesAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('returns coordinates for valid address', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';
    $expectedLatitude = 45.4642;
    $expectedLongitude = 9.1900;

    $mockResponse = [
        'status' => 'OK',
        'results' => [
            [
                'geometry' => [
                    'location' => [
                        'lat' => $expectedLatitude,
                        'lng' => $expectedLongitude,
                    ],
                ],
            ],
        ],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame($expectedLatitude, $result->latitude);
    Assert::assertSame($expectedLongitude, $result->longitude);
    Assert::assertSame($address, $result->address);
});

it('throws exception when api key missing', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';
    Config::set('services.google.maps.key', null);

    // Act & Assert
    try {
        $action->execute($address);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Google Maps API key not found', $exception->getMessage());
    }
});

it('throws exception when api request fails', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response([], 500),
    ]);

    // Act & Assert
    try {
        $action->execute($address);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Failed to get coordinates from Google Maps API', $exception->getMessage());
    }
});

it('returns null for invalid address', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Invalid Address That Does Not Exist';

    $mockResponse = [
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertNull($result);
});

it('returns null for over query limit status', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';

    $mockResponse = [
        'status' => 'OVER_QUERY_LIMIT',
        'results' => [],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertNull($result);
});

it('returns null for request denied status', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';

    $mockResponse = [
        'status' => 'REQUEST_DENIED',
        'results' => [],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertNull($result);
});

it('handles empty results array', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';

    $mockResponse = [
        'status' => 'OK',
        'results' => [],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertNull($result);
});

it('handles multiple results and returns first', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma, Italia';
    $expectedLatitude = 45.4642;
    $expectedLongitude = 9.1900;

    $mockResponse = [
        'status' => 'OK',
        'results' => [
            [
                'geometry' => [
                    'location' => [
                        'lat' => $expectedLatitude,
                        'lng' => $expectedLongitude,
                    ],
                ],
            ],
            [
                'geometry' => [
                    'location' => [
                        'lat' => 41.9028,
                        'lng' => 12.4964,
                    ],
                ],
            ],
        ],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame($expectedLatitude, $result->latitude);
    Assert::assertSame($expectedLongitude, $result->longitude);
});

it('handles special characters in address', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia - Ufficio 4° piano';
    $expectedLatitude = 45.4642;
    $expectedLongitude = 9.1900;

    $mockResponse = [
        'status' => 'OK',
        'results' => [
            [
                'geometry' => [
                    'location' => [
                        'lat' => $expectedLatitude,
                        'lng' => $expectedLongitude,
                    ],
                ],
            ],
        ],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame($address, $result->address);
});

it('handles numeric coordinates correctly', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = '123 Main St, New York, NY';
    $expectedLatitude = 40.7128;
    $expectedLongitude = -74.0060;

    $mockResponse = [
        'status' => 'OK',
        'results' => [
            [
                'geometry' => [
                    'location' => [
                        'lat' => $expectedLatitude,
                        'lng' => $expectedLongitude,
                    ],
                ],
            ],
        ],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame($expectedLatitude, $result->latitude);
    Assert::assertSame($expectedLongitude, $result->longitude);
});

it('handles very long addresses', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = str_repeat('Via Roma 123, Milano, Italia - ', 50).'Ufficio 4° piano';
    $expectedLatitude = 45.4642;
    $expectedLongitude = 9.1900;

    $mockResponse = [
        'status' => 'OK',
        'results' => [
            [
                'geometry' => [
                    'location' => [
                        'lat' => $expectedLatitude,
                        'lng' => $expectedLongitude,
                    ],
                ],
            ],
        ],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame($address, $result->address);
});

it('handles coordinates with high precision', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Precise Location Test';
    $expectedLatitude = 45.4642034;
    $expectedLongitude = 9.1900001;

    $mockResponse = [
        'status' => 'OK',
        'results' => [
            [
                'geometry' => [
                    'location' => [
                        'lat' => $expectedLatitude,
                        'lng' => $expectedLongitude,
                    ],
                ],
            ],
        ],
    ];

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    // Act
    $result = $action->execute($address);

    // Assert
    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame($expectedLatitude, $result->latitude);
    Assert::assertSame($expectedLongitude, $result->longitude);
});

it('handles network timeout gracefully', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response([], 408), // Request Timeout
    ]);

    // Act & Assert
    try {
        $action->execute($address);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Failed to get coordinates from Google Maps API', $exception->getMessage());
    }
});

it('handles invalid json response', function (): void {
    $action = new GetCoordinatesAction();

    // Arrange
    $address = 'Via Roma 123, Milano, Italia';

    Config::set('services.google.maps.key', 'test-api-key');
    Http::fake([
        'maps.googleapis.com/*' => Http::response('Invalid JSON', 200),
    ]);

    // Act & Assert
    try {
        $action->execute($address);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Invalid JSON response from Google Maps API', $exception->getMessage());
    }
});
