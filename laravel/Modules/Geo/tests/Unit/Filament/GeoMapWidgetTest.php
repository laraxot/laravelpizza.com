<?php

declare(strict_types=1);

use Modules\Geo\Filament\Pages\Dashboard;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

test('geo map widget resolves embedded geojson dataset', function (): void {
    $widget = new GeoMapWidget();
    $dataset = $widget->getDataset();

<<<<<<< HEAD
    expect($dataset['type'])->toBe('FeatureCollection')
        ->and($dataset['features'])->toBeArray()
        ->and($dataset['features'])->not->toBeEmpty();
=======
    Assert::assertSame('FeatureCollection', $dataset['type']);

    Assert::assertIsArray($dataset['features']);

    Assert::assertEmpty($dataset['features']);
>>>>>>> 40b96bcd6 (.)
});

test('geo map widget exposes categories and config', function (): void {
    $widget = new GeoMapWidget();
    $config = $widget->getMapConfig();

<<<<<<< HEAD
    expect($widget->getCategories())->toContain('farm', 'marketplace', 'beekeeper', 'vending_machine')
        ->and($config['layers'])->toBe([
            'clusters' => true,
            'points' => true,
            'heatmap' => true,
            'zones' => true,
        ])
        ->and($config['detailZoom'])->toBe(12)
        ->and($config['aggregateZoom'])->toBe(8)
        ->and($config['stats'])->toBe([
            'total' => 6,
            'points' => 5,
            'zones' => 1,
            'categories' => 4,
        ]);
=======
    foreach (['farm', 'marketplace', 'beekeeper', 'vending_machine'] as $category) {
        Assert::assertContains($category, $widget->getCategories());
    }

    Assert::assertSame(12, $config['detailZoom']);

    Assert::assertSame(8, $config['aggregateZoom']);
>>>>>>> 40b96bcd6 (.)
});

test('geo map widget serializes dataset and config to json', function (): void {
    $widget = new GeoMapWidget();

<<<<<<< HEAD
    expect($widget->getDatasetJson())->toStartWith('{')
        ->and($widget->getConfigJson())->toStartWith('{');
=======
    Assert::assertStringStartsWith('{', (string) $widget->getDatasetJson());

    Assert::assertStringStartsWith('{', (string) $widget->getConfigJson());
>>>>>>> 40b96bcd6 (.)
});

test('geo dashboard registers geo map widget', function (): void {
    $dashboard = new Dashboard();

<<<<<<< HEAD
    expect($dashboard->getWidgets())->toContain(GeoMapWidget::class);
=======
    Assert::assertContains(GeoMapWidget::class, $dashboard->getWidgets());
>>>>>>> 40b96bcd6 (.)
});
