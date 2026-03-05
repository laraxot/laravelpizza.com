<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
use Modules\Geo\Actions\Bing\GetAddressFromBingMapsAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Exceptions\InvalidLocationException;

beforeEach(function () {
    $this->client = new Client();
    $this->action = new GetAddressFromBingMapsAction();
});

it('throws exception when api key is not configured', function (): void {
    config(['services.bing.maps_api_key' => null]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'API key di Bing Maps non configurata');
});

it('throws exception for invalid latitude range', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    expect(fn () => $this->action->execute(91.0, 9.1900))
        ->toThrow(InvalidLocationException::class);
});

it('throws exception for invalid longitude range', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    expect(fn () => $this->action->execute(45.0, 181.0))
        ->toThrow(InvalidLocationException::class);
});

it('throws exception when api response is not successful', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Richiesta a Bing Maps fallita');
});

it('throws exception when api response is not valid json', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response('not valid json', 200),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Risposta JSON non valida');
});

it('throws exception when no results in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [],
            ]],
        ], 200),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Nessun risultato trovato');
});

it('throws exception when point is missing in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'address' => ['locality' => 'Milano'],
                ]],
            ]],
        ], 200),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Point mancante');
});

it('throws exception when coordinates are missing in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'point' => [],
                    'address' => ['locality' => 'Milano'],
                ]],
            ]],
        ], 200),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Coordinate mancanti');
});

it('throws exception when address is missing in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'point' => ['coordinates' => [45.4642, 9.1900]],
                ]],
            ]],
        ], 200),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Indirizzo mancante');
});

it('returns address data for valid coordinates', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'point' => ['coordinates' => [45.4642, 9.1900]],
                    'address' => [
                        'countryRegion' => 'Italia',
                        'adminDistrict' => 'Lombardia',
                        'adminDistrict2' => 'Milano',
                        'locality' => 'Milano',
                        'postalCode' => '20100',
                        'addressLine' => 'Via Roma 1',
                        'countryRegionIso2' => 'IT',
                    ],
                ]],
            ]],
        ], 200),
    ]);

    $result = $this->action->execute(45.4642, 9.1900);

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->street)->toBe('Via Roma 1')
        ->and($result->state)->toBe('Lombardia')
        ->and($result->country_code)->toBe('IT');
});
