# Troubleshooting: Map Rendering in Wizards & Tabs

## Problem: Blank Maps
When a geographic component (e.g., `MapPicker`, `GeopointPicker`) is placed inside a Filament Wizard step (especially steps after the first) or a dormant Tab, the map often appears blank, gray, or only shows a small square of tiles in the top-left corner.

### Root Causes
1. **Zero-Dimension Initialization**: Leaflet (and most map libraries) needs physical pixel dimensions to calculate tile positions. If the map initializes while its container is `display: none`, it inherits `0x0` dimensions, causing rendering failure.
2. **Framework DOM Diffing**: Standard Shadow DOM components can be "cleared" or disconnected by Alpine.js or Livewire's diffing engine during parent state updates, causing the Leaflet instance to be lost.

---

## Solution 1: Resize Recovery
All standardized components now use a `ResizeObserver` to detect when they gain physical dimensions.

### Technical Implementation
```javascript
firstUpdated() {
    this._resizeObserver = new ResizeObserver(() => {
        if (this._map) {
            // Apply delay to allow CSS transitions (e.g., wizard slide) to finish
            setTimeout(() => this._map.invalidateSize(), 350);
        }
    });
    this._resizeObserver.observe(this);
}
```

---

## Solution 2: Light DOM Persistence
To avoid the "disappearing map" bug during Livewire updates, we switch from Shadow DOM to **Guarded Light DOM**.

### Technical Implementation
1. **createRenderRoot**: Force the component to render in the Light DOM.
2. **guard**: Protect the map container from Lit's diffing engine.

```javascript
createRenderRoot() {
    return this; // Light DOM
}

render() {
    return html`
        <div class="map-container">
            ${guard([], () => html`<div class="map-pane"></div>`)}
        </div>
    `;
}
```

---

## Solution 3: Standardized Icon Rendering (Missing Icons)
If controls (Zoom, Fullscreen) appear as small text snippets like `<svg...>` instead of icons:

### Root Cause
LitElement escapes strings by default. If `controlIcons.zoomIn` is a raw string, it won't render as an SVG.

### Fix
Standardize the icon export to use the `html` tag:
```javascript
export const controlIcons = {
    zoomIn: html`<svg ...></svg>`,
    // NOT: zoomIn: '<svg ...></svg>'
};
```

---
*Created: 2026-04-22*
*Part of: Geo Module Troubleshooting Guide*
