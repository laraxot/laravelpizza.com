<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Nominatim\ReverseGeocodeAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);

/**
 * L'action costruisce da se' il client Guzzle: lo si sostituisce con uno che risponde dalla coda, senza rete.
 *
 * @return array{0: ReverseGeocodeAction, 1: MockHandler}
 */
function reverseGeocodeActionWithQueue(Response|\Throwable ...$queue): array
{
    $mockHandler = new MockHandler(array_values($queue));
    $action = new ReverseGeocodeAction();

    (new \ReflectionProperty($action, 'client'))->setValue($action, new Client(['handler' => HandlerStack::create($mockHandler)]));

    return [$action, $mockHandler];
}

function nominatimReverseBody(): string
{
    return json_encode([
        'lat' => '45.46420',
        'lon' => '9.19000',
        'display_name' => 'Piazza del Duomo, 20121 Milano, Italia',
    ]);
}

test('ReverseGeocodeAction returns the Nominatim address for the requested coordinates', function (): void {
    [$action] = reverseGeocodeActionWithQueue(new Response(200, [], nominatimReverseBody()));

    $location = $action->execute(45.4642, 9.19);

    Assert::assertInstanceOf(LocationData::class, $location);
    Assert::assertSame(45.4642, $location->latitude);
    Assert::assertSame(9.19, $location->longitude);
    Assert::assertSame('Piazza del Duomo, 20121 Milano, Italia', $location->address);
    Assert::assertNull($location->name);
});

test('ReverseGeocodeAction calls the Nominatim reverse endpoint with coordinates, json format and user agent', function (): void {
    [$action, $mockHandler] = reverseGeocodeActionWithQueue(new Response(200, [], nominatimReverseBody()));

    $action->execute(45.4642, 9.19);

    $request = $mockHandler->getLastRequest();
    if (null === $request) {
        Assert::fail('Nominatim e stato chiamato zero volte');
    }
    parse_str($request->getUri()->getQuery(), $query);

    Assert::assertSame('nominatim.openstreetmap.org', $request->getUri()->getHost());
    Assert::assertSame('/reverse', $request->getUri()->getPath());
    Assert::assertSame(['lat' => '45.4642', 'lon' => '9.19', 'format' => 'json'], $query);
    Assert::assertSame('Xot/1.0', $request->getHeaderLine('User-Agent'));
});

test('ReverseGeocodeAction lets Nominatim HTTP errors reach the caller', function (): void {
    [$notFound] = reverseGeocodeActionWithQueue(new Response(400, [], json_encode(['error' => 'Unable to geocode'])));
    [$unavailable] = reverseGeocodeActionWithQueue(new Response(503));

    expect(fn (): LocationData => $notFound->execute(999.0, 999.0))->toThrow(ClientException::class)
        ->and(fn (): LocationData => $unavailable->execute(45.4642, 9.19))->toThrow(ServerException::class);
});

test('ReverseGeocodeAction lets a network failure reach the caller', function (): void {
    [$action] = reverseGeocodeActionWithQueue(new ConnectException('Connection refused', new Request('GET', '/reverse')));

    expect(fn (): LocationData => $action->execute(45.4642, 9.19))->toThrow(ConnectException::class);
});

it('SENZA SORGENTE: requests the Nominatim zoom level when the caller asks for it (execute() has no zoom parameter)')->todo();

it('SENZA SORGENTE: answers an empty Nominatim body without a PHP warning (display_name is not guarded)')->todo();
