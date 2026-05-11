# Map Flicker Fix in Wizard Steps

## Problem Description
The map flickers when navigating between wizard steps or when the component becomes visible. Flickering manifests as:
- Brief blank/white flashes during step transitions
- Tile reloading delays causing visual instability
- Repeated `invalidateSize()` calls causing layout thrashing

## Root Cause
1. **Multiple `invalidateSize()` calls** from overlapping observers (ResizeObserver + MutationObserver + Livewire events)
2. **No debouncing** on refresh methods leading to rapid successive calls
3. **Tile layer redraws** happening too frequently during visibility transitions
4. **Race conditions** between geolocation async calls and map initialization

## Implementation

### 1. Debounced Map Refresh
```javascript
// In coordinate-picker-lit.js
_setupRefreshDebounced() {
    if (!this._refreshDebounced) {
        this._refreshDebounced = debounce((delay) => {
            if (!this._map || this.offsetParent === null) return;
            
            window.requestAnimationFrame(() => {
                const pane = this.renderRoot.querySelector('.map-picker-leaflet-pane');
                const rect = pane?.getBoundingClientRect();
                if (!rect || rect.width === 0 || rect.height === 0) return;
                
                this._map.invalidateSize({ animate: false, pan: false });
                this._redrawTileLayers();
                
                if (this._lat != null && this._lng != null) {
                    this._updateMarker(this._lat, this._lng);
                }
            });
        }, 300); // 300ms debounce
    }
}
```

### 2. Single Observer Coordination
```javascript
// Replace multiple observers with coordinated single trigger
firstUpdated() {
    this._initMap();
    
    // Single debounced refresh for all observer types
    this._setupRefreshDebounced();
    
    // ResizeObserver - only trigger debounced refresh
    this._resizeObserver = new ResizeObserver(() => {
        this._refreshDebounced();
    });
    this._resizeObserver.observe(this);
    
    // MutationObserver - coordinated with ResizeObserver
    this._mutationObserver = new MutationObserver(() => {
        if (this.offsetParent !== null) {
            this._refreshDebounced();
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
    
    // Remove duplicate Livewire event listeners
    // Keep only one coordinated listener
    document.removeEventListener('livewire:updated', this._boundRefreshMapSize);
    document.addEventListener('livewire:updated', () => this._refreshDebounced());
}
```

### 3. Geolocation Guard
```javascript
// Prevent double geolocation requests
async _requestGeolocation() {
    if (!navigator.geolocation || this._geolocRequested) return;
    this._geolocRequested = true;
    
    this.isLocating = true;
    this.requestUpdate();
    
    return new Promise((resolve) => {
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                this._handleMapInteraction(lat, lng, 'geolocation');
                if (this._map) {
                    this._map.setView([lat, lng], 16);
                }
                this.isLocating = false;
                this.requestUpdate();
                resolve(true);
            },
            () => {
                this.isLocating = false;
                this.requestUpdate();
                resolve(false);
            },
            { enableHighAccuracy: true, timeout: 5000 }
        );
    });
}
```

## CSS Stability Fixes
```css
/* Prevent flash during map initialization */
.map-container {
    background-color: #e9ecef; /* Neutral backdrop */
    will-change: transform; /* GPU acceleration */
}

.leaflet-container {
    transition: opacity 0.2s ease-in-out;
}

/* Prevent tile flicker */
.leaflet-tile {
    will-change: transform;
    backface-visibility: hidden;
}
```

## Verification Steps
- [ ] Navigate between wizard steps 5 times - no flickering
- [ ] Resize browser window - smooth map transitions
- [ ] Toggle fullscreen mode - no blank flashes
- [ ] Test with slow 3G throttling - tiles load progressively without flicker
- [ ] Console shows max 1 `invalidateSize()` per 300ms period

## Related Files
- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- `laravel/Themes/Sixteen/resources/css/app.css`

## Wiki References
- [leaflet-wizard-step-invalidate-size](./leaflet-wizard-step-invalidate-size.md)
- [map-loading-fix-in-wizard](./map-loading-fix-in-wizard.md)
- [map-default-coordinates-wizard](./map-default-coordinates-wizard.md)
