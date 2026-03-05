<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;
use GuzzleHttp\Client;

uses(LightTestCase::class);
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetGeocodingDataAction;
use Modules\Geo\Datas\GeocodingData;

beforeEach(function () {
    $this->mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($this->mockHandler);
    $this->client = new Client(['handler' => $handlerStack]);
    $this->action = new GetGeocodingDataAction($this->client);
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(\RuntimeException::class, 'Chiave API Google Maps non configurata');
});

it('throws exception for empty address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => $this->action->execute(''))
        ->toThrow(\RuntimeException::class, 'Indirizzo non può essere vuoto');
});

it('throws exception for too long address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

    expect(fn () => $this->action->execute($longAddress))
        ->toThrow(\RuntimeException::class, 'Indirizzo troppo lungo');
});

it('returns error geocoding data for guzzle exception', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new \GuzzleHttp\Exception\RequestException('Error', new \GuzzleHttp\Psr7\Request('GET', 'http://test')));

    $result = $this->action->execute('Milano, Italia');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue()
        ->and($result->status)->toBe('REQUEST_FAILED');
});

it('returns error geocoding data for invalid status', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ])));

    $result = $this->action->execute('NonExistentPlace');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue();
});

it('returns geocoding data for valid address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
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

    $result = $this->action->execute('Via Roma, Milano, Italia');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeFalse()
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
});
