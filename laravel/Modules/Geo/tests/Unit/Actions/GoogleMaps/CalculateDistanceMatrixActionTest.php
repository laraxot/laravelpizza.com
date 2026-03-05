<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Illuminate\Support\Collection;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;

beforeEach(function () {
    $this->action = new CalculateDistanceMatrixAction;
});

it('throws exception when google maps api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    expect(fn () => $this->action->execute($origins, $destinations))
        ->toThrow(GoogleMapsApiException::class, 'API key non configurata');
});

it('throws exception when api key is empty string', function (): void {
    config(['services.google.maps_api_key' => '']);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    expect(fn () => $this->action->execute($origins, $destinations))
        ->toThrow(GoogleMapsApiException::class);
});

it('throws exception when api response is not successful', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['status' => 'REQUEST_DENIED'], 403),
    ]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    expect(fn () => $this->action->execute($origins, $destinations))
        ->toThrow(GoogleMapsApiException::class, 'Richiesta fallita');
});

it('throws exception when response status is not OK', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['status' => 'ZERO_RESULTS'], 200),
    ]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    expect(fn () => $this->action->execute($origins, $destinations))
        ->toThrow(GoogleMapsApiException::class, 'Stato della risposta non valido');
});

it('throws exception when response has no rows', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['status' => 'OK', 'rows' => []], 200),
    ]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    expect(fn () => $this->action->execute($origins, $destinations))
        ->toThrow(GoogleMapsApiException::class, 'Nessun risultato');
});

it('returns distance matrix for valid locations', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'status' => 'OK',
            'rows' => [[
                'elements' => [[
                    'distance' => ['text' => '572 km', 'value' => 572000],
                    'duration' => ['text' => '5h 30m', 'value' => 19800],
                    'status' => 'OK',
                ]],
            ]],
        ], 200),
    ]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    $result = $this->action->execute($origins, $destinations);

    expect($result)
        ->toBeArray()
        ->toHaveCount(1)
        ->and($result[0][0]['distance']['text'])->toBe('572 km')
        ->and($result[0][0]['distance']['value'])->toBe(572000)
        ->and($result[0][0]['duration']['text'])->toBe('5h 30m')
        ->and($result[0][0]['status'])->toBe('OK');
});

it('handles multiple origins and destinations', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'status' => 'OK',
            'rows' => [
                [
                    'elements' => [
                        ['distance' => ['text' => '100 km', 'value' => 100000], 'duration' => ['text' => '1h', 'value' => 3600], 'status' => 'OK'],
                        ['distance' => ['text' => '200 km', 'value' => 200000], 'duration' => ['text' => '2h', 'value' => 7200], 'status' => 'OK'],
                    ],
                ],
                [
                    'elements' => [
                        ['distance' => ['text' => '150 km', 'value' => 150000], 'duration' => ['text' => '1h 30m', 'value' => 5400], 'status' => 'OK'],
                        ['distance' => ['text' => '250 km', 'value' => 250000], 'duration' => ['text' => '2h 30m', 'value' => 9000], 'status' => 'OK'],
                    ],
                ],
            ],
        ], 200),
    ]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
        new LocationData(latitude: 44.4056, longitude: 8.9463, address: 'Genova'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
        new LocationData(latitude: 40.8518, longitude: 14.2681, address: 'Napoli'),
    ]);

    $result = $this->action->execute($origins, $destinations);

    expect($result)
        ->toBeArray()
        ->toHaveCount(2)
        ->and($result[0][0]['distance']['value'])->toBe(100000)
        ->and($result[0][1]['distance']['value'])->toBe(200000)
        ->and($result[1][0]['distance']['value'])->toBe(150000)
        ->and($result[1][1]['distance']['value'])->toBe(250000);
});

it('handles zero results status', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'status' => 'OK',
            'rows' => [[
                'elements' => [[
                    'distance' => ['text' => '0 km', 'value' => 0],
                    'duration' => ['text' => '0 min', 'value' => 0],
                    'status' => 'ZERO_RESULTS',
                ]],
            ]],
        ], 200),
    ]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    $result = $this->action->execute($origins, $destinations);

    expect($result[0][0]['status'])->toBe('ZERO_RESULTS');
});
