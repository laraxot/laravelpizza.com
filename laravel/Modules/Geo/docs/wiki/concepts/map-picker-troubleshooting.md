---
name: map-picker-troubleshooting
description: Guide for diagnosing and fixing MapPicker issues in the Geo module
---

# MapPicker Troubleshooting Guide

## Common Symptoms
- **Blank map** on wizard step navigation (e.g., `/it/segnalazione-crea?step=...`).
- **Tiles not loading** despite correct HTML structure.
- **Console errors** related to `leaflet.openstreetmap.org` or `ArcGIS`.
- **Picker component not initializing** (`customElements.get('map-picker-lit')` undefined).

## Root Cause Analysis

### 1. Timing Issues
- The `<coordinate-picker-lit>` component is added to the DOM *after* the wizard step becomes visible.
- Leaflet's `L.Map` is instantiated before the container has non‑zero dimensions.

**Fix:**  
Use a `MutationObserver` (see `map-picker-lit.js`) to detect when the wrapper exits the `hidden` class and then call `map.invalidateSize()` followed by a short `setTimeout` (700‑1200 ms) before initializing the map.

```js
// In connectedCallback()
this._mutationObserver = new MutationObserver(() => {
  if (this.offsetParent !== null && this._map) {
    setTimeout(() => this._map.invalidateSize(), 700);
  }
});
let parent = this.parentElement;
for (let i = 0; i < 12 && parent; i++) {
  this._mutationObserver.observe(parent, {
    attributes: true,
    attributeFilter: ['class', 'style', 'hidden']
  });
  parent = parent.parentElement;
}
```

### 2. CSS Blocking
- `.dropdown-menu { display: none !important }` from Bootstrap Italia overrides Alpine's `x-show`.
- Wrapper may have `bg-gray-900` or other dark backgrounds that hide controls.

**Fix:**  
- Force `pointer-events: auto` on the map container.
- Ensure `z-index` of dropdown menus > 1000.
- Use `bg-white` on the map wrapper when on a guest or authenticated context.

### 3. Asset Loading Errors
- Missing SVG marker (`map-marker.svg`) leads to Leaflet defaulting to an unprefixed icon that may not be visible.
- Dependence on external providers (`unpkg.com`, `cdn.`) is prohibited; use locally versioned assets only.

**Fix:**  
- Place all SVG markers under `laravel/Modules/Geo/resources/svg/`.
- Register a custom Leaflet icon via `L.divIcon` with inline SVG (see `map-picker-marker-config.js`).

### 4. JavaScript Import Issues
- Importing Leaflet CSS via `<link>` in Blade templates is not allowed; all assets must be bundled through Vite.
- Using `L.Icon.Default` falls back to CDN assets.

**Fix:**  
```js
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
```
- Always use `L.divIcon` for custom markers.

## Diagnostic Checklist

| ✅ | Check |
|----|-------|
| 1 | Verify `coordinate-picker-lit` custom element exists (`customElements.get('map-picker-lit')`). |
| 2 | Confirm the component’s shadow root contains `.map-picker-leaflet-pane`. |
| 3 | Ensure the container `.map-container` has non‑zero width/height after the step is shown. |
| 4 | Check network tab for 404s on `*.svg` or `*.css` files under `resources/svg/` and `resources/css/`. |
| 5 | Look for `leaflet-tile-error` classes in the rendered tiles. |
| 6 | Ensure `pointer-events: auto` is set on `.map-container`. |
| 7 | Validate that the correct Vite build was run (`npm run build && npm run copy` from `laravel/Themes/Sixteen`). |
| 8 | Capture a screenshot of the map area and compare against `reference/screenshots/map-ready.png`. |

## Fix Workflow

1. **Make HTML adjustments** (add missing wrapper classes, ensure no `display: none` from Bootstrap Italia).  
2. **Update JS** (add MutationObserver, use `invalidateSize()` with appropriate timeout).  
3. **Re‑run the build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`.  
4. **Run the smoke test**: `node scripts/map-picker-smoke.cjs http://127.0.0.1:8000/it/segnalazione-crea?step=...`.  
5. **Verify visually** – open the URL in a browser and confirm tiles appear, dropdown works, avatar is visible.  
6. **Document the change** in `docs/wiki/concepts/map-picker-troubleshooting.md` and add a checklist entry to `docs/merge-conflict-task-list.md` under *MapPicker fixes*.

## References
- `laravel/Modules/Geo/resources/js/components/map-picker-lit.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-marker-config.js`
- `laravel/Modules/Geo/resources/svg/map-marker.svg`
- Design System rule: *No page‑specific CSS* – keep styles generic (`Design Comuni`).
- Policy: *Leaflet must not rely on unpkg/ CDN assets* – see `svg-asset-location.md`.

---
*When in doubt, run the diagnostic script (`scripts/map-picker-smoke.cjs`) and inspect the JSON report for tile counts, loaded tile ratios, and console errors.*