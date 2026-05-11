---
type: entity
module: Geo
component: geo-map-lit
file: Modules/Geo/resources/js/components/geo-map-lit.js
created: 2026-04-29
stories:
  - 8-76-geo-map-lit-component
  - 8-78-segnalazioni-elenco-polish
  - 8-79-geo-map-controls-unification
  - 8-80-geo-map-lit-shared-modules
  - 8-81-geo-map-lit-farmshops-parity
updated: 2026-04-29
status: COMPLETED — 13/13 Playwright tests pass
---

# `<geo-map-lit>` — Mappa Segnalazioni Pubblica

## Scopo

Web Component Lit per la visualizzazione **read-only** delle segnalazioni pubbliche. Usato in `segnalazioni-elenco`. Non raccoglie input utente — solo visualizza marker da un GeoJSON statico.

## Differenze da `coordinate-picker-lit`

|                     | `geo-map-lit`                                      | `coordinate-picker-lit`                     |
|---------------------|----------------------------------------------------|--------------------------------------------|
| **Scopo**           | Visualizzazione pubblica read-only                 | Picker input lat/lng in form               |
| **Pagina**          | `/tests/segnalazioni-elenco`                       | `/tests/segnalazione-crea` (wizard)        |
| **Input**           | `data-url` (fetch GeoJSON)                         | `state`, `:lat`, `:lng` (Livewire)         |
| **Cluster**         | ✅ MarkerClusterGroup                              | ❌ singolo marker                         |
| **Heatmap**         | ✅ toggle heat layer                               | ❌ assente                                 |
| **Geolocalizzazione**| ⚠️ da aggiungere (view-only)                       | ✅ completa + save                         |
| **Shadow DOM**      | ❌ `createRenderRoot()` → `this` (light DOM)        | ✅ Shadow DOM                              |
| **CSS**             | Stile inline + `<style>` globale                    | Adopts `map-picker-lit-styles.js`          |

## Attributi pubblici

```html
<geo-map-lit
    id="ticket-map"
    data-url="/data/tickets.json"
    style="height:450px;display:block;width:100%"
    aria-label="Mappa delle segnalazioni"
></geo-map-lit>
```

| Attributo      | Tipo   | Default      | Descrizione                                     |
|---------------|--------|--------------|-------------------------------------------------|
| `data-url`    | String | `/data/tickets.json` | URL del file GeoJSON (fetch)                  |
| `filter-type` | String | `null`       | Filtra marker per valore enum                  |
| `active-layer`| String | `'markers'`  | Layer visualizzato: `'markers'` o `'heat'`     |

## Metodi pubblici (API JS)

```js
const map = document.getElementById('ticket-map');

// Filtra marker per tipo (es. 'road_maintenance')
map.filterByType('road_maintenance');
map.filterByType(null); // rimuovi filtro

// Cambia layer visualizzato
map.showLayer('markers'); // layer cluster markers
map.showLayer('heat');    // layer heatmap

// Altri metodi pubblici
map.toggleFullscreen();
map.zoomIn();           // delega a controlli condivisi
map.zoomOut();          // idem
map.switchLayer();      // idem
map.requestGeolocation();// idem
map._setupMutationObserver(); // idem
```

## Metodi interni

| Metodo                | Stato | Descrizione                                                                 |
|-----------------------|-------|-----------------------------------------------------------------------------|
| `_initMap()`          | ✅    | Inizializza Leaflet, tile layers, cluster, heatmap                        |
| `_loadGeoJson()`      | ✅    | Fetch `data-url`, popola `_allFeatures`, chiama `_renderMarkers`            |
| `_renderMarkers(features)`| ✅ | Aggiunge marker colorati al layer cluster                              |
| `_createClusterIcon(cluster)`| ✅ | Icona cluster con conteggio e etichette tipo                                    |
| `_toggleFullscreen()` | ✅    | Toggle `isFullscreen`, `overflow:hidden` su `body`                           |
| `_zoomIn()` / `_zoomOut()` | ✅ | Delegano a controlli condivisi (`zoomIn(this)` / `zoomOut(this)`)       |
| `_switchLayer()`      | ✅    | Delegano a controlli condivisi (`switchLayer(this)`)                        |
| `_requestGeolocation()`| ✅   | Delegano a controlli condivisi (`requestGeolocation(this)`)                |
| `_setupMutationObserver()`| ✅ | Observer per re-init in wizard Filament                                   |

## Bug noti (da story 8-79)

### 1. `_wireControls()` non definita
```
TypeError: this._wireControls is not a function
```
Chiamata in `_initMap()` riga 118 ma il metodo non esiste. I pulsanti di controllo del `render()` non sono cablati.

### 2. Doppio zoom control
```js
// In _initMap():
L.control.zoom({ position: 'bottomright' }).addTo(this._map); // DA RIMUOVERE
```
I pulsanti custom del `render()` fanno già zoom — il controllo Leaflet nativo crea duplicazione visiva.

### 3. Pulsanti zoom/layer senza `@click`
```html
<!-- DA: -->
<button class="geo-map-btn geo-map-btn-zoom-in" title="Zoom in">${geoIcon('plus')}</button>
<!-- A: -->
<button class="geo-map-btn geo-map-btn-zoom-in" title="Zoom in" @click=${() => this._zoomIn()}>${geoIcon('plus')}</button>
```

### 4. Stile `.geo-map-btn` vs `.ctrl-btn`
I bottoni usano stile inline diverso da `coordinate-picker-lit`. Devono essere visivamente identici.

## Integrazione Blade

```blade
{{-- In layout.blade.php --}}
<geo-map-lit
    id="ticket-map"
    data-url="/data/tickets.json"
    style="height:450px;display:block;width:100%"
    aria-label="{{ __('fixcity::segnalazione.map.image.alt') }}"
></geo-map-lit>

{{-- Script Vite (bundle Geo) --}}
<script type="module" src="{{ Vite::asset('resources/js/components/geo-map-lit.js', 'assets/geo') }}"></script>
```

## CSS obbligatorio

```blade
{{-- In head layout --}}
<style>.leaflet-container { z-index: 1; }</style>
```

## Filtro da checkbox esterno

```js
// Blake inline script (layout.blade.php)
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[name="category"]');
    const map = document.getElementById('ticket-map');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            const active = document.querySelector('input[name="category"]:checked');
            map.filterByType(active ? active.value : null);
        });
    });
});
```

## Fonte GeoJSON

Generato da `Modules/Fixcity/app/Actions/GenerateTicketsJsonAction::execute()`.
Scritto in `public_html/data/tickets.json`.
Servito via HTTP da `/data/tickets.json`.

## Vite bundle

Configurato in `Modules/Geo/vite.config.js`:
```js
// Output: public_html/assets/geo/assets/geo-map-lit-[hash].js
```

## Regole correlate

- [geo-map-controls-unification-rule](../concepts/geo-map-controls-unification-rule.md) — controlli devono essere visivamente identici a `coordinate-picker-lit`
- [geo-vite-build-contract](../concepts/geo-vite-build-contract.md)
- [static-geo-map-widget-pattern](../concepts/static-geo-map-widget-pattern.md)