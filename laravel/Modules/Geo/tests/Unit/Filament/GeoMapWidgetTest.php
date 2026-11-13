<?php

declare(strict_types=1);

use Modules\Geo\Filament\Pages\Dashboard;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

// XotBaseWidget::__construct() resolves its view through the container: these tests need the app.
uses(LightTestCase::class);

test('geo map widget resolves embedded geojson dataset', function (): void {
    $widget = new GeoMapWidget;
    $dataset = $widget->getDataset();

    Assert::assertSame('FeatureCollection', $dataset['type']);

    Assert::assertIsArray($dataset['features']);

    // resources/data/geo-map-widget.geojson ships 5 points and 1 zone polygon
    Assert::assertCount(6, $dataset['features']);
    Assert::assertSame('Feature', $dataset['features'][0]['type']);
});

test('geo map widget exposes categories and config', function (): void {
    $widget = new GeoMapWidget;
    $config = $widget->getMapConfig();

    foreach (['farm', 'marketplace', 'beekeeper', 'vending_machine'] as $category) {
        Assert::assertContains($category, $widget->getCategories());
    }

    Assert::assertSame(12, $config['detailZoom']);

    Assert::assertSame(8, $config['aggregateZoom']);
});

test('geo map widget serializes dataset and config to json', function (): void {
    $widget = new GeoMapWidget;

    Assert::assertStringStartsWith('{', (string) $widget->getDatasetJson());

    Assert::assertStringStartsWith('{', (string) $widget->getConfigJson());
});

test('geo dashboard registers geo map widget', function (): void {
    $dashboard = new Dashboard;

    Assert::assertContains(GeoMapWidget::class, $dashboard->getWidgets());
});
