# 🗺️ FARMSHOPS.EU - INTEGRATION GUIDE

**Data**: 2025-10-02  
**Source**: https://github.com/CodeforKarlsruhe/farmshops.eu  
**Purpose**: Integrare tecnologie e pattern da farmshops.eu in FixCity  

---

## 📊 ANALISI PROGETTO FARMSHOPS.EU

### Scopo
Mappa interattiva di negozi agricoli, distributori automatici di latte e altri venditori diretti nella regione DACH (Germania, Austria, Svizzera) usando dati OpenStreetMap.

### Stack Tecnologico
- **Leaflet.js** - Libreria mappe interattive
- **Leaflet Extra Markers** - Marker personalizzati
- **Leaflet Marker Clusterer** - Raggruppamento marker
- **Leaflet Permalinks** - URL permanenti
- **Leaflet Sidebar v2** - Sidebar laterale
- **Leaflet LocateControl** - Geolocalizzazione
- **Opening Hours.js** - Gestione orari apertura
- **Query-Overpass** - Import dati OSM
- **Overpass Turbo** - Query OSM API

### Features Principali
✅ Visualizzazione punti da OpenStreetMap  
✅ Marker differenziati per tipo  
✅ Clustering automatico  
✅ Popup informativi  
✅ Link a OSM, Google Maps, OpenRouteService  
✅ Gestione punti e poligoni  
✅ Permalinks con posizione e zoom  
✅ Geolocalizzazione utente  
✅ Orari di apertura  

---

## 🎯 APPLICABILITÀ A FIXCITY

### Similitudini con FixCity
1. **Gestione Punti Geografici** - Tickets come farmshops
2. **Visualizzazione Mappa** - Entrambi necessitano mappe interattive
3. **Dati OpenStreetMap** - Geocoding e reverse geocoding
4. **Clustering** - Raggruppamento segnalazioni vicine
5. **Popup Informativi** - Dettagli ticket/segnalazione
6. **Geolocalizzazione** - Trovare segnalazioni vicine

### Differenze
- Farmshops: Dati statici da OSM
- FixCity: Dati dinamici da database
- Farmshops: Solo visualizzazione
- FixCity: CRUD completo + workflow

---

## 🚀 FEATURES DA INTEGRARE

### 1. Leaflet.js Map Component (HIGH PRIORITY)

**Cosa**: Mappa interattiva con Leaflet invece di Google Maps

**Benefici**:
- ✅ Open Source e gratuito
- ✅ Altamente personalizzabile
- ✅ Ottima performance
- ✅ Mobile-friendly
- ✅ Plugin ecosystem ricco

**Implementazione**:
```javascript
// resources/js/components/LeafletMap.js
import L from 'leaflet';
import 'leaflet.markercluster';

export class TicketMap {
    constructor(elementId, options = {}) {
        this.map = L.map(elementId).setView(
            options.center || [45.4642, 9.1900], 
            options.zoom || 13
        );
        
        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);
        
        // Initialize marker cluster
        this.markerCluster = L.markerClusterGroup();
        this.map.addLayer(this.markerCluster);
    }
    
    addTicket(ticket) {
        const marker = L.marker([ticket.latitude, ticket.longitude], {
            icon: this.getIconByStatus(ticket.status)
        });
        
        marker.bindPopup(this.createPopup(ticket));
        this.markerCluster.addLayer(marker);
    }
    
    getIconByStatus(status) {
        const colors = {
            'open': 'red',
            'in_progress': 'orange',
            'resolved': 'green',
            'closed': 'gray'
        };
        
        return L.ExtraMarkers.icon({
            icon: 'fa-exclamation',
            markerColor: colors[status] || 'blue',
            shape: 'circle',
            prefix: 'fa'
        });
    }
    
    createPopup(ticket) {
        return `
            <div class="ticket-popup">
                <h3>${ticket.title}</h3>
                <p><strong>Status:</strong> ${ticket.status}</p>
                <p><strong>Priority:</strong> ${ticket.priority}</p>
                <p>${ticket.description}</p>
                <a href="/tickets/${ticket.id}">View Details</a>
            </div>
        `;
    }
}
```

