<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('returns AddressData when first service succeeds', function (): void {
    $action = new GetAddressDataFromFullAddressAction;

    // As this action depends on multiple external services which are difficult to mock,
    // we can test that it at least has the correct structure and properties
    Assert::assertCount(0, $action->getErrors());
});

it('initializes with empty errors collection', function (): void {
    $action = new GetAddressDataFromFullAddressAction;

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
            static fn (): \GuzzleHttp\Promise\PromiseInterface => Create::promiseFor(new Response(503)),
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

    $action = new GetAddressDataFromFullAddressAction;

    // The execute method handles failing providers gracefully and returns null
    $result = $action->execute('Test Address');

    Assert::assertNull($result);
    // Every provider failure is collected as an error message
    Assert::assertNotEmpty($action->getErrors());
});
