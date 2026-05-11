<?php

declare(strict_types=1);

use Modules\Geo\Filament\Pages\Dashboard;
use Modules\Geo\Filament\Widgets\GeoMapWidget;

test('geo map widget resolves embedded geojson dataset', function (): void {
    $widget = new GeoMapWidget();
    $dataset = $widget->getDataset();

    expect($dataset['type'])->toBe('FeatureCollection')
        ->and($dataset['features'])->toBeArray()
        ->and($dataset['features'])->not->toBeEmpty();
});

test('geo map widget exposes categories and config', function (): void {
    $widget = new GeoMapWidget();
    $config = $widget->getMapConfig();

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
});

test('geo map widget serializes dataset and config to json', function (): void {
    $widget = new GeoMapWidget();

    expect($widget->getDatasetJson())->toStartWith('{')
        ->and($widget->getConfigJson())->toStartWith('{');
});

test('geo dashboard registers geo map widget', function (): void {
    $dashboard = new Dashboard();

    expect($dashboard->getWidgets())->toContain(GeoMapWidget::class);
});
