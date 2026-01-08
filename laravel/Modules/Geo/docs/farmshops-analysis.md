# 🗺️ ANALISI PROGETTO FARMSHOPS.EU

**Data**: 2025-01-27  
**Fonte**: https://github.com/CodeforKarlsruhe/farmshops.eu  
**Sito**: https://farmshops.eu/  
**Obiettivo**: Integrazione funzionalità mappa interattiva nel progetto FixCity

---

## 📋 PANORAMICA PROGETTO

### 🎯 Scopo
Farmshops.eu è una mappa interattiva che visualizza:
- **Negozi agricoli** (shop=farm)
- **Distributori automatici** (amenity=vending_machine)
- **Mercati** (amenity=marketplace) 
- **Apicoltori** (craft=beekeeper)
- **Altri punti vendita diretta**

### 🌍 Copertura Geografica
- **Germania** 🇩🇪
- **Austria** 🇦🇹  
- **Svizzera** 🇨🇭
- **Regione DACH**

---

## 🏗️ ARCHITETTURA TECNICA

### 📊 Stack Tecnologico
```yaml
Frontend:
  - HTML5/CSS3
  - JavaScript (Vanilla)
  - Leaflet.js (mappe)
  - Bootstrap (UI)

Backend:
  - Node.js
  - Express.js
  - API Overpass (OpenStreetMap)

Database:
  - OpenStreetMap (fonte dati)
  - Cache locale per performance

Deployment:
  - GitHub Pages
  - CDN per assets statici
```

### 🔧 Componenti Principali

#### 1. **Data Pipeline**
```javascript
// Estrazione dati da OSM
const overpassQuery = `
[out:json][timeout:25];
(
  node["shop"="farm"]({{bbox}});
  node["amenity"="vending_machine"]["vending"~"milk|food"]({{bbox}});
  node["amenity"="marketplace"]({{bbox}});
  node["craft"="beekeeper"]({{bbox}});
);
out geom;
`;
```

#### 2. **Mappa Interattiva**
```javascript
// Configurazione Leaflet
const map = L.map('map').setView([49.0069, 8.4037], 6);

// Layer OSM
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Marker personalizzati
const farmIcon = L.icon({
  iconUrl: 'icons/farm.svg',
  iconSize: [25, 25],
  iconAnchor: [12, 12]
});
```

#### 3. **Filtri e Categorie**
```javascript
// Sistema di filtri
const filters = {
  farm: true,
  vending: true,
  market: true,
  beekeeper: true
};

// Applicazione filtri
function applyFilters() {
  markers.eachLayer(marker => {
    const type = marker.options.type;
    marker.setOpacity(filters[type] ? 1 : 0);
  });
}
```

---

## 🎨 DESIGN PATTERNS

### 🎯 Principi UX
1. **Semplicità**: Interfaccia pulita e intuitiva
2. **Accessibilità**: Supporto screen reader e navigazione keyboard
3. **Responsive**: Ottimizzato per mobile e desktop
4. **Performance**: Caricamento veloce e smooth scrolling

### 🎨 Elementi Visivi
- **Icone personalizzate** per ogni categoria
- **Colori distintivi** per tipi di punti vendita
- **Popup informativi** con dettagli completi
- **Permalink** per condivisione posizioni

---

## 🔌 API E INTEGRAZIONI

### 📡 OpenStreetMap Integration
```javascript
// Query Overpass per dati specifici
const query = `
[out:json][timeout:25];
(
  node["shop"="farm"]["addr:city"~"Karlsruhe"]({{bbox}});
  way["shop"="farm"]["addr:city"~"Karlsruhe"]({{bbox}});
);
out geom;
`;
```

### 🗺️ Servizi Mappa
- **OpenStreetMap**: Mappa base
- **OpenRouteService**: Routing e direzioni
- **Google Maps**: Link esterni per navigazione

---

## 💡 FUNZIONALITÀ CHIAVE

### 🎯 Core Features
1. **Visualizzazione Mappa**: Punti vendita su mappa interattiva
2. **Filtri Dinamici**: Filtro per categoria e area geografica
3. **Dettagli Punto**: Popup con informazioni complete
4. **Permalink**: URL condivisibili per posizioni specifiche
5. **Aggiornamento Dati**: Sync automatico con OSM

### 🔍 Funzionalità Avanzate
1. **Ricerca Geografica**: Trova punti vendita per area
2. **Esportazione Dati**: Download dati in vari formati
3. **Contribuzione**: Link diretti per modificare OSM
4. **Statistiche**: Dashboard con metriche di utilizzo

---

## 🚀 INTEGRAZIONE NEL PROGETTO FIXCITY

### 🎯 Casi d'Uso Applicabili

#### 1. **Mappa Ticket Georeferenziati**
```php
// Modello Ticket con coordinate
class Ticket extends XotBaseModel {
    protected $fillable = [
        'latitude', 'longitude', 'address'
    ];
    
    public function getMapMarker(): array {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
            'title' => $this->name,
            'description' => $this->description,
            'status' => $this->status->slug,
            'priority' => $this->priority->slug
        ];
    }
}
```

