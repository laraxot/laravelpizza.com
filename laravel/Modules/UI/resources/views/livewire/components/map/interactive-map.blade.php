<div class="interactive-map-container" wire:ignore.self>
    <!-- Controlli mappa -->
    @if($showControls)
        <div class="map-controls">
            <!-- Ricerca -->
            <div class="controls-section">
                <h5 class="controls-title">
                    <i class="fas fa-search"></i> Ricerca
                </h5>
                <div class="search-container">
                    <div class="input-group">
                        <input 
                            type="text" 
                            wire:model.debounce.300ms="searchQuery"
                            class="form-control form-control-sm"
                            placeholder="Cerca indirizzo..."
                        >
                        <button 
                            wire:click="searchAddress"
                            class="btn btn-outline-primary btn-sm"
                            type="button"
                        >
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filtri tipo -->
            <div class="controls-section">
                <h5 class="controls-title">
                    <i class="fas fa-filter"></i> Tipo
                </h5>
                <div class="filter-group">
                    <label class="filter-option">
                        <input 
                            type="checkbox" 
                            wire:model="filters.tickets"
                            wire:change="loadMarkers"
                        >
                        <span class="filter-icon ticket-icon"></span>
                        <span class="filter-label">Ticket</span>
                        <span class="filter-count">({{ $stats['by_type']['ticket'] ?? 0 }})</span>
                    </label>
                    <label class="filter-option">
                        <input 
                            type="checkbox" 
                            wire:model="filters.users"
                            wire:change="loadMarkers"
                        >
                        <span class="filter-icon user-icon"></span>
                        <span class="filter-label">Utenti</span>
                        <span class="filter-count">({{ $stats['by_type']['user'] ?? 0 }})</span>
                    </label>
                    <label class="filter-option">
                        <input 
                            type="checkbox" 
                            wire:model="filters.locations"
                            wire:change="loadMarkers"
                        >
                        <span class="filter-icon location-icon"></span>
                        <span class="filter-label">Luoghi</span>
                        <span class="filter-count">({{ $stats['by_type']['location'] ?? 0 }})</span>
                    </label>
                </div>
            </div>

            <!-- Filtri stato (solo se ticket attivi) -->
            @if($filters['tickets'])
                <div class="controls-section">
                    <h5 class="controls-title">
                        <i class="fas fa-flag"></i> Stato Ticket
                    </h5>
                    <div class="filter-group">
                        <label class="filter-option">
                            <input 
                                type="checkbox" 
                                wire:model="filters.status"
                                value="pending"
                                wire:change="loadMarkers"
                            >
                            <span class="status-indicator status-pending"></span>
                            <span class="filter-label">In Attesa</span>
                            <span class="filter-count">({{ $stats['by_status']['pending'] ?? 0 }})</span>
                        </label>
                        <label class="filter-option">
                            <input 
                                type="checkbox" 
                                wire:model="filters.status"
                                value="assigned"
                                wire:change="loadMarkers"
                            >
                            <span class="status-indicator status-assigned"></span>
                            <span class="filter-label">Assegnato</span>
                            <span class="filter-count">({{ $stats['by_status']['assigned'] ?? 0 }})</span>
                        </label>
                        <label class="filter-option">
                            <input 
                                type="checkbox" 
                                wire:model="filters.status"
                                value="in_progress"
                                wire:change="loadMarkers"
                            >
                            <span class="status-indicator status-in-progress"></span>
                            <span class="filter-label">In Corso</span>
                            <span class="filter-count">({{ $stats['by_status']['in_progress'] ?? 0 }})</span>
                        </label>
                        <label class="filter-option">
                            <input 
                                type="checkbox" 
                                wire:model="filters.status"
                                value="resolved"
                                wire:change="loadMarkers"
                            >
                            <span class="status-indicator status-resolved"></span>
                            <span class="filter-label">Risolto</span>
                            <span class="filter-count">({{ $stats['by_status']['resolved'] ?? 0 }})</span>
                        </label>
                    </div>
                </div>
            @endif

            <!-- Azioni -->
            <div class="controls-section">
                <h5 class="controls-title">
                    <i class="fas fa-tools"></i> Azioni
                </h5>
                <div class="action-buttons">
                    <button 
                        wire:click="resetView" 
                        class="btn btn-outline-secondary btn-sm"
                    >
                        <i class="fas fa-home"></i> Reset Vista
                    </button>
                    <button 
                        wire:click="exportData('json')" 
                        class="btn btn-outline-primary btn-sm"
                    >
                        <i class="fas fa-download"></i> Esporta JSON
                    </button>
                    <button 
                        wire:click="exportData('csv')" 
                        class="btn btn-outline-success btn-sm"
                    >
                        <i class="fas fa-file-csv"></i> Esporta CSV
                    </button>
                    <button 
                        wire:click="clearFilters" 
                        class="btn btn-outline-warning btn-sm"
                    >
                        <i class="fas fa-times"></i> Pulisci Filtri
                    </button>
                </div>
            </div>

            <!-- Statistiche -->
            <div class="controls-section">
                <h5 class="controls-title">
                    <i class="fas fa-chart-bar"></i> Statistiche
                </h5>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-value">{{ $stats['total_markers'] ?? 0 }}</span>
                        <span class="stat-label">Totale Marker</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $visibleMarkersCount }}</span>
                        <span class="stat-label">Visibili</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $filteredMarkersCount }}</span>
                        <span class="stat-label">Filtrati</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Toggle controlli -->
    <button 
        wire:click="toggleControls"
        class="map-controls-toggle"
    >
        <i class="fas fa-{{ $showControls ? 'times' : 'bars' }}"></i>
    </button>

    <!-- Mappa -->
    <div id="map-{{ $this->id }}" class="map-container" wire:ignore></div>

    <!-- Loading overlay -->
    @if($isLoading)
        <div class="map-loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Caricamento...</span>
            </div>
            <p>Caricamento marker...</p>
        </div>
    @endif

    <!-- Dettagli marker selezionato -->
    @if($selectedMarker)
        <div class="marker-details">
            <div class="marker-details-header">
                <h6>{{ $selectedMarker['title'] }}</h6>
                <button 
                    wire:click="$set('selectedMarker', null)"
                    class="btn-close"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="marker-details-content">
                <p class="marker-description">{{ $selectedMarker['description'] }}</p>
                
                @if($selectedMarker['type'] === 'ticket')
                    <div class="ticket-info">
                        <div class="ticket-meta">
                            <span class="badge badge-{{ $selectedMarker['status'] }}">
                                {{ ucfirst($selectedMarker['status']) }}
                            </span>
                            <span class="badge badge-{{ $selectedMarker['priority'] }}">
                                {{ ucfirst($selectedMarker['priority']) }}
                            </span>
                        </div>
                        <div class="ticket-details">
                            <small class="text-muted">
                                <i class="fas fa-user"></i> {{ $selectedMarker['user_name'] ?? 'Sconosciuto' }}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> {{ $selectedMarker['created_at'] ?? 'N/A' }}
                            </small>
                        </div>
                    </div>
                @endif
            </div>
            <div class="marker-details-actions">
                <a 
                    href="{{ $selectedMarker['url'] }}" 
                    class="btn btn-primary btn-sm"
                    target="_blank"
                >
                    <i class="fas fa-eye"></i> Visualizza
                </a>
                <button 
                    wire:click="$set('selectedMarker', null)"
                    class="btn btn-outline-secondary btn-sm"
                >
                    <i class="fas fa-times"></i> Chiudi
                </button>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inizializza mappa Leaflet
    const mapId = 'map-{{ $this->id }}';
    const map = L.map(mapId).setView([{{ $center[0] }}, {{ $center[1] }}], {{ $zoom }});
    
    // Aggiungi layer OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Layer per i marker
    const markersLayer = L.layerGroup().addTo(map);
    
    // Funzione per aggiornare i marker
    function updateMarkers(markers) {
        markersLayer.clearLayers();
        
        markers.forEach(marker => {
            const leafletMarker = L.marker([marker.lat, marker.lng])
                .addTo(markersLayer)
                .bindPopup(`
                    <div class="marker-popup">
                        <h6>${marker.title}</h6>
                        <p>${marker.description}</p>
                        <button onclick="Livewire.emit('markerSelected', ${marker.id})">
                            Seleziona
                        </button>
                    </div>
                `);
                
            // Aggiungi classe CSS per il tipo
            leafletMarker.getElement().classList.add(`marker-${marker.type}`);
            
            // Aggiungi classe per priorità se è un ticket
            if (marker.type === 'ticket' && marker.priority) {
                leafletMarker.getElement().classList.add(`marker-priority-${marker.priority}`);
            }
        });
    }
    
    // Carica marker iniziali
    updateMarkers(@json($markers));
    
    // Listener per aggiornamenti Livewire
    Livewire.on('markersUpdated', (markers) => {
        updateMarkers(markers);
    });
    
    // Listener per reset vista
    Livewire.on('resetMapView', () => {
        map.setView([{{ $center[0] }}, {{ $center[1] }}], {{ $zoom }});
    });
    
    // Listener per aggiornamento centro
    Livewire.on('updateMapCenter', (center, zoom) => {
        map.setView(center, zoom);
    });
    
    // Listener per bounds
    map.on('moveend', function() {
        const bounds = map.getBounds();
        Livewire.emit('mapBoundsChanged', {
            north: bounds.getNorth(),
            south: bounds.getSouth(),
            east: bounds.getEast(),
            west: bounds.getWest()
        });
    });
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
.interactive-map-container {
    position: relative;
    height: 600px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.map-container {
    height: 100%;
    width: 100%;
}

.map-controls {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 1000;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 20px;
    max-width: 320px;
    max-height: 80vh;
    overflow-y: auto;
}

.map-controls-toggle {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 1001;
    background: white;
    border: none;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #007bff;
}

.map-loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.marker-details {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    max-width: 320px;
    z-index: 1000;
}

.marker-details-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-radius: 12px 12px 0 0;
}

.marker-details-content {
    padding: 20px;
}

.marker-details-actions {
    padding: 16px 20px;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
    border-radius: 0 0 12px 12px;
    display: flex;
    gap: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .map-controls {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        bottom: 0;
        max-width: 100%;
        border-radius: 0;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .map-controls.open {
        transform: translateX(0);
    }
    
    .interactive-map-container {
        height: 500px;
    }
}
</style>
@endpush






