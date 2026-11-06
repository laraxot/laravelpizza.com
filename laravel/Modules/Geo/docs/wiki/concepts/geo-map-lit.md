---
title: "geo map lit"
tags: [documentation]
created: 2026-09-26
updated: 2026-10-14
qmd: "geo map lit"
issues: []
discussions: []
name: GeoMapLit Component
description: Documentation for geo-map-lit.js Lit component with Leaflet and markercluster
type: concept
status: draft
---

# GeoMapLit Component

## Overview

`geo-map-lit.js` is a Lit Web Component that renders a Leaflet map with marker clustering (using `leaflet.markercluster`) for the ticket-list page. It follows the farmshops.eu pattern.

## Changes (2026-04-29)

- Removed heatmap functionality due to `L.heatLayer` constructor errors: `_heatLayer` e `showHeatLayer` non sono piu in `geo-map-lit.js` (verificato 2026-10-14).
- Correzione 2026-10-14: `geo-map-lit.js` importa ancora `leaflet.heat` (riga 18) senza usarlo, e il commento "Heatmap removed..." citato prima non e nel file. Togliere l'import e un cambio di codice, non fatto in questa revisione dei docs.
- Clustering handled exclusively by `leaflet.markercluster` (`L.markerClusterGroup`, `_createClusterIcon`).

## Contract Update (2026-04-30)

- `<geo-map-lit>` uses the shared address search UI via `renderSearch(this)`, rendered when the search panel is open (`_searchOpen`, toggled by `_toggleSearch()`; verificato 2026-10-14: non e sempre presente nel DOM).
- Do not pass `show-search` to `<geo-map-lit>` in Blade, docs, stories, or tests (the component has no such attribute).
- The `show-search` API belongs only to picker components that still explicitly support optional search.
- If the search box causes layout issues, fix the shared CSS in `map/styles.js`; do not hide search with a component attribute.

## Architecture

- Uses LitElement for reactive updates.
- Imports shared modules: `map-picker-controls.js`, `map-picker-search.js`, `map-picker-layers.js`, `map-marker-config.js`.
- GeoJSON data loaded from `/data/tickets.json`.
- Markers clustered via `L.markerClusterGroup` with custom icon creation (`_createClusterIcon`).
- Handles map visibility in Filament wizard via `MutationObserver` on up to 12 ancestors (`for (let i = 0; i < 12 && parent; i++)`), not "depth >= 12".

## Usage

```html
<geo-map-lit
    data-url="/data/tickets.json"
    height="450px"
></geo-map-lit>
```

## Build

After modifying JS in Geo module:

```bash
cd laravel/Themes/Sixteen
npm run build   # esegue gia anche `npm run copy` e `php artisan view:clear` (Themes/Sixteen/package.json)
```

## Golden Rule (2026-05-08)

**MapPicker Golden Rule — Auto-Geolocation**: If `latitude == null || longitude == null`, the map MUST auto-geolocate via browser GPS.

Stato reale del codice, verificato il 2026-10-14 (la descrizione del 2026-05-08 qui sopra non corrispondeva piu):
- `map-lit.js` imposta `this._geolocRequested = false` nel costruttore (riga 112). `geo-map-lit.js` NON ha `_geolocRequested`: fa una propria richiesta GPS con `setView([lat, lng], Math.max(zoomCorrente, 13))` e, in caso di errore, scrive solo un log.
- `requestGeolocation()` in `map-picker-controls.js` (usato da `geo-map-lit.js`) esce se `ctx.isLocating` o se `ctx._geolocRequested && !showLoading` (un clic esplicito sul pulsante passa sempre). Alla riuscita centra con `locateZoom = Math.max(ctx.zoom, 14)` (15 se `zoom` non e un numero), non 12, e imposta `ctx._isUserCentered = true`. In caso di errore azzera `_geolocRequested` e non usa `DEFAULT_CENTER`.
- `DEFAULT_CENTER = [41.9028, 12.4964]` e solo il centro iniziale della mappa (`geo-map-lit.js:29`, `map-lit.js:48`).
- Il picker (`coordinate-picker-lit.js`) usa `map/controls/geolocation.js`: senza `window.isSecureContext` non chiede il GPS e ricade sul punto salvato o sulla vista iniziale (`_initialView`), con un invito neutro. La regola "MUST auto-geolocate" non vale quindi su HTTP; vedi `stories/dcp-127-mappa-centratura-senza-https.story.md`.

## References

- `laravel/Modules/Geo/resources/js/components/geo-map-lit.js`
- `laravel/Modules/Geo/resources/js/components/map-lit.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-controls.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-marker-config.js`
- farmshops.eu pattern: `laravel/Modules/Geo/resources/js/direktvermarkter.js`
- Golden Rule source: `memory/project_map_golden_rule.md` (non verificato: il file non esiste nel repo ne in `~/.claude/projects/.../memory/`)
