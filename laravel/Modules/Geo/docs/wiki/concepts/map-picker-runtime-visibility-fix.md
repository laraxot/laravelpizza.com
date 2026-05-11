# Map Picker Runtime Visibility Fix

## Best Practice: Ensure Map Visibility in Wizard Steps

### Core Issue
When navigating the Livewire wizard, the Leaflet map container remains hidden (`display: none`) when transitioning to the summary step. The existing `MutationObserver` in `coordinate-picker-lit.js` attempts to resolve this by calling `_refreshMapSize()` with a 150ms timeout, but this is inconsistent across browsers and device sizes.

### Solution
Replace the current timeout-based approach with a robust `ResizeObserver` combined with a visibility check to guarantee the map is fully rendered before initializing Leaflet.

## Implementation Steps

1. **Add ResizeObserver with Animation Frame**
   ```js
   // In firstUpdated()
   this._resizeObserver = new ResizeObserver((entries) => {
       for (const entry of entries) {
           if (entry.target === this) {
               requestAnimationFrame(() => this._onResize(entry));
           }
       }
   });
   this._resizeObserver.observe(this);
   ```

2. **Implement Proper Resize Handler**
   ```js
   _onResize(entry) {
       // Only proceed after layout stabilizes
       requestAnimationFrame(() => {
           if (this.offsetParent !== null) {
               this._refreshMapSize();
           }
       });
   }
   ```

3. **Visibility Handling**
   ```js
   // In disconnectedCallback()
   this._resizeObserver?.disconnect();
   ```

4. **Map Initialization Safety**
   ```js
   _initMap() {
       // Ensure container has explicit dimensions
       if (!this.offsetParent) return;
       
       this._map = L.map(this.querySelector('.map-picker-leaflet-pane'), {
           center: [this._lat ?? 41.9028, this._lng ?? 12.4964],
           zoom: this.zoom,
           zoomControl: false,
           attributionControl: false
       });
   }
   ```

5. **CSS Requirements**
   - Add to `map-picker-styles.js`:
     ```css
     .map-container {
         min-height: 300px;
         transition: opacity 0.2s ease;
         opacity: 1;
     }
     .map-container.is-hidden {
         opacity: 0;
         pointer-events: none;
     }
     ```

## Why This Works
- `ResizeObserver` detects when the element becomes visible in the layout
- `requestAnimationFrame` ensures the handler runs after layout stabilization
- Direct dimension observation eliminates timing issues with `MutationObserver`
- Explicit CSS opacity manages visual transition without affecting layout

## Verification Checklist
- [ ] Map renders correctly on first visit to summary step
- [ ] No blank/empty map containers after step navigation
- [ ] Mobile view preserves map dimensions during step transitions
- [ ] Performance impact is negligible (<5ms render per observation)

## Related Rules
- [Leaflet Wizard invalidateSize Rule](leaflet-wizard-invalidate-size.md)
- [SVG Asset Location](svg-asset-location.md)
- [Design Comuni Theme CSS Build Workflow](theme-css-build-workflow.md)

## References
- Story: 8-26 (map runtime fix)
- Fixcity Wiki: [[../../../../docs/wiki/concepts/map-picker-runtime-asset-governance.md|Map Picker Architecture]]