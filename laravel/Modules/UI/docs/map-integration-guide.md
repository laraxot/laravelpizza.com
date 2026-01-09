# 🗺️ GUIDA INTEGRAZIONE MAPPA INTERATTIVA

**Modulo**: UI (User Interface)
**Data**: 2025-01-27
**Versione**: 1.0
**Stato**: 🚧 IN SVILUPPO

---

## 🎯 PANORAMICA

Questa guida descrive l'integrazione di funzionalità mappa interattiva nel modulo UI, ispirate al progetto [farmshops.eu](https://farmshops.eu/). L'obiettivo è fornire componenti riutilizzabili per visualizzazioni geografiche in tutta l'applicazione FixCity.

---

## 🏗️ ARCHITETTURA COMPONENTI

### 📦 Struttura Modulo UI Estesa

```
Modules/UI/
├── App/
│   ├── Components/
│   │   ├── Map/
│   │   │   ├── InteractiveMap.php
│   │   │   ├── MapMarker.php
│   │   │   ├── MapFilter.php
│   │   │   └── MapPopup.php
│   │   └── Geo/
│   │       ├── LocationPicker.php
│   │       ├── AddressAutocomplete.php
│   │       └── GeocodingInput.php
│   ├── Services/
│   │   ├── MapService.php
│   │   ├── GeocodingService.php
│   │   └── MapDataService.php
│   └── Http/Controllers/
│       └── MapController.php
├── Resources/
│   ├── js/
│   │   ├── map/
│   │   │   ├── map-core.js
│   │   │   ├── map-filters.js
│   │   │   ├── map-markers.js
│   │   │   └── map-popup.js
│   │   └── components/
│   │       ├── location-picker.js
│   │       └── address-autocomplete.js
│   ├── css/
│   │   ├── map/
│   │   │   ├── map-core.css
│   │   │   ├── map-markers.css
│   │   │   └── map-popup.css
│   │   └── components/
│   │       ├── location-picker.css
│   │       └── address-autocomplete.css
│   └── views/
│       ├── components/
│       │   ├── map/
│       │   │   ├── interactive-map.blade.php
│       │   │   ├── map-marker.blade.php
│       │   │   └── map-popup.blade.php
│       │   └── geo/
│       │       ├── location-picker.blade.php
│       │       └── address-autocomplete.blade.php
│       └── pages/
│           ├── map-dashboard.blade.php
│           └── map-settings.blade.php
└── docs/
    ├── map-integration-guide.md
    ├── component-api.md
    └── styling-guide.md
```

---

## 🎨 COMPONENTI UI

### 🗺️ InteractiveMap Component

#### 📋 Caratteristiche
- **Mappa Leaflet.js** integrata
- **Marker personalizzati** per diverse categorie
- **Filtri dinamici** per contenuto
- **Popup informativi** con dettagli
- **Responsive design** per mobile/desktop
- **Accessibilità** completa

#### 💻 Implementazione

```php
<?php

namespace Modules\UI\App\Components\Map;

use Livewire\Component;

class InteractiveMap extends Component
{
    public $center = [49.0069, 8.4037];
    public $zoom = 6;
    public $markers = [];
    public $filters = [];
    public $selectedMarker = null;

    protected $listeners = [
        'markerSelected' => 'selectMarker',
        'filtersChanged' => 'updateFilters'
    ];

    public function render()
    {
        return view('ui::components.map.interactive-map');
    }

    public function selectMarker($markerId)
    {
        $this->selectedMarker = $markerId;
        $this->emit('markerSelected', $markerId);
    }

    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->loadMarkers();
    }

    private function loadMarkers()
    {
        // Carica marker basati sui filtri
        $this->markers = app(MapDataService::class)
            ->getMarkers($this->filters);
    }
}
```

#### 🎨 Template Blade