### 2. Marker Clustering (HIGH PRIORITY)

**Cosa**: Raggruppamento automatico di segnalazioni vicine

**Benefici**:
- ✅ Performance con molti marker
- ✅ UI pulita e leggibile
- ✅ Zoom progressivo
- ✅ Contatori automatici

**Implementazione**:
```javascript
// Automatic clustering
const markers = L.markerClusterGroup({
    maxClusterRadius: 50,
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: true,
    zoomToBoundsOnClick: true
});

tickets.forEach(ticket => {
    const marker = L.marker([ticket.latitude, ticket.longitude]);
    marker.bindPopup(createTicketPopup(ticket));
    markers.addLayer(marker);
});

map.addLayer(markers);
```

### 3. Sidebar Component (MEDIUM PRIORITY)

**Cosa**: Pannello laterale con lista segnalazioni

**Benefici**:
- ✅ Navigazione facile
- ✅ Filtri integrati
- ✅ Dettagli rapidi
- ✅ Mobile responsive

**Implementazione**:
```javascript
import 'leaflet-sidebar-v2';

const sidebar = L.control.sidebar({
    autopan: true,
    closeButton: true,
    container: 'sidebar',
    position: 'left'
}).addTo(map);

sidebar.addPanel({
    id: 'tickets',
    tab: '<i class="fa fa-list"></i>',
    title: 'Tickets',
    pane: '<div id="ticket-list"></div>'
});
```

### 4. Geolocation Control (HIGH PRIORITY)

**Cosa**: Bottone "Trova segnalazioni vicine"

**Benefici**:
- ✅ UX migliorata
- ✅ Accessibilità mobile
- ✅ Filtro geografico automatico

**Implementazione**:
```javascript
import 'leaflet.locatecontrol';

L.control.locate({
    position: 'topright',
    strings: {
        title: "Mostra la mia posizione"
    },
    locateOptions: {
        maxZoom: 16
    }
}).addTo(map);
```

### 5. Permalinks (MEDIUM PRIORITY)

**Cosa**: URL con posizione e zoom salvati

**Benefici**:
- ✅ Condivisione facile
- ✅ Bookmark specifici
- ✅ Deep linking

**Implementazione**:
```javascript
import 'leaflet.permalink';

const permalink = new L.Permalink(map);
```

### 6. Opening Hours Integration (LOW PRIORITY)

**Cosa**: Gestione orari per uffici/servizi

**Benefici**:
- ✅ Mostra se ufficio aperto
- ✅ Prossimo orario apertura
- ✅ Standard OSM

**Implementazione**:
```javascript
import opening_hours from 'opening_hours';

const oh = new opening_hours('Mo-Fr 08:00-17:00');
const isOpen = oh.getState();
const nextChange = oh.getNextChange();
```

---

## 📦 PACKAGE.JSON ADDITIONS

```json
{
  "dependencies": {
    "leaflet": "^1.9.4",
    "leaflet.markercluster": "^1.5.3",
    "leaflet-extra-markers": "^1.2.2",
    "leaflet.permalink": "^1.0.0",
    "leaflet-sidebar-v2": "^3.2.3",
    "leaflet.locatecontrol": "^0.79.0",
    "opening_hours": "^3.8.0"
  }
}
```

---

## 🎨 LIVEWIRE COMPONENT

```php
<?php

namespace Modules\Fixcity\Livewire;

use Livewire\Component;
use Modules\Fixcity\Models\Ticket;

class TicketMap extends Component
{
    public $center = [45.4642, 9.1900];
    public $zoom = 13;
    public $filters = [];
    
    public function mount()
    {
        // Get user location or default
        $this->center = $this->getUserLocation();
    }
    
    public function getTicketsProperty()
    {
        return Ticket::query()
            ->with(['owner', 'category'])
            ->when($this->filters, function ($query) {
                // Apply filters
            })
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'title' => $ticket->name,
                    'latitude' => $ticket->latitude,
                    'longitude' => $ticket->longitude,
                    'status' => $ticket->status,
                    'priority' => $ticket->priority,
                    'description' => $ticket->content,
                    'category' => $ticket->category->name ?? null,
                ];
            });
    }
    
    public function render()
    {
        return view('fixcity::livewire.ticket-map', [
            'tickets' => $this->tickets,
        ]);
    }
}
```

