<?php

declare(strict_types=1);

<<<<<<< HEAD
uses(LightTestCase::class);

use Modules\Geo\Actions\Maps\BuildGeoMapWidgetPayloadAction;
use Modules\Geo\Datas\Map\GeoMapWidgetData;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Tests\LightTestCase;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

test('geo map widget extends xot base widget', function () {
    expect(is_subclass_of(GeoMapWidget::class, XotBaseWidget::class))->toBeTrue();
});

test('geo map widget exposes expected view', function () {
    $widget = new GeoMapWidget();

    expect($widget->render()->name())->toBe('geo::filament.widgets.geo-map-widget');
});

test('geo map widget returns payload data object', function () {
    $payload = GeoMapWidgetData::from([
        'geoJson' => ['type' => 'FeatureCollection', 'features' => []],
        'initialState' => [
            'center' => ['lat' => 45.4642, 'lng' => 9.1900],
            'zoom' => 7,
            'selectedId' => null,
            'activeLayers' => ['cluster'],
            'filters' => ['categories' => [], 'text' => null],
        ],
        'layerConfig' => [],
        'meta' => ['totalFeatures' => 0, 'availableCategories' => []],
    ]);

    $this->app->bind(
        BuildGeoMapWidgetPayloadAction::class,
        static fn (): object => new class($payload) {
            public function __construct(private readonly GeoMapWidgetData $payload)
            {
            }

            public function execute(): GeoMapWidgetData
            {
                return $this->payload;
            }
        }
    );

    $widget = new GeoMapWidget();

    expect($widget->getPayload())->toBeInstanceOf(GeoMapWidgetData::class);
=======
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
>>>>>>> 40b96bcd6 (.)
});
