<?php

declare(strict_types=1);

namespace Tests\Modules\Geo\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\CalculateTravelTimeAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);

it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

    config(['services.google.maps_api_key' => null]);

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    try {
        $action->execute($origin, $destination);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Google Maps API key not configured', $exception->getMessage());
    }
});

it('throws exception when origin and destination are the same', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $location = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');

    try {
        $action->execute($location, $location);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Origin and destination cannot be the same location', $exception->getMessage());
    }
});

it('returns error travel time data for failed api request', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(500, [], 'Server Error'));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

    Assert::assertSame('REQUEST_FAILED', $result->status);
});

it('returns error for invalid response status', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'INVALID_REQUEST',
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

    Assert::assertSame('INVALID_REQUEST', $result->status);
});

it('returns error when no route found', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'status' => 'ZERO_RESULTS',
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

    Assert::assertSame('ZERO_RESULTS', $result->status);
});

it('returns travel time data for valid route', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'status' => 'OK',
                'duration' => ['value' => 19800, 'text' => '5 hours 30 mins'],
                'duration_in_traffic' => ['value' => 21000, 'text' => '5 hours 50 mins'],
                'distance' => ['value' => 572000, 'text' => '572 km'],
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

    Assert::assertSame(19800, $result->duration_seconds);
    Assert::assertSame(21000, $result->duration_in_traffic_seconds);
    Assert::assertSame(572000, $result->distance_meters);
    Assert::assertSame('5 hours 30 mins', $result->formatted_duration);
    Assert::assertSame('572 km', $result->formatted_distance);
    Assert::assertSame('OK', $result->status);
});

it('uses duration as fallback for duration in traffic', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'status' => 'OK',
                'duration' => ['value' => 19800, 'text' => '5 hours 30 mins'],
                'distance' => ['value' => 572000, 'text' => '572 km'],
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

    Assert::assertSame(19800, $result->duration_in_traffic_seconds);
});
