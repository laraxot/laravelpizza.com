<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use Modules\Geo\Actions\GoogleMaps\GoogleMapsHttpAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('can be resolved from container', function (): void {
    $action = app(GoogleMapsHttpAction::class);

    Assert::assertInstanceOf(GoogleMapsHttpAction::class, $action);
});

it('exposes elevation entrypoint', function (): void {
    $reflection = new \ReflectionClass(GoogleMapsHttpAction::class);
    Assert::assertTrue($reflection->hasMethod('executeElevation'));
    Assert::assertTrue($reflection->hasMethod('executeReverseGeocode'));
    Assert::assertTrue($reflection->hasMethod('executeDistanceMatrix'));
});
