<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\IPGeolocation;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Datas\Location\IPLocationData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);
/**
 * @return array{0: FetchIPLocationAction, 1: MockHandler}
 */
function createFetchIPLocationActionWithMock(): array
{
    $mockHandler = new MockHandler();
    $client = new Client(['handler' => HandlerStack::create($mockHandler)]);
    $action = new FetchIPLocationAction();

    $reflection = new \ReflectionClass($action);
    $property = $reflection->getProperty('client');
    $property->setAccessible(true);
    $property->setValue($action, $client);

    return [$action, $mockHandler];
}

it('fetches IP location successfully', function (): void {
    [$action, $mockHandler] = createFetchIPLocationActionWithMock();

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'success',
        'country' => 'United States',
        'countryCode' => 'US',
        'regionName' => 'Virginia',
        'city' => 'Ashburn',
        'lat' => 39.03,
        'lon' => -77.5,
        'timezone' => 'America/New_York',
        'isp' => 'Google LLC',
    ])));

    $result = $action->execute('8.8.8.8');

    Assert::assertInstanceOf(IPLocationData::class, $result);
    Assert::assertSame('8.8.8.8', $result->ip);
    Assert::assertSame('Ashburn', $result->city);
    Assert::assertSame('US', $result->country);
});

it('throws runtime exception when API returns failure status', function (): void {
    [$action, $mockHandler] = createFetchIPLocationActionWithMock();

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'fail',
        'message' => 'invalid query',
    ])));

    try {
        $action->execute('invalid-ip');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertStringContainsString('Failed to get IP location', $exception->getMessage());
    }
});

it('throws runtime exception on HTTP error', function (): void {
    [$action, $mockHandler] = createFetchIPLocationActionWithMock();

    $mockHandler->append(new Response(500, [], ''));

    try {
        $action->execute('8.8.8.8');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertStringContainsString('Failed to get IP location', $exception->getMessage());
    }
});
