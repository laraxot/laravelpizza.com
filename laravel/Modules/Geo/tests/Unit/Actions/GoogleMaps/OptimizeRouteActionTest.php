<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\GoogleMaps\OptimizeRouteAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\RouteData;

beforeEach(function () {
    $action = new OptimizeRouteAction();
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps.key' => null]);

    $locations = [
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ];
    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    expect(fn () => $action->execute($locations, $origin, $destination))
        ->toThrow(RuntimeException::class, 'API key not found');
});

it('returns empty array for empty locations', function (): void {
    config(['services.google.maps.key' => 'test_key']);

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute([], $origin, $destination);

    expect($result)->toBeArray()->toBeEmpty();
});

it('returns empty array when api returns no routes', function (): void {
    config(['services.google.maps.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response(['routes' => []], 200),
    ]);

    $locations = [
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ];
    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($locations, $origin, $destination);

    expect($result)->toBeArray()->toBeEmpty();
});

it('returns route data for valid request', function (): void {
    config(['services.google.maps.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
            'routes' => [[
                'legs' => [
                    [
                        'distance' => ['text' => '572 km', 'value' => 572000],
                        'duration' => ['text' => '5h 30m', 'value' => 19800],
                        'start_location' => ['lat' => 45.4642, 'lng' => 9.1900],
                        'end_location' => ['lat' => 44.4056, 'lng' => 8.9463],
                        'steps' => [
                            [
                                'distance' => ['text' => '100 km', 'value' => 100000],
                                'duration' => ['text' => '1h', 'value' => 3600],
                                'start_location' => ['lat' => 45.4642, 'lng' => 9.1900],
                                'end_location' => ['lat' => 44.4056, 'lng' => 8.9463],
                                'html_instructions' => 'Head north',
                                'travel_mode' => 'DRIVING',
                            ],
                        ],
                    ],
                    [
                        'distance' => ['text' => '472 km', 'value' => 472000],
                        'duration' => ['text' => '4h 30m', 'value' => 16200],
                        'start_location' => ['lat' => 44.4056, 'lng' => 8.9463],
                        'end_location' => ['lat' => 41.9028, 'lng' => 12.4964],
                        'steps' => [],
                    ],
                ],
                'overview_polyline' => ['points' => 'encoded_polyline'],
                'summary' => 'Via A7',
                'warnings' => [],
                'waypoint_order' => [0],
            ]],
        ], 200),
    ]);

    $locations = [
        new LocationData(latitude: 44.4056, longitude: 8.9463, address: 'Genova'),
    ];
    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($locations, $origin, $destination);

    expect($result)
        ->toBeArray()
        ->toHaveCount(1)
        ->and($result[0])->toBeInstanceOf(RouteData::class)
        ->and($result[0]->totalDistance)->toBe(1044000)
        ->and($result[0]->totalDuration)->toBe(36000);
});

it('throws exception when api request fails', function (): void {
    config(['services.google.maps.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response(null, 500),
    ]);

    $locations = [
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ];
    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    expect(fn () => $action->execute($locations, $origin, $destination))
        ->toThrow(RuntimeException::class, 'Failed to get directions');
});
