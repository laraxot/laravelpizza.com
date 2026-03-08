<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetAddressByLatLngFromGoogleMapsAction;
use Modules\Geo\Datas\LocationData;

beforeEach(function () {
    // @var mixed mockHandler = new MockHandler(;
    $handlerStack = HandlerStack::create(// @var mixed mockHandler;
    // @var mixed client = new Client(['handler' => $handlerStack];
    // @var mixed action = new GetAddressByLatLngFromGoogleMapsAction($this->client;
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    expect(fn () => // @var mixed action->execute(45.4642, 9.1900
        ->toThrow(RuntimeException::class, 'Google Maps API key not configured');
});

it('throws exception for invalid latitude below -90', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => // @var mixed action->execute(-91.0, 9.1900
        ->toThrow(InvalidArgumentException::class, 'Invalid latitude');
});

it('throws exception for invalid latitude above 90', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => // @var mixed action->execute(91.0, 9.1900
        ->toThrow(InvalidArgumentException::class, 'Invalid latitude');
});

it('throws exception for invalid longitude below -180', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => // @var mixed action->execute(45.0, -181.0
        ->toThrow(InvalidArgumentException::class, 'Invalid longitude');
});

it('throws exception for invalid longitude above 180', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => // @var mixed action->execute(45.0, 181.0
        ->toThrow(InvalidArgumentException::class, 'Invalid longitude');
});

it('throws exception for guzzle exception', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    // @var mixed mockHandler->append(new GuzzleHttp\Exception\RequestException('Error', new GuzzleHttp\Psr7\Request('GET', 'http://test';

    expect(fn () => // @var mixed action->execute(45.4642, 9.1900
        ->toThrow(RuntimeException::class, 'Failed to get address from coordinates');
});

it('throws exception when no results found', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [],
    ])));

    expect(fn () => // @var mixed action->execute(45.4642, 9.1900
        ->toThrow(RuntimeException::class, 'No address found');
});

it('throws exception for invalid response status', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ])));

    expect(fn () => // @var mixed action->execute(45.4642, 9.1900
        ->toThrow(RuntimeException::class, 'No address found');
});

it('returns location data for valid coordinates', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'formatted_address' => 'Via Roma, Milano, MI, Italia',
            'geometry' => [
                'location' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
            ],
        ]],
    ])));

    $result = // @var mixed action->execute(45.4642, 9.1900;

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->address)->toBe('Via Roma, Milano, MI, Italia')
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
});

it('handles boundary latitude values', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'formatted_address' => 'North Pole',
            'geometry' => [
                'location' => [
                    'lat' => 90.0,
                    'lng' => 0.0,
                ],
            ],
        ]],
    ])));

    $result = // @var mixed action->execute(90.0, 0.0;

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->latitude)->toBe(90.0);
});

it('handles boundary longitude values', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'formatted_address' => 'International Date Line',
            'geometry' => [
                'location' => [
                    'lat' => 0.0,
                    'lng' => 180.0,
                ],
            ],
        ]],
    ])));

    $result = // @var mixed action->execute(0.0, 180.0;

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->longitude)->toBe(180.0);
});
