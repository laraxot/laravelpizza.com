---
type: concept
module: Geo
component: geo-map-lit
created: 2026-04-30
updated: 2026-04-30
stories:
  - 8-78-segnalazioni-elenco-polish
  - 8-79-geo-map-controls-unification
  - 8-80-geo-map-lit-shared-modules
---

# Geo Map Controls — Shared Implementation Pattern

## Scopo

Il componente `<geo-map-lit>` riutilizza i moduli condivisi del MapPicker per garantire che i controlli mappa siano **visivamente e funzionalmente identici** a quelli di `coordinate-picker-lit`.

## Pattern di Importazione

Tutti i moduli condivisi si trovano in `Modules/Geo/resources/js/components/`.

### 1. `map-picker-controls.js`

Renderizza la barra dei controlli e fornisce funzioni di manipolazione mappa.

```javascript
import { renderControls, toggleFullscreen, zoomIn, zoomOut, switchLayer, requestGeolocation } from './map-picker-controls.js';
```

**API Esposta:**

- `renderControls(ctx)` — Restituisce template Lit della toolbar
- `toggleFullscreen(ctx)` — Toggle modalità fullscreen
- `zoomIn(ctx)` / `zoomOut(ctx)` — Zoom mappa
- `switchLayer(ctx)` — Alterna layer (markers ↔ heatmap)
- `requestGeolocation(ctx)` — Geolocalizzazione utente

**Contesto Richiesto (`ctx`):**

```javascript
{
    _map: L.Map,                    // Istanza Leaflet
    isFullscreen: Boolean,          // Stato fullscreen
    activeLayer: String,            // 'markers' | 'heat'
    labels: Object,                 // Traduzioni UI
    _toggleFullscreen(): void,      // Metodo interno
    _zoomIn(): void,                // Metodo interno
    _zoomOut(): void,               // Metodo interno
    _switchLayer(): void,           // Metodo interno
    _requestGeolocation(): void     // Metodo interno
}
```

### 2. `map-picker-search.js`

Barra di ricerca indirizzi con geocodifica e navigazione.

```javascript
import { renderSearch } from './map-picker-search.js';
```

**API Esposta:**

- `renderSearch(ctx)` — Restituisce template Lit della search bar

**Metodi di Ricerca nel Contesto:**

```javascript
{
    _map: L.Map,                             // Istanza Leaflet
    isSearching: Boolean,                    // Stato ricerca
    searchQuery: String,                     // Query corrente
    searchResults: Array<Feature>,           // Risultati
    isLocating: Boolean,                     // Stato geoloc
    labels: Object,
    _handleMapInteraction(lat, lng, source): void,  // Centra mappa
    _handleSearchSelection(result, lat, lng): void  // Gestione selezione
}
```

### 3. `map-picker-layers.js`

Layer tile configurati per l'applicazione.

```javascript
import { buildMapLayers } from './map-picker-layers.js';
```

**API Esposta:**

- `buildMapLayers(L)` — Restituisce oggetto layer configurati

**Uso in `geo-map-lit.js`:**

```javascript
this._layers = buildMapLayers(L);
this._layers[this._currentLayer].addTo(this._map);
```

### 4. `map-picker-styles.js`

Template literal CSS condiviso.

```javascript
import { mapPickerStylesText } from './map-picker-styles.js';
```

**Uso nel template Lit:**

```javascript
render() {
    return html`
        <style>${mapPickerStylesText}</style>
        <!-- contenuto -->
    `;
}
```

## Implementazione in `geo-map-lit.js`

```javascript
import { LitElement, html } from 'lit';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import { renderControls, toggleFullscreen, zoomIn, zoomOut, switchLayer, requestGeolocation } from './map-picker-controls.js';
import { renderSearch } from './map-picker-search.js';
import { buildMapLayers } from './map-picker-layers.js';
import { mapPickerStylesText } from './map-picker-styles.js';

class GeoMapLit extends LitElement {
    // ... proprietà ...

    render() {
        return html`
            <style>${mapPickerStylesText}</style>
            <div class="map-container">
                <div class="geo-map-leaflet"></div>
                ${renderControls(this)}
                ${this.showSearch ? renderSearch(this) : ''}
            </div>
        `;
    }

    _initMap() {
        // ... inizializzazione mappa ...
        this._layers = buildMapLayers(L);
        this._layers[this._currentLayer].addTo(this._map);
        // ...
    }

    _toggleFullscreen() { toggleFullscreen(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }
    _switchLayer() { switchLayer(this); }
    _requestGeolocation() { requestGeolocation(this); }
}
```

## Vantaggi dell'Approccio Condiviso

### 1. Coerenza Visiva
- Stesso design token `.ctrl-btn`
- Stessi colori, dimensioni, icone
- Compatibilità con Design Comuni

