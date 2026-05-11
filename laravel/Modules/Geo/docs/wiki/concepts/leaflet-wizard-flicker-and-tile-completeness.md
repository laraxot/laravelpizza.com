# Leaflet Wizard Flicker & Tile Completeness Rule

## Problem
When transitioning to the map step in the Filament wizard, the map flickers and tiles load incompletely (empty squares). This is caused by race conditions between DOM visibility and Leaflet's tile requests.

## Root Cause
1. **Race condition**: Tiles requested before container has correct dimensions
2. **invalidateSize() insufficient**: Calling invalidateSize() alone doesn't always trigger tile re-request
3. **Tile coordinates cached**: Leaflet caches tile coordinates based on map dimensions at request time
4. **Multiple rapid transitions**: Wizard step changes trigger multiple rapid visibility changes

## Solution

### 1. Force Tile Layer Reload
After invalidateSize(), explicitly trigger tile recalculation:

```javascript
_refreshMapSize() {
    if (!this._map) return;
    
    const delays = [0, 80, 180, 350, 700, 1200];
    delays.forEach((delay) => {
        setTimeout(() => {
            window.requestAnimationFrame(() => {
                const pane = this.querySelector('.map-picker-leaflet-pane');
                const rect = pane?.getBoundingClientRect();
                
                if (!rect || rect.width === 0 || rect.height === 0) {
                    return;
                }
                
                // Critical: invalidate size first
                this._map.invalidateSize();
                
                // Force tile layer to recalculate
                this._map.eachLayer((layer) => {
                    if (layer._url) {  // Is a tile layer
                        layer.redraw();
                    }
                });
                
                // Force map to recalculate bounds
                this._map.fire('viewreset');
            });
        }, delay);
    });
}
```

### 2. MutationObserver with Proper Depth
```javascript
// In firstUpdated() — after _initMap():
this._mutationObserver = new MutationObserver(() => {
    if (this.offsetParent !== null && this._map) {
        this._refreshMapSize();
    }
});
let parent = this.parentElement;
// CRITICAL: use 12, NOT 6 — x-show of wizard step is at depth ~7-8
for (let i = 0; i < 12 && parent; i++) {
    this._mutationObserver.observe(parent, {
        attributes: true,
        attributeFilter: ['class', 'style', 'hidden']
    });
    parent = parent.parentElement;
}
```

### 3. Anti-Flicker Measures
- **Debounce interactions**: Prevent rapid coordinate updates during transitions
- **Guard flags**: `_geolocRequested` prevents duplicate geolocation requests
- **Multiple delayed redraws**: Ensure tiles load even in slow environments

## Implementation Files
- `laravel/Modules/Geo/resources/js/components/map-picker-lit.js`
- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`

## Testing Checklist
- [ ] Map tiles load completely within 2 seconds of step transition
- [ ] No flickering when navigating between wizard steps
- [ ] No empty squares visible after transition
- [ ] Fullscreen mode shows complete tiles
- [ ] Zoom in/out works immediately after step transition
- [ ] Switching layers shows complete tiles
- [ ] No console errors about tile loading

## Related Rules
- [leaflet-wizard-step-invalidate-size](./leaflet-wizard-step-invalidate-size.md)
- [coordinate-picker-wizard-visibility-rule](./coordinate-picker-wizard-visibility-rule.md)
- [map-picker-runtime-asset-governance](./map-picker-runtime-asset-governance.md)

## Anti-Patterns
- ❌ Single `invalidateSize()` call — insufficient
- ❌ `IntersectionObserver` for `class="hidden"` toggle — doesn't work
- ❌ Depth < 12 in MutationObserver — misses wizard x-show
- ❌ No `layer.redraw()` after `invalidateSize()` — tiles stay incomplete

*Updated: 2026-04-23*