---

## 🗺️ BLADE TEMPLATE

```blade
<div wire:ignore>
    <div id="ticket-map" style="height: 600px;"></div>
    
    <div id="sidebar" class="leaflet-sidebar collapsed">
        <div class="leaflet-sidebar-tabs">
            <ul role="tablist">
                <li><a href="#tickets" role="tab"><i class="fa fa-list"></i></a></li>
                <li><a href="#filters" role="tab"><i class="fa fa-filter"></i></a></li>
            </ul>
        </div>
        
        <div class="leaflet-sidebar-content">
            <div class="leaflet-sidebar-pane" id="tickets">
                <h1 class="leaflet-sidebar-header">
                    Segnalazioni
                    <span class="leaflet-sidebar-close"><i class="fa fa-times"></i></span>
                </h1>
                <div id="ticket-list">
                    @foreach($tickets as $ticket)
                        <div class="ticket-item" data-ticket-id="{{ $ticket['id'] }}">
                            <h4>{{ $ticket['title'] }}</h4>
                            <span class="badge badge-{{ $ticket['status'] }}">
                                {{ $ticket['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tickets = @json($tickets);
        const map = new TicketMap('ticket-map', {
            center: @json($center),
            zoom: {{ $zoom }}
        });
        
        tickets.forEach(ticket => map.addTicket(ticket));
    });
</script>
@endpush
```

---

## 🔧 IMPLEMENTATION PLAN

### Phase 1: Core Map (Week 1)
1. [ ] Install Leaflet.js packages
2. [ ] Create TicketMap Livewire component
3. [ ] Implement basic map display
4. [ ] Add ticket markers
5. [ ] Create popup templates

### Phase 2: Advanced Features (Week 2)
6. [ ] Implement marker clustering
7. [ ] Add geolocation control
8. [ ] Create sidebar component
9. [ ] Implement filters
10. [ ] Add permalinks

### Phase 3: Polish (Week 3)
11. [ ] Custom marker icons per status
12. [ ] Responsive design
13. [ ] Performance optimization
14. [ ] Documentation
15. [ ] Testing

---

## 🎯 BENEFITS FOR FIXCITY

### User Experience
✅ **Mappa Interattiva** - Visualizzazione intuitiva  
✅ **Clustering** - Performance con molti ticket  
✅ **Geolocalizzazione** - Trova vicino a te  
✅ **Mobile-Friendly** - Touch ottimizzato  

### Technical
✅ **Open Source** - No costi licenza  
✅ **Performance** - Ottimizzato per grandi dataset  
✅ **Customizable** - Totalmente personalizzabile  
✅ **Plugin Ecosystem** - Tante estensioni  

### Business
✅ **AGID Compliant** - Accessibilità garantita  
✅ **No Vendor Lock-in** - Indipendenza  
✅ **Community Support** - Ampia community  
✅ **Future-Proof** - Tecnologia consolidata  

---

## 📚 RESOURCES

### Documentation
- [Leaflet.js Docs](https://leafletjs.com/reference.html)
- [Marker Cluster Plugin](https://github.com/Leaflet/Leaflet.markercluster)
- [Sidebar v2](https://github.com/Turbo87/sidebar-v2)
- [Farmshops.eu Source](https://github.com/CodeforKarlsruhe/farmshops.eu)

### Examples
- [Farmshops.eu Live](https://www.farmshops.eu/)
- [Leaflet Tutorials](https://leafletjs.com/examples.html)

---

**Status**: 📋 READY TO IMPLEMENT  
**Priority**: HIGH  
**Estimated Time**: 3 weeks  
**Impact**: MAJOR UX improvement  

*"Integrando le migliori pratiche da farmshops.eu, FixCity avrà una mappa interattiva di livello mondiale!"*
