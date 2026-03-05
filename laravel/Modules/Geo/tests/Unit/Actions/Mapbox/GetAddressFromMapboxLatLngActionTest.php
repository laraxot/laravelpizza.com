<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxLatLngAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Exceptions\InvalidLocationException;

beforeEach(function () {
    $this->action = new GetAddressFromMapboxLatLngAction;
});

it('throws exception for invalid latitude below -90', function (): void {
    expect(fn () => $this->action->execute(-91.0, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Latitudine non valida');
});

it('throws exception for invalid latitude above 90', function (): void {
    expect(fn () => $this->action->execute(91.0, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Latitudine non valida');
});

it('throws exception for invalid longitude below -180', function (): void {
    expect(fn () => $this->action->execute(45.0, -181.0))
        ->toThrow(InvalidLocationException::class, 'Longitudine non valida');
});

it('throws exception for invalid longitude above 180', function (): void {
    expect(fn () => $this->action->execute(45.0, 181.0))
        ->toThrow(InvalidLocationException::class, 'Longitudine non valida');
});

it('throws exception when api key is not configured', function (): void {
    config(['services.mapbox.api_key' => null]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'API key di Mapbox non configurata');
});

it('throws exception when api response is not successful', function (): void {
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Richiesta a Mapbox fallita');
});

it('throws exception when response is not valid json', function (): void {
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response('not valid json', 200),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Risposta di Mapbox non valida');
});

it('throws exception when no features in response', function (): void {
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [],
        ], 200),
    ]);

    expect(fn () => $this->action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Nessun risultato trovato');
});

it('returns address data for valid coordinates', function (): void {
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [[
                'center' => [9.1900, 45.4642],
                'text' => 'Via Roma',
                'address' => '1',
                'context' => [
                    ['id' => 'country.1', 'text' => 'Italia', 'short_code' => 'it'],
                    ['id' => 'place.1', 'text' => 'Milano'],
                    ['id' => 'postcode.1', 'text' => '20100'],
                    ['id' => 'region.1', 'text' => 'Lombardia'],
                    ['id' => 'neighborhood.1', 'text' => 'Centro'],
                ],
            ]],
        ], 200),
    ]);

    $result = $this->action->execute(45.4642, 9.1900);

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->country_code)->toBe('IT')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->locality)->toBeNull()
        ->and($result->county)->toBe('Lombardia')
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->district)->toBe('Centro')
        ->and($result->state)->toBe('Lombardia');
});

it('handles boundary coordinate values', function (): void {
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [[
                'center' => [180.0, 90.0],
                'text' => 'North Pole',
                'context' => [
                    ['id' => 'country.1', 'text' => 'Unknown', 'short_code' => 'xx'],
                ],
            ]],
        ], 200),
    ]);

    $result = $this->action->execute(90.0, 180.0);

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(90.0)
        ->and($result->longitude)->toBe(180.0);
});

it('handles missing context items', function (): void {
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [[
                'center' => [9.1900, 45.4642],
                'text' => 'Via Roma',
            ]],
        ], 200),
    ]);

    $result = $this->action->execute(45.4642, 9.1900);

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->country)->toBeNull()
        ->and($result->city)->toBeNull();
});
