# Fix: Map Blank Tiles in Wizard Steps

## Issue
When navigating through the Filament wizard steps, or when opening the map in fullscreen mode, map tiles do not fully render, leaving blank gray squares.

## Root Causes
1. **Leaflet initialization timing**: Leaflet initializes when container is hidden (0px size), then `invalidateSize()` is called but some tiles fail to load.
2. **MutationObserver depth**: Original code uses depth 12 to detect wizard step changes, but this may not catch all visibility changes.
3. **Resize observer intervals**: The staggered timeout approach may not wait long enough for container to reach final size.

## Solution
1. Increase MutationObserver depth to 15 to catch all DOM changes in wizard structure
2. Add staggered resize calls: [0, 50, 150, 300, 500, 800, 1200]ms
3. Add explicit check for container visibility before invalidating size
4. Force redraw of all tile layers after resize

## Files
- `coordinate-picker-lit.js` - main implementation
- `coordinate-picker-field.js` - field-specific adjustments

## Implementation Notes
```javascript
// Monitor deeper DOM hierarchy
for (let i = 0; i < 15 && parent; i++) {
    this._mutationObserver.observe(parent, { attributes: true, attributeFilter: ['class', 'style', 'hidden'] });
    parent = parent.parentElement;
}

// Extended resize intervals
_resizeMapSize() {
    if (!this._map) return;
    [0, 50, 150, 300, 500, 800, 1200].forEach((delay) => {
        setTimeout(() => {
            window.requestAnimationFrame(() => {
                const pane = this.renderRoot.querySelector('.map-picker-leaflet-pane');
                const rect = pane?.getBoundingClientRect();
                if (!rect || rect.width === 0 || rect.height === 0) return;
                this._map?.invalidateSize();
                Object.values(this._layers).forEach((layer) => {
                    if (layer?._map && typeof layer.redraw === 'function') {
                        layer.redraw();
                    }
                });
            });
        }, delay);
    });
}
```