```blade
<!-- resources/views/components/map/interactive-map.blade.php -->
<div class="interactive-map-container">
    <div class="map-controls">
        <div class="filters-panel">
            <h4>Filtri</h4>
            <div class="filter-group">
                <label>
                    <input type="checkbox" wire:model="filters.tickets" value="tickets">
                    Ticket
                </label>
                <label>
                    <input type="checkbox" wire:model="filters.users" value="users">
                    Utenti
                </label>
                <label>
                    <input type="checkbox" wire:model="filters.locations" value="locations">
                    Luoghi
                </label>
            </div>
        </div>

        <div class="map-actions">
            <button wire:click="resetView" class="btn btn-secondary">
                <i class="fas fa-home"></i> Reset Vista
            </button>
            <button wire:click="exportData" class="btn btn-primary">
                <i class="fas fa-download"></i> Esporta
            </button>
        </div>
    </div>

    <div id="map" class="map-container" wire:ignore></div>

    @if($selectedMarker)
        <div class="marker-details">
            <h5>{{ $selectedMarker['title'] }}</h5>
            <p>{{ $selectedMarker['description'] }}</p>
            <div class="marker-actions">
                <a href="{{ $selectedMarker['url'] }}" class="btn btn-sm btn-primary">
                    Visualizza Dettagli
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inizializza mappa Leaflet
    const map = L.map('map').setView([{{ $center[0] }}, {{ $center[1] }}], {{ $zoom }});

    // Aggiungi layer OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Carica marker
    @foreach($markers as $marker)
        const marker{{ $marker['id'] }} = L.marker([{{ $marker['lat'] }}, {{ $marker['lng'] }}])
            .addTo(map)
            .bindPopup(`
                <div class="marker-popup">
                    <h6>{{ $marker['title'] }}</h6>
                    <p>{{ $marker['description'] }}</p>
                    <button onclick="Livewire.emit('markerSelected', {{ $marker['id'] }})">
                        Seleziona
                    </button>
                </div>
            `);
    @endforeach
});
</script>
@endpush
```

### 📍 LocationPicker Component

#### 📋 Caratteristiche
- **Input con autocompletamento** per indirizzi
- **Mappa integrata** per selezione visiva
- **Geocoding** automatico
- **Validazione** coordinate
- **Supporto mobile** ottimizzato

#### 💻 Implementazione

```php
<?php

namespace Modules\UI\App\Components\Geo;

use Livewire\Component;

class LocationPicker extends Component
{
    public $address = '';
    public $latitude = null;
    public $longitude = null;
    public $showMap = false;
    public $suggestions = [];

    protected $rules = [
        'address' => 'required|string|max:255',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180'
    ];

    public function updatedAddress()
    {
        if (strlen($this->address) > 3) {
            $this->suggestions = app(GeocodingService::class)
                ->getSuggestions($this->address);
        }
    }

    public function selectSuggestion($suggestion)
    {
        $this->address = $suggestion['address'];
        $this->latitude = $suggestion['lat'];
        $this->longitude = $suggestion['lng'];
        $this->suggestions = [];
        $this->showMap = true;
    }

    public function toggleMap()
    {
        $this->showMap = !$this->showMap;
    }

    public function render()
    {
        return view('ui::components.geo.location-picker');
    }
}
```

### 🎨 Styling CSS

```css
/* resources/css/map/map-core.css */
.interactive-map-container {
    position: relative;
    height: 500px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.map-container {
    height: 100%;
    width: 100%;
}

.map-controls {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 1000;
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 300px;
}

.filters-panel h4 {
    margin-bottom: 10px;
    color: #333;
    font-size: 14px;
    font-weight: 600;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    cursor: pointer;
}

.map-actions {
    margin-top: 15px;
    display: flex;
    gap: 8px;
}

.map-actions .btn {
    padding: 6px 12px;
    font-size: 12px;
}

.marker-details {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 300px;
    z-index: 1000;
}

.marker-popup {
    text-align: center;
}

.marker-popup h6 {
    margin-bottom: 8px;
    color: #333;
}

.marker-popup button {
    background: #007bff;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .map-controls {
        position: relative;
        top: auto;
        left: auto;
        max-width: 100%;
        margin-bottom: 10px;
    }

    .interactive-map-container {
        height: 400px;
    }
}
```

---

## 🔌 API E SERVIZI

### 🗺️ MapService

```php
<?php

namespace Modules\UI\App\Services;

class MapService
{
    public function getMarkers(array $filters = []): array
    {
        $markers = [];

        if (isset($filters['tickets'])) {
            $markers = array_merge($markers, $this->getTicketMarkers());
        }

        if (isset($filters['users'])) {
            $markers = array_merge($markers, $this->getUserMarkers());
        }

        if (isset($filters['locations'])) {
            $markers = array_merge($markers, $this->getLocationMarkers());
        }

        return $markers;
    }

    private function getTicketMarkers(): array
    {
        return Ticket::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'type' => 'ticket',
                    'lat' => $ticket->latitude,
                    'lng' => $ticket->longitude,
                    'title' => $ticket->name,
                    'description' => $ticket->description,
                    'status' => $ticket->status->slug,
                    'priority' => $ticket->priority->slug,
                    'url' => route('fixcity.tickets.show', $ticket)
                ];
            })
            ->toArray();
    }

    public function exportData(array $filters = [], string $format = 'json'): string
    {
        $markers = $this->getMarkers($filters);

        switch ($format) {
            case 'csv':
                return $this->exportToCsv($markers);
            case 'geojson':
                return $this->exportToGeoJson($markers);
            default:
                return json_encode($markers, JSON_PRETTY_PRINT);
        }
    }
}
```

