<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Datas\Map\GeoMapWidgetData;
use Modules\Geo\Models\Place;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

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
                ['key' => 'cluster', 'label' => 'Cluster', 'enabled' => true],
                ['key' => 'points', 'label' => 'Points', 'enabled' => false],
                ['key' => 'heatmap', 'label' => 'Heatmap', 'enabled' => false],
                ['key' => 'zones', 'label' => 'Zones', 'enabled' => false],
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
        /** @var Collection<int, Place> $places */
        $places = Place::query()
            ->with(['placeType', 'address'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->limit(3000)
            ->get();

        return $places;
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
        $search = trim(strtolower(implode(' ', array_filter([
            SafeStringCastAction::cast($title),
            SafeStringCastAction::cast($category),
            SafeStringCastAction::cast($address),
            SafeStringCastAction::cast($description),
        ]))));

        return [
            'type' => 'Feature',
            'properties' => [
                'id' => SafeStringCastAction::cast($place->getKey()),
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
                    SafeFloatCastAction::cast($place->longitude),
                    SafeFloatCastAction::cast($place->latitude),
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
            'lat' => SafeFloatCastAction::cast($latitudes->average() ?? 45.4642),
            'lng' => SafeFloatCastAction::cast($longitudes->average() ?? 9.1900),
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

        return 'Place #'.SafeStringCastAction::cast($place->getKey());
    }
}
