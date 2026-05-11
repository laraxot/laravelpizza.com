# Scopo e Utilità del Coordinate Picker nella Creazione Ticket

## Overview

Il componente **Coordinate Picker** (mappa interattiva) nel wizard di creazione ticket serve a **georeferenziare le segnalazioni**, ovvero associare coordinate geografiche precise (latitudine/longitudine) a ogni ticket.

## 🧩 Component Extraction Rule (DRY Principle)

### ✅ DO - Extract Reusable Components

Seguendo il principio **DRY (Don't Repeat Yourself)** e le regole Laraxot, tutti i componenti UI devono essere:

1. **Estratti in componenti riutilizzabili** quando usati in più punti
2. **Posizionati in `resources/views/components/`** del modulo
3. **Usati via `@include()` o `<x-component />`**

### Esempio: Search Input Component

**Prima (inline, duplicato)**:
```blade
{{-- In coordinate-picker.blade.php --}}
<div class="relative">
    <input type="text" ...>
    <div class="absolute left-3">
        <svg ...>...</svg> {{-- SVG inline duplicato --}}
    </div>
</div>
```

**Dopo (componente riutilizzabile)**:
```blade
{{-- In coordinate-picker.blade.php --}}
@include('geo::filament.components.address-search-input')

{{-- In resources/views/filament/components/address-search-input.blade.php --}}
<div class="relative">
    <input type="text" ...>
    <div class="absolute left-3 w-4 h-4">
        @svg('geo-magnifying-glass', 'w-full h-full') {{-- SVG separato --}}
    </div>
</div>
```

### Vantaggi
- **DRY**: Una sola fonte di verità per ogni componente
- **Manutenibilità**: Modifica in un punto, applicata ovunque
- **Testing**: Componenti testabili singolarmente
- **Consistenza**: Stessa UI in tutto il sistema

---

## 🎨 SVG Icon Architecture (NO Hardcoded SVG)

### ❌ DON'T - SVG Inline Hardcoded

```blade
{{-- VIETATO: SVG inline hardcoded --}}
<svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor">
    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
</svg>
```

### ✅ DO - SVG Separati in `resources/svg/`

```
laravel/Modules/Geo/resources/svg/
├── magnifying-glass.svg    {{-- Ricerca --}}
├── location.svg              {{-- Geolocalizzazione --}}
├── layer.svg                 {{-- Cambio layer --}}
├── arrows-pointing-out.svg   {{-- Fullscreen --}}
├── arrows-pointing-in.svg    {{-- Exit fullscreen --}}
├── map-icon-plus.svg         {{-- Zoom in --}}
├── map-icon-minus.svg        {{-- Zoom out --}}
├── crosshair.svg             {{-- Centra mappa --}}
└── ...
```

### Utilizzo nei Componenti

**In Blade (PHP)**:
```blade
@svg('geo-magnifying-glass', 'w-4 h-4 text-gray-400')
```

**In Lit (JavaScript)**:
```javascript
// Caricamento via fetch o importazione come stringhe
import magnifyingGlassSvg from '/modules/geo/svg/magnifying-glass.svg?raw';

render() {
    return html`<div class="icon">${unsafeSVG(magnifyingGlassSvg)}</div>`;
}
```

### Icone Mappa Coordinate Picker

| Icona | File SVG | Scopo |
|-------|----------|-------|
| 🔍 | `magnifying-glass.svg` | Ricerca indirizzo |
| 📍 | `location.svg` | Geolocalizzazione utente |
| 🗂️ | `layer.svg` | Cambio layer mappa (street/satellite/topo) |
| ⛶ | `arrows-pointing-out.svg` | Fullscreen mode |
| ⛶ | `arrows-pointing-in.svg` | Exit fullscreen |
| + | `map-icon-plus.svg` | Zoom in |
| - | `map-icon-minus.svg` | Zoom out |
| ⊕ | `crosshair.svg` | Centra su coordinate |

---

## 🎯 Scopo (Purpose)

Permettere agli utenti di selezionare una posizione precisa sulla mappa per:
1. **Localizzare il problema** - Indicare esattamente dove si verifica la segnalazione
2. **Facilitare interventi** - Fornire coordinate navigabili agli operatori sul campo
3. **Analisi territoriale** - Aggregare e visualizzare segnalazioni per area geografica
4. **Assegnazione automatica** - Associare ticket alla giurisdizione/area corretta

---

## 💡 Utilità (Utility)

### Per l'Utente Cittadino
- **Facilità d'uso**: Clicca sulla mappa invece di inserire indirizzi manualmente
- **Precisione**: Evita errori di trascrizione dell'indirizzo
- **Geolocalizzazione**: Bottone "Mia posizione" per rilevamento automatico GPS
- **Indirizzo inverso**: Dalle coordinate ottiene automaticamente l'indirizzo completo

### Per l'Admin/Operatore
- **Dashboard mappa**: Visualizza tutti i ticket su mappa per pattern territoriali
- **Routing ottimizzato**: Coordinate precise per pianificazione interventi
- **Filtraggio area**: Filtra ticket per raggio geografico o comune
- **Esportazione GIS**: Coordinate esportabili per sistemi GIS esterni

### Per il Sistema
- **Geofencing**: Notifiche automatiche basate su area geografica
- **SLA territoriali**: Tempi di risposta diversi per zona
- **Statistische**: Heatmap delle segnalazioni per identificare zone critiche
- **Routing automatico**: Assegnazione ticket all'operatore più vicino

---

## 🔧 Implementazione Tecnica

### Componente Lit (`coordinate-picker-lit.js`)
- **Framework**: Lit Element 3.x + Leaflet.js
- **Features**:
  - 3 layer mappa switchabili (OSM, Satellite, Topografica)
  - Fullscreen mode per precisione
  - Geolocalizzazione browser
  - Marker draggable
  - Observer per wizard Livewire

### Integrazione Filament (`CoordinatePicker.php`)
- **Estende**: `Filament\Forms\Components\Field`
- **Integrazione**: Alpine.js + Livewire `@entangle`
- **Geocoding**: Nominatim OSM per reverse geocoding

### View Blade (`coordinate-picker.blade.php`)
- **Wrapper**: Alpine.js per state management
- **wire:ignore**: Previene re-render Livewire che distruggerebbe la mappa
- **Partial**: `@include('geo::filament.components.address-search-input')` per ricerca indirizzo

---

## 📊 Data Flow

```
┌─────────────────┐     ┌──────────────────┐     ┌─────────────────┐
│  Utente clicca  │────▶│  Lit Component   │────▶│  Alpine state   │
│  sulla mappa    │     │  (Leaflet.js)    │     │  (coordinate)   │
└─────────────────┘     └──────────────────┘     └────────┬────────┘
                                                          │
                           ┌──────────────────────────────┘
                           ▼
┌─────────────────┐     ┌──────────────────┐     ┌─────────────────┐
│  Livewire Form  │◀────│  Reverse Geocode │◀────│  Update marker  │
│  (TicketForm)   │     │  (Nominatim API) │     │  (lat/lng)      │
└─────────────────┘     └──────────────────┘     └─────────────────┘
       │
       ▼
┌─────────────────┐
│  Database       │
│  (tickets       │
│   lat/lng col)  │
└─────────────────┘
```

---

## 🗄️ Schema Database

```php
// Migrazione tickets
$table->decimal('latitude', 10, 8)->nullable();
$table->decimal('longitude', 11, 8)->nullable();
$table->string('address')->nullable();
$table->geometry('location_point', 'POINT')->nullable(); // PostGIS
```

---

## 🎨 UX/UI Considerations

### Wizard Step Context
- **Posizione**: Step 2 del wizard (dopo descrizione, prima di riepilogo)
- **Height**: 400px default, fullscreen disponibile
- **Default center**: Roma centro (41.9028, 12.4964) o geolocalizzazione utente

### Responsive
- **Desktop**: 2 colonne (mappa grande + search laterale)
- **Mobile**: Mappa a tutta larghezza, controlli compatti
- **Tablet**: Layout adattivo

---

## 🔒 Security & Privacy

1. **Geolocalizzazione**: Richiede consenso utente (browser API)
2. **Nominatim**: Rate limiting implementato (1 req/sec)
3. **Coordinate**: Salvate con precisione 6 decimali (~10cm precisione)
4. **Privacy**: Non tracciamento continuo, solo snapshot alla creazione

---

## 📈 Metrics & KPI

- **Adoption rate**: % ticket con coordinate vs senza
- **Accuracy**: Distanza media tra coordinate e indirizzo verificato
- **Performance**: Tempo medio selezione posizione
- **Error rate**: % errori geocoding/reverse geocoding

---

## 🔗 Integrations

- **Mapbox/Google Maps**: Possibile upgrade per tile personalizzate
- **PostGIS**: Query geografiche avanzate (distanza, within, etc.)
- **Routing APIs**: Calcolo percorso ottimale per operatori
- **Notifications**: Geofencing per notifiche area-based

---

## 📚 References

- [TicketForm Schema](../../Modules/Fixcity/app/Filament/Resources/TicketResource/Schemas/TicketForm.php)
- [CoordinatePicker Component](../../Modules/Geo/app/Filament/Forms/Components/CoordinatePicker.php)
- [Lit Component JS](../../Modules/Geo/resources/js/components/coordinate-picker-lit.js)
- [Blade View](../../Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php)

---

**Ultimo aggiornamento**: 2026-04-27
**Autore**: System
**Scopo**: Documentazione architetturale per AI agents e developers
