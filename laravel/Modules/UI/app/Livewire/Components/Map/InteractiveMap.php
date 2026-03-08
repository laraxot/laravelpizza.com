<?php

declare(strict_types=1);

namespace Modules\UI\Livewire\Components\Map;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Geo\Services\GeocodingService;
use Modules\Geo\Services\MapService;
use Webmozart\Assert\Assert;

/**
 * Componente Livewire per la mappa interattiva.
 *
 * Fornisce funzionalità per visualizzare marker geografici,
 * filtri dinamici e interazione con la mappa.
 */
final class InteractiveMap extends Component
{
    public array $center = [45.4642, 9.1900]; // Milano

    public int $zoom = 10;

    public array $markers = [];

    public array $filters = [
        'tickets' => true,
        'users' => false,
        'locations' => false,
        'status' => [],
        'priority' => [],
        'type' => [],
        'roles' => [],
        'location_types' => [],
    ];

    public ?array $selectedMarker = null;

    public array $stats = [];

    public bool $showControls = true;

    public bool $isLoading = false;

    public string $searchQuery = '';

    /** @var array<string, string> */
    protected $listeners = [
        'markerSelected' => 'selectMarker',
        'filtersChanged' => 'updateFilters',
        'mapBoundsChanged' => 'updateBounds',
        'refreshMap' => 'loadMarkers',
    ];

    public function mount(?array $center = null, ?int $zoom = null, array $filters = []): void
    {
        if ($center) {
            // @var mixed center = $center;
        }

        if ($zoom) {
            // @var mixed zoom = $zoom;
        }

        if ($filters) {
            // @var mixed filters = array_merge($this->filters, $filters;
        }

        // @var mixed loadMarkers(;
    }

    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'ui::livewire.components.map.interactive-map';

