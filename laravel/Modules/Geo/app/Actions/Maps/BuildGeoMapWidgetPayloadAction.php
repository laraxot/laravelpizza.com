<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Datas\Map\GeoMapLayerConfigData;
use Modules\Geo\Datas\Map\GeoMapWidgetData;
use Modules\Geo\Models\Place;

class BuildGeoMapWidgetPayloadAction
{
    public function execute(): GeoMapWidgetData
    {
        $places = $this->getPlaces();

        $features = $places
            ->map(fn (Place $place): array => $this->mapPlaceToFeature($place))
            ->values()
            ->all();

        $center = $this->resolveCenter($places);

        return new GeoMapWidgetData(
            geoJson: [
                'type' => 'FeatureCollection',
                'features' => $features,
            ],
            initialState: [
                'center' => $center,
                'zoom' => 7,
                'selectedId' => null,
                'activeLayers' => ['cluster'],
                'filters' => [
                    'categories' => [],
                    'text' => null,
                ],
            ],
            layerConfig: [
                $this->toStringMixedMap(GeoMapLayerConfigData::from([
                    'key' => 'cluster',
                    'label' => 'Cluster',
                    'enabled' => true,
                ])->toArray()),
                $this->toStringMixedMap(GeoMapLayerConfigData::from([
                    'key' => 'points',
                    'label' => 'Points',
                    'enabled' => false,
                ])->toArray()),
                $this->toStringMixedMap(GeoMapLayerConfigData::from([
                    'key' => 'heatmap',
                    'label' => 'Heatmap',
                    'enabled' => false,
                ])->toArray()),
                $this->toStringMixedMap(GeoMapLayerConfigData::from([
                    'key' => 'zones',
                    'label' => 'Zones',
                    'enabled' => false,
                ])->toArray()),
            ],
            meta: [
                'totalFeatures' => \count($features),
                'availableCategories' => array_values(array_unique(array_filter(array_map(
                    static fn (array $feature): string => $feature['properties']['category'],
                    $features,
                )))),
            ],
        );
    }

    /**
     * @return Collection<int, Place>
     */
    protected function getPlaces(): Collection
    {
        return Place::query()
            ->with(['placeType', 'address'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->limit(3000)
            ->get();
    }

    /**
     * @return array{
     *     type: 'Feature',
     *     properties: array{
     *         id: string,
     *         title: string,
     *         name: string,
     *         category: string,
     *         address: string,
     *         description: string,
     *         search: string,
     *         popup: array{
     *             title: string,
     *             category: string,
     *             address: string,
     *             description: string
     *         }
     *     },
     *     geometry: array{
     *         type: 'Point',
     *         coordinates: array{0: float, 1: float}
     *     }
     * }
     */
    private function mapPlaceToFeature(Place $place): array
    {
        $category = data_get($place->placeType, 'slug', 'unknown');
        $title = $this->resolveTitle($place);
        $address = $place->getFormattedAddress();
        $description = \is_string($place->description ?? null) ? $place->description : '';
        $searchTerms = array_values(array_filter([
            $title,
            $category,
            $address,
            $description,
        ], static fn (mixed $value): bool => \is_string($value) && '' !== $value));
        $search = trim(strtolower(implode(' ', $searchTerms)));

        return [
            'type' => 'Feature',
            'properties' => [
                'id' => (string) $place->getKey(),
                'title' => $title,
                'name' => $title,
                'category' => \is_string($category) ? $category : 'unknown',
                'address' => $address,
                'description' => $description,
                'search' => $search,
                'popup' => [
                    'title' => $title,
                    'category' => \is_string($category) ? $category : 'unknown',
                    'address' => $address,
                    'description' => $description,
                ],
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [
                    (float) $place->longitude,
                    (float) $place->latitude,
                ],
            ],
        ];
    }

    /**
     * @param Collection<int, Place> $places
     *
     * @return array{lat: float, lng: float}
     */
    private function resolveCenter(Collection $places): array
    {
        if ($places->isEmpty()) {
            return ['lat' => 45.4642, 'lng' => 9.1900];
        }

        $latitudes = $places->pluck('latitude')->filter(static fn ($value): bool => \is_float($value) || \is_int($value));
        $longitudes = $places->pluck('longitude')->filter(static fn ($value): bool => \is_float($value) || \is_int($value));

        return [
            'lat' => (float) ($latitudes->average() ?? 45.4642),
            'lng' => (float) ($longitudes->average() ?? 9.1900),
        ];
    }

    private function resolveTitle(Place $place): string
    {
        $title = $place->name;

        if (\is_string($title) && '' !== trim($title)) {
            return trim($title);
        }

        $formattedAddress = $place->getFormattedAddress();

        if ('' !== $formattedAddress) {
            return $formattedAddress;
        }

        $placeKey = $place->getKey();

        return 'Place #'.(\is_scalar($placeKey) ? (string) $placeKey : '');
    }

    /**
     * @param array<mixed> $data
     *
     * @return array<string, mixed>
     */
    private function toStringMixedMap(array $data): array
    {
        $normalized = [];

        foreach ($data as $key => $value) {
            if (\is_string($key)) {
                $normalized[$key] = $value;
            }
        }

        return $normalized;
    }
}
