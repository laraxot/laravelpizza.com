<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Mapbox;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => null]);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Mapbox access token not configured', $exception->getMessage());
    }
});

it('throws exception for empty address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    try {
        $action->execute('');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Address cannot be empty', $exception->getMessage());
    }
});

it('throws exception for too long address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

    try {
        $action->execute($longAddress);

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Address is too long', $exception->getMessage());
    }
});

it('throws exception for guzzle exception', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $action->execute('Milano, Italia');

    Assert::assertNull($result);
});

it('returns null when no features in response', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'features' => [],
    ])));

    $result = $action->execute('NonExistentPlace');

    Assert::assertNull($result);
});

it('returns address data for valid response', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'features' => [[
            'center' => [9.1900, 45.4642],
            'context' => [
                ['id' => 'place.1', 'text' => 'Milano'],
                ['id' => 'region.1', 'short_code' => 'IT-MI'],
                ['id' => 'postcode.1', 'text' => '20100'],
            ],
            'place_name' => 'Via Roma 1, Milano, Lombardia 20100, Italia',
            'address' => '1',
            'text' => 'Via Roma',
        ]],
    ])));

    $result = $action->execute('Via Roma 1, Milano, Italia');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('1', $result->street_number);

    Assert::assertSame('MI', $result->state);
});

it('handles address without house number', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'features' => [[
            'center' => [9.1900, 45.4642],
            'context' => [
                ['id' => 'place.1', 'text' => 'Milano'],
            ],
            'place_name' => 'Via Roma, Milano, Italia',
            'text' => 'Via Roma',
        ]],
    ])));

    $result = $action->execute('Via Roma, Milano');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('', $result->street_number);
});
