<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\ClusterLocationsAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\InvalidLocationException;
use Modules\Geo\Tests\Fixtures\ClusterDistanceStub;
use Modules\Geo\Tests\Fixtures\FixedPairDistanceStub;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('clusters locations that are close together', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 45.4643, longitude: 9.1901);
    $location3 = new LocationData(latitude: 46.4642, longitude: 10.1900);

    $clusters = (new ClusterLocationsAction(new ClusterDistanceStub()))->execute(
        [$location1, $location2, $location3],
        1.0,
    );

    Assert::assertCount(2, $clusters);
    Assert::assertCount(2, $clusters[0]['points']);
    Assert::assertCount(1, $clusters[1]['points']);
});

it('creates separate clusters for distant locations', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 47.0000, longitude: 11.0000);

    $clusters = (new ClusterLocationsAction(new FixedPairDistanceStub(200000)))->execute(
        [$location1, $location2],
        1.0,
    );

    Assert::assertCount(2, $clusters);
    Assert::assertCount(1, $clusters[0]['points']);
    Assert::assertCount(1, $clusters[1]['points']);
});

function invokeClusterLocations(ClusterLocationsAction $action, mixed $locations, float $maxDistance = 1.0): mixed
{
    $method = new \ReflectionMethod(ClusterLocationsAction::class, 'execute');

    return $method->invoke($action, $locations, $maxDistance);
}

it('throws exception when location is null', function (): void {
    $action = new ClusterLocationsAction(new FixedPairDistanceStub(1000));

    try {
        invokeClusterLocations($action, [null]);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Dati della posizione non validi', $exception->getMessage());
    }
});

it('throws exception when location is string', function (): void {
    $action = new ClusterLocationsAction(new FixedPairDistanceStub(1000));

    try {
        invokeClusterLocations($action, ['not a location']);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Dati della posizione non validi', $exception->getMessage());
    }
});

it('throws exception when location is integer', function (): void {
    $action = new ClusterLocationsAction(new FixedPairDistanceStub(1000));

    try {
        invokeClusterLocations($action, [123]);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Dati della posizione non validi', $exception->getMessage());
    }
});

it('handles single location correctly', function (): void {
    $location = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $clusters = (new ClusterLocationsAction(new FixedPairDistanceStub(100)))->execute([$location], 1.0);

    Assert::assertCount(1, $clusters);
    Assert::assertCount(1, $clusters[0]['points']);
    Assert::assertSame($location, $clusters[0]['points'][0]);
});

it('handles empty locations array', function (): void {
    Assert::assertCount(0, (new ClusterLocationsAction(new FixedPairDistanceStub(100)))->execute([], 1.0));
});

it('works with different max distance parameter', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 45.4700, longitude: 9.1950);
    $stub = new FixedPairDistanceStub(1500);

    Assert::assertCount(1, (new ClusterLocationsAction($stub))->execute([$location1, $location2], 2.0));
    Assert::assertCount(2, (new ClusterLocationsAction($stub))->execute([$location1, $location2], 1.0));
});

it('updates cluster centers correctly', function (): void {
    $location1 = new LocationData(latitude: 45.0, longitude: 9.0);
    $location2 = new LocationData(latitude: 46.0, longitude: 10.0);

    $clusters = (new ClusterLocationsAction(new FixedPairDistanceStub(100)))->execute(
        [$location1, $location2],
        5.0,
    );

    Assert::assertCount(1, $clusters);
    $center = $clusters[0]['center'];
    Assert::assertInstanceOf(LocationData::class, $center);
    Assert::assertSame(45.5, $center->latitude);
    Assert::assertSame(9.5, $center->longitude);
});
