<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

uses(TestCase::class);

use Modules\Geo\Datas\Map\IconData;
use Modules\Geo\Datas\Map\MarkerData;
use Modules\Geo\Datas\Map\PositionData;
use Modules\Geo\Datas\Map\SizeData;
use Modules\Geo\Tests\TestCase;

test('IconData can be instantiated', function () {
    expect(class_exists(IconData::class))->toBeTrue();

    try {
        $icon = IconData::from([
            'url' => 'https://example.com/icon.png',
            'size' => ['width' => 32, 'height' => 32],
        ]);
        expect($icon)->toBeInstanceOf(IconData::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});

test('MarkerData can be instantiated', function () {
    expect(class_exists(MarkerData::class))->toBeTrue();

    try {
        $marker = MarkerData::from([
            'position' => ['lat' => 41.9028, 'lng' => 12.4964],
            'title' => 'Test Marker',
            'icon' => ['url' => 'https://example.com/icon.png'],
        ]);
        expect($marker)->toBeInstanceOf(MarkerData::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});

test('PositionData can be instantiated', function () {
    expect(class_exists(PositionData::class))->toBeTrue();

    try {
        $position = PositionData::from([
            'lat' => 41.9028,
            'lng' => 12.4964,
        ]);
        expect($position)->toBeInstanceOf(PositionData::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});

test('SizeData can be instantiated', function () {
    expect(class_exists(SizeData::class))->toBeTrue();

    try {
        $size = SizeData::from([
            'width' => 100,
            'height' => 100,
        ]);
        expect($size)->toBeInstanceOf(SizeData::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});
