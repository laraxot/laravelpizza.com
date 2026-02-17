<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Models\Place;

// use Webbingbrasil\FilamentMaps\Widgets\MapWidget; // Disabilitato per compatibilità Filament 4

/**
 * Widget per visualizzare una mappa OpenStreetMap con le posizioni.
 *
 * DISABILITATO per compatibilità con Filament 4
 */
class OSMMapWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<int, array{
     *     position: array{lat: float, lng: float},
     *     title: string,
     *     content: string,
     *     icon?: array{url: string, scaledSize: array{width: int, height: int}}
     * }>
     */
    public function getMarkers(): array
    {
        /** @var Collection<int, Place> $places */
        $places = Place::with(['address', 'placeType'])->get();

        return $places
            ->filter(fn (Place $place) => $place->latitude !== null && $place->longitude !== null)
            ->map(function (Place $place): array {
                $marker = [
                    'position' => [
                        'lat' => (float) $place->latitude,
                        'lng' => (float) $place->longitude,
                    ],
                    'title' => (string) ($place->name ?? 'Unnamed Place'),
                    'content' => $this->getInfoWindowContent($place),
                ];

                $icon = $this->getMarkerIcon($place);
                if ($icon !== null) {
                    $marker['icon'] = $icon;
                }

                return $marker;
            })->all();
    }

    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'geo::filament.widgets.osm-map-widget';

        return view($viewName, [
            'data' => $this->getData(),
        ]);
    }

    protected function getData(): array
    {
        /** @var Collection<int, Place> $places */
        $places = Place::with(['address', 'placeType'])->get();

        return [
            'markers' => $this->getMarkers(),
            'center' => $this->getMapCenter($places),
            'zoom' => $this->getMapZoom($places),
        ];
    }

    /**
     * @param  Collection<int, Place>  $places
     * @return array{lat: float, lng: float}
     */
    protected function getMapCenter(Collection $places): array
    {
        if ($places->isEmpty()) {
            return ['lat' => 41.9028, 'lng' => 12.4964]; // Rome, Italy
        }

        $latitudes = $places->pluck('latitude')->filter(fn ($lat) => is_float($lat));
        $longitudes = $places->pluck('longitude')->filter(fn ($lng) => is_float($lng));

        return [
            'lat' => $latitudes->average() ?? 0.0,
            'lng' => $longitudes->average() ?? 0.0,
        ];
    }

    /**
     * @param  Collection<int, Place>  $places
     */
    protected function getMapZoom(Collection $places): int
    {
        if ($places->count() <= 1) {
            return 13;
        }

        return 10;
    }

    protected function getInfoWindowContent(Place $place): string
    {
        /** @var view-string $viewName */
        $viewName = 'geo::filament.widgets.osm-map-info-window';

        return view($viewName, [
            'place' => $place,
        ])->render();
    }

    /**
     * @return array{url: string, scaledSize: array{width: int, height: int}}|null
     */
    protected function getMarkerIcon(Place $place): ?array
    {
        // Uso placeType invece di type per evitare relazioni mancanti
        $placeType = $place->placeType;
        $type = is_object($placeType) && isset($placeType->slug) && is_string($placeType->slug) ? $placeType->slug : 'default';

        $iconPath = resource_path("images/markers/{$type}.png");
        if (! file_exists($iconPath)) {
            return null;
        }

        return [
            'url' => asset("images/markers/{$type}.png"),
            'scaledSize' => [
                'width' => 32,
                'height' => 32,
            ],
        ];
    }
}
