<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Polygon;

use Modules\Geo\Actions\Polygon\IsPointInPolygonAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('IsPointInPolygonAction detects point inside square', function (): void {
    $action = app(IsPointInPolygonAction::class);
    $polygon = [
        ['lat' => 44.0, 'lng' => 8.0],
        ['lat' => 44.0, 'lng' => 10.0],
        ['lat' => 46.0, 'lng' => 10.0],
        ['lat' => 46.0, 'lng' => 8.0],
        ['lat' => 44.0, 'lng' => 8.0],
    ];

    Assert::assertTrue($action->execute(45.0, 9.0, $polygon));
});

test('IsPointInPolygonAction rejects point outside polygon', function (): void {
    $action = app(IsPointInPolygonAction::class);
    $polygon = [
        ['lat' => 44.0, 'lng' => 8.0],
        ['lat' => 44.0, 'lng' => 10.0],
        ['lat' => 46.0, 'lng' => 10.0],
        ['lat' => 46.0, 'lng' => 8.0],
        ['lat' => 44.0, 'lng' => 8.0],
    ];

    Assert::assertFalse($action->execute(50.0, 9.0, $polygon));
});

test('IsPointInPolygonAction accepts triangle boundary', function (): void {
    $action = app(IsPointInPolygonAction::class);
    $polygon = [
        ['lat' => 44.0, 'lng' => 8.0],
        ['lat' => 44.0, 'lng' => 10.0],
        ['lat' => 46.0, 'lng' => 9.0],
        ['lat' => 44.0, 'lng' => 8.0],
    ];

    Assert::assertTrue($action->execute(45.0, 9.0, $polygon));
});
