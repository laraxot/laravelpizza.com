# Map Tile Incomplete Loading Fix

## Problem
When transitioning to the map step in the wizard, only some tiles load, leaving empty squares (tile-shaped holes). This is a recurring error.

## Root Cause
1. **Race condition**: Tiles requested before container has correct dimensions
2. **invalidateSize() insufficient**: Calling invalidateSize() alone doesn't always trigger tile re-request
3. **Tile coordinates cached**: Leaflet caches tile coordinates based on map dimensions at request time

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

### 2. Initial Map Setup
Ensure proper initialization when map becomes visible:

```javascript
_initMap() {
    // ... existing code ...
    
    // REMOVE: setTimeout(() => this._map?.invalidateSize(), 350);
    // REPLACE with:
    setTimeout(() => {
        if (this._map) {
            this._map.invalidateSize();
            this._map.eachLayer((layer) => {
                if (layer._url) layer.redraw();
            });
        }
    }, 350);
}
```

### 3. Fullscreen Handling
Fix the fullscreen change handler:

```javascript
_onFullscreenChange() {
    const isFullscreen = !!document.fullscreenElement;
    this.classList.toggle('is-fullscreen', isFullscreen);
    
    if (this._map) {
        // Multiple invalidations for reliability
        [100, 300, 500].forEach(delay => {
            setTimeout(() => {
                this._map.invalidateSize();
                this._map.eachLayer(layer => {
                    if (layer._url) layer.redraw();
                });
            }, delay);
        });
    }
}
```

## Best Practices

- **Never assume single invalidateSize() is enough** - use multiple delays
- **Always check container dimensions** before triggering tile operations
- **Use layer.redraw()** for tile layers that might have incorrect tiles
- **Test with slow connections** to catch race conditions

## False Friends

- ❌ `map.invalidateSize()` alone - tiles may not reload
- ❌ Single timeout - race condition with DOM updates
- ✅ `invalidateSize()` + `layer.redraw()` + multiple delays

## Visual Verification Checklist

- [ ] All map tiles load within 2 seconds of step transition
- [ ] No empty squares visible
- [ ] Fullscreen mode shows complete tiles
- [ ] Zoom in/out works immediately after step transition
- [ ] Switching layers shows complete tiles
- [ ] No console errors about tile loading

## Related Files

- `laravel/Modules/Geo/resources/js/components/map-picker-lit.js`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Modules/Fixcity/docs/wiki/concepts/wizard-map-visibility-fix.md`

## Testing

### Manual Test Steps
1. Navigate to wizard step with map
2. Verify all tiles load (no empty squares)
3. Click fullscreen - verify tiles load completely
4. Zoom in/out - verify tiles update correctly
5. Switch layer - verify new tiles load
6. Navigate away and back - verify tiles reload

### Automated Check (Playwright)
```javascript
test('Map tiles load completely', async ({ page }) => {
    await page.goto('/it/tests/segnalazione-crea');
    await page.click('text=Avanti');  // Go to map step
    
    // Wait for map to be visible
    const mapContainer = page.locator('.leaflet-container');
    await expect(mapContainer).toBeVisible();
    
    // Check for tile images (should be > 0)
    const tiles = page.locator('.leaflet-tile');
    await expect(tiles).toHaveCountGreaterThan(0);
    
    // Check no empty tiles (tiles with 0x0 dimensions)
    const hasEmptyTiles = await page.evaluate(() => {
        const tiles = document.querySelectorAll('.leaflet-tile');
        return Array.from(tiles).some(t => t.naturalWidth === 0 || t.naturalHeight === 0);
    });
    expect(hasEmptyTiles).toBeFalsy();
});
```
