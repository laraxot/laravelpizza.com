<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Create;
<<<<<<< .merge_file_WMswM3
<<<<<<< HEAD
=======
<<<<<<< HEAD
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
=======
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_RW5JQ1
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
<<<<<<< HEAD
=======
use Modules\Geo\Actions\GoogleMaps\GetAddressFromGoogleMapsAction;
use Modules\Geo\Actions\Photon\GetAddressFromPhotonAction;
use Modules\Geo\Datas\Geocoding\AddressData;
<<<<<<< .merge_file_WMswM3
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_RW5JQ1
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
<<<<<<< .merge_file_WMswM3
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
=======
>>>>>>> .merge_file_RW5JQ1

it('returns AddressData when first service succeeds', function (): void {
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction())->getErrors());
});

it('initializes with empty errors collection', function (): void {
<<<<<<< .merge_file_WMswM3
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
=======
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction())->getErrors());
>>>>>>> .merge_file_RW5JQ1
});

it('executes without throwing error for basic call', function (): void {
    Http::preventStrayRequests();
    Http::fake(['*' => Http::response([], 503)]);
    app()->instance(Client::class, new Client([
        'handler' => HandlerStack::create(
<<<<<<< .merge_file_WMswM3
<<<<<<< HEAD
            static fn (): PromiseInterface => Create::promiseFor(new Response(503)),
=======
<<<<<<< HEAD
            static fn (): \GuzzleHttp\Promise\PromiseInterface => Create::promiseFor(new Response(503)),
=======
            static fn (): PromiseInterface => Create::promiseFor(new Response(503)),
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
            static fn (): PromiseInterface => Create::promiseFor(new Response(503)),
>>>>>>> .merge_file_RW5JQ1
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

<<<<<<< .merge_file_WMswM3
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
=======
    $action = new GetAddressDataFromFullAddressAction();
    Assert::assertNull($action->execute('Test Address'));
    Assert::assertNotEmpty($action->getErrors());
>>>>>>> .merge_file_RW5JQ1
})->group('GEO-GEOCODE-INV-2', 'GEO-GEOCODE-INV-3');

/**
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
<<<<<<< .merge_file_WMswM3
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_RW5JQ1
