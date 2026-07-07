---
title: "Map JS Module Naming Rule"
type: concept
module: Geo
confidence: high
created: 2026-05-15
updated: 2026-05-15
tags: [geo, leaflet, lit, map-folder, dry, naming]
related:
  - geo-map-controls-unification-rule.md
  - map-picker-family-architecture.md
  - geo-map-controls-shared-implementation.md
  - ../../../../Themes/Sixteen/docs/wiki/concepts/theme-geo-js-boundary.md
---

# Regola: moduli JS mappa in `components/map/`

## Scopo

La logica Leaflet/Lit **condivisa** tra `coordinate-picker-lit`, `geo-map-lit`, `map-lit` vive in una cartella dedicata. Il **path** è il namespace (`map/controls.js`, `map/styles.js`), non prefissi ripetuti nel filename (`map-picker-controls.js`, `map/styles.js`).

Obiettivo: DRY + KISS — un posto per controlli, eventi, search, resize, utils, styles; suffisso `map-picker-*` solo per ciò che resta davvero legato al contratto picker, ad esempio marker icon config. I file root `map-picker-*` legacy devono restare solo come re-export di compatibilità.

## Layout canonico

```
Modules/Geo/resources/js/components/
├── coordinate-picker-lit.js      ← entry Lit (importa da ./map/*)
├── geo-map-lit.js
├── map-picker-marker-config.js   ← picker-specific (icona marker)
└── map/
    ├── controls.js               ← barrel: overlay + re-export search
    ├── events.js                 ← initMap, click, marker sync
    ├── search.js                 ← shim → `./controls/search.js` (+ alias `renderSearchPanel`)
    ├── resize.js                 ← invalidateSize, observer
    ├── utils.js                  ← resolveStateCoordinates, normalizeCoordinatePair
    ├── layers.js                 ← tile layers OSM/satellite/topo
    ├── heroicons.js              ← SVG controlli mappa (`geoIcon`)
    ├── styles.js                 ← CSS condiviso (`mapStyles`, `mapStylesText`)
    ├── resize-after-action.js    ← invalidateSize dopo azioni controllo
    ├── popup-ticket.js           ← popup marker map-lit (STORY-132; era popup-segnalazione.js)
    ├── marker-config.js          ← divIcon marker (import da map-lit)
    ├── icon-glyph.js
    └── controls/
        ├── render-controls.js    ← solo registry `OVERLAY_PARTS` → moduli sotto `controls/`
        ├── search.js             ← Nominatim, `renderSearch`, `searchUiHandlers`, `renderToggleButton`
        ├── fullscreen.js
        ├── zoom-in-out.js
        ├── geolocation.js        ← `requestGeolocation`
        └── switch-layer.js
```

Nella stessa cartella `map/` possono esistere file legacy Vue (es. `Map1.vue`): **non** confonderli con i moduli Lit sopra.

## Regola import

| Path | Uso |
|------|-----|
| `./map/controls.js` | Controlli generici |
| `./map/events.js` | Interazioni mappa |
| `./map/search.js` | Shim compat → `./controls/search.js` (`renderSearchPanel` = alias deprecato di `renderSearch`) |
| `./map/controls/search.js` | Ricerca indirizzo (logica + `renderSearch`, `renderToggleButton`, `searchUiHandlers`) |
| `./map/resize.js` | Refresh dimensioni |
| `./map/utils.js` | Normalizzazione coordinate |
| `./map/layers.js` | `buildMapLayers(L)` |
| `./map/heroicons.js` | `geoIcon(name)` per controlli/search |
| `./map/styles.js` | `mapStyles`, `mapStylesText`, `controlIcons` legacy |
| `./geo-heroicons.js` | **Deprecated** — re-export verso `./map/heroicons.js` |
| `./map/styles.js` | **Deprecated** — re-export verso `./map/styles.js` |
| `./map-picker-marker-config.js` | Solo icona marker picker |

### Filename: solo inglese (standing rule)

Sotto `map/` e tutto `resources/js/`: **vietato** segmenti italiani nel path (`segnalazione`, `mappa`, `filtro`, …).

| Deprecato | Canonico |
|----------|----------|
| `popup-segnalazione.js` | `popup-ticket.js` |

Dettaglio: [js-file-english-naming-rule.md](../rules/js-file-english-naming-rule.md) · [STORY-132](../../../../../docs/stories/STORY-132-rename-popup-segnalazione-js-english.md)

### Vietato

- `map-picker-controls.js`, `map-controls.js`, `map/styles.js` in nuovo codice root `components/` (spostati in `map/`; il file styles root resta solo compatibilità).
- Duplicare `map/` nel tema senza allineare il mirror `Themes/Sixteen/resources/js/components/modules/Geo/map/`.
- Nuovi file `*-segnalazione*.js` o export `buildSegnalazione*`.

## Import corretti (`coordinate-picker-lit`)

```js
import { mapStylesText } from './map/styles.js';
import { renderControls, switchLayer, toggleFullscreen, zoomIn, zoomOut, requestGeolocation, syncFullscreenState } from './map/controls.js';
import { renderSearch, searchUiHandlers } from './map/controls/search.js';
import { initMap, handleMapInteraction, updateMarker, syncMarkerToProperties } from './map/events.js';
import { refreshMapSize, bindRefreshHandler, cleanupObservers } from './map/resize.js';
import { resolveStateCoordinates } from './map/utils.js';
```

## Build e verifica

```bash
cd laravel/Themes/Sixteen
npm run build
npm run copy
```

`app.js` importa `coordinate-picker-field` da `@modules/Geo/...` (usa il modulo Geo, non il mirror).

## Collegamenti

- [geo-map-controls-unification-rule](./geo-map-controls-unification-rule.md)
- [geo-map-controls-shared-implementation](./geo-map-controls-shared-implementation.md)
- [theme-geo-js-boundary](../../../../Themes/Sixteen/docs/wiki/concepts/theme-geo-js-boundary.md)
