<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Modules\Geo\Actions\OptimizeRouteAction;
use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\TestCase;


it('returns same locations when count is 2 or less', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 46.4642, longitude: 10.1900);

    // Test with single location
    $singleCollection = collect([$location1]);
    $calculateDistance = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new OptimizeRouteAction($calculateDistance);

    $result = $action->execute($singleCollection);
    expect($result)->toHaveCount(1);
    expect($result->first())->toBe($location1);

    // Test with two locations
    $twoCollection = collect([$location1, $location2]);
    $result = $action->execute($twoCollection);
    expect($result)->toHaveCount(2);
    expect($result->first())->toBe($location1);
    expect($result->skip(1)->first())->toBe($location2);
});

it('optimizes route for three locations', function (): void {
    $locationA = new LocationData(latitude: 45.0, longitude: 9.0);
    $locationB = new LocationData(latitude: 45.1, longitude: 9.1); // Closer to A
    $locationC = new LocationData(latitude: 47.0, longitude: 11.0); // Far from A and B

    $locations = collect([$locationA, $locationC, $locationB]); // Initial order: A, C, B

    $calculateDistance = Mockery::mock(CalculateDistanceActionContract::class);

    // Mock distances: A to B is shorter than A to C
    $calculateDistance->shouldReceive('execute')
        ->with($locationA, $locationC)
        ->andReturn(['distance' => ['value' => 200000]]); // 200km

    $calculateDistance->shouldReceive('execute')
        ->with($locationA, $locationB)
        ->andReturn(['distance' => ['value' => 1500]]); // 1.5km

    $calculateDistance->shouldReceive('execute')
        ->with($locationB, $locationC)
        ->andReturn(['distance' => ['value' => 250000]]); // 250km

    $action = new OptimizeRouteAction($calculateDistance);
    $result = $action->execute($locations);

    // Should start with A, then go to B (closer), then C
    expect($result)->toHaveCount(3);
    expect($result->first())->toBe($locationA);
    expect($result->skip(1)->first())->toBe($locationB);
    expect($result->skip(2)->first())->toBe($locationC);
});

it('handles empty collection', function (): void {
    $calculateDistance = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new OptimizeRouteAction($calculateDistance);

    $result = $action->execute(collect([]));
    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->count())->toBe(0);
});

it('handles route optimization with multiple locations', function (): void {
    $locationA = new LocationData(latitude: 0, longitude: 0);
    $locationB = new LocationData(latitude: 1, longitude: 1);
    $locationC = new LocationData(latitude: 2, longitude: 2);
    $locationD = new LocationData(latitude: 3, longitude: 3);

    $locations = collect([$locationA, $locationD, $locationB, $locationC]); // A, D, B, C

    $calculateDistance = Mockery::mock(CalculateDistanceActionContract::class);

    // Mock distances: each location is closer to the next in sequence
    $calculateDistance->shouldReceive('execute')
        ->with($locationA, $locationB)
        ->andReturn(['distance' => ['value' => 100000]]); // 100km
    $calculateDistance->shouldReceive('execute')
        ->with($locationA, $locationC)
        ->andReturn(['distance' => ['value' => 200000]]); // 200km
    $calculateDistance->shouldReceive('execute')
        ->with($locationA, $locationD)
        ->andReturn(['distance' => ['value' => 300000]]); // 300km
    $calculateDistance->shouldReceive('execute')
        ->with($locationB, $locationC)
        ->andReturn(['distance' => ['value' => 100000]]); // 100km
    $calculateDistance->shouldReceive('execute')
        ->with($locationB, $locationD)
        ->andReturn(['distance' => ['value' => 200000]]); // 200km
    $calculateDistance->shouldReceive('execute')
        ->with($locationC, $locationD)
        ->andReturn(['distance' => ['value' => 100000]]); // 100km

    $action = new OptimizeRouteAction($calculateDistance);
    $result = $action->execute($locations);

    // Should follow the sequence A, B, C, D as each is closer to the next
    expect($result)->toHaveCount(4);
    expect($result->values()->first())->toBe($locationA);
    expect($result->values()->skip(1)->first())->toBe($locationB);
    expect($result->values()->skip(2)->first())->toBe($locationC);
    expect($result->values()->skip(3)->first())->toBe($locationD);
});

it('stops optimization when no more locations remain', function (): void {
    $locationA = new LocationData(latitude: 45.0, longitude: 9.0);
    $locationB = new LocationData(latitude: 45.1, longitude: 9.1);

    $locations = collect([$locationA, $locationB]);

    $calculateDistance = Mockery::mock(CalculateDistanceActionContract::class);
    $calculateDistance->shouldReceive('execute')
        ->andReturn(['distance' => ['value' => 1000]]);

    $action = new OptimizeRouteAction($calculateDistance);
    $result = $action->execute($locations);

    expect($result)->toHaveCount(2);
    expect($result->first())->toBe($locationA);
    expect($result->skip(1)->first())->toBe($locationB);
});

it('correctly calculates nearest location', function (): void {
    $locationA = new LocationData(latitude: 45.0, longitude: 9.0);
    $locationB = new LocationData(latitude: 45.1, longitude: 9.1); // Closer
    $locationC = new LocationData(latitude: 47.0, longitude: 11.0); // Farther

    $locations = collect([$locationA, $locationC, $locationB]);

    $calculateDistance = Mockery::mock(CalculateDistanceActionContract::class);

    // A to B is closer than A to C
    $calculateDistance->shouldReceive('execute')
        ->with($locationA, $locationC)
        ->andReturn(['distance' => ['value' => 300000]]);
    $calculateDistance->shouldReceive('execute')
        ->with($locationA, $locationB)
        ->andReturn(['distance' => ['value' => 15000]]);
    // B to C is called after B is selected as nearest
    $calculateDistance->shouldReceive('execute')
        ->with($locationB, $locationC)
        ->andReturn(['distance' => ['value' => 250000]]);

    $action = new OptimizeRouteAction($calculateDistance);
    $result = $action->execute($locations);

    // Should start with A, then go to B (nearest), then C
    expect($result->first())->toBe($locationA);
    expect($result->skip(1)->first())->toBe($locationB);
    expect($result->skip(2)->first())->toBe($locationC);
});
