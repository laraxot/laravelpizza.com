<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\GetBoundingBoxAction;

beforeEach(function () {
    $action = new GetBoundingBoxAction();
});

it('calculates bounding box correctly for milan', function (): void {
    // Milano: 45.4642, 9.1900
    $result = $action->execute(45.4642, 9.1900, 1.0);

    expect($result)
        ->toBeArray()
        ->toHaveKeys(['min_lat', 'max_lat', 'min_lon', 'max_lon'])
        ->and($result['min_lat'])->toBeLessThan(45.4642)
        ->and($result['max_lat'])->toBeGreaterThan(45.4642)
        ->and($result['min_lon'])->toBeLessThan(9.1900)
        ->and($result['max_lon'])->toBeGreaterThan(9.1900);
});

it('calculates bounding box for rome', function (): void {
    // Roma: 41.9028, 12.4964
    $result = $action->execute(41.9028, 12.4964, 5.0);

    expect($result)
        ->toBeArray()
        ->and($result['min_lat'])->toBeLessThan(41.9028)
        ->and($result['max_lat'])->toBeGreaterThan(41.9028)
        ->and($result['min_lon'])->toBeLessThan(12.4964)
        ->and($result['max_lon'])->toBeGreaterThan(12.4964);
});

it('calculates bounding box with zero distance', function (): void {
    $result = $action->execute(45.4642, 9.1900, 0);

    // With zero distance, min and max should be the same as the center
    expect($result['min_lat'])->toBe(45.4642);
    expect($result['max_lat'])->toBe(45.4642);
    expect($result['min_lon'])->toBe(9.1900);
    expect($result['max_lon'])->toBe(9.1900);
});

it('calculates bounding box with larger distance expands more', function (): void {
    $smallResult = $action->execute(45.4642, 9.1900, 1.0);
    $largeResult = $action->execute(45.4642, 9.1900, 10.0);

    // Larger distance should produce wider bounds
    expect($largeResult['max_lat'] - $largeResult['min_lat'])
        ->toBeGreaterThan($smallResult['max_lat'] - $smallResult['min_lat']);
});

it('handles boundary coordinates at equator', function (): void {
    $result = $action->execute(0, 0, 1.0);

    expect($result)
        ->toHaveKeys(['min_lat', 'max_lat', 'min_lon', 'max_lon'])
        ->and($result['min_lat'])->toBeLessThanOrEqual(0)
        ->and($result['max_lat'])->toBeGreaterThanOrEqual(0)
        ->and($result['min_lon'])->toBeLessThanOrEqual(0)
        ->and($result['max_lon'])->toBeGreaterThanOrEqual(0);
});

it('handles boundary coordinates at poles', function (): void {
    $result = $action->execute(89.0, 0, 1.0);

    expect($result)
        ->toHaveKeys(['min_lat', 'max_lat', 'min_lon', 'max_lon'])
        ->and($result['max_lat'])->toBeLessThanOrEqual(90.0);
});

it('handles boundary coordinates at international date line', function (): void {
    $result = $action->execute(0, 179.0, 1.0);

    expect($result)
        ->toHaveKeys(['min_lat', 'max_lat', 'min_lon', 'max_lon'])
        ->and($result['min_lon'])->toBeGreaterThan(170.0)
        ->and($result['max_lon'])->toBeLessThanOrEqual(180.0);
});

it('handles negative coordinates', function (): void {
    $result = $action->execute(-33.8688, 151.2093, 5.0); // Sydney

    expect($result)
        ->toHaveKeys(['min_lat', 'max_lat', 'min_lon', 'max_lon'])
        ->and($result['min_lat'])->toBeLessThan(-33.8688)
        ->and($result['max_lat'])->toBeGreaterThan(-33.8688);
});
