<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception when google maps api key is not configured', function (): void {
    $action = new CalculateDistanceMatrixAction();

    config(['services.google.maps_api_key' => null]);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    try {
        $action->execute($origins, $destinations);

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException $exception) {
        Assert::assertSame('API key non configurata', $exception->getMessage());
    }
});

it('throws exception when api key is empty string', function (): void {
    $action = new CalculateDistanceMatrixAction();

    config(['services.google.maps_api_key' => '']);

    $origins = collect([
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano'),
    ]);

    $destinations = collect([
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma'),
    ]);

    try {
        $action->execute($origins, $destinations);

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException) {
    }
});

it('throws exception when api response is not successful', function (): void {
    $action = new CalculateDistanceMatrixAction();

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

    try {
        $action->execute($origins, $destinations);

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException $exception) {
        Assert::assertSame('Richiesta fallita', $exception->getMessage());
    }
});

it('throws exception when response status is not OK', function (): void {
    $action = new CalculateDistanceMatrixAction();

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

    try {
        $action->execute($origins, $destinations);

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException $exception) {
        Assert::assertSame('Stato della risposta non valido', $exception->getMessage());
    }
});

it('throws exception when response has no rows', function (): void {
    $action = new CalculateDistanceMatrixAction();

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

    try {
        $action->execute($origins, $destinations);

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException $exception) {
        Assert::assertSame('Nessun risultato', $exception->getMessage());
    }
});

it('returns distance matrix for valid locations', function (): void {
    $action = new CalculateDistanceMatrixAction();

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

    $result = $action->execute($origins, $destinations);
    Assert::assertCount(1, $result);

    Assert::assertSame('572 km', $result[0][0]['distance']['text']);

    Assert::assertSame(572000, $result[0][0]['distance']['value']);

    Assert::assertSame('5h 30m', $result[0][0]['duration']['text']);

    Assert::assertSame('OK', $result[0][0]['status']);
});

it('handles multiple origins and destinations', function (): void {
    $action = new CalculateDistanceMatrixAction();

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

    $result = $action->execute($origins, $destinations);
    Assert::assertCount(2, $result);

    Assert::assertSame(100000, $result[0][0]['distance']['value']);

    Assert::assertSame(200000, $result[0][1]['distance']['value']);

    Assert::assertSame(150000, $result[1][0]['distance']['value']);

    Assert::assertSame(250000, $result[1][1]['distance']['value']);
});

it('handles zero results status', function (): void {
    $action = new CalculateDistanceMatrixAction();

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

    $result = $action->execute($origins, $destinations);

    Assert::assertSame('ZERO_RESULTS', $result[0][0]['status']);
});
