---
name: Map Visibility Fix
description: Fixes for map not appearing in wizard steps (FixCreateTicketWizard)
type: concept
---

# Map Visibility Fix Guide

## Symptoms
- Map container is invisible when navigating to wizard step "Form dati della segnalazione"
- No map tiles, controls, or search box visible despite HTML structure being correct
- Console shows no errors, but Leaflet fails to render

## Root Causes

### 1. Missing `height` Value
```php
// WRONG - missing proper height configuration
Height::make('340px') // returns string, but not applied to container

// CORRECT - enforce height via Tailwind utility
<div class="h-[340px]">...</div>
```

### 2. CSS Overlap Preventing Interaction
- `.bg-gray-900` or `.bg-black` applied to parent wrapper hides map controls
- Incorrect `z-index` on dropdown menus causes them to render underneath map pane
- `overflow: hidden` on container clips map canvas

### 3. Cardinal Direction Context
- Wizard step depth requires **depth >= 12** in MutationObserver to detect `class="hidden"` toggle
- Using depth < 12 means observer never triggers → map never refreshed

### 4. Legacy Component Conflict
- Commented-out `<GeopointPicker>` references remain in Blade
- These cause class name collisions for Leaflet CSS targeting
- Result: map container receives unexpected `hidden` class

## Solutions

### A. Enforce Proper Container Height
```blade
<div class="w-full h-[340px] map-container">
    <div class="map-picker-leaflet-pane"></div>
</div>
```

### B. Fix CSS Overlap
```css
/* Add to app.css */
.map-container {
    z-index: 1050 !important; /* Above dropdown menus */
    position: relative;
    overflow: visible !important;
}
```

### C. Correct Deep Observation
```js
// In coordinate-picker-lit.js – set depth to 20+ for Filament 5 steps
let parent = this.parentElement;
for (let i = 0; i < 20 && parent; i++) {
    this._mutationObserver.observe(parent, {
        attributes: true,
        attributeFilter: ['class', 'style', 'hidden']
    });
    parent = parent.parentElement;
}
```

### D. Clean Component References
- Remove any commented `<GeopointPicker>` or `<LatitudeLongitudeInput>` tags
- Keep only one active picker component per step
- Use `CoordinatePicker` as the canonical component

### E. Initialise Map Properly
```js
_initMap() {
    const el = this.renderRoot.querySelector('.map-picker-leaflet-pane');
    if (!el || this._map) return;

    const centerLat = this._lat ?? 41.9028;
    const centerLng = this._lng ?? 12.4964;

    this._map = L.map(el, {
        center: [centerLat, centerLng],
        zoom: this.zoom,
        zoomControl: false,
        attributionControl: false
    });

    // Add tile layers...
}
```

## Best Practices ✅

| Practice | Why |
|---|---|
| **Fixed height container** (`h-[340px]`) | Guarantees Leaflet can calculate dimensions |
| **Depth >= 20 MutationObserver** | Captures `class="hidden"` toggle in Filament wizard |
| **Single active picker** | Prevents CSS class conflicts |
| **`overflow: visible`** on map container | Allows Leaflet controls to render outside bounds |
| **Explicit `zoomControl: false`** | Avoids duplicate Leaflet controls |
| **Dedicated CSS for z-index** | Prevents dropdowns from hiding under map |

## Bad Practices ❌

- Using `height="340px"` string instead of Tailwind utility class
- Relying on `IntersectionObserver` to detect hidden state
- Leaving commented component references in Blade
- Adding `!important` CSS rules without scope isolation
- Using `id="map"` instead of class-based selectors

## False Friends 🚫

| Misconception | Reality |
|---|---|
| "Map is loaded, just need more time" | Issue is structural (hidden class depth) not timing |
| "Add more debounce" | Incorrect – need proper observer configuration |
| "Shadow DOM isolates Leaflet" | Leaflet requires Light DOM for CSS panes |
| "Commented components are harmless" | They inject hidden class conflicts |

## References

- ✅ [Leaflet Wizard Step Invalidate Size](laravel/Modules/Geo/docs/wiki/concepts/leafet-wizard-step-invalidate-size.md)
- ✅ [Coordinate Picker Fullscreen Handling](laravel/Modules/Geo/docs/wiki/concepts/coordinate-picker-fullscreen-wizard-contract.md)
- ✅ [Fixcity Wizard Map Visibility](laravel/Modules/Fixcity/docs/wiki/concepts/wizard-map-visibility-fix.md)
- ✅ [Design Comuni – Map Controls](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html)

*Last updated: 2026-04-23*