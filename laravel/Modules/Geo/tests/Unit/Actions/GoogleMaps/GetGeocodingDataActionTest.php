<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetGeocodingDataAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => null]);

    try {
        $action->execute('Milano, Italia');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Chiave API Google Maps non configurata', $exception->getMessage());
    }
});

it('throws exception for empty address', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    try {
        $action->execute('');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Indirizzo non può essere vuoto', $exception->getMessage());
    }
});

it('throws exception for too long address', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

    try {
        $action->execute($longAddress);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Indirizzo troppo lungo', $exception->getMessage());
    }
});

it('returns error geocoding data for guzzle exception', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $action->execute('Milano, Italia');

    Assert::assertNotNull($result->error);
    Assert::assertSame('REQUEST_FAILED', $result->error);
});

it('returns error geocoding data for invalid status', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ])));

    $result = $action->execute('NonExistentPlace');

    Assert::assertNotNull($result->error);
    Assert::assertSame('ZERO_RESULTS', $result->error);
});

it('returns geocoding data for valid address', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'geometry' => [
                'location' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
            ],
            'formatted_address' => 'Via Roma, Milano, MI, Italia',
            'address_components' => [
                ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['locality']],
            ],
        ]],
    ])));

    $result = $action->execute('Via Roma, Milano, Italia');

    Assert::assertNull($result->error);
    Assert::assertSame(45.4642, $result->latitude);
    Assert::assertSame(9.1900, $result->longitude);
});
