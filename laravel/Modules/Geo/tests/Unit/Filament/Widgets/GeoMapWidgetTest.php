<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
test('geo map widget extends filament widget', function (): void {
    Assert::assertInstanceOf(Widget::class, new GeoMapWidget());
});

test('geo map widget exposes expected view', function (): void {
    $widget = new GeoMapWidget();
    $reflection = new \ReflectionClass($widget);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    Assert::assertSame('geo::filament.widgets.geo-map-widget', $property->getValue($widget));
});

test('geo map widget returns dataset and config payloads', function (): void {
    $widget = new GeoMapWidget();
    $dataset = $widget->getDataset();
    $config = $widget->getMapConfig();

    Assert::assertSame('FeatureCollection', $dataset['type']);
    Assert::assertSame(12, $config['detailZoom']);
    Assert::assertSame(8, $config['aggregateZoom']);
});
