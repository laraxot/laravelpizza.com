<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetCoordinatesByAddressAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

/*
 * L'action prova più provider; gli ultimi (Nominatim, Open-Meteo) non chiedono chiavi, quindi senza fake i test andavano in rete
 * davvero e fallivano a ogni rallentamento. Nessuna chiamata reale: Nominatim e Open-Meteo rispondono «nessun risultato» e ogni
 * altra richiesta non prevista fa fallire il test subito.
 */
beforeEach(function (): void {
    Http::preventStrayRequests();
    Http::fake([
        'nominatim.openstreetmap.org/*' => Http::response([], 200),
        'api.open-meteo.com/*' => Http::response(['generationtime_ms' => 0.1], 200),
    ]);
});

it('returns null for empty address', function (): void {
    $action = new GetCoordinatesByAddressAction;

    // Without API keys configured, should return null
    $result = $action->execute('');

    Assert::assertNull($result);
    // Nessun provider interpellato per un indirizzo vuoto.
    Http::assertNothingSent();
});

it('returns null when google api key not configured', function (): void {
    $action = new GetCoordinatesByAddressAction;

    Config::set('services.google.maps_api_key', null);
    Config::set('services.bing.maps_api_key', null);
    Config::set('services.opencage.api_key', null);

    // Azzerare le chiavi non spegne la catena: `GetCoordinatesByAddressAction`
    // prova cinque fornitori, e gli ultimi due — Nominatim e open-meteo — non
    // vogliono chiavi. Senza questo finto il test uscuiva in rete davvero e
    // falliva per timeout (base_quaeris_fila5#241).
    Http::fake(['*' => Http::response([], 200)]);

    $result = $action->execute('Fake Address XYZ');

    Assert::assertNull($result);
});

it('returns null for non-existent address with mock', function (): void {
    $action = new GetCoordinatesByAddressAction;

    Config::set('services.google.maps_api_key', 'fake-key');
    Config::set('services.bing.maps_api_key', null);
    Config::set('services.opencage.api_key', null);

    // Il finto su Google non bastava: una richiesta che nessuna regola
    // intercetta passa alla rete vera, e la catena arriva fino a open-meteo,
    // che non vuole chiavi. La regola `*` in coda chiude il buco.
    Http::fake([
        'maps.googleapis.com/*' => Http::response([
            'status' => 'ZERO_RESULTS',
            'results' => [],
        ], 200),
        '*' => Http::response([], 200),
    ]);

    $result = $action->execute('asdfghjklqwertyuizxcvbnm123456789');

    Assert::assertNull($result);
});
