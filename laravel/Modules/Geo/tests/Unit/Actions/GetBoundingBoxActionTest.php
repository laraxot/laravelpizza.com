<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\GetBoundingBoxAction;
use PHPUnit\Framework\Assert;

it('calculates bounding box correctly for milan', function (): void {
    $action = new GetBoundingBoxAction();

    // Milano: 45.4642, 9.1900
    $result = $action->execute(45.4642, 9.1900, 1.0);

    Assert::assertLessThan(45.4642, $result['min_lat']);

    Assert::assertGreaterThan(45.4642, $result['max_lat']);

    Assert::assertLessThan(9.1900, $result['min_lon']);

    Assert::assertGreaterThan(9.1900, $result['max_lon']);
});

it('calculates bounding box for rome', function (): void {
    $action = new GetBoundingBoxAction();

    // Roma: 41.9028, 12.4964
    $result = $action->execute(41.9028, 12.4964, 5.0);

    Assert::assertLessThan(41.9028, $result['min_lat']);

    Assert::assertGreaterThan(41.9028, $result['max_lat']);

    Assert::assertLessThan(12.4964, $result['min_lon']);

    Assert::assertGreaterThan(12.4964, $result['max_lon']);
});

it('calculates bounding box with zero distance', function (): void {
    $action = new GetBoundingBoxAction();

    $result = $action->execute(45.4642, 9.1900, 0);

    // With zero distance, min and max should be the same as the center
    Assert::assertSame(45.4642, $result['min_lat']);
    Assert::assertSame(45.4642, $result['max_lat']);
    Assert::assertSame(9.1900, $result['min_lon']);
    Assert::assertSame(9.1900, $result['max_lon']);
});

it('calculates bounding box with larger distance expands more', function (): void {
    $action = new GetBoundingBoxAction();

    $smallResult = $action->execute(45.4642, 9.1900, 1.0);
    $largeResult = $action->execute(45.4642, 9.1900, 10.0);

    // Larger distance should produce wider bounds
    Assert::assertGreaterThan($smallResult['max_lat'] - $smallResult['min_lat'], $largeResult['max_lat'] - $largeResult['min_lat']);
});

it('handles boundary coordinates at equator', function (): void {
    $action = new GetBoundingBoxAction();

    $result = $action->execute(0, 0, 1.0);

    Assert::assertLessThan(0.0, $result['min_lat']);
    Assert::assertGreaterThan(0.0, $result['max_lat']);
    Assert::assertLessThan(0.0, $result['min_lon']);
    Assert::assertGreaterThan(0.0, $result['max_lon']);

    // All'equatore cos(0) = 1: l'ampiezza in longitudine coincide con quella in latitudine
    Assert::assertEqualsWithDelta($result['max_lat'], $result['max_lon'], 1e-9);
});

it('handles boundary coordinates at poles', function (): void {
    $action = new GetBoundingBoxAction();

    $result = $action->execute(89.0, 0, 1.0);

    Assert::assertLessThan(89.0, $result['min_lat']);
    Assert::assertGreaterThan(89.0, $result['max_lat']);

    // Vicino ai poli i meridiani convergono: a parita' di distanza l'ampiezza in longitudine supera quella in latitudine
    Assert::assertGreaterThan(
        $result['max_lat'] - $result['min_lat'],
        $result['max_lon'] - $result['min_lon'],
    );
});

it('handles boundary coordinates at international date line', function (): void {
    $action = new GetBoundingBoxAction();

    $result = $action->execute(0, 179.0, 1.0);

    Assert::assertGreaterThan(170.0, $result['min_lon']);
});

it('handles negative coordinates', function (): void {
    $action = new GetBoundingBoxAction();

    $result = $action->execute(-33.8688, 151.2093, 5.0); // Sydney

    Assert::assertLessThan(-33.8688, $result['min_lat']);

    Assert::assertGreaterThan(-33.8688, $result['max_lat']);
});
