<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Create;
<<<<<<< HEAD
=======
<<<<<<< HEAD
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
=======
>>>>>>> laraxot/dev
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
<<<<<<< HEAD
=======
use Modules\Geo\Actions\GoogleMaps\GetAddressFromGoogleMapsAction;
use Modules\Geo\Actions\Photon\GetAddressFromPhotonAction;
use Modules\Geo\Datas\Geocoding\AddressData;
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('returns AddressData when first service succeeds', function (): void {
<<<<<<< HEAD
    $action = new GetAddressDataFromFullAddressAction;
=======
<<<<<<< HEAD
    $action = new GetAddressDataFromFullAddressAction;
=======
    $action = new GetAddressDataFromFullAddressAction();
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

    // As this action depends on multiple external services which are difficult to mock,
    // we can test that it at least has the correct structure and properties
    Assert::assertCount(0, $action->getErrors());
});

it('initializes with empty errors collection', function (): void {
<<<<<<< HEAD
    $action = new GetAddressDataFromFullAddressAction;
=======
<<<<<<< HEAD
    $action = new GetAddressDataFromFullAddressAction;
=======
    $action = new GetAddressDataFromFullAddressAction();
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

    Assert::assertCount(0, $action->getErrors());
});

it('executes without throwing error for basic call', function (): void {
    // Hermetic: every provider must fail without reaching the network.
    // Laravel Http-based providers (Google, Nominatim, Here, OpenCage) get a fake 503,
    // Guzzle-based providers (Photon, Bing, Mapbox) get a Client whose handler answers 503.
    Http::preventStrayRequests();
    Http::fake(['*' => Http::response([], 503)]);
    app()->instance(Client::class, new Client([
        'handler' => HandlerStack::create(
<<<<<<< HEAD
            static fn (): PromiseInterface => Create::promiseFor(new Response(503)),
=======
<<<<<<< HEAD
            static fn (): \GuzzleHttp\Promise\PromiseInterface => Create::promiseFor(new Response(503)),
=======
            static fn (): PromiseInterface => Create::promiseFor(new Response(503)),
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
        ),
    ]));
    config([
        'geo.driver' => null,
        'services.google.maps_api_key' => 'test-key',
        'services.bing.maps_api_key' => 'test-key',
        'services.here.key' => 'test-key',
        'services.mapbox.access_token' => 'test-key',
        'services.opencage.key' => 'test-key',
    ]);

<<<<<<< HEAD
    $action = new GetAddressDataFromFullAddressAction;
=======
<<<<<<< HEAD
    $action = new GetAddressDataFromFullAddressAction;
=======
    $action = new GetAddressDataFromFullAddressAction();
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

    // The execute method handles failing providers gracefully and returns null
    $result = $action->execute('Test Address');

    Assert::assertNull($result);
    // Every provider failure is collected as an error message
    Assert::assertNotEmpty($action->getErrors());
<<<<<<< HEAD
});
=======
<<<<<<< HEAD
});
=======
})->group('GEO-GEOCODE-INV-2', 'GEO-GEOCODE-INV-3');

/*
 * Contratto: docs/contracts/get-address-data-from-full-address-action.md. I provider si sostituiscono nel container con
 * oggetti che registrano le chiamate: nessuna rete, nessuna chiave.
 *
 * @return object{calls: list<string>}
 */
function geocodeProviderStub(?AddressData $result, ?string $failure = null): object
{
    return new class($result, $failure)
    {
        /** @var list<string> */
        public array $calls = [];

        public function __construct(private readonly ?AddressData $result, private readonly ?string $failure) {}

        public function execute(string $address): ?AddressData
        {
            $this->calls[] = $address;
            if ($this->failure !== null) {
                throw new \RuntimeException($this->failure);
            }

            return $this->result;
        }
    };
}

it('asks the provider chosen in geo.driver first and stops at its answer', function (): void {
    $photon = geocodeProviderStub(new AddressData(latitude: 43.77, longitude: 11.25, city: 'Firenze'));
    $google = geocodeProviderStub(null, 'google must not be asked');
    app()->instance(GetAddressFromPhotonAction::class, $photon);
    app()->instance(GetAddressFromGoogleMapsAction::class, $google);
    config(['geo.driver' => 'photon']);

    $result = (new GetAddressDataFromFullAddressAction())->execute('Piazza della Signoria, Firenze');

    Assert::assertSame('Firenze', $result?->city);
    Assert::assertSame(['Piazza della Signoria, Firenze'], $photon->calls);
    Assert::assertSame([], $google->calls);
})->group('GEO-GEOCODE-INV-1');

it('moves to the next provider when one throws, and keeps its message', function (): void {
    $photon = geocodeProviderStub(null, 'photon down');
    $google = geocodeProviderStub(new AddressData(latitude: 45.46, longitude: 9.19, city: 'Milano'));
    app()->instance(GetAddressFromPhotonAction::class, $photon);
    app()->instance(GetAddressFromGoogleMapsAction::class, $google);
    config(['geo.driver' => 'photon']);

    $action = new GetAddressDataFromFullAddressAction();
    $result = $action->execute('Via Roma 1, Milano');

    Assert::assertSame('Milano', $result?->city);
    Assert::assertSame(['photon down'], $action->getErrors()->all());
})->group('GEO-GEOCODE-INV-2');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
