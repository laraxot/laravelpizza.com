<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;
use Modules\Geo\Actions\GoogleMaps\GoogleMapsHttpAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('CalculateGeoDistanceAction can be resolved', function (): void {
    $action = app(CalculateGeoDistanceAction::class);

    Assert::assertInstanceOf(CalculateGeoDistanceAction::class, $action);
});

test('GoogleMapsHttpAction can be resolved', function (): void {
    $action = app(GoogleMapsHttpAction::class);

    Assert::assertInstanceOf(GoogleMapsHttpAction::class, $action);
});

test('distance between same points is zero', function (): void {
    $distance = app(CalculateGeoDistanceAction::class)->execute(45.0, 9.0, 45.0, 9.0, 'K');

    Assert::assertSame(0.0, $distance);
});
