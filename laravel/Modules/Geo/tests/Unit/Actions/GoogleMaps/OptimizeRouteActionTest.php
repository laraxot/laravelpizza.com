<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GoogleMaps\OptimizeRouteAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\Routing\RouteData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $action = new OptimizeRouteAction();

    config(['services.google.maps.key' => null]);

    $locations = [
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ];
    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    try {
        $action->execute($locations, $origin, $destination);

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('API key not found', $exception->getMessage());
    }
});

it('returns empty array for empty locations', function (): void {
    $action = new OptimizeRouteAction();

    config(['services.google.maps.key' => 'test_key']);

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute([], $origin, $destination);
    Assert::assertEmpty($result);
});

it('returns empty array when api returns no routes', function (): void {
    $action = new OptimizeRouteAction();

    config(['services.google.maps.key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['routes' => []], 200),
    ]);

    $locations = [
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ];
    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($locations, $origin, $destination);
    Assert::assertEmpty($result);
});

it('returns route data for valid request', function (): void {
    $action = new OptimizeRouteAction();

    config(['services.google.maps.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
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
    Assert::assertCount(1, $result);

    Assert::assertInstanceOf(RouteData::class, $result[0]);

    Assert::assertSame(1044000, $result[0]->totalDistance);

    Assert::assertSame(36000, $result[0]->totalDuration);
});

it('throws exception when api request fails', function (): void {
    $action = new OptimizeRouteAction();

    config(['services.google.maps.key' => 'test_key']);

    Http::fake([
        '*' => Http::response(null, 500),
    ]);

    $locations = [
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ];
    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    try {
        $action->execute($locations, $origin, $destination);

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Failed to get directions', $exception->getMessage());
    }
});
