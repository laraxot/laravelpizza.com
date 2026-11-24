<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Actions\GoogleMaps\GetAddressFromGoogleMapsAction;
use Modules\Geo\Actions\Photon\GetAddressFromPhotonAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('returns AddressData when first service succeeds', function (): void {
<<<<<<< .merge_file_dKhHii
<<<<<<< .merge_file_gfGhnE
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction)->getErrors());
});

it('initializes with empty errors collection', function (): void {
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction)->getErrors());
=======
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction())->getErrors());
});

it('initializes with empty errors collection', function (): void {
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction())->getErrors());
>>>>>>> .merge_file_2w84DZ
=======
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction())->getErrors());
});

it('initializes with empty errors collection', function (): void {
    Assert::assertCount(0, (new GetAddressDataFromFullAddressAction())->getErrors());
>>>>>>> .merge_file_HLrLUK
});

it('executes without throwing error for basic call', function (): void {
    Http::preventStrayRequests();
    Http::fake(['*' => Http::response([], 503)]);
    app()->instance(Client::class, new Client([
        'handler' => HandlerStack::create(
            static fn (): PromiseInterface => Create::promiseFor(new Response(503)),
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
<<<<<<< .merge_file_dKhHii
<<<<<<< .merge_file_gfGhnE

    $action = new GetAddressDataFromFullAddressAction;
    Assert::assertNull($action->execute('Test Address'));
    Assert::assertNotEmpty($action->getErrors());
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

=======

    $action = new GetAddressDataFromFullAddressAction();
    Assert::assertNull($action->execute('Test Address'));
    Assert::assertNotEmpty($action->getErrors());
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

=======

    $action = new GetAddressDataFromFullAddressAction();
    Assert::assertNull($action->execute('Test Address'));
    Assert::assertNotEmpty($action->getErrors());
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

>>>>>>> .merge_file_HLrLUK
        public function execute(string $address): ?AddressData
        {
            $this->calls[] = $address;
            if ($this->failure !== null) {
                throw new \RuntimeException($this->failure);
            }

<<<<<<< .merge_file_dKhHii
>>>>>>> .merge_file_2w84DZ
=======
>>>>>>> .merge_file_HLrLUK
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

<<<<<<< .merge_file_dKhHii
<<<<<<< .merge_file_gfGhnE
    $result = (new GetAddressDataFromFullAddressAction)->execute('Piazza della Signoria, Firenze');
=======
    $result = (new GetAddressDataFromFullAddressAction())->execute('Piazza della Signoria, Firenze');
>>>>>>> .merge_file_2w84DZ
=======
    $result = (new GetAddressDataFromFullAddressAction())->execute('Piazza della Signoria, Firenze');
>>>>>>> .merge_file_HLrLUK

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

<<<<<<< .merge_file_dKhHii
<<<<<<< .merge_file_gfGhnE
    $action = new GetAddressDataFromFullAddressAction;
=======
    $action = new GetAddressDataFromFullAddressAction();
>>>>>>> .merge_file_2w84DZ
=======
    $action = new GetAddressDataFromFullAddressAction();
>>>>>>> .merge_file_HLrLUK
    $result = $action->execute('Via Roma 1, Milano');

    Assert::assertSame('Milano', $result?->city);
    Assert::assertSame(['photon down'], $action->getErrors()->all());
})->group('GEO-GEOCODE-INV-2');