### 🌍 GeocodingService

```php
<?php

namespace Modules\UI\App\Services;

class GeocodingService
{
    public function getSuggestions(string $query): array
    {
        // Implementa geocoding con provider esterno
        $response = Http::get('https://api.example.com/geocode', [
            'q' => $query,
            'limit' => 5
        ]);

        return $response->json()['results'] ?? [];
    }

    public function geocodeAddress(string $address): array
    {
        // Implementa geocoding completo
        $response = Http::get('https://api.example.com/geocode', [
            'address' => $address
        ]);

        $data = $response->json();

        return [
            'address' => $data['formatted_address'],
            'latitude' => $data['geometry']['location']['lat'],
            'longitude' => $data['geometry']['location']['lng']
        ];
    }
}
```

---

## 🎯 CASI D'USO

### 1. **Dashboard Ticket Geografica**
```blade
<!-- Pagina dashboard con mappa ticket -->
@extends('ui::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <livewire:ui::components.map.interactive-map
                :filters="['tickets' => true]"
                :center="[45.4642, 9.1900]"
                :zoom="10"
            />
        </div>
        <div class="col-md-4">
            <livewire:fixcity::components.ticket-stats />
        </div>
    </div>
</div>
@endsection
```

### 2. **Selezione Posizione in Form**
```blade
<!-- Form con selezione posizione -->
<form wire:submit.prevent="saveTicket">
    <div class="form-group">
        <label>Nome Ticket</label>
        <input type="text" wire:model="name" class="form-control">
    </div>

    <div class="form-group">
        <label>Posizione</label>
        <livewire:ui::components.geo.location-picker
            wire:model="location"
        />
    </div>

    <button type="submit" class="btn btn-primary">Salva</button>
</form>
```

### 3. **Mappa Utenti**
```blade
<!-- Mappa con utenti georeferenziati -->
<livewire:ui::components.map.interactive-map
    :filters="['users' => true]"
    :center="[45.4642, 9.1900]"
    :zoom="8"
/>
```

---

## 🚀 ROADMAP IMPLEMENTAZIONE

### 📅 Fase 1: Fondamenta (Settimana 1)
- [ ] Setup modulo UI esteso
- [ ] Integrazione Leaflet.js
- [ ] Componente InteractiveMap base
- [ ] Styling CSS base

### 📅 Fase 2: Componenti Core (Settimana 2)
- [ ] LocationPicker component
- [ ] AddressAutocomplete component
- [ ] MapService implementation
- [ ] GeocodingService implementation

### 📅 Fase 3: Integrazione (Settimana 3)
- [ ] Integrazione con modulo Fixcity
- [ ] Integrazione con modulo User
- [ ] API endpoints per mappa
- [ ] Testing componenti

### 📅 Fase 4: Ottimizzazione (Settimana 4)
- [ ] Performance optimization
- [ ] Mobile responsiveness
- [ ] Accessibility compliance
- [ ] Documentation completa

---

## 📚 RISORSE E RIFERIMENTI

### 🔗 Link Utili
- [Leaflet.js Documentation](https://leafletjs.com/)
- [OpenStreetMap Wiki](https://wiki.openstreetmap.org/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [Livewire Components](https://laravel-livewire.com/docs/2.x/quickstart)

### 📖 Documentazione Correlata
- [Farmshops.eu Analysis](../Geo/docs/farmshops-analysis.md)
- [Geo Module Documentation](../Geo/docs/)
- [UI Component API](component-api.md)
- [Styling Guide](styling-guide.md)

---

**Last Updated**: 2025-01-27
**Next Review**: 2025-02-27
**Status**: 🚧 IN SVILUPPO
**Confidence Level**: 90%

---

*Questa guida fornisce le basi per implementare funzionalità mappa interattiva nel modulo UI, migliorando significativamente l'esperienza utente con visualizzazioni geografiche avanzate.*
