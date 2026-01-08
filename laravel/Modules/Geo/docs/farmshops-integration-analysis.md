# 🗺️ Farmshops.eu Integration Analysis

**Date:** 2025-10-02  
**Module:** Geo  
**Status:** Analysis & Proposal

---

## 📋 Executive Summary

**Farmshops.eu** è un progetto open-source che visualizza su mappa interattiva negozi di fattoria, distributori automatici di latte/cibo e mercati diretti utilizzando dati da OpenStreetMap.

**Potenziale per FixCity:** ALTO - Perfetta integrazione con il nostro modulo Geo per visualizzare punti di interesse civici su mappa interattiva.

---

## 🔍 Analisi Progetto Farmshops.eu

### Informazioni Generali

| Aspetto | Dettaglio |
|---------|-----------|
| **Repository** | https://github.com/CodeforKarlsruhe/farmshops.eu |
| **Licenza** | MIT License |
| **Linguaggio** | JavaScript |
| **Stars** | 40 |
| **Forks** | 10 |
| **Ultimo Update** | 2025-09-23 |
| **Homepage** | https://farmshops.eu |

### Stack Tecnologico

#### Frontend Libraries
1. **Leaflet.js** - Libreria principale per mappe interattive
2. **Leaflet Extra Markers** - Marker personalizzati
3. **Leaflet Marker Clusterer** - Raggruppamento marker
4. **Leaflet Permalinks** - URL persistenti con posizione
5. **Leaflet Sidebar v2** - Sidebar laterale
6. **Leaflet LocateControl** - Geolocalizzazione utente
7. **Opening Hours.js** - Gestione orari di apertura

#### Backend/Data
- **query-overpass** - Import dati da OpenStreetMap
- **Overpass Turbo API** - Query OSM data
- **GeoJSON** - Formato dati geografici

### Funzionalità Principali

1. **Visualizzazione Dati OSM**
   - Mostra punti da regione DACH (Germania, Austria, Svizzera)
   - Supporta punti e poligoni
   - Marker differenziati per tipo (negozi, distributori, mercati)

2. **Gestione Dati**
   - Import automatico da OpenStreetMap
   - Update script automatizzato
   - Validazione e pulizia dati

3. **User Experience**
   - Clustering automatico marker
   - Popup informativi dettagliati
   - Link a OSM, OpenRouteService, Google Maps
   - Permalinks per condivisione
   - Geolocalizzazione utente

4. **Data Processing**
   - Traduzione termini comuni
   - Rendering link cliccabili
   - Visualizzazione orari apertura
   - Gestione dati mancanti

---

## 🎯 Applicabilità a FixCity

### Use Cases Perfetti

#### 1. Segnalazioni Cittadine su Mappa
**Scenario:** Visualizzare tutte le segnalazioni (buche, rifiuti, illuminazione) su mappa interattiva

**Benefici:**
- Clustering automatico per zone dense
- Filtri per tipo segnalazione
- Popup con dettagli e foto
- Link diretti alla segnalazione

#### 2. Punti di Interesse Civici
**Scenario:** Mostrare servizi pubblici (farmacie, uffici, servizi)

**Benefici:**
- Integrazione con dati comunali
- Orari di apertura
- Informazioni di contatto
- Navigazione diretta

#### 3. Mappa Partecipativa
**Scenario:** Cittadini possono aggiungere/modificare punti

**Benefici:**
- Crowdsourcing dati
- Validazione community
- Aggiornamenti real-time
- Gamification

#### 4. Dashboard Amministrativa
**Scenario:** Admin visualizza statistiche geografiche

**Benefici:**
- Heatmap problemi
- Analisi zone critiche
- Report geografici
- Export dati

---

## 🏗️ Architettura Proposta per Integrazione

### Componenti da Creare

```
Modules/Geo/
├── Actions/
│   ├── ImportOSMDataAction.php          # Import da OSM
│   ├── GeocodeAddressAction.php         # Geocoding
│   └── CalculateDistanceAction.php      # Calcolo distanze
├── Services/
│   ├── MapService.php                   # Gestione mappe
│   ├── OSMService.php                   # Integrazione OSM
│   └── GeoJSONService.php               # Export GeoJSON
├── Models/
│   ├── MapPoint.php                     # Punto su mappa
│   ├── MapLayer.php                     # Layer mappa
│   └── MapCategory.php                  # Categoria punti
├── Filament/
│   ├── Resources/
│   │   ├── MapPointResource.php         # Gestione punti
│   │   └── MapLayerResource.php         # Gestione layer
│   └── Widgets/
│       └── InteractiveMapWidget.php     # Widget mappa
└── Http/
    └── Controllers/
        └── Api/
            ├── MapDataController.php     # API dati mappa
            └── GeoJSONController.php     # Export GeoJSON
```

### Database Schema

