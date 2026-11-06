<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\DistanceCalculationException;
use Modules\Geo\Tests\Fixtures\CalculateDistanceMatrixActionStub;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param CalculateDistanceMatrixAction $matrixAction
 */
function makeCalculateDistanceAction(CalculateDistanceMatrixAction $matrixAction): CalculateDistanceAction
{
    app()->instance(CalculateDistanceMatrixAction::class, $matrixAction);

    return new CalculateDistanceAction();
}

it('calculates distance between two valid locations', function (): void {
    $expectedResponse = [
        [
            [
                'distance' => ['text' => '572 km', 'value' => 572000],
                'duration' => ['text' => '5 ore 30 min', 'value' => 19800],
                'status' => 'OK',
            ],
        ],
    ];

    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub($expectedResponse));

    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $result = $action->execute($origin, $destination);

    Assert::assertSame('572 km', $result['distance']['text']);
    Assert::assertSame(572000, $result['distance']['value']);
    Assert::assertSame('5 ore 30 min', $result['duration']['text']);
    Assert::assertSame(19800, $result['duration']['value']);
    Assert::assertSame('OK', $result['status']);
});

it('throws exception for invalid latitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine non valida: 100.000000', $exception->getMessage());
    }
});

it('throws exception for invalid longitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine non valida: 200.000000', $exception->getMessage());
    }
});

it('throws exception for negative latitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine non valida: -100.000000', $exception->getMessage());
    }
});

it('throws exception for negative longitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine non valida: -200.000000', $exception->getMessage());
    }
});

it('throws exception for empty response', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([]));

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze', $exception->getMessage());
    }
});

it('throws exception for malformed response', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([[]]));

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze', $exception->getMessage());
    }
});

it('throws exception when distance matrix fails', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([], new \Exception('API Error')));

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: API Error', $exception->getMessage());
    }
});

it('formats distance in meters correctly', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('500 m', $action->formatDistance(500));
});

it('formats distance in kilometers correctly', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1.5 km', $action->formatDistance(1500));
});

it('formats distance with decimal kilometers', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('2.5 km', $action->formatDistance(2500));
});

it('formats exact kilometer distance', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1.0 km', $action->formatDistance(1000));
});

it('throws exception for negative distance', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->formatDistance(-100);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('La distanza non può essere negativa', $exception->getMessage());
    }
});

it('handles zero distance', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('0 m', $action->formatDistance(0));
});

it('handles very small distances', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1 m', $action->formatDistance(1));
});

it('handles very large distances', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1000.0 km', $action->formatDistance(999999));
});

it('handles boundary latitude values', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
    ]));

    $result = $action->execute(
        new LocationData(latitude: 90.0, longitude: 9.1900, address: 'Boundary Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    );

    Assert::assertSame('OK', $result['status']);
});

it('handles boundary longitude values', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
    ]));

    $result = $action->execute(
        new LocationData(latitude: 45.4642, longitude: 180.0, address: 'Boundary Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    );

    Assert::assertSame('OK', $result['status']);
});

it('handles same origin and destination', function (): void {
    $sameLocation = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([
        [
            [
                'distance' => ['text' => '0 m', 'value' => 0],
                'duration' => ['text' => '0 min', 'value' => 0],
                'status' => 'OK',
            ],
        ],
    ]));

    $result = $action->execute($sameLocation, $sameLocation);

    Assert::assertSame(0, $result['distance']['value']);
    Assert::assertSame(0, $result['duration']['value']);
});
