<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Geo\Support;

use Spatie\QueueableAction\QueueableAction;

use function Safe\file_get_contents;

/**
 * @phpstan-type GeoProperties array<string, scalar|null>
 * @phpstan-type GeoFeature array{
 *     type: string,
 *     properties: GeoProperties,
 *     geometry: array{type: string, coordinates: array<mixed>}
 * }
 * @phpstan-type GeoDataset array{type: string, features: list<GeoFeature>}
 * @phpstan-type GeoDatasetStats array{
 *     total: int,
 *     points: int,
 *     zones: int,
 *     categories: int
 * }
 */
final class GeoMapDatasetAction
{
    use QueueableAction;

    /**
     * @var list<GeoFeature>|null
     */
    private ?array $features = null;

    public function __construct(
        private readonly string $path,
    ) {}

    /**
     * @return GeoDataset
     */
    public function execute(): array
    {
        return [
            'type' => 'FeatureCollection',
            'features' => $this->getFeatures(),
        ];
    }

    /**
     * @return list<string>
     */
    public function getCategoriesAction(): array
    {
        $categories = [];

        foreach ($this->getFeatures() as $feature) {
            if ($feature['geometry']['type'] !== 'Point') {
                continue;
            }

            $category = $feature['properties']['p'] ?? $feature['properties']['category'] ?? null;

            if (is_string($category) && $category !== '') {
                $categories[] = $category;
            }
        }

        $categories = array_values(array_unique($categories));
        sort($categories);

        return $categories;
    }

    /**
     * @return GeoDatasetStats
     */
    public function getStatsAction(): array
    {
        $points = 0;
        $zones = 0;

        foreach ($this->getFeatures() as $feature) {
            $geometryType = $feature['geometry']['type'];

            if ($geometryType === 'Point') {
                $points++;
            }

            if ($geometryType === 'Polygon' || $geometryType === 'MultiPolygon') {
                $zones++;
            }
        }

        return [
            'total' => count($this->getFeatures()),
            'points' => $points,
            'zones' => $zones,
            'categories' => count($this->getCategoriesAction()),
        ];
    }

    /**
     * @return list<GeoFeature>
     */
    private function getFeatures(): array
    {
        if ($this->features !== null) {
            return $this->features;
        }

        if (! is_file($this->path)) {
            throw new \RuntimeException("GeoMapWidget dataset not found at [{$this->path}]");
        }

        $contents = file_get_contents($this->path);

        try {
            $decoded = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new \RuntimeException('GeoMapWidget dataset contains invalid GeoJSON.', 0, $exception);
        }

        if (! is_array($decoded)) {
            throw new \RuntimeException('GeoMapWidget dataset must decode to an array.');
        }

        $this->features = $this->normalizeFeatureCollection($decoded);

        return $this->features;
    }

    /**
     * @param  array<array-key, mixed>  $decoded
     * @return list<GeoFeature>
     */
    private function normalizeFeatureCollection(array $decoded): array
    {
        $type = $decoded['type'] ?? null;
        $features = $decoded['features'] ?? null;

        if ($type !== 'FeatureCollection' || ! is_array($features)) {
            throw new \RuntimeException('GeoMapWidget dataset is not a valid FeatureCollection.');
        }

        $normalized = [];

        foreach ($features as $feature) {
            if (! is_array($feature)) {
                continue;
            }

            $normalizedFeature = $this->normalizeFeature($feature);

            if ($normalizedFeature !== null) {
                $normalized[] = $normalizedFeature;
            }
        }

        return $normalized;
    }

    /**
     * @param  array<array-key, mixed>  $feature
     * @return GeoFeature|null
     */
    private function normalizeFeature(array $feature): ?array
    {
        $type = $feature['type'] ?? null;
        $properties = $feature['properties'] ?? null;
        $geometry = $feature['geometry'] ?? null;

        if (! is_string($type) || ! is_array($properties) || ! is_array($geometry)) {
            return null;
        }

        $geometryType = $geometry['type'] ?? null;
        $coordinates = $geometry['coordinates'] ?? null;

        if (! is_string($geometryType) || ! is_array($coordinates)) {
            return null;
        }

        $normalizedProperties = $this->normalizeProperties($properties);

        if ($normalizedProperties === null) {
            return null;
        }

        return [
            'type' => $type,
            'properties' => $normalizedProperties,
            'geometry' => [
                'type' => $geometryType,
                'coordinates' => array_values($coordinates),
            ],
        ];
    }

    /**
     * @param  array<array-key, mixed>  $properties
     * @return GeoProperties|null
     */
    private function normalizeProperties(array $properties): ?array
    {
        $normalized = [];

        foreach ($properties as $key => $value) {
            if (! is_string($key) || (! is_scalar($value) && $value !== null)) {
                return null;
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }
}
