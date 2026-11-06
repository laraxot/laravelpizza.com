<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use function Safe\file_get_contents;

use Spatie\QueueableAction\QueueableAction;

/**
 * @phpstan-type GeoProperties array<string, scalar|null>
 * @phpstan-type GeoFeature array{
 *     type: string,
 *     properties: GeoProperties,
 *     geometry: array{type: string, coordinates: array<mixed>}
 * }
 * @phpstan-type GeoDataset array{type: string, features: list<GeoFeature>}
 */
class LoadGeoMapDatasetAction
{
    use QueueableAction;

    /**
     * @return GeoDataset
     */
    public function execute(string $path): array
    {
        return [
            'type' => 'FeatureCollection',
            'features' => $this->loadFeatures($path),
        ];
    }

    /**
     * @return list<GeoFeature>
     */
    public function loadFeatures(string $path): array
    {
        if (! is_file($path)) {
            throw new \RuntimeException("GeoMapWidget dataset not found at [{$path}]");
        }

        $contents = file_get_contents($path);

        try {
            $decoded = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new \RuntimeException('GeoMapWidget dataset contains invalid GeoJSON.', 0, $exception);
        }

        if (! is_array($decoded)) {
            throw new \RuntimeException('GeoMapWidget dataset must decode to an array.');
        }

        return $this->normalizeFeatureCollection($decoded);
    }

    /**
     * @param array<array-key, mixed> $decoded
     *
     * @return list<GeoFeature>
     */
    private function normalizeFeatureCollection(array $decoded): array
    {
        $type = $decoded['type'] ?? null;
        $features = $decoded['features'] ?? null;

        if ('FeatureCollection' !== $type || ! is_array($features)) {
            throw new \RuntimeException('GeoMapWidget dataset is not a valid FeatureCollection.');
        }

        $normalized = [];

        foreach ($features as $feature) {
            if (! is_array($feature)) {
                continue;
            }

            $normalizedFeature = $this->normalizeFeature($feature);

            if (null !== $normalizedFeature) {
                $normalized[] = $normalizedFeature;
            }
        }

        return $normalized;
    }

    /**
     * @param array<array-key, mixed> $feature
     *
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

        if (null === $normalizedProperties) {
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
     * @param array<array-key, mixed> $properties
     *
     * @return GeoProperties|null
     */
    private function normalizeProperties(array $properties): ?array
    {
        $normalized = [];

        foreach ($properties as $key => $value) {
            if (! is_string($key) || (! is_scalar($value) && null !== $value)) {
                return null;
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }
}
