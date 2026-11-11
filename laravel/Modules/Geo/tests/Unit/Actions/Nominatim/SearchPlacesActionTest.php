<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Modules\Geo\Actions\Nominatim\SearchPlacesAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);

/**
 * L'action costruisce da se' il client Guzzle: lo si sostituisce con uno che risponde dalla coda, senza rete.
 *
 * @return array{0: SearchPlacesAction, 1: MockHandler}
 */
function searchPlacesActionWithQueue(Response ...$queue): array
{
    $mockHandler = new MockHandler(array_values($queue));
    $action = new SearchPlacesAction('FixCity');

    (new \ReflectionProperty($action, 'client'))->setValue($action, new Client(['handler' => HandlerStack::create($mockHandler)]));

    return [$action, $mockHandler];
}

/**
 * @param  list<array<string, mixed>>  $places
 */
function nominatimSearchResponse(array $places): Response
{
    return new Response(200, [], json_encode($places));
}

/**
 * Query string dell'ultima richiesta inviata a Nominatim.
 *
 * @return array<int|string, mixed>
 */
function lastSearchQuery(MockHandler $mockHandler): array
{
    $request = $mockHandler->getLastRequest();
    if ($request === null) {
        Assert::fail('Nominatim e stato chiamato zero volte');
    }
    parse_str($request->getUri()->getQuery(), $query);

    return $query;
}

test('SearchPlacesAction maps every Nominatim place to a LocationData, in order', function (): void {
    [$action] = searchPlacesActionWithQueue(nominatimSearchResponse([
        ['lat' => '45.4642', 'lon' => '9.1900', 'display_name' => 'Milano, Lombardia, Italia', 'type' => 'city'],
        ['lat' => '41.9028', 'lon' => '12.4964', 'display_name' => 'Roma, Lazio, Italia', 'type' => 'city'],
    ]));

    $places = $action->execute('Italia');

    Assert::assertInstanceOf(Collection::class, $places);
    Assert::assertCount(2, $places);
    Assert::assertContainsOnlyInstancesOf(LocationData::class, $places);
    Assert::assertSame([45.4642, 41.9028], $places->pluck('latitude')->all());
    Assert::assertSame([9.19, 12.4964], $places->pluck('longitude')->all());
    Assert::assertSame(['Milano, Lombardia, Italia', 'Roma, Lazio, Italia'], $places->pluck('address')->all());
});

test('SearchPlacesAction asks Nominatim for ten Italian results by default, without a country filter', function (): void {
    [$action, $mockHandler] = searchPlacesActionWithQueue(nominatimSearchResponse([
        ['lat' => '45.4642', 'lon' => '9.1900', 'display_name' => 'Milano'],
    ]));

    $action->execute('Milano');

    Assert::assertSame([
        'q' => 'Milano',
        'format' => 'json',
        'addressdetails' => '1',
        'limit' => '10',
        'accept-language' => 'it',
    ], lastSearchQuery($mockHandler));
});

test('SearchPlacesAction forwards the country and the limit to Nominatim and identifies the application', function (): void {
    [$action, $mockHandler] = searchPlacesActionWithQueue(nominatimSearchResponse([
        ['lat' => '45.4642', 'lon' => '9.1900', 'display_name' => 'Milano'],
    ]));

    $action->execute('Milano', 'it', 3);

    $query = lastSearchQuery($mockHandler);
    Assert::assertSame('it', $query['countrycodes']);
    Assert::assertSame('3', $query['limit']);
    Assert::assertSame('FixCity Application', $mockHandler->getLastRequest()?->getHeaderLine('User-Agent'));
});

test('SearchPlacesAction sends apostrophes and accents in the query intact', function (string $query): void {
    [$action, $mockHandler] = searchPlacesActionWithQueue(nominatimSearchResponse([
        ['lat' => '45.0', 'lon' => '9.0', 'display_name' => 'Risultato'],
    ]));

    $action->execute($query);

    Assert::assertSame($query, lastSearchQuery($mockHandler)['q']);
})->with([
    'apostrofo' => ["Sant'Antonio"],
    'accento' => ["Piazza dell'Unità"],
]);

test('SearchPlacesAction throws when Nominatim finds nothing', function (): void {
    [$action] = searchPlacesActionWithQueue(nominatimSearchResponse([]));

    expect(fn (): Collection => $action->execute('NonExistentPlace12345'))
        ->toThrow(\RuntimeException::class, 'No results found for query');
});

test('SearchPlacesAction wraps a Nominatim HTTP failure in a RuntimeException', function (): void {
    [$action] = searchPlacesActionWithQueue(new Response(503));

    expect(fn (): Collection => $action->execute('Test'))
        ->toThrow(\RuntimeException::class, 'Failed to search places:');
});