```sql
-- Punti sulla mappa
CREATE TABLE map_points (
    id BIGINT PRIMARY KEY,
    category_id BIGINT,
    name VARCHAR(255),
    description TEXT,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    address TEXT,
    opening_hours JSON,
    contact JSON,
    metadata JSON,
    osm_id VARCHAR(50),
    osm_type VARCHAR(20),
    status ENUM('active', 'pending', 'archived'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Categorie punti
CREATE TABLE map_categories (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    icon VARCHAR(100),
    color VARCHAR(20),
    marker_type VARCHAR(50),
    is_active BOOLEAN
);

-- Layer mappa
CREATE TABLE map_layers (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    categories JSON,
    bounds JSON,
    is_public BOOLEAN,
    created_at TIMESTAMP
);
```

---

## 💻 Implementazione Tecnica

### 1. Frontend Integration (Blade + Alpine.js)

```blade
<!-- resources/views/components/interactive-map.blade.php -->
<div 
    x-data="interactiveMap()"
    x-init="initMap()"
    class="relative w-full h-screen"
>
    <div id="map" class="w-full h-full"></div>
    
    <!-- Sidebar -->
    <div id="sidebar" class="leaflet-sidebar">
        <div class="leaflet-sidebar-content">
            <div class="leaflet-sidebar-pane" id="home">
                <h1>FixCity Map</h1>
                <div x-html="selectedPoint"></div>
            </div>
        </div>
    </div>
</div>

<script>
function interactiveMap() {
    return {
        map: null,
        markers: [],
        
        initMap() {
            this.map = L.map('map').setView([45.4642, 9.1900], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(this.map);
            
            this.loadMarkers();
        },
        
        async loadMarkers() {
            const response = await fetch('/api/map/points');
            const data = await response.json();
            
            const markerCluster = L.markerClusterGroup();
            
            data.forEach(point => {
                const marker = L.marker([point.latitude, point.longitude])
                    .bindPopup(this.createPopup(point));
                markerCluster.addLayer(marker);
            });
            
            this.map.addLayer(markerCluster);
        },
        
        createPopup(point) {
            return `
                <div class="map-popup">
                    <h3>${point.name}</h3>
                    <p>${point.description}</p>
                    <a href="/tickets/${point.id}">Vedi dettagli</a>
                </div>
            `;
        }
    }
}
</script>
```

### 2. Backend Service

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Support\Collection;
use Modules\Geo\Models\MapPoint;

/**
 * Service for managing interactive maps with OSM data.
 */
class MapService
{
    /**
     * Get all map points as GeoJSON.
     */
    public function getGeoJSON(array $filters = []): array
    {
        $points = MapPoint::query()
            ->when($filters['category'] ?? null, fn($q, $cat) => 
                $q->where('category_id', $cat)
            )
            ->when($filters['status'] ?? null, fn($q, $status) => 
                $q->where('status', $status)
            )
            ->get();

        return [
            'type' => 'FeatureCollection',
            'features' => $points->map(fn($point) => [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$point->longitude, $point->latitude],
                ],
                'properties' => [
                    'id' => $point->id,
                    'name' => $point->name,
                    'description' => $point->description,
                    'category' => $point->category->name,
                    'icon' => $point->category->icon,
                    'color' => $point->category->color,
                ],
            ])->toArray(),
        ];
    }

    /**
     * Import data from OpenStreetMap.
     */
    public function importFromOSM(array $bounds, array $tags): Collection
    {
        $query = $this->buildOverpassQuery($bounds, $tags);
        $data = $this->queryOverpass($query);
        
        return collect($data['elements'])->map(function ($element) {
            return MapPoint::updateOrCreate(
                ['osm_id' => $element['id']],
                [
                    'name' => $element['tags']['name'] ?? 'Unknown',
                    'latitude' => $element['lat'] ?? $element['center']['lat'],
                    'longitude' => $element['lon'] ?? $element['center']['lon'],
                    'metadata' => $element['tags'],
                    'osm_type' => $element['type'],
                ]
            );
        });
    }

    /**
     * Build Overpass API query.
     */
    private function buildOverpassQuery(array $bounds, array $tags): string
    {
        $bbox = implode(',', $bounds); // [south, west, north, east]
        $tagQueries = collect($tags)->map(fn($v, $k) => "[\"{$k}\"=\"{$v}\"]")->implode('');
        
        return <<<QUERY
        [out:json][timeout:25];
        (
          node{$tagQueries}({$bbox});
          way{$tagQueries}({$bbox});
          relation{$tagQueries}({$bbox});
        );
        out center;
        QUERY;
    }

    /**
     * Query Overpass API.
     */
    private function queryOverpass(string $query): array
    {
        $response = Http::post('https://overpass-api.de/api/interpreter', [
            'data' => $query,
        ]);

        return $response->json();
    }
}
```

### 3. Filament Resource

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Geo\Models\MapPoint;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MapPointResource extends XotBaseResource
{
    protected static ?string $model = MapPoint::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->rows(3),

            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('latitude')
                        ->numeric()
                        ->required()
                        ->step(0.000001),

                    Forms\Components\TextInput::make('longitude')
                        ->numeric()
                        ->required()
                        ->step(0.000001),
                ]),

            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),

            Forms\Components\KeyValue::make('opening_hours')
                ->label('Orari di Apertura'),

            Forms\Components\KeyValue::make('contact')
                ->label('Contatti'),

            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Attivo',
                    'pending' => 'In Attesa',
                    'archived' => 'Archiviato',
                ])
                ->default('active'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('category.name')
                ->badge(),

            Tables\Columns\TextColumn::make('latitude')
                ->numeric(8),

            Tables\Columns\TextColumn::make('longitude')
                ->numeric(8),

            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'success' => 'active',
                    'warning' => 'pending',
                    'danger' => 'archived',
                ]),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('view_on_map')
                ->icon('heroicon-o-map')
                ->url(fn (MapPoint $record): string => 
                    route('map.show', ['lat' => $record->latitude, 'lon' => $record->longitude])
                )
                ->openUrlInNewTab(),

            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }
}
```

