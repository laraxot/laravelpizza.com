<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetCoordinatesAction;
use Modules\Geo\Datas\LocationData;
use Tests\TestCase;

class GetCoordinatesActionTest extends TestCase
{
    private GetCoordinatesAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new GetCoordinatesAction;
    }

    /** @test */
    public function it_returns_coordinates_for_valid_address(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)
            ->toBeInstanceOf(LocationData::class)
            ->and($result->latitude)
            ->toBe($expectedLatitude)
            ->and($result->longitude)
            ->toBe($expectedLongitude)
            ->and($result->address)
            ->toBe($address);
    }

    /** @test */
    public function it_throws_exception_when_api_key_missing(): void
    {
        // Arrange
        $address = 'Via Roma 123, Milano, Italia';
        Config::set('services.google.maps.key', null);

        // Act & Assert
        expect(fn () => $this->action->execute($address))
            ->toThrow(\RuntimeException::class, 'Google Maps API key not found');
    }

    /** @test */
    public function it_throws_exception_when_api_request_fails(): void
    {
        // Arrange
        $address = 'Via Roma 123, Milano, Italia';

        Config::set('services.google.maps.key', 'test-api-key');
        Http::fake([
            'maps.googleapis.com/*' => Http::response([], 500),
        ]);

        // Act & Assert
        expect(fn () => $this->action->execute($address))
            ->toThrow(\RuntimeException::class, 'Failed to get coordinates from Google Maps API');
    }

    /** @test */
    public function it_returns_null_for_invalid_address(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)->toBeNull();
    }

    /** @test */
    public function it_returns_null_for_over_query_limit_status(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)->toBeNull();
    }

    /** @test */
    public function it_returns_null_for_request_denied_status(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)->toBeNull();
    }

    /** @test */
    public function it_handles_empty_results_array(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)->toBeNull();
    }

    /** @test */
    public function it_handles_multiple_results_and_returns_first(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)
            ->toBeInstanceOf(LocationData::class)
            ->and($result->latitude)
            ->toBe($expectedLatitude)
            ->and($result->longitude)
            ->toBe($expectedLongitude);
    }

    /** @test */
    public function it_handles_special_characters_in_address(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)->toBeInstanceOf(LocationData::class)->and($result->address)->toBe($address);
    }

    /** @test */
    public function it_handles_numeric_coordinates_correctly(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)
            ->toBeInstanceOf(LocationData::class)
            ->and($result->latitude)
            ->toBe($expectedLatitude)
            ->and($result->longitude)
            ->toBe($expectedLongitude);
    }

    /** @test */
    public function it_handles_very_long_addresses(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)->toBeInstanceOf(LocationData::class)->and($result->address)->toBe($address);
    }

    /** @test */
    public function it_handles_coordinates_with_high_precision(): void
    {
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
        $result = $this->action->execute($address);

        // Assert
        expect($result)
            ->toBeInstanceOf(LocationData::class)
            ->and($result->latitude)
            ->toBe($expectedLatitude)
            ->and($result->longitude)
            ->toBe($expectedLongitude);
    }

    /** @test */
    public function it_handles_network_timeout_gracefully(): void
    {
        // Arrange
        $address = 'Via Roma 123, Milano, Italia';

        Config::set('services.google.maps.key', 'test-api-key');
        Http::fake([
            'maps.googleapis.com/*' => Http::response([], 408), // Request Timeout
        ]);

        // Act & Assert
        expect(fn () => $this->action->execute($address))
            ->toThrow(\RuntimeException::class, 'Failed to get coordinates from Google Maps API');
    }

    /** @test */
    public function it_handles_invalid_json_response(): void
    {
        // Arrange
        $address = 'Via Roma 123, Milano, Italia';

        Config::set('services.google.maps.key', 'test-api-key');
        Http::fake([
            'maps.googleapis.com/*' => Http::response('Invalid JSON', 200),
        ]);

        // Act & Assert
        expect(fn () => $this->action->execute($address))->toThrow(\RuntimeException::class);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
