<?php

declare(strict_types=1);

use Modules\Geo\Actions\Distance\BuildHaversineSqlAction;
use Modules\Geo\Actions\Math\GenerateHaversineSqlAction;

use function Safe\preg_replace;

test('BuildHaversineSqlAction builds an SQL expression with balanced parentheses', function (): void {
    $sql = app(BuildHaversineSqlAction::class)->execute(45.1, 9.2, 'lat', 'lng');

    expect(substr_count($sql, '('))->toBe(substr_count($sql, ')'));
});

test('BuildHaversineSqlAction yields the same expression as the legacy GeoService haversine', function (): void {
    $normalize = static fn (string $sql): string => preg_replace('/\s+/', '', $sql);

    $built = app(BuildHaversineSqlAction::class)->execute(-12.5, 130.25, 'lat', 'lng');
    $generated = app(GenerateHaversineSqlAction::class)->execute(-12.5, 130.25, 'lat', 'lng');

    expect($normalize($built))->toBe($normalize($generated));
});

test('BuildHaversineSqlAction defaults to the latitude and longitude columns', function (): void {
    $sql = app(BuildHaversineSqlAction::class)->execute(45.0, 9.0);

    expect($sql)->toContain('`latitude`')->toContain('`longitude`');
});
