<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Nominatim\LookupPlaceAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);

/**
 * L'action costruisce da se' il client Guzzle: lo si sostituisce con uno che risponde dalla coda, senza rete.
 *
 * @return array{0: LookupPlaceAction, 1: MockHandler}
 */
function lookupPlaceActionWithQueue(Response|\Throwable ...$queue): array
{
    $mockHandler = new MockHandler(array_values($queue));
    $action = new LookupPlaceAction();

    (new \ReflectionProperty($action, 'client'))->setValue($action, new Client(['handler' => HandlerStack::create($mockHandler)]));

    return [$action, $mockHandler];
}

function nominatimLookupBody(): string
{
    return json_encode([
        [
            'lat' => '41.9028',
            'lon' => '12.4964',
            'display_name' => 'Roma, Lazio, Italia',
        ],
    ]);
}

test('LookupPlaceAction returns the Nominatim location of the requested OSM id', function (): void {
    [$action] = lookupPlaceActionWithQueue(new Response(200, [], nominatimLookupBody()));

    $location = $action->execute('R123456');

    Assert::assertInstanceOf(LocationData::class, $location);
    Assert::assertSame(41.9028, $location->latitude);
    Assert::assertSame(12.4964, $location->longitude);
    Assert::assertSame('Roma, Lazio, Italia', $location->address);
});

test('LookupPlaceAction calls the Nominatim lookup endpoint with osm_ids, json format and user agent', function (): void {
    [$action, $mockHandler] = lookupPlaceActionWithQueue(new Response(200, [], nominatimLookupBody()));

    $action->execute('R123456');

    $request = $mockHandler->getLastRequest();
    if (null === $request) {
        Assert::fail('Nominatim e stato chiamato zero volte');
    }
    parse_str($request->getUri()->getQuery(), $query);

    Assert::assertSame('nominatim.openstreetmap.org', $request->getUri()->getHost());
    Assert::assertSame('/lookup', $request->getUri()->getPath());
    Assert::assertSame(['osm_ids' => 'R123456', 'format' => 'json'], $query);
    Assert::assertSame('Xot/1.0', $request->getHeaderLine('User-Agent'));
});

test('LookupPlaceAction throws when Nominatim finds nothing for the OSM id', function (): void {
    [$action] = lookupPlaceActionWithQueue(new Response(200, [], json_encode([])));

    expect(fn (): LocationData => $action->execute('R999999'))
        ->toThrow(\RuntimeException::class, 'No results found for OSM ID: R999999');
});

test('LookupPlaceAction lets Nominatim HTTP errors reach the caller', function (): void {
    [$action] = lookupPlaceActionWithQueue(new Response(503));

    expect(fn (): LocationData => $action->execute('R123456'))->toThrow(ServerException::class);
});

test('LookupPlaceAction lets a network failure reach the caller', function (): void {
    [$action] = lookupPlaceActionWithQueue(new ConnectException('Connection refused', new Request('GET', '/lookup')));

    expect(fn (): LocationData => $action->execute('R123456'))->toThrow(ConnectException::class);
});
