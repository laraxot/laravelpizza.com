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
    /** @var array{0: float, 1: float} */
    public array $center = [45.4642, 9.1900]; // Milano

    public int $zoom = 10;

    /** @var array<int, array<string, mixed>> */
    public array $markers = [];

    /** @var array<string, mixed> */
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

    /** @var array<string, mixed>|null */
    public ?array $selectedMarker = null;

    /** @var array<string, mixed> */
    public array $stats = [];

    public bool $showControls = true;

    public bool $isLoading = false;

    public string $searchQuery = '';

    /**
     * Untyped to match HandlesEvents::$listeners.
     *
     * @var array<string, string>
     */
    protected $listeners = [
        'markerSelected' => 'selectMarker',
        'filtersChanged' => 'updateFilters',
        'mapBoundsChanged' => 'updateBounds',
        'refreshMap' => 'loadMarkers',
    ];

    /**
     * @param array{0: float, 1: float}|null $center
     * @param array<string, mixed>           $filters
     */
    public function mount(?array $center = null, ?int $zoom = null, array $filters = []): void
    {
        if ($center) {
            $this->center = $center;
        }

        if ($zoom) {
            $this->zoom = $zoom;
        }

        if ($filters) {
            $this->filters = array_merge($this->filters, $filters);
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
        $marker = collect($this->markers)
            ->firstWhere('id', $markerId);

        $this->selectedMarker = \is_array($marker) ? $marker : null;

        $this->dispatch('markerSelected', $this->selectedMarker);
    }

    /**
     * Aggiorna i filtri.
     *
     * @param array<string, mixed> $filters
     * @param array<string, mixed> $filters
     */
    public function updateFilters(array $filters): void
    {
        $this->filters = array_merge($this->filters, $filters);
        $this->loadMarkers();
    }

    /**
     * Aggiorna i bounds della mappa.
     */
    /**
     * @param array<string, float> $bounds
     */
    public function updateBounds(array $bounds): void
    {
        $this->filters['bounds'] = $bounds;
        $this->loadMarkers();
    }

    /**
     * Carica i marker.
     */
    public function loadMarkers(): void
    {
        $this->isLoading = true;

        try {
            $mapService = app(MapService::class);
            $filters = $this->getMapFilters();
            $this->markers = $mapService->getMarkers($filters);
            $this->stats = $mapService->getMapStats($filters);
        } catch (\Exception $e) {
            $this->addError('map', 'Errore nel caricamento dei marker: '.$e->getMessage());
            $this->markers = [];
            $this->stats = [];
        } finally {
            $this->isLoading = false;
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
            $mapService = app(MapService::class);
            $data = $mapService->exportData($this->getMapFilters(), $format);

            $filename = 'map_export_'.now()->format('Y_m_d_H_i_s').'.'.$format;

            $this->dispatch('downloadFile', [
                'content' => $data,
                'filename' => $filename,
                'mimeType' => $this->getMimeType($format),
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
        if (empty($this->searchQuery)) {
            return;
        }

        try {
            $geocodingService = app(GeocodingService::class);
            $result = $geocodingService->geocodeAddress($this->searchQuery);
            Assert::isArray($result, 'Geocoding result must be array');

            $address = $result['address'] ?? '';
            Assert::string($address, 'Address must be string');

            $this->center = [$result['latitude'], $result['longitude']];
            $this->zoom = 15;

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
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSuggestions(): array
    {
        if (\strlen($this->searchQuery) < 3) {
            return [];
        }

        try {
            $geocodingService = app(GeocodingService::class);

            /** @var array<int, array<string, mixed>> $suggestions */
            $suggestions = $geocodingService->getSuggestions($this->searchQuery);

            return $suggestions;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Toggle controlli mappa.
     */
    public function toggleControls(): void
    {
        $this->showControls = ! $this->showControls;
    }

    /**
     * Filtra per tipo.
     */
    public function filterByType(string $type, bool $enabled): void
    {
        $this->filters[$type] = $enabled;
        $this->loadMarkers();
    }

    /**
     * Filtra per stato.
     */
    public function filterByStatus(string $status, bool $enabled): void
    {
        $currentStatus = $this->filters['status'] ?? [];
        Assert::isArray($currentStatus, 'Status filter must be array');
        $statusList = array_values(array_filter(
            $currentStatus,
            static fn (mixed $value): bool => \is_string($value),
        ));

        if ($enabled) {
            $statusList[] = $status;
            $this->filters['status'] = array_values(array_unique($statusList));
            $this->loadMarkers();

            return;
        }

        $statusList = array_values(array_diff($statusList, [$status]));
        $this->filters['status'] = array_values(array_unique($statusList));
        $this->loadMarkers();
    }

    /**
     * Filtra per priorità.
     */
    public function filterByPriority(string $priority, bool $enabled): void
    {
        $currentPriority = $this->filters['priority'] ?? [];
        Assert::isArray($currentPriority, 'Priority filter must be array');
        $priorityList = array_values(array_filter(
            $currentPriority,
            static fn (mixed $value): bool => \is_string($value),
        ));

        if ($enabled) {
            $priorityList[] = $priority;
            $this->filters['priority'] = array_values(array_unique($priorityList));
            $this->loadMarkers();

            return;
        }

        $priorityList = array_values(array_diff($priorityList, [$priority]));
        $this->filters['priority'] = array_values(array_unique($priorityList));
        $this->loadMarkers();
    }

    /**
     * Pulisce tutti i filtri.
     */
    public function clearFilters(): void
    {
        $this->filters = [
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
     *
     * @return array<string, int>
     */
    public function getMarkersByTypeProperty(): array
    {
        /** @var array<string, int> $grouped */
        $grouped = collect($this->markers)
            ->groupBy('type')
            ->map(static fn ($markers) => $markers->count())
            ->all();

        return $grouped;
    }

    public function getVisibleMarkersCountProperty(): int
    {
        return \count($this->markers);
    }

    public function getFilteredMarkersCountProperty(): int
    {
        return \count($this->markers);
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

    /**
     * @return array<string, mixed>
     */
    private function getMapFilters(): array
    {
        $filters = [];

        foreach ($this->filters as $key => $value) {
            if (! \is_string($key)) {
                continue;
            }

            $filters[$key] = $value;
        }

        return $filters;
    }
}
