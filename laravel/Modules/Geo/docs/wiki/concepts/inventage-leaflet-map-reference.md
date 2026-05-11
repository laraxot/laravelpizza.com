# Riferimento: inventage/leaflet-map (Lit + Leaflet)

**Tipo:** concept / ricerca esterna  
**Status:** sintesi per confronto con `map-picker-lit` nel modulo Geo  
**Sorgente:** [github.com/inventage/leaflet-map](https://github.com/inventage/leaflet-map), pacchetto npm [`@inventage/leaflet-map`](https://www.npmjs.com/package/@inventage/leaflet-map)

---

## Scopo business

Capire come un progetto **open source maturo** incapsula Leaflet in un Web Component Lit, quali **eventi**, **lifecycle** e **resize** usa, e cosa è riusabile o diverso rispetto al nostro `MapPicker` / `map-picker-lit` (Filament, wizard, Livewire).

---

## Panoramica del repository

| Area | Contenuto |
|------|------------|
| Runtime | Web Component `<leaflet-map>` (classe `LeafletMap` in `src/LeafletMap.ts`) |
| Lit | **`lit-element`** (API classica `lit-element`, non il package unico `lit` attuale) |
| Leaflet | Import ESM da `leaflet/dist/leaflet-src.esm.js` (con `@ts-ignore` per typings) |
| Tooling | TypeScript, Storybook (`stories/`), test Karma / Web Test Runner (`test/`), demo (`demo/`) |
| Distribuzione | `custom-elements.json` per documentazione elementi |

Licenza: MIT (vedi `LICENSE` nel repo).

---

## `LeafletMap.ts` — comportamento rilevante

### Incapsulamento DOM

- Usa il **Shadow DOM** di default: in `firstUpdated` ottiene il contenitore con `this.renderRoot.querySelector('.map')` e chiama `L.map(mapDomElement)`.
- Il template `render()` espone un contenitore con classe **`map`** (mappa Leaflet montata lì).

### Stato ed proprietà (API pubblica)

- **`latitude` / `longitude`**: centro mappa (numeri, default Zurigo-area nel sorgente).
- **`defaultZoom`**, **`maxZoom`**, **`radius`**: cerchio opzionale intorno al centro.
- **`markers`**: array di `MarkerInformation` (`latitude`, `longitude`, `title?`, `url?`) con popup HTML.
- **`selectedMarker`**: evidenzia marker e apre popup.
- **`updateCenterOnClick`**: se true, click sulla mappa aggiorna centro (con evento `center-updated`).
- **`detectRetina`**: passato al tile layer OSM.

Stato interno Lit: `@state() markers`, `selectedMarker` (array marker Leaflet gestiti separatamente dal marker “centro”).

### Eventi custom (documentati anche in README)

| Evento | Payload | Quando |
|--------|---------|--------|
| `tiles-loading` | `{ promise }` | All’inizio caricamento tile; la promise si risolve su evento `load` del layer |
| `center-updated` | `{ latitude, longitude }` | Centro aggiornato (es. click se `updateCenterOnClick`) |
| `map-ready` | `{ map }` | Istanza `L.Map` da `map.whenReady()` |

### Lifecycle e integrazione Leaflet

1. **`firstUpdated`**: crea mappa, tile OSM, `L.control.scale()`, `whenReady` → `map-ready`, click ritardato (500 ms) per non confondere con doppio click; su iOS disabilita `tap` se presente (issue note nel codice).
2. **`updated`**: su ogni aggiornamento chiama **`_updateMapSize()`** (`invalidateSize()`); se cambiano lat/lng aggiorna marker centro, radius, markers, bounds (`fitBounds` se cerchio o marker).
3. **Dopo il primo paint**: `await new Promise(r => setTimeout(r, 0))` poi **`window.dispatchEvent(new Event('resize'))`** — pattern citato per problemi di primo render (storia legacy Lit/Polymer).
4. **`connectedCallback`**: debounce 200 ms su **`window` `resize`** → `_handleResize` (`invalidateSize` + `fitBounds`).
5. **`disconnectedCallback`**: rimuove listener `resize`.

### Icone marker

- Imposta `L.Icon.Default.imagePath` verso **unpkg** per le immagini default Leaflet.
- Marker “centro” rosso da URL esterni (CDN / repo leaflet-color-markers).

---

## Confronto con `map-picker-lit` (modulo Geo)

| Aspetto | inventage `LeafletMap` | Geo `map-picker-lit` |
|--------|-------------------------|----------------------|
| DOM | Shadow DOM + `.map` | **Light DOM** (`createRenderRoot() { return this; }`) per tile/stacking affidabile con il nostro stack |
| Scopo | Centro + raggio + **più marker** + selezione | **Un marker** draggable, layer Street/Satellite, ricerca Nominatim, geoloc, fullscreen |
| Eventi | `center-updated`, `map-ready`, `tiles-loading` | `coords-changed` (allineato a Filament/Livewire state path) |
| Resize | `updated` → sempre `invalidateSize`; debounce window resize | `ResizeObserver` sul host + init **differita** fino a box ≥ 32px (wizard Filament con step `h-0`) |
| Dipendenze | `lit-element`, `@queso/debounce` | `lit`, Leaflet dal bundle tema |

**Takeaway:** il progetto inventage è **ottimo riferimento** per eventi (`tiles-loading` + promise, `map-ready` con istanza map) e per il **debounce resize** globale; il nostro design privilegia **un contratto dati unico** con Filament e **nessun accoppiamento** a `window` dove possibile, più **init visibile** per wizard.

---

## Quando valutare dipendenza diretta

- **Pro:** meno codice da mantenere per scenari “mappa read-only + lista marker”.
- **Contro:** stack **`lit-element`** legacy, API diverse (props `latitude`/`longitude` flat vs nostro `location`), Shadow DOM può complicare CSS tema e integrazione Filament; **non** risolve da solo il problema **step wizard con altezza 0**.

Eventuale adozione: valutare come **peer** o fork solo logica eventi/tiles, non come drop-in nel wizard senza adattamento.

---

## Collegamenti

- [Documentazione README upstream](https://github.com/inventage/leaflet-map/blob/master/README.md)
- [Sorgente `LeafletMap.ts`](https://github.com/inventage/leaflet-map/blob/master/src/LeafletMap.ts)
- Wiki Geo locale: [map-picker-filament-field](./map-picker-filament-field.md), [lit-web-components](./lit-web-components.md)

---

*Ultimo aggiornamento: 2026-04-17*