---

## 📦 Package Dependencies

### Composer (Backend)
```json
{
    "require": {
        "geoip2/geoip2": "^2.13",
        "league/geotools": "^2.0"
    }
}
```

### NPM (Frontend)
```json
{
    "dependencies": {
        "leaflet": "^1.9.4",
        "leaflet.markercluster": "^1.5.3",
        "leaflet-extra-markers": "^1.2.2",
        "leaflet-sidebar-v2": "^3.2.3",
        "leaflet.locatecontrol": "^0.79.0",
        "opening_hours": "^3.8.0"
    }
}
```

---

## 🚀 Roadmap Implementazione

### Phase 1: Foundation (Week 1-2)
- [ ] Creare modelli database (MapPoint, MapCategory, MapLayer)
- [ ] Implementare migrations
- [ ] Creare MapService base
- [ ] Setup Leaflet.js nel frontend

### Phase 2: Core Features (Week 3-4)
- [ ] Implementare import da OSM
- [ ] Creare API GeoJSON
- [ ] Sviluppare Filament Resources
- [ ] Implementare clustering markers

### Phase 3: Advanced Features (Week 5-6)
- [ ] Aggiungere filtri avanzati
- [ ] Implementare search geografica
- [ ] Creare widget dashboard
- [ ] Aggiungere heatmap

### Phase 4: Integration (Week 7-8)
- [ ] Integrare con modulo Fixcity (segnalazioni)
- [ ] Collegare con modulo User (geolocalizzazione)
- [ ] Implementare notifiche geografiche
- [ ] Testing completo

---

## 💡 Innovazioni Proposte

### 1. AI-Powered Categorization
Usare AI per categorizzare automaticamente punti basandosi su descrizione e metadata OSM.

### 2. Real-time Updates
WebSocket per aggiornamenti real-time quando nuovi punti vengono aggiunti.

### 3. Gamification
Sistema punti per cittadini che aggiungono/validano punti sulla mappa.

### 4. Offline Support
Progressive Web App con cache locale dei dati mappa per uso offline.

### 5. AR Integration
Realtà aumentata per visualizzare punti di interesse tramite fotocamera smartphone.

---

## 📊 Metriche di Successo

| Metrica | Target | Misurazione |
|---------|--------|-------------|
| Punti sulla mappa | >1000 | Count MapPoints |
| Utenti attivi | >500/mese | Analytics |
| Tempo medio sessione | >5 min | Analytics |
| Segnalazioni via mappa | >50/mese | Count Tickets |
| Soddisfazione utenti | >4.5/5 | Survey |

---

## 🔒 Considerazioni Privacy & Security

### GDPR Compliance
- ✅ Anonimizzazione coordinate precise
- ✅ Consenso esplicito per geolocalizzazione
- ✅ Diritto all'oblio per punti utente
- ✅ Export dati personali

### Security
- ✅ Rate limiting API
- ✅ Validazione input coordinate
- ✅ Sanitizzazione dati OSM
- ✅ HTTPS only
- ✅ CORS policy restrittiva

---

## 💰 Costi Stimati

### Sviluppo
- Backend: 40 ore
- Frontend: 40 ore
- Testing: 20 ore
- **Totale: 100 ore**

### Infrastruttura
- Storage dati: ~100MB/anno
- API calls OSM: Gratuito
- Bandwidth: ~50GB/mese
- **Costo: ~€50/mese**

---

## 🎯 Conclusioni

### Pro dell'Integrazione
✅ **Open Source** - Codice MIT, completamente riutilizzabile  
✅ **Mature** - Progetto attivo dal 2018  
✅ **Proven** - 40 stars, 10 forks, community attiva  
✅ **Perfect Fit** - Allineato perfettamente con obiettivi FixCity  
✅ **Scalable** - Architettura testata su migliaia di punti  

### Raccomandazione

**IMPLEMENTARE** - L'integrazione di farmshops.eu pattern nel modulo Geo porterebbe valore immediato a FixCity, permettendo visualizzazione geografica interattiva di segnalazioni e servizi civici.

**Priority: HIGH**  
**Effort: MEDIUM**  
**Impact: HIGH**

---

**📝 Documento preparato da:** Super Mucca 🐮  
**📅 Data:** 2025-10-02  
**📧 Contatto:** geo-team@fixcity.com

---

*Prossimi passi: Creare POC (Proof of Concept) con subset di dati per validare approccio.*
