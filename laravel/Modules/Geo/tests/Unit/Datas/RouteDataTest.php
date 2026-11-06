<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Illuminate\Support\Collection;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\Routing\RouteData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('RouteData formats distance and duration for long routes', function (): void {
    /** @var Collection<int, LocationData> $waypoints */
    $waypoints = collect([
        new LocationData(45.4642, 9.1900, name: 'Milano'),
        new LocationData(41.9028, 12.4964, name: 'Roma'),
    ]);

    $dto = new RouteData(
        waypoints: $waypoints,
        originalWaypoints: $waypoints,
        totalDistance: 570000,
        totalDuration: 19800,
        steps: [],
    );

    Assert::assertSame('570.0 km', $dto->getFormattedDistance());
    Assert::assertSame('5 ore 30 min', $dto->getFormattedDuration());
});

test('RouteData getSummary counts steps and waypoints', function (): void {
    /** @var Collection<int, LocationData> $waypoints */
    $waypoints = collect([new LocationData(45.0, 9.0)]);

    $dto = new RouteData(
        waypoints: $waypoints,
        originalWaypoints: $waypoints,
        totalDistance: 500,
        totalDuration: 120,
        steps: [
            [
                'distance' => ['value' => 500, 'text' => '500 m'],
                'duration' => ['value' => 120, 'text' => '2 min'],
                'instructions' => 'Prosegui dritto',
            ],
        ],
    );

    $summary = $dto->getSummary();

    Assert::assertSame(1, $summary['steps']);
    Assert::assertSame(1, $summary['waypoints']);
    Assert::assertSame('500 m', $summary['distance']);
});
