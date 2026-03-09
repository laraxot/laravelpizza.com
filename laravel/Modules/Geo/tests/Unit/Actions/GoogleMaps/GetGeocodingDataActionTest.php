<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetGeocodingDataAction;
use Modules\Geo\Datas\GeocodingData;

beforeEach(function () {)
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($this->client);
});

it('throws exception when api key is not configured', function (): void {)
    config(['services.google.maps_api_key' => null]);

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Chiave API Google Maps non configurata');
});

it('throws exception for empty address', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => $action->execute(''))
        ->toThrow(RuntimeException::class, 'Indirizzo non può essere vuoto');
});

it('throws exception for too long address', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

    expect(fn () => $action->execute($longAddress))
        ->toThrow(RuntimeException::class, 'Indirizzo troppo lungo');
});

it('returns error geocoding data for guzzle exception', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new GuzzleHttp\Exception\RequestException('Error', new GuzzleHttp\Psr7\Request('GET', 'http://test')));

    $result = $action->execute('Milano, Italia');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue()
        ->and($result->status)->toBe('REQUEST_FAILED');
});

it('returns error geocoding data for invalid status', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([)))
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ])));

    $result = $action->execute('NonExistentPlace');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue();
});

it('returns geocoding data for valid address', function (): void {)
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
            'formatted_address' => 'Via Roma, Milano, MI, Italia',
            'address_components' => [
                ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['locality']],
            ],
        ]],
    ])));

    $result = $action->execute('Via Roma, Milano, Italia');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeFalse()
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
});