### 2. Coerenza Funzionale
- Comportamento identico (click handler, stati)
- Nessuna duplicazione logica
- Bug fix propagati a entrambi i componenti

### 3. Manutenibilità
- Modifica in un punto → impatta entrambi i componenti
- Riduzione codice duplicato ~150 righe
- Test unificati

### 4. Testing
- I 13 test Playwright per `geo-map-lit` validano automaticamente anche il comportamento condiviso
- Parity garantita con pattern `direktvermarkter.js`

## Differenze Chiave tra Componenti

| Caratteristica | `geo-map-lit` | `coordinate-picker-lit` |
|----------------|---------------|------------------------|
| **Scopo** | Visualizzazione pubblica read-only | Input lat/lng in form Filament |
| **Attributo dati** | `data-url` (GeoJSON) | `state` + `:lat`/`:lng` (Livewire) |
| **Cluster** | ✅ MarkerCluster | ❌ Singolo marker |
| **Heatmap** | ✅ Toggle layer | ❌ Assente |
| **Shadow DOM** | ❌ Light DOM | ✅ Shadow DOM |
| **Geoloc** | ⚠️ View-only | ✅ Salva coordinate |

## Regole di Integrazione

### Controllo Import
L'import di `renderControls` **deve** avvenire dopo l'inizializzazione di Leaflet:
```javascript
import L from 'leaflet';
// ... plugin leaflet ...
import { renderControls } from './map-picker-controls.js';
```

### Contesto Completo
Tutti i metodi richiamati dai controlli devono essere definiti nel componente:
```javascript
// OBBLIGATORIO
toggleFullscreen(this);    // → this._toggleFullscreen()
zoomIn(this);              // → this._zoomIn()
switchLayer(this);         // → this._switchLayer()
```

### Styling CSS
Il CSS condiviso (`mapPickerStylesText`) include stile per:
- `.ctrl-btn` (bottoni controllo)
- `.layer-controls-overlay` (pannello layer)
- `.search-container` (barra ricerca)
- Media query per responsive

## Testing e Verifica

### Test Playwright (13/13 pass)
```bash
cd laravel/Modules/Geo
npm test                              # test componente
playwright test geo-map-lit.spec.js   # specifico
```

### Verifica Parity
```bash
# 1. Apri segnalazioni-elenco
curl http://127.0.0.1:8000/it/tests/segnalazioni-elenco | grep 'data-url'

# 2. Controlla presenza controlli
grep -r 'ctrl-btn' laravel/Modules/Geo/resources/js/components/

# 3. Verifica bundle condiviso
grep -r 'map-picker-controls' laravel/Modules/Geo/resources/js/
```

## Troubleshooting

### Problema: Controlli non funzionano
**Causa:** Manca uno dei metodi di callback nel contesto.
**Fix:** Assicurarsi che `_zoomIn`, `_zoomOut`, `_switchLayer`, `_toggleFullscreen`, `_requestGeolocation` siano definiti.

### Problema: Stile diverso da coordinate-picker-lit
**Causa:** CSS non importato o sovrascritto.
**Fix:** Verificare `mapPickerStylesText` importato e che non ci sia CSS globale in conflitto.

### Problema: `this` undefined nei handler
**Causa:** Contesto perso nel template Lit.
**Fix:** Usare i metodi wrapper come mostrato sopra.

## Story Correlate

- **8-78**: Integrazione iniziale `geo-map-lit` con controlli condivisi
- **8-79**: Regola unificazione controlli (`geo-map-controls-unification-rule.md`)
- **8-80**: Moduli condivisi per riuso
- **8-81**: Parità con `farmshops.eu` (completato ✅)

## Best Practice

1. **Non modificare** direttamente i moduli condivisi senza aggiornare entrambi i componenti
2. **Verificare** su entrambe le pagine (`segnalazioni-elenco` e `segnalazione-crea`)
3. **Mantenere** lo stesso order di import per coerenza
4. **Aggiornare** la documentazione in caso di cambiamenti API

## Referenze

- [geo-map-lit](./entities/geo-map-lit.md) — Entità componente
- [geo-map-controls-unification-rule](./concepts/geo-map-controls-unification-rule.md) — Regola parity
- [coordinate-picker-lit](./entities/coordinate-picker-lit.md) — Componente input form
- [map-picker-controls](./concepts/map-picker-controls.md) — Dettagli moduli condivisi

## Changelog

| Data | Versione | Modifica |
|------|----------|----------|
| 2026-04-29 | 1.0 | Implementazione iniziale con 4 moduli condivisi |
| 2026-04-29 | 1.1 | Fix bug `typeLabel` duplicato in `_buildGeoJsonLayer` |
| 2026-04-29 | 1.2 | Rimosso duplicate `L.control.zoom()` |
| 2026-04-30 | 1.3 | Documentazione completa condivisione pattern |
