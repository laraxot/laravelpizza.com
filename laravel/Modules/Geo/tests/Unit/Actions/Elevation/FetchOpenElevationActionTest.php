<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Elevation\FetchOpenElevationAction;
use Modules\Geo\Datas\Elevation\ElevationData;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

/**
 * @return array{0: FetchOpenElevationAction, 1: MockHandler}
 */
function createFetchOpenElevationActionWithMock(): array
{
    $mockHandler = new MockHandler();
    $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

    return [new FetchOpenElevationAction($client), $mockHandler];
}

it('fetches elevation successfully', function (): void {
    [$action, $mockHandler] = createFetchOpenElevationActionWithMock();

    $mockHandler->append(new Response(
        200,
        [],
        json_encode([
            'results' => [
                [
                    'latitude' => 45.4642,
                    'longitude' => 9.1900,
                    'elevation' => 120.5,
                ],
            ],
        ])
    ));

    $result = $action->execute(45.4642, 9.1900);

    Assert::assertInstanceOf(ElevationData::class, $result);
    Assert::assertSame(45.4642, $result->latitude);
    Assert::assertSame(9.1900, $result->longitude);
    Assert::assertSame(120.5, $result->elevation);
});

it('throws exception for failed API request', function (): void {
    [$action, $mockHandler] = createFetchOpenElevationActionWithMock();

    $request = new Request('POST', 'https://api.open-elevation.com/api/v1/lookup');
    $mockHandler->append(RequestException::create($request, null, new \Exception('Connection failed')));

    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Failed to get elevation data', $exception->getMessage());
    }
});

it('throws exception for invalid response', function (): void {
    [$action, $mockHandler] = createFetchOpenElevationActionWithMock();

    $mockHandler->append(new Response(200, [], json_encode(['results' => []])));

    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Invalid elevation data response', $exception->getMessage());
    }
});

it('handles negative elevation', function (): void {
    [$action, $mockHandler] = createFetchOpenElevationActionWithMock();

    $mockHandler->append(new Response(200, [], json_encode([
        'results' => [
            ['latitude' => 31.5, 'longitude' => 35.5, 'elevation' => -430.0],
        ],
    ])));

    Assert::assertSame(-430.0, $action->execute(31.5, 35.5)->elevation);
});

it('handles high elevation', function (): void {
    [$action, $mockHandler] = createFetchOpenElevationActionWithMock();

    $mockHandler->append(new Response(200, [], json_encode([
        'results' => [
            ['latitude' => 27.9881, 'longitude' => 86.9250, 'elevation' => 8848.0],
        ],
    ])));

    Assert::assertSame(8848.0, $action->execute(27.9881, 86.9250)->elevation);
});

it('handles zero elevation', function (): void {
    [$action, $mockHandler] = createFetchOpenElevationActionWithMock();

    $mockHandler->append(new Response(200, [], json_encode([
        'results' => [
            ['latitude' => 0.0, 'longitude' => 0.0, 'elevation' => 0.0],
        ],
    ])));

    Assert::assertSame(0.0, $action->execute(0.0, 0.0)->elevation);
});

it('sends correct API payload', function (): void {
    [$action, $mockHandler] = createFetchOpenElevationActionWithMock();

    $mockHandler->append(new Response(200, [], json_encode([
        'results' => [
            ['latitude' => 45.4642, 'longitude' => 9.1900, 'elevation' => 100.0],
        ],
    ])));

    $action->execute(45.4642, 9.1900);

    Assert::assertCount(1, $mockHandler);
});
