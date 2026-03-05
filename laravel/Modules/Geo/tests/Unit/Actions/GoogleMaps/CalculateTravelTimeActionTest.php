<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;
use GuzzleHttp\Client;

uses(LightTestCase::class);
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\CalculateTravelTimeAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\TravelTimeData;

beforeEach(function () {
    $this->mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($this->mockHandler);
    $this->client = new Client(['handler' => $handlerStack]);
    $this->action = new CalculateTravelTimeAction($this->client);
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(\RuntimeException::class, 'Google Maps API key not configured');
});

it('throws exception when origin and destination are the same', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $location = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');

    expect(fn () => $this->action->execute($location, $location))
        ->toThrow(\InvalidArgumentException::class, 'Origin and destination cannot be the same');
});

it('returns error travel time data for failed api request', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(500, [], 'Server Error'));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $this->action->execute($origin, $destination);

    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->status)->toBe('REQUEST_FAILED');
});

it('returns error for invalid response status', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'INVALID_REQUEST',
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $this->action->execute($origin, $destination);

    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->status)->toBe('INVALID_RESPONSE');
});

it('returns error when no route found', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'status' => 'ZERO_RESULTS',
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $this->action->execute($origin, $destination);

    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->status)->toBe('NO_ROUTE');
});

it('returns travel time data for valid route', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'duration' => ['value' => 19800, 'text' => '5 hours 30 mins'],
                'duration_in_traffic' => ['value' => 21000, 'text' => '5 hours 50 mins'],
                'distance' => ['value' => 572000, 'text' => '572 km'],
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $this->action->execute($origin, $destination);

    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->duration_seconds)->toBe(19800)
        ->and($result->duration_in_traffic_seconds)->toBe(21000)
        ->and($result->distance_meters)->toBe(572000)
        ->and($result->formatted_duration)->toBe('5 hours 30 mins')
        ->and($result->formatted_distance)->toBe('572 km')
        ->and($result->status)->toBe('OK');
});

it('uses duration as fallback for duration in traffic', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'duration' => ['value' => 19800, 'text' => '5 hours 30 mins'],
                'distance' => ['value' => 572000, 'text' => '572 km'],
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $this->action->execute($origin, $destination);

    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->duration_in_traffic_seconds)->toBe(19800);
});
