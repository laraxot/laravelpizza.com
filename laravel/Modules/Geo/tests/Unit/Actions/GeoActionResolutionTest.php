<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;
use Modules\Geo\Actions\GoogleMapsAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('CalculateGeoDistanceAction can be resolved', function (): void {
    $action = app(CalculateGeoDistanceAction::class);

    Assert::assertSame(CalculateGeoDistanceAction::class, $action::class);
});

test('GoogleMapsAction can be instantiated', function (): void {
    $service = new GoogleMapsAction;

    Assert::assertSame(GoogleMapsAction::class, $service::class);
});
