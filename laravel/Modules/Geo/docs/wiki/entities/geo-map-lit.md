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
updated: 2026-04-30
status: MAINTAINED — search toggle + outside close, shared controls, marker clustering (inline fix), farmshops-style parity
---

# `<geo-map-lit>` — Mappa Segnalazioni Pubblica

## Scopo

Web Component Lit per la visualizzazione **read-only** delle segnalazioni pubbliche. Usato in `segnalazioni-elenco`. Non raccoglie input utente — solo visualizza marker da un GeoJSON statico.

## Differenze da `coordinate-picker-lit`

| | `geo-map-lit` | `coordinate-picker-lit` |
|--|---------------|------------------------|
| **Scopo** | Visualizzazione pubblica read-only | Picker input lat/lng in form |
| **Pagina** | `/tests/segnalazioni-elenco` | `/tests/segnalazione-crea` (wizard) |
| **Input** | `data-url` (fetch GeoJSON) | `state`, `:lat`, `:lng` (Livewire) |
| **Cluster** | ✅ MarkerClusterGroup | ❌ singolo marker |
| **Heatmap** | Fallback non primario; marker cluster è il layer principale | ❌ assente |
| **Geolocalizzazione** | ✅ view-only center map | ✅ completa + save |
| **Shadow DOM** | ❌ `createRenderRoot()` → `this` (light DOM) | ✅ Shadow DOM |
| **CSS** | Stile inline + `<style>` globale | Adopts `map-picker-lit-styles.js` |

## Attributi pubblici

```html
<geo-map-lit
    id="ticket-map"
    data-url="/data/tickets.json"
    height="450px"
    style="height:450px;display:block;width:100%"
    aria-label="Mappa delle segnalazioni"
></geo-map-lit>
```

| Attributo | Tipo | Default | Descrizione |
|-----------|------|---------|-------------|
| `data-url` | String | `/data/tickets.json` | URL del file GeoJSON (fetch) |
| `height` | String | `450px` | Altezza CSS del contenitore mappa |
| `filter-type` | String | `null` | Filtra marker per tipo enum value |
| `active-layer` | String | `'markers'` | Layer attivo: `'markers'` o `'heat'` |

`show-search` non è un attributo pubblico di `<geo-map-lit>`. La ricerca è gestita internamente dal componente con stato `_searchOpen`: parte collassata di default e apertura tramite controllo lente.

## Metodi pubblici (API JS)

```js
const map = document.getElementById('ticket-map');

// Filtra marker per tipo (es. 'road_maintenance')
map.filterByType('road_maintenance');
map.filterByType(null); // rimuovi filtro

// Cambia layer visualizzato
map.showLayer('markers'); // cluster markers
map.showLayer('heat');    // heatmap
```

## Metodi interni

| Metodo | Stato | Descrizione |
|--------|-------|-------------|
| `_initMap()` | ✅ | Inizializza Leaflet, tile layers, cluster, heatmap |
| `_loadGeoJson()` | ✅ | Fetch `data-url`, popola `_allFeatures`, costruisce marker e heat fallback |
| `_buildGeoJsonLayer(features)` | ✅ | Crea marker colorati via `L.geoJson(pointToLayer, onEachFeature)` |
| `_createClusterIcon(cluster)` | ✅ | Icona cluster con conteggio, size dinamica per densita, e LOD per tipo |
| `_toggleFullscreen()` | ✅ | Toggle `isFullscreen`, `overflow:hidden` su body |
| `_zoomIn()` | ✅ | Chiama `zoomIn(this)` dal controlli condivisi |
| `_zoomOut()` | ✅ | Chiama `zoomOut(this)` dal controlli condivisi |
| `_switchLayer()` | ✅ | Chiama `switchLayer(this)` dal controlli condivisi |
| `_requestGeolocation()` | ✅ | Chiama `requestGeolocation(this)` dal controlli condivisi |
| `_setupMutationObserver()` | ✅ | Observer per re-init in wizard Filament |

## Regole Anti-Regressione

- Non usare `show-search` su `<geo-map-lit>`: la search è governata solo da stato interno (`_searchOpen`).
- Non ripristinare `L.control.zoom()` o `L.control.layers()`: i controlli sono quelli condivisi in `map-picker-controls.js`.
- Non usare CDN o `file_get_contents()` per montare il componente: il bundle è servito da Vite asset del modulo Geo.
- Non cambiare cluster in logica page-specific: clustering e LOD restano nel componente Geo riusabile.
- Mantenere `minimumClusterSize: 2` per evitare cluster con un solo marker.
- Mantenere `showCoverageOnHover: false` per parity UX con `farmshops.eu`.
- Search panel: default chiuso, apertura da lente, chiusura con `Escape` e click fuori componente.

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
// Blade inline script (layout.blade.php)
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

## GeoJSON source

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