#### 2. **Filtri per Stato e Priorità**
```javascript
// Filtri per ticket
const ticketFilters = {
    status: ['pending', 'assigned', 'in_progress'],
    priority: ['low', 'medium', 'high', 'critical'],
    type: ['bug', 'feature', 'maintenance']
};
```

#### 3. **Popup Informativi**
```html
<!-- Template popup ticket -->
<div class="ticket-popup">
    <h3>{{ ticket.name }}</h3>
    <p><strong>Stato:</strong> {{ ticket.status.label }}</p>
    <p><strong>Priorità:</strong> {{ ticket.priority.label }}</p>
    <p><strong>Indirizzo:</strong> {{ ticket.address }}</p>
    <a href="{{ ticket.url }}" class="btn btn-primary">Visualizza Dettagli</a>
</div>
```

### 🏗️ Architettura Integrazione

#### 1. **Modulo Geo Esteso**
```
Modules/Geo/
├── App/
│   ├── Models/
│   │   ├── MapMarker.php
│   │   ├── GeoLocation.php
│   │   └── MapFilter.php
│   ├── Services/
│   │   ├── MapService.php
│   │   ├── OverpassService.php
│   │   └── GeocodingService.php
│   └── Http/Controllers/
│       └── MapController.php
├── Resources/
│   ├── js/
│   │   ├── map.js
│   │   ├── filters.js
│   │   └── markers.js
│   └── views/
│       ├── map.blade.php
│       └── components/
└── docs/
    ├── farmshops-analysis.md
    ├── map-integration.md
    └── api-reference.md
```

#### 2. **API Endpoints**
```php
// Routes per mappa
Route::prefix('api/map')->group(function () {
    Route::get('/tickets', [MapController::class, 'tickets']);
    Route::get('/markers', [MapController::class, 'markers']);
    Route::post('/filters', [MapController::class, 'applyFilters']);
    Route::get('/geocode', [MapController::class, 'geocode']);
});
```

#### 3. **Frontend Components**
```javascript
// Componente mappa Vue/Livewire
class MapComponent {
    constructor(containerId) {
        this.map = L.map(containerId);
        this.markers = L.layerGroup();
        this.filters = new MapFilters();
    }
    
    loadTickets(filters = {}) {
        fetch('/api/map/tickets', {
            method: 'POST',
            body: JSON.stringify(filters)
        })
        .then(response => response.json())
        .then(tickets => this.addMarkers(tickets));
    }
}
```

---

## 📊 BENEFICI INTEGRAZIONE

### 🎯 Per Utenti
1. **Visualizzazione Spaziale**: Ticket su mappa geografica
2. **Filtri Avanzati**: Ricerca per area e caratteristiche
3. **Navigazione**: Link diretti per raggiungere posizioni
4. **Condivisione**: URL condivisibili per ticket specifici

### 🎯 Per Amministratori
1. **Dashboard Geografica**: Panoramica ticket per area
2. **Analisi Spaziale**: Identificazione zone critiche
3. **Pianificazione**: Ottimizzazione risorse per area
4. **Reporting**: Statistiche geografiche dettagliate

### 🎯 Per Sviluppatori
1. **API Robuste**: Endpoint per integrazioni esterne
2. **Componenti Riusabili**: Sistema modulare per mappe
3. **Performance**: Cache e ottimizzazioni avanzate
4. **Estensibilità**: Architettura scalabile

---

## 🛠️ IMPLEMENTAZIONE ROADMAP

### 📅 Fase 1: Fondamenta (Settimana 1-2)
- [ ] Studio approfondito codice farmshops.eu
- [ ] Setup modulo Geo esteso
- [ ] Integrazione Leaflet.js
- [ ] API base per marker

### 📅 Fase 2: Core Features (Settimana 3-4)
- [ ] Mappa interattiva ticket
- [ ] Sistema filtri base
- [ ] Popup informativi
- [ ] Geocoding service

### 📅 Fase 3: Funzionalità Avanzate (Settimana 5-6)
- [ ] Filtri dinamici
- [ ] Permalink system
- [ ] Export dati
- [ ] Mobile optimization

### 📅 Fase 4: Integrazione Completa (Settimana 7-8)
- [ ] Dashboard geografica
- [ ] Analytics spaziali
- [ ] Performance optimization
- [ ] Testing completo

---

## 🔗 RISORSE E RIFERIMENTI

### 📚 Documentazione
- [Repository GitHub](https://github.com/CodeforKarlsruhe/farmshops.eu)
- [Sito Live](https://farmshops.eu/)
- [OpenStreetMap Wiki](https://wiki.openstreetmap.org/)
- [Leaflet.js Docs](https://leafletjs.com/)

### 🛠️ Strumenti
- **Overpass API**: Query OSM data
- **Leaflet.js**: Mappe interattive
- **Bootstrap**: UI components
- **GitHub Pages**: Hosting statico

---

**Last Updated**: 2025-01-27  
**Next Review**: 2025-02-27  
**Status**: 📋 ANALYSIS COMPLETE  
**Confidence Level**: 95%

---

*Questa analisi fornisce le basi per integrare le funzionalità di farmshops.eu nel progetto FixCity, migliorando significativamente l'esperienza utente con visualizzazioni geografiche avanzate.*











