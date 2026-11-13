<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Illuminate\Contracts\View\View;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Widget base per mappe Leaflet nei panel Filament.
 *
 * Fornisce il contratto dati condiviso (marker, origine, asset, stringhe)
 * e la vista `geo::filament.widgets.base-map` con cluster, layer control,
 * scala, geolocalizzazione, permalink e fullscreen.
 *
 * Le classi figlie implementano `getMapMarkers()` e opzionalmente
 * `getMapOrigin()`, `getMapStrings()` e `getMapAssetBase()`.
 *
 * Contratto marker (array{...}):
 * - id: int|string — usato dai data-map-arg delle azioni Livewire
 * - label: string — aria-label del marker
 * - latitude/longitude: float
 * - popup: string — HTML già escapato lato server (link e bottoni inclusi)
 *
 * Le azioni che richiedono Livewire vanno messe nel popup come
 * `<button data-map-method="nomeMetodo" data-map-arg="123">`: la vista
 * instrada la chiamata a `$wire.nomeMetodo(123)` sul widget istanza.
 *
 * @phpstan-type MapMarker array{id: int|string, label: string, latitude: float, longitude: float, popup: string}
 * @phpstan-type MapOrigin array{latitude: float|null, longitude: float|null, label: string}
 */
abstract class BaseMapWidget extends XotBaseWidget
{
    protected string $view = 'geo::filament.widgets.base-map';

    protected int|string|array $columnSpan = 'full';

    protected int $maxMarkers = 500;

    protected string $mapHeight = 'clamp(360px, 55vh, 560px)';

    /**
     * Marker da disegnare sulla mappa.
     *
     * @return array<int, MapMarker>
     */
    abstract public function getMapMarkers(): array;

    /**
     * Punto di riferimento opzionale (es. origine per le distanze).
     *
     * @return MapOrigin
     */
    protected function getMapOrigin(): array
    {
        return ['latitude' => null, 'longitude' => null, 'label' => ''];
    }

    protected function getMapAssetBase(): string
    {
        return asset('assets/geo/assets');
    }

    /**
     * Stringhe UI della mappa (aria, controlli, footer).
     * Le figlie possono sovrascrivere per chiavi di traduzione custom.
     *
     * @return array{aria_label: string, fullscreen: string, fullscreen_exit: string, locate: string, layer_satellite: string, footer: string}
     */
    protected function getMapStrings(int $markerCount): array
    {
        return [
            'aria_label' => (string) trans('geo::widgets.base_map.aria_label'),
            'fullscreen' => (string) trans('geo::widgets.base_map.fullscreen'),
            'fullscreen_exit' => (string) trans('geo::widgets.base_map.fullscreen_exit'),
            'locate' => (string) trans('geo::widgets.base_map.locate'),
            'layer_satellite' => (string) trans('geo::widgets.base_map.layer_satellite'),
            'footer' => (string) trans('geo::widgets.base_map.markers_shown', ['count' => $markerCount]),
        ];
    }

    public function render(): View
    {
        /** @var array<int, MapMarker> $markers */
        $markers = $this->getMapMarkers();

        return view($this->view, [
            'markers' => $markers,
            'origin' => $this->getMapOrigin(),
            'asset_base' => $this->getMapAssetBase(),
            'map_height' => $this->mapHeight,
            'map_strings' => $this->getMapStrings(count($markers)),
        ]);
    }
}
