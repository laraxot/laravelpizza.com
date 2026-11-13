---
name: GeoMapLit Component
description: Documentation for geo-map-lit.js Lit component with Leaflet and markercluster
type: concept
---

# GeoMapLit Component

## Overview

`geo-map-lit.js` is a Lit Web Component that renders a Leaflet map with marker clustering (using `leaflet.markercluster`) for the ticket-list page. It follows the farmshops.eu pattern.

## Changes (2026-04-29)

- Removed heatmap functionality (`leaflet.heat`) due to `L.heatLayer` constructor errors.
- Heatmap-related state (`_heatLayer`, `showHeatLayer`) removed from constructor.
- Comment added: "Heatmap removed: leaflet.heat caused L.heatLayer constructor errors".
- Clustering handled exclusively by `leaflet.markercluster`.

## Contract Update (2026-04-30)

- `<geo-map-lit>` always renders the shared address search UI via `renderSearch(this)`.
- Do not pass `show-search` to `<geo-map-lit>` in Blade, docs, stories, or tests.
- The `show-search` API belongs only to picker components that still explicitly support optional search.
- If the search box causes layout issues, fix the shared CSS in `map/styles.js`; do not hide search with a component attribute.

## Architecture

- Uses LitElement for reactive updates.
- Imports shared modules: `map-picker-controls.js`, `map-picker-search.js`, `map-picker-layers.js`, `map-marker-config.js`.
- GeoJSON data loaded from `/data/tickets.json`.
- Markers clustered via `L.markerClusterGroup` with custom icon creation (`_createClusterIcon`).
- Handles map visibility in Filament wizard via `MutationObserver` (depth ≥ 12).

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
npm run build
npm run copy
```

## Golden Rule (2026-05-08)

**MapPicker Golden Rule — Auto-Geolocation**: If `latitude == null || longitude == null`, the map MUST auto-geolocate via browser GPS.

Implementation in `map-lit.js` and `geo-map-lit.js`:
- Constructor sets `this._geolocRequested = false`
- `requestGeolocation()` in `map-picker-controls.js` checks `ctx._geolocRequested` guard to prevent double-trigger
- If geolocation succeeds: `ctx._isUserCentered = true` and `ctx._map.setView([lat, lng], 12)`
- If geolocation fails or is denied: fallback to `DEFAULT_CENTER = [41.9028, 12.4964]`
- Guard `_geolocRequested` is set to `true` immediately when `requestGeolocation` is called successfully

```javascript
// In map-lit.js constructor
this._geolocRequested = false;

// In map-picker-controls.js
export function requestGeolocation(ctx, options = {}) {
    if (!navigator.geolocation || ctx.isLocating || ctx._geolocRequested) return;
    ctx._geolocRequested = true;
    // ... proceed with geolocation
}
```

## References

- `laravel/Modules/Geo/resources/js/components/geo-map-lit.js`
- `laravel/Modules/Geo/resources/js/components/map-lit.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-controls.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-marker-config.js`
- farmshops.eu pattern: `laravel/Modules/Geo/resources/js/direktvermarkter.js`
- Golden Rule source: `memory/project_map_golden_rule.md`
