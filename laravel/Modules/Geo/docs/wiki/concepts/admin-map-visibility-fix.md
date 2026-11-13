---
name: admin-map-visibility-fix
description: >
  Fix for missing map in Filament 5 admin ticket creation wizard step.
  Ensures map loads and controls remain visible when step toggles via x-show/hidden.
---

# Fix for Missing Map on Admin Ticket Creation Page

## Problem

On `http://127.0.0.1:8000/fixcity/admin/tickets/create?step=form.data::data::wizard-step` the Leaflet map fails to render correctly inside Filament 5 wizard steps when the step is toggled via `x-show`/`hidden`.

## Root Causes Identified

### 1. MutationObserver Depth Insufficient for Filament 5 Wizard

- Filament 5 DOM depth from the Lit component to the `x-show` toggle is ~8 levels.
- The original observer used `depth = 6`, missing the toggle node.
- Result: `_refreshMapSize` never fires when the step becomes visible, map stays blank.

### 2. Incorrect Observer Type for Class-Based Visibility

- `IntersectionObserver` does **not** detect `class="hidden"` toggles.
- Only `MutationObserver` with `attributeFilter: ['class', 'style', 'hidden']` works for Tailwind `hidden`/`show`.

### 3. Map Sizing Delays for Filament Wizard Compatibility

- Leaflet needs `invalidateSize()` after the container has non-zero dimensions.
- Staggered delays account for Alpine.js tick and any custom transition durations.

## Solution Applied

### MutationObserver Depth Update (map-picker-lit.js)

```js
// Observer depth increased to 12 to reach x-show in Filament 5 wizard steps
for (let i = 0; i < 12 && parent; i++) {
    this._mutationObserver.observe(parent, {
        attributes: true,
        attributeFilter: ['class', 'style', 'hidden']
    });
    parent = parent.parentElement;
}
```

### Staggered invalidateSize() Calls

```js
[0, 80, 180, 350, 700, 1200].forEach((delay) => {
    setTimeout(() => {
        if (this.offsetParent === null || !this._map) return;
        this._map.invalidateSize({ animate: false, pan: false });
        this._forceTileRedraw();
    }, delay);
});
```

- 700ms: covers standard Alpine tick.
- 1200ms: fallback for slow environments or custom transitions.

### CoordinatePickerLite (coordinate-picker-lit.js) Fix

- Added `this._layers = this._layers || {};` in `_initMap()` to prevent `Cannot set properties of undefined (setting 'street')`.
- Uses same MutationObserver depth 12 and `_refreshMapSize()` pattern.

### Marker Sizing Adjustments (map-picker-marker-config.js)

- `iconSize`: `[32, 45]` → `[24, 30]`
- `iconAnchor`: `[22, 42]` → `[12, 30]`
- `popupAnchor`: `[1, -32]` → `[0, -30]`
- Result: smaller marker footprint leaves room for control buttons in the map corner.

### Search Input Component Extraction

- Extracted search UI into `search-input.js` as a reusable template function.
- Keeps map-picker-lit.js clean and promotes reuse across wizard steps.

## Verification Checklist

- [x] Map renders correctly when entering the wizard step with empty coordinates.
- [x] Geolocation button works and updates map and state.
- [x] Fullscreen, Zoom, Layer Switch buttons remain clickable after step toggle.
- [x] Coordinate updates propagate to form fields and emit `coords-changed`.
- [x] Marker SVG icon scaled appropriately and does not overlap controls.
- [x] No console errors related to `_layers` or `_map` undefined.

## Asset Pipeline Reminder

After any JS/CSS changes in the Geo module:

```bash
cd /var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo
npm run build
npm run copy
```

## Documentation Links

- LLM Wiki: `docs/wiki/concepts/admin-map-visibility-fix.md` (this file)
- Related: `docs/wiki/concepts/leaflet-wizard-invalidate-size.md`, `docs/wiki/concepts/map-picker-troubleshooting.md`