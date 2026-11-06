<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Elevation;

use Modules\Geo\Actions\Elevation\GetElevationAction;
use Modules\Geo\Actions\GoogleMapsAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\ElevationException;
use Modules\Geo\Tests\Fixtures\GoogleMapsActionElevationStub;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

function makeGetElevationAction(GoogleMapsAction $mapsService): GetElevationAction
{
    app()->instance(GoogleMapsAction::class, $mapsService);

    return new GetElevationAction();
}

it('gets elevation for valid location', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub([
        'results' => [
            ['elevation' => 120.5, 'resolution' => 5.0],
        ],
    ]));

    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    Assert::assertSame(120.5, $action->execute($location));
});

it('throws exception for invalid latitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    try {
        $action->execute(new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
});

it('throws exception for invalid longitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
});

it('throws exception for negative latitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    try {
        $action->execute(new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
});

it('throws exception for negative longitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
});

it('throws exception for empty response', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub(['results' => []]));

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Risposta non valida dal servizio di elevazione', $exception->getMessage());
    }
});

it('throws exception for invalid response structure', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub(['results' => ['invalid']]));

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Risposta non valida dal servizio di elevazione', $exception->getMessage());
    }
});

it('throws exception when service throws generic exception', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub([], new \Exception('Network error')));

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Errore nel recupero dell\'elevazione: Network error', $exception->getMessage());
    }
});

it('formats elevation correctly', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    Assert::assertSame('1234.5 m s.l.m.', $action->formatElevation(1234.5));
});

it('formats elevation with zero value', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    Assert::assertSame('0.0 m s.l.m.', $action->formatElevation(0));
});

it('formats negative elevation correctly', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    Assert::assertSame('-430.0 m s.l.m.', $action->formatElevation(-430.0));
});

it('handles high elevation correctly', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub());

    Assert::assertSame('8848.0 m s.l.m.', $action->formatElevation(8848.0));
});

it('handles boundary latitude values', function (): void {
    $action = makeGetElevationAction(new GoogleMapsActionElevationStub([
        'results' => [
            ['elevation' => 0.0, 'resolution' => 1.0],
        ],
    ]));

    Assert::assertSame(0.0, $action->execute(new LocationData(latitude: 90.0, longitude: 0.0, address: 'North Pole')));
});
