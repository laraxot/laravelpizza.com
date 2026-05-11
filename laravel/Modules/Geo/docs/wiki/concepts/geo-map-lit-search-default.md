# GeoMapLit Search Visibility Default

## Overview
The `geo-map-lit` component keeps address search **collapsed by default** and opens it on demand via the magnifying-glass control. This avoids overlap with map controls on small screens.

## Implementation Details
- The property `_searchOpen` is initialized to `false` (see `geo-map-lit.js`).
- The control button toggles this state via `_toggleSearch()`, which flips `_searchOpen` and triggers a Lit `requestUpdate()`.
- `renderSearch(ctx)` returns only the lens button when `_searchOpen === false`, and full search panel when `_searchOpen === true`.
- Search can be closed with close button or `Escape`.

## Rationale
- Keeps the map controls (fullscreen, zoom, layer switch) constantly accessible.
- Reduces UI clutter on mobile devices where screen estate is limited.
- Mirrors the behaviour of the original Farmshops implementation where the search panel is opened on‑demand.

## Related Rules
- **Map Interaction Transparency Rule** – ensures UI elements remain visible and interactive.
- **Lit Icons – Filament Way** – the magnifying‑glass icon is rendered via `geoIcon('magnifying‑glass')`.

## Test Coverage
- Visual check: initial state shows only `.geo-search-toggle`.
- After click on lens: `.geo-search-expanded` appears.
- After close/escape: component returns to collapsed state.
