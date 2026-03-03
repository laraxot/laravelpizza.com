<?php

declare(strict_types=1);

use Modules\Geo\Actions\ClusterLocationsAction;
use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\InvalidLocationException;
use Modules\Geo\Tests\TestCase;


it('clusters locations that are close together', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 45.4643, longitude: 9.1901); // Very close
    $location3 = new LocationData(latitude: 46.4642, longitude: 10.1900); // Far away

    $locations = [$location1, $location2, $location3];

    // Create a mock CalculateDistanceAction
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')
        ->withAnyArgs()
        ->andReturnUsing(function ($from, $to) use ($location1, $location2) {
            $isPairClose =
                (
                    $from->latitude === $location1->latitude
                    && $from->longitude === $location1->longitude
                    && $to->latitude === $location2->latitude
                    && $to->longitude === $location2->longitude
                )
                || (
                    $from->latitude === $location2->latitude
                    && $from->longitude === $location2->longitude
                    && $to->latitude === $location1->latitude
                    && $to->longitude === $location1->longitude
                );

            return ['distance' => ['value' => $isPairClose ? 100 : 150000]];
        });

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 1.0); // 1km max distance

    expect($clusters)->toHaveCount(2); // Should have 2 clusters: [loc1,loc2] and [loc3]
    expect($clusters[0]['points'])->toHaveCount(2); // First cluster should have 2 points
    expect($clusters[1]['points'])->toHaveCount(1); // Second cluster should have 1 point
});

it('creates separate clusters for distant locations', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 47.0000, longitude: 11.0000); // Very far away
    $locations = [$location1, $location2];

    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')
        ->with($location1, $location2)
        ->andReturn(['distance' => ['value' => 200000]]); // 200km

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 1.0);

    expect($clusters)->toHaveCount(2); // Should have 2 separate clusters
    expect($clusters[0]['points'])->toHaveCount(1);
    expect($clusters[1]['points'])->toHaveCount(1);
});

it('throws exception when location is not LocationData', function (): void {
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $invalidLocations = [null, 'not a location', 123];

    foreach ($invalidLocations as $invalidLocation) {
        expect(fn () => $action->execute([$invalidLocation]))
            ->toThrow(InvalidLocationException::class);
    }
});

it('handles single location correctly', function (): void {
    $location = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $locations = [$location];

    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 1.0);

    expect($clusters)->toHaveCount(1);
    expect($clusters[0]['points'])->toHaveCount(1);
    expect($clusters[0]['points'][0])->toBe($location);
});

it('handles empty locations array', function (): void {
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute([], 1.0);

    expect($clusters)->toBeArray()->toHaveCount(0);
});

it('works with different max distance parameter', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 45.4700, longitude: 9.1950); // About 1km apart
    $locations = [$location1, $location2];

    // Create calculator mock for this test
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')
        ->andReturn(['distance' => ['value' => 1500]]); // 1.5km

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    // With 2km max distance, they should be in same cluster
    $clusters = $action->execute($locations, 2.0);
    expect($clusters)->toHaveCount(1);
    expect($clusters[0]['points'])->toHaveCount(2);

    // With 1km max distance, they should be in separate clusters
    $mockDistanceCalculator2 = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator2->shouldReceive('execute')
        ->andReturn(['distance' => ['value' => 1500]]); // 1.5km

    $action2 = new ClusterLocationsAction($mockDistanceCalculator2);

    $clusters = $action2->execute($locations, 1.0);
    expect($clusters)->toHaveCount(2);
});

it('updates cluster centers correctly', function (): void {
    $location1 = new LocationData(latitude: 45.0, longitude: 9.0);
    $location2 = new LocationData(latitude: 46.0, longitude: 10.0);
    $locations = [$location1, $location2];

    // Create calculator mock for this test
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')
        ->andReturn(['distance' => ['value' => 100]]); // 100m

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 5.0); // 5km max distance

    expect($clusters)->toHaveCount(1);

    // The center should be the average of the two locations
    $center = $clusters[0]['center'];
    expect($center->latitude)->toBe(45.5); // average of 45 and 46
    expect($center->longitude)->toBe(9.5); // average of 9 and 10
});
