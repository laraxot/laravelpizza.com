<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Tests\Fixtures\Traits\HandlesCoordinatesProbe;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('HandlesCoordinates validates latitude and longitude bounds', function (): void {
    $probe = new HandlesCoordinatesProbe();

    Assert::assertTrue($probe->exposesAreValidCoordinates(45.4642, 9.1900));
    Assert::assertFalse($probe->exposesAreValidCoordinates(95.0, 9.0));
    Assert::assertFalse($probe->exposesAreValidCoordinates(45.0, 200.0));
    Assert::assertFalse($probe->exposesAreValidCoordinates(null, 9.0));
});

test('HandlesCoordinates calculateDistance returns positive km between cities', function (): void {
    $probe = new HandlesCoordinatesProbe();

    $km = $probe->exposesCalculateDistance(45.4642, 9.1900, 41.9028, 12.4964);

    Assert::assertGreaterThan(400.0, $km);
    Assert::assertLessThan(550.0, $km);
});

test('HandlesCoordinates formatCoordinates respects decimal precision', function (): void {
    $probe = new HandlesCoordinatesProbe();

    $formatted = $probe->exposesFormatCoordinates(45.464211, 9.190022, 4);

    Assert::assertSame('45.4642, 9.1900', $formatted);
});
