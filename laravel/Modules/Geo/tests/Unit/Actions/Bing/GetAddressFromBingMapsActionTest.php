<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Bing;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\Bing\GetAddressFromBingMapsAction;
use Modules\Geo\Exceptions\InvalidLocationException;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    config(['services.bing.maps_api_key' => null]);

    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('API key di Bing Maps non configurata', $exception->getMessage());
    }
});

it('throws exception for invalid latitude range', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(91.0, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
<<<<<<< HEAD
    } catch (InvalidLocationException) {
    }
=======
    } catch (InvalidLocationException $exception) {
        // Il `catch` era vuoto, quindi il test non registrava nessuna
        // asserzione e PHPUnit lo segnalava come «risky»: passava per il solo
        // fatto di non essere arrivato all'`Assert::fail`. Il messaggio
        // dell'eccezione e' l'unica cosa che l'operatore legge, e deve dire
        // **quale** coordinata e' sbagliata (base_quaeris_fila5#241).
        Assert::assertStringContainsString('91', $exception->getMessage());
    }
=======
    Http::fake();

    try {
        (new GetAddressFromBingMapsAction)->execute(91.0, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertStringStartsWith('Coordinate non valide', $exception->getMessage());
    }
    // Coordinate fuori range: nessuna chiamata a Bing.
    Http::assertNothingSent();
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
});

it('throws exception for invalid longitude range', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.0, 181.0);
        Assert::fail('Expected InvalidLocationException was not thrown');
<<<<<<< HEAD
    } catch (InvalidLocationException) {
    }
=======
    } catch (InvalidLocationException $exception) {
        // Vedi il test gemello: un `catch` vuoto non asserisce niente.
        Assert::assertStringContainsString('181', $exception->getMessage());
    }
=======
    Http::fake();

    try {
        (new GetAddressFromBingMapsAction)->execute(45.0, 181.0);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertStringStartsWith('Coordinate non valide', $exception->getMessage());
    }
    // Coordinate fuori range: nessuna chiamata a Bing.
    Http::assertNothingSent();
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
});

it('throws exception when api response is not successful', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Richiesta a Bing Maps fallita', $exception->getMessage());
    }
});

it('throws exception when api response is not valid json', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response('not valid json', 200),
    ]);

    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Risposta JSON non valida da Bing Maps', $exception->getMessage());
    }
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

    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Nessun risultato trovato', $exception->getMessage());
    }
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

    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Point mancante nella risposta', $exception->getMessage());
    }
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

    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Coordinate mancanti nella risposta', $exception->getMessage());
    }
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

    $action = new GetAddressFromBingMapsAction;
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Indirizzo mancante nella risposta', $exception->getMessage());
    }
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

    $action = new GetAddressFromBingMapsAction;
    $result = $action->execute(45.4642, 9.1900);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertSame('Via Roma 1', $result->street);

    Assert::assertSame('Lombardia', $result->state);

    Assert::assertSame('IT', $result->country_code);
});
