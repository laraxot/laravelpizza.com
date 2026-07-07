<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetCoordinatesFromGoogleMapsAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);

it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => null]);

    try {
        $action->execute('Milano, Italia');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Google Maps API key not configured', $exception->getMessage());
    }
});

it('throws exception for empty address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    try {
        $action->execute('');
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Address cannot be empty', $exception->getMessage());
    }
});

it('throws exception for too long address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

    try {
        $action->execute($longAddress);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Address is too long', $exception->getMessage());
    }
});

it('throws exception for guzzle exception', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    try {
        $action->execute('Milano, Italia');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Failed to get coordinates', $exception->getMessage());
    }
});

it('throws exception when no coordinates found', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [],
    ])));

    try {
        $action->execute('NonExistentPlace');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('No coordinates found', $exception->getMessage());
    }
});

it('throws exception when status is not ok', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
    ])));

    try {
        $action->execute('NonExistentPlace');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('No coordinates found', $exception->getMessage());
    }
});

it('returns location data for valid address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

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
        ]],
    ])));

    $result = $action->execute('Milano, Italia');

    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame('Milano, Italia', $result->address);
    Assert::assertSame(45.4642, $result->latitude);
    Assert::assertSame(9.1900, $result->longitude);
});

it('handles address with special characters', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'results' => [[
            'geometry' => [
                'location' => [
                    'lat' => 41.9028,
                    'lng' => 12.4964,
                ],
            ],
        ]],
    ])));

    $result = $action->execute('Piazza del Popolo, Roma, Italia');

    Assert::assertInstanceOf(LocationData::class, $result);
    Assert::assertSame(41.9028, $result->latitude);
    Assert::assertSame(12.4964, $result->longitude);
});
