<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\FilterCoordinatesInRadius;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->action = new FilterCoordinatesInRadius();
});

it('calculates zero distance between identical points', function (): void {
    $distance = $this->action->calcolaDistanzaGeografica(45.4642, 9.1900, '45.4642', '9.1900');

    expect($distance)->toBeFloat()->toBeGreaterThanOrEqual(0.0)->toBeLessThan(0.01);
});

it('calculates a realistic distance between Milan and Rome', function (): void {
    // Milan (45.4642, 9.1900) to Rome (41.9028, 12.4964) is roughly 480km
    $distance = $this->action->calcolaDistanzaGeografica(45.4642, 9.1900, '41.9028', '12.4964');

    expect($distance)->toBeGreaterThan(450.0)->toBeLessThan(520.0);
});

it('filters out coordinates that are not arrays', function (): void {
    $coordinates = [
        'not-an-array',
        ['latitude' => '45.4642', 'longitude' => '9.1900'],
    ];

    $result = $this->action->execute(45.4642, 9.1900, $coordinates, 10);

    // Milan to itself is 0km distance, which is < 10km radius, so it is excluded (>= check).
    expect($result)->toBeArray();
});

it('filters out coordinates with non-string lat/lon values', function (): void {
    $coordinates = [
        ['latitude' => null, 'longitude' => null],
        ['latitude' => 41.9028, 'longitude' => 12.4964], // not strings, must be skipped
    ];

    $result = $this->action->execute(45.4642, 9.1900, $coordinates, 10);

    expect($result)->toBe([]);
});

it('keeps only coordinates at or beyond the given radius', function (): void {
    $milan = ['latitude' => '45.4642', 'longitude' => '9.1900']; // ~0km from Milan
    $rome = ['latitude' => '41.9028', 'longitude' => '12.4964']; // ~480km from Milan

    // Starting point is Milan itself, radius 10km: Milan (0km) excluded, Rome (~480km) included.
    // Note: execute() re-indexes results numerically (append via []), it does not preserve input keys.
    $result = $this->action->execute(45.4642, 9.1900, ['milan' => $milan, 'rome' => $rome], 10);

    expect($result)->toHaveCount(1);
    expect(array_values($result)[0])->toBe($rome);
});
