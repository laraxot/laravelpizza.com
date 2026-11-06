<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetAddressByLatLngFromGoogleMapsAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => null]);

    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Google Maps API key not configured', $exception->getMessage());
    }
});

it('throws exception for invalid latitude below -90', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    try {
        $action->execute(-91.0, 9.1900);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\Throwable $exception) {
        Assert::assertInstanceOf(\InvalidArgumentException::class, $exception);
        Assert::assertSame('Invalid latitude', $exception->getMessage());
    }
});

it('throws exception for invalid latitude above 90', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    try {
        $action->execute(91.0, 9.1900);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\Throwable $exception) {
        Assert::assertInstanceOf(\InvalidArgumentException::class, $exception);
        Assert::assertSame('Invalid latitude', $exception->getMessage());
    }
});

it('throws exception for invalid longitude below -180', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    try {
        $action->execute(45.0, -181.0);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\Throwable $exception) {
        Assert::assertInstanceOf(\InvalidArgumentException::class, $exception);
        Assert::assertSame('Invalid longitude', $exception->getMessage());
    }
});

it('throws exception for invalid longitude above 180', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    try {
        $action->execute(45.0, 181.0);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\Throwable $exception) {
        Assert::assertInstanceOf(\InvalidArgumentException::class, $exception);
        Assert::assertSame('Invalid longitude', $exception->getMessage());
    }
});

it('throws exception for guzzle exception', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Failed to get address from coordinates', $exception->getMessage());
    }
});

it('throws exception when no results found', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [],
    ])));

    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('No address found', $exception->getMessage());
    }
});

it('throws exception for invalid response status', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ])));

    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('No address found', $exception->getMessage());
    }
});

it('returns location data for valid coordinates', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'formatted_address' => 'Via Roma, Milano, MI, Italia',
            'geometry' => [
                'location' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
            ],
        ]],
    ])));

    $result = $action->execute(45.4642, 9.1900);

    Assert::assertSame('Via Roma, Milano, MI, Italia', $result->address);
    Assert::assertSame(45.4642, $result->latitude);
    Assert::assertSame(9.1900, $result->longitude);
});

it('handles boundary latitude values', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'formatted_address' => 'North Pole',
            'geometry' => [
                'location' => [
                    'lat' => 90.0,
                    'lng' => 0.0,
                ],
            ],
        ]],
    ])));

    $result = $action->execute(90.0, 0.0);

    Assert::assertSame(90.0, $result->latitude);
});

it('handles boundary longitude values', function (): void {
    $mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressByLatLngFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'formatted_address' => 'International Date Line',
            'geometry' => [
                'location' => [
                    'lat' => 0.0,
                    'lng' => 180.0,
                ],
            ],
        ]],
    ])));

    $result = $action->execute(0.0, 180.0);

    Assert::assertSame(180.0, $result->longitude);
});
