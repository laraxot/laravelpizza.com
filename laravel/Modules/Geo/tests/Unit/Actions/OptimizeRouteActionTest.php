<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Support\Collection;
use Modules\Geo\Actions\OptimizeRouteAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\Fixtures\RouteDistanceStub;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('returns same locations when count is 2 or less', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 46.4642, longitude: 10.1900);

    $action = new OptimizeRouteAction(new RouteDistanceStub);

    Assert::assertCount(1, $action->execute(collect([$location1])));
    Assert::assertCount(2, $action->execute(collect([$location1, $location2])));
});

it('optimizes route for three locations', function (): void {
    $locationA = new LocationData(latitude: 45.0, longitude: 9.0);
    $locationB = new LocationData(latitude: 45.1, longitude: 9.1);
    $locationC = new LocationData(latitude: 47.0, longitude: 11.0);

    $stub = new RouteDistanceStub(999999, [
        '45,9|47,11' => 200000,
        '45,9|45.1,9.1' => 1500,
        '45.1,9.1|47,11' => 250000,
    ]);

    $result = (new OptimizeRouteAction($stub))->execute(collect([$locationA, $locationC, $locationB]));

    Assert::assertCount(3, $result);
    Assert::assertSame($locationA, $result->first());
    Assert::assertSame($locationB, $result->skip(1)->first());
    Assert::assertSame($locationC, $result->skip(2)->first());
});

it('handles empty collection', function (): void {
    /** @var Collection<int, LocationData> $emptyLocations */
    $emptyLocations = collect([]);

    $result = (new OptimizeRouteAction(new RouteDistanceStub))->execute($emptyLocations);

    Assert::assertCount(0, $result);
});

it('handles route optimization with multiple locations', function (): void {
    $locationA = new LocationData(latitude: 0, longitude: 0);
    $locationB = new LocationData(latitude: 1, longitude: 1);
    $locationC = new LocationData(latitude: 2, longitude: 2);
    $locationD = new LocationData(latitude: 3, longitude: 3);

    $stub = new RouteDistanceStub(999999, [
        '0,0|1,1' => 100000,
        '0,0|2,2' => 200000,
        '0,0|3,3' => 300000,
        '1,1|2,2' => 100000,
        '1,1|3,3' => 200000,
        '2,2|3,3' => 100000,
    ]);

    $result = (new OptimizeRouteAction($stub))->execute(collect([$locationA, $locationD, $locationB, $locationC]));

    Assert::assertCount(4, $result);
    Assert::assertSame($locationA, $result->values()->first());
    Assert::assertSame($locationB, $result->values()->skip(1)->first());
    Assert::assertSame($locationC, $result->values()->skip(2)->first());
    Assert::assertSame($locationD, $result->values()->skip(3)->first());
});

it('stops optimization when no more locations remain', function (): void {
    $locationA = new LocationData(latitude: 45.0, longitude: 9.0);
    $locationB = new LocationData(latitude: 45.1, longitude: 9.1);

    $result = (new OptimizeRouteAction(new RouteDistanceStub(1000)))->execute(collect([$locationA, $locationB]));

    Assert::assertCount(2, $result);
    Assert::assertSame($locationA, $result->first());
    Assert::assertSame($locationB, $result->skip(1)->first());
});

it('correctly calculates nearest location', function (): void {
    $locationA = new LocationData(latitude: 45.0, longitude: 9.0);
    $locationB = new LocationData(latitude: 45.1, longitude: 9.1);
    $locationC = new LocationData(latitude: 47.0, longitude: 11.0);

    $stub = new RouteDistanceStub(999999, [
        '45,9|47,11' => 300000,
        '45,9|45.1,9.1' => 15000,
        '45.1,9.1|47,11' => 250000,
    ]);

    $result = (new OptimizeRouteAction($stub))->execute(collect([$locationA, $locationC, $locationB]));

    Assert::assertSame($locationA, $result->first());
    Assert::assertSame($locationB, $result->skip(1)->first());
    Assert::assertSame($locationC, $result->skip(2)->first());
});
