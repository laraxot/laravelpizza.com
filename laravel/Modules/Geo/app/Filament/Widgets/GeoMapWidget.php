<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Geo\Support\GeoMapDataset;

/**
 * @phpstan-type GeoDataset array{type: string, features: list<array{
 *     type: string,
 *     properties: array<string, scalar|null>,
 *     geometry: array{type: string, coordinates: array}
 * }>}
 * @phpstan-type GeoMapConfig array{
 *     defaultZoom: int,
 *     detailZoom: int,
 *     aggregateZoom: int,
 *     baseLayers: array{street: string, satellite: string},
 *     layers: array{clusters: bool, points: bool, heatmap: bool, zones: bool},
 *     categories: list<string>,
 *     stats: array{total: int, points: int, zones: int, categories: int}
 * }
 */
final class GeoMapWidget extends Widget
{
    protected string $view = 'geo::filament.widgets.geo-map-widget';

    protected int|string|array $columnSpan = 'full';

    protected string $datasetRelativePath =
        'resources/data/geo-map-widget.geojson';

    protected int $defaultZoom = 6;

    protected int $aggregateZoom = 8;

    protected int $detailZoom = 12;

    /**
     * @return GeoDataset
     */
    public function getDataset(): array
    {
        return $this->getGeoMapDataset()->toArray();
    }

    /**
     * @return list<string>
     */
    public function getCategories(): array
    {
        return $this->getGeoMapDataset()->getCategories();
    }

    /**
     * @return GeoMapConfig
     */
    public function getMapConfig(): array
    {
        return [
            'defaultZoom' => $this->defaultZoom,
            'detailZoom' => $this->detailZoom,
            'aggregateZoom' => $this->aggregateZoom,
            'baseLayers' => [
                'street' => 'OpenStreetMap',
                'satellite' => 'Esri World Imagery',
            ],
            'layers' => [
                'clusters' => true,
                'points' => true,
                'heatmap' => true,
                'zones' => true,
            ],
            'categories' => $this->getCategories(),
            'stats' => $this->getDatasetStats(),
        ];
    }

    /**
     * @return array{
     *     total: int,
     *     points: int,
     *     zones: int,
     *     categories: int
     * }
     */
    public function getDatasetStats(): array
    {
        return $this->getGeoMapDataset()->getStats();
    }

    public function getDatasetJson(): string
    {
        return $this->encodeJson(
            $this->getDataset(),
            'Unable to serialize GeoMapWidget dataset.',
        );
    }

    public function getConfigJson(): string
    {
        return $this->encodeJson(
            $this->getMapConfig(),
            'Unable to serialize GeoMapWidget config.',
        );
    }

    protected function getDatasetPath(): string
    {
        return dirname(__DIR__, 3)
            .DIRECTORY_SEPARATOR
            .$this->datasetRelativePath;
    }

    /**
     * @param array<string, array|bool|float|int|string|null> $payload
     */
    private function encodeJson(array $payload, string $message): string
    {
        try {
            return json_encode($payload, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new \RuntimeException($message, 0, $exception);
        }
    }

    private function getGeoMapDataset(): GeoMapDataset
    {
        return new GeoMapDataset($this->getDatasetPath());
    }
}
