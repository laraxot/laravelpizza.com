<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\Map\IconData;
use Modules\Geo\Datas\Map\MarkerData;
use Modules\Geo\Datas\Map\PositionData;
use Modules\Geo\Datas\Map\SizeData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('IconData can be instantiated', function (): void {
    $icon = IconData::from([
        'url' => 'https://example.com/icon.png',
        'size' => ['width' => 32, 'height' => 32],
    ]);

    Assert::assertSame('https://example.com/icon.png', $icon->url);
});

test('MarkerData can be instantiated', function (): void {
    $marker = MarkerData::from([
        'position' => ['lat' => 41.9028, 'lng' => 12.4964],
        'title' => 'Test Marker',
        'icon' => ['url' => 'https://example.com/icon.png'],
    ]);

    Assert::assertSame('Test Marker', $marker->title);
});

test('PositionData can be instantiated', function (): void {
    $position = PositionData::from([
        'lat' => 41.9028,
        'lng' => 12.4964,
    ]);

    Assert::assertSame(41.9028, $position->lat);
});

test('SizeData can be instantiated', function (): void {
    $size = SizeData::from([
        'width' => 100,
        'height' => 100,
    ]);

    Assert::assertSame(100, $size->width);
});
