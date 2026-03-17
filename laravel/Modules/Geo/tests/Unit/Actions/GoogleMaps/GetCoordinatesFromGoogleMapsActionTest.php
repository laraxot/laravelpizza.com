<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetCoordinatesFromGoogleMapsAction;
use Modules\Geo\Datas\LocationData;

beforeEach(function () {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($this->client);
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Google Maps API key not configured');
});

it('throws exception for empty address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => $action->execute(''))
        ->toThrow(InvalidArgumentException::class, 'Address cannot be empty');
});

it('throws exception for too long address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

    expect(fn () => $action->execute($longAddress))
        ->toThrow(InvalidArgumentException::class, 'Address is too long');
});

it('throws exception for guzzle exception', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new GuzzleHttp\Exception\RequestException('Error', new GuzzleHttp\Psr7\Request('GET', 'http://test')));

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Failed to get coordinates');
});

it('throws exception when no coordinates found', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([)))
        'status' => 'OK',
        'results' => [],
    ])));

    expect(fn () => $action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found');
});

it('throws exception when status is not OK', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([)))
        'status' => 'ZERO_RESULTS',
    ])));

    expect(fn () => $action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found');
});

it('returns location data for valid address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([)))
        'status' => 'OK',
        'results' => [[
            'geometry' => [
                'location' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
            ],
        ]],
    ])));

    $result = $action->execute('Milano, Italia');

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->address)->toBe('Milano, Italia')
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
});

it('handles address with special characters', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([)))
        'status' => 'OK',
        'results' => [[
            'geometry' => [
                'location' => [
                    'lat' => 41.9028,
                    'lng' => 12.4964,
                ],
            ],
        ]],
    ])));

    $result = $action->execute('Piazza del Popolo, Roma, Italia');

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->latitude)->toBe(41.9028)
        ->and($result->longitude)->toBe(12.4964);
});
