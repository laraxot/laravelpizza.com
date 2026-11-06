<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Modules\Geo\Actions\Maps\GetGeoMapDatasetCategoriesAction;
use Modules\Geo\Actions\Maps\GetGeoMapDatasetStatsAction;
use Modules\Geo\Actions\Maps\LoadGeoMapDatasetAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * @phpstan-type GeoDataset array{type: string, features: list<array{
 *     type: string,
 *     properties: array<string, scalar|null>,
 *     geometry: array{type: string, coordinates: array<mixed>}
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
final class GeoMapWidget extends XotBaseWidget
{
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
        return app(LoadGeoMapDatasetAction::class)->execute($this->getDatasetPath());
    }

    /**
     * @return list<string>
     */
    public function getCategories(): array
    {
        return app(GetGeoMapDatasetCategoriesAction::class)->execute($this->getDatasetPath());
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
        return app(GetGeoMapDatasetStatsAction::class)->execute($this->getDatasetPath());
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
     * @param array<string, mixed> $payload
     */
    private function encodeJson(array $payload, string $message): string
    {
        try {
            return json_encode($payload, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new \RuntimeException($message, 0, $exception);
        }
    }
}
