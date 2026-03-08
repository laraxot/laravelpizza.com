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
            $center = $center;
        }

        if ($zoom) {
            $zoom = $zoom;
        }

        if ($filters) {
            $filters = array_merge($this->filters, $filters);
        }

        $this->loadMarkers();
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
        $marker = collect($markers
            ->firstWhere('id', $markerId);

        $selectedMarker = is_array($marker);

        $this->dispatch('markerSelected', $this->selectedMarker);
    }

    /**
     * Aggiorna i filtri.
     */
    public function updateFilters(array $filters): void
    {
        $filters = array_merge($this->filters, $filters);
        $this->loadMarkers();
    }

    /**
     * Aggiorna i bounds della mappa.
     */
    public function updateBounds(array $bounds): void
    {
        $filters['bounds'] = $bounds;
        $this->loadMarkers();
    }

    /**
     * Carica i marker.
     */
    public function loadMarkers(): void
    {
        $isLoading = true;

        try {
            /** @phpstan-ignore-next-line class.notFound */
            $mapService = app(MapService::class);
            /* @phpstan-ignore-next-line class.notFound, assign.propertyType */
            $markers = $mapService->getMarkers($this->filters);
            /* @phpstan-ignore-next-line class.notFound, assign.propertyType */
            $stats = $mapService->getMapStats($this->filters);
        } catch (\Exception $e) {
            $this->addError('map', 'Errore nel caricamento dei marker: '.$e->getMessage());
            $markers = [];
            $stats = [];
        } finally {
            $isLoading = false;
        }
    }

    /**
     * Resetta la vista della mappa.
     */
    public function resetView(): void
    {
        $this->dispatch('resetMapView');
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
            $data = $mapService->exportData($filters, $format);

            $filename = 'map_export_'.now()->format('Y_m_d_H_i_s').'.'.$format;

            $this->dispatch('downloadFile', [
                'content' => $data,
                'filename' => $filename,
                'mimeType' => $this->getMimeType($format)
            ]);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Dati esportati con successo!',
            ]);
        } catch (\Exception $e) {
            $this->addError('export', 'Errore nell\'esportazione: '.$e->getMessage());
        }
    }

    /**
     * Cerca un indirizzo.
     */
    public function searchAddress(): void
    {
        if (empty($searchQuery
            return;
        }

        try {
            /** @phpstan-ignore-next-line class.notFound */
            $geocodingService = app(GeocodingService::class);
            /** @phpstan-ignore-next-line class.notFound */
            $result = $geocodingService->geocodeAddress($searchQuery);
            Assert::isArray($result, 'Geocoding result must be array');

            $address = $result['address'] ?? '';
            Assert::string($address, 'Address must be string');

            $center = [$result['latitude'], $result['longitude']];
            $zoom = 15;

            $this->dispatch('updateMapCenter', $this->center, $this->zoom);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Indirizzo trovato: '.$address,
            ]);
        } catch (\Exception $e) {
            $this->addError('search', 'Indirizzo non trovato: '.$e->getMessage());
        }
    }

    /**
     * Ottiene suggerimenti per la ricerca.
     */
    public function getSuggestions(): array
    {
        if (strlen($searchQuery
            return [];
        }

        try {
            /** @phpstan-ignore-next-line class.notFound */
            $geocodingService = app(GeocodingService::class);

            /* @phpstan-ignore-next-line class.notFound, return.type */
            return $geocodingService->getSuggestions($searchQuery);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Toggle controlli mappa.
     */
    public function toggleControls(): void
    {
        $showControls = ! $this->showControls;
    }

    /**
     * Filtra per tipo.
     */
    public function filterByType(string $type, bool $enabled): void
    {
        $filters[$type] = $enabled;
        $this->loadMarkers();
    }

    /**
     * Filtra per stato.
     */
    public function filterByStatus(string $status, bool $enabled): void
    {
        $currentStatus = $filters['status'] ?? [];
        Assert::isArray($currentStatus, 'Status filter must be array');

        if ($enabled) {
            $currentStatus[] = $status;
            $filters['status'] = array_unique($currentStatus);
            $this->loadMarkers();

            return;
        }

        $currentStatus = array_diff($currentStatus, [$status]);
        $filters['status'] = array_unique($currentStatus);
        $this->loadMarkers();
    }

    /**
     * Filtra per priorità.
     */
    public function filterByPriority(string $priority, bool $enabled): void
    {
        $currentPriority = $filters['priority'] ?? [];
        Assert::isArray($currentPriority, 'Priority filter must be array');

        if ($enabled) {
            $currentPriority[] = $priority;
            $filters['priority'] = array_unique($currentPriority);
            $this->loadMarkers();

            return;
        }

        $currentPriority = array_diff($currentPriority, [$priority]);
        $filters['priority'] = array_unique($currentPriority);
        $this->loadMarkers();
    }

    /**
     * Pulisce tutti i filtri.
     */
    public function clearFilters(): void
    {
        $filters = [
            'tickets' => true,
            'users' => false,
            'locations' => false,
            'status' => [],
            'priority' => [],
            'type' => [],
            'roles' => [],
            'location_types' => [],
        ];

        $this->loadMarkers();
    }

    /**
     * Ottiene le proprietà computate.
     */
    public function getMarkersByTypeProperty(): array
    {
        return collect($markers
            ->groupBy('type')
            ->map(fn ($markers) => $markers->count())
            ->toArray();
    }

    public function getVisibleMarkersCountProperty(): int
    {
        return count($markers);
    }

    public function getFilteredMarkersCountProperty(): int
    {
        return count($markers);
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