        return view($viewName);
    }

    /**
     * Seleziona un marker.
     */
    public function selectMarker(int $markerId): void
    {
        $marker = collect(// @var mixed markers
            ->firstWhere('id', $markerId);

        // @var mixed selectedMarker = is_array($marker;

        // @var mixed dispatch('markerSelected', $this->selectedMarker;
    }

    /**
     * Aggiorna i filtri.
     */
    public function updateFilters(array $filters): void
    {
        // @var mixed filters = array_merge($this->filters, $filters;
        // @var mixed loadMarkers(;
    }

    /**
     * Aggiorna i bounds della mappa.
     */
    public function updateBounds(array $bounds): void
    {
        // @var mixed filters['bounds'] = $bounds;
        // @var mixed loadMarkers(;
    }

    /**
     * Carica i marker.
     */
    public function loadMarkers(): void
    {
        // @var mixed isLoading = true;

        try {
            /** @phpstan-ignore-next-line class.notFound */
            $mapService = app(MapService::class);
            /* @phpstan-ignore-next-line class.notFound, assign.propertyType */
            // @var mixed markers = $mapService->getMarkers($this->filters;
            /* @phpstan-ignore-next-line class.notFound, assign.propertyType */
            // @var mixed stats = $mapService->getMapStats($this->filters;
        } catch (\Exception $e) {
            // @var mixed addError('map', 'Errore nel caricamento dei marker: '.$e->getMessage(;
            // @var mixed markers = [];
            // @var mixed stats = [];
        } finally {
            // @var mixed isLoading = false;
        }
    }

    /**
     * Resetta la vista della mappa.
     */
    public function resetView(): void
    {
        // @var mixed dispatch('resetMapView';
    }

    /**
     * Esporta i dati della mappa.
     */
    public function exportData(string $format = 'json'): void
    {
        try {
            /** @phpstan-ignore-next-line class.notFound */
            $mapService = app(MapService::class);
            /** @phpstan-ignore-next-line class.notFound */
            $data = $mapService->exportData(// @var mixed filters, $format;

            $filename = 'map_export_'.now()->format('Y_m_d_H_i_s').'.'.$format;

            // @var mixed dispatch('downloadFile', [
                'content' => $data,
                'filename' => $filename,
                'mimeType' => // @var mixed getMimeType($format
            ]);

            // @var mixed dispatch('notify', [
                'type' => 'success',
                'message' => 'Dati esportati con successo!',
            ]);
        } catch (\Exception $e) {
            // @var mixed addError('export', 'Errore nell\'esportazione: '.$e->getMessage(;
        }
    }

    /**
     * Cerca un indirizzo.
     */
    public function searchAddress(): void
    {
        if (empty(// @var mixed searchQuery
            return;
        }

        try {
            /** @phpstan-ignore-next-line class.notFound */
            $geocodingService = app(GeocodingService::class);
            /** @phpstan-ignore-next-line class.notFound */
            $result = $geocodingService->geocodeAddress(// @var mixed searchQuery;
            Assert::isArray($result, 'Geocoding result must be array');

            $address = $result['address'] ?? '';
            Assert::string($address, 'Address must be string');

            // @var mixed center = [$result['latitude'], $result['longitude']];
            // @var mixed zoom = 15;

            // @var mixed dispatch('updateMapCenter', $this->center, $this->zoom;

            // @var mixed dispatch('notify', [
                'type' => 'success',
                'message' => 'Indirizzo trovato: '.$address,
            ]);
        } catch (\Exception $e) {
            // @var mixed addError('search', 'Indirizzo non trovato: '.$e->getMessage(;
        }
    }

    /**
     * Ottiene suggerimenti per la ricerca.
     */
    public function getSuggestions(): array
    {
        if (strlen(// @var mixed searchQuery
            return [];
        }

        try {
            /** @phpstan-ignore-next-line class.notFound */
            $geocodingService = app(GeocodingService::class);

            /* @phpstan-ignore-next-line class.notFound, return.type */
            return $geocodingService->getSuggestions(// @var mixed searchQuery;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Toggle controlli mappa.
     */
    public function toggleControls(): void
    {
        // @var mixed showControls = ! $this->showControls;
    }

    /**
     * Filtra per tipo.
     */
    public function filterByType(string $type, bool $enabled): void
    {
        // @var mixed filters[$type] = $enabled;
        // @var mixed loadMarkers(;
    }

    /**
     * Filtra per stato.
     */
    public function filterByStatus(string $status, bool $enabled): void
    {
        $currentStatus = // @var mixed filters['status'] ?? [];
        Assert::isArray($currentStatus, 'Status filter must be array');

        if ($enabled) {
            $currentStatus[] = $status;
            // @var mixed filters['status'] = array_unique($currentStatus;
            // @var mixed loadMarkers(;

            return;
        }

        $currentStatus = array_diff($currentStatus, [$status]);
        // @var mixed filters['status'] = array_unique($currentStatus;
        // @var mixed loadMarkers(;
    }

    /**
     * Filtra per priorità.
     */
    public function filterByPriority(string $priority, bool $enabled): void
    {
        $currentPriority = // @var mixed filters['priority'] ?? [];
        Assert::isArray($currentPriority, 'Priority filter must be array');

        if ($enabled) {
            $currentPriority[] = $priority;
            // @var mixed filters['priority'] = array_unique($currentPriority;
            // @var mixed loadMarkers(;

            return;
        }

        $currentPriority = array_diff($currentPriority, [$priority]);
        // @var mixed filters['priority'] = array_unique($currentPriority;
        // @var mixed loadMarkers(;
    }

    /**
     * Pulisce tutti i filtri.
     */
    public function clearFilters(): void
    {
        // @var mixed filters = [
            'tickets' => true,
            'users' => false,
            'locations' => false,
            'status' => [],
            'priority' => [],
            'type' => [],
            'roles' => [],
            'location_types' => [],
        ];

        // @var mixed loadMarkers(;
    }

    /**
     * Ottiene le proprietà computate.
     */
    public function getMarkersByTypeProperty(): array
    {
        return collect(// @var mixed markers
            ->groupBy('type')
            ->map(fn ($markers) => $markers->count())
            ->toArray();
    }

    public function getVisibleMarkersCountProperty(): int
    {
        return count(// @var mixed markers;
    }

    public function getFilteredMarkersCountProperty(): int
    {
        return count(// @var mixed markers;
    }

    /**
     * Ottiene il MIME type per il formato di esportazione.
     */
    private function getMimeType(string $format): string
    {
        return match ($format) {
            'csv' => 'text/csv',
            'geojson' => 'application/geo+json',
            'kml' => 'application/vnd.google-earth.kml+xml',
            default => 'application/json',
        };
    }
}
