<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Tests\Fixtures\CalculateDistanceMatrixQueueStub;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeFilterCoordinatesInRadiusAction(CalculateDistanceMatrixQueueStub $matrixStub): FilterCoordinatesInRadiusAction
{
    app()->instance(CalculateDistanceMatrixAction::class, $matrixStub);
    app()->instance(CalculateDistanceAction::class, new CalculateDistanceAction);

    /** @var CalculateDistanceActionContract $distanceCalculator */
    $distanceCalculator = app(CalculateDistanceAction::class);

    return new FilterCoordinatesInRadiusAction($distanceCalculator);
}

it('filters coordinates within radius', function (): void {
    $stub = new CalculateDistanceMatrixQueueStub([
        [[['distance' => ['value' => 1000], 'duration' => ['value' => 100], 'status' => 'OK']]],
        [[['distance' => ['value' => 7000], 'duration' => ['value' => 500], 'status' => 'OK']]],
        [[['distance' => ['value' => 200], 'duration' => ['value' => 30], 'status' => 'OK']]],
    ]);
    $action = makeFilterCoordinatesInRadiusAction($stub);

    $result = $action->execute(45.4642, 9.1900, [
        ['latitude' => '45.4700', 'longitude' => '9.2000'],
        ['latitude' => '45.5000', 'longitude' => '9.2500'],
        ['latitude' => '45.4650', 'longitude' => '9.1910'],
    ], 5000);

    Assert::assertCount(2, $result);
});

it('resolves the distance contract from the application container', function (): void {
    Assert::assertInstanceOf(
        CalculateDistanceAction::class,
        app(CalculateDistanceActionContract::class),
    );
});

it('returns empty array when no coordinates within radius', function (): void {
    $stub = new CalculateDistanceMatrixQueueStub([
        [[['distance' => ['value' => 10000], 'duration' => ['value' => 600], 'status' => 'OK']]],
        [[['distance' => ['value' => 12000], 'duration' => ['value' => 800], 'status' => 'OK']]],
    ]);
    $action = makeFilterCoordinatesInRadiusAction($stub);

    $result = $action->execute(45.4642, 9.1900, [
        ['latitude' => '45.5000', 'longitude' => '9.2500'],
        ['latitude' => '45.5100', 'longitude' => '9.2600'],
    ], 1000);

    Assert::assertCount(0, $result);
});

it('returns all coordinates when all within radius', function (): void {
    $stub = new CalculateDistanceMatrixQueueStub([
        [[['distance' => ['value' => 1000], 'duration' => ['value' => 100], 'status' => 'OK']]],
        [[['distance' => ['value' => 8000], 'duration' => ['value' => 400], 'status' => 'OK']]],
        [[['distance' => ['value' => 3000], 'duration' => ['value' => 200], 'status' => 'OK']]],
    ]);
    $action = makeFilterCoordinatesInRadiusAction($stub);

    $result = $action->execute(45.4642, 9.1900, [
        ['latitude' => '45.4700', 'longitude' => '9.2000'],
        ['latitude' => '45.5000', 'longitude' => '9.2500'],
        ['latitude' => '45.4800', 'longitude' => '9.2100'],
    ], 50000);

    Assert::assertCount(3, $result);
});

it('handles empty coordinates array', function (): void {
    $action = makeFilterCoordinatesInRadiusAction(new CalculateDistanceMatrixQueueStub);

    $result = $action->execute(45.4642, 9.1900, [], 5000);

    Assert::assertCount(0, $result);
});

it('filters exactly at boundary', function (): void {
    $stub = new CalculateDistanceMatrixQueueStub([
        [[['distance' => ['value' => 5000], 'duration' => ['value' => 300], 'status' => 'OK']]],
    ]);
    $action = makeFilterCoordinatesInRadiusAction($stub);

    $result = $action->execute(45.4642, 9.1900, [
        ['latitude' => '45.4700', 'longitude' => '9.2000'],
    ], 5000);

    Assert::assertCount(1, $result);
});
