---
title: "MapPicker Custom Marker Rule"
type: decision
confidence: high
created: 2026-04-20
updated: 2026-04-20
tags: [mappicker, marker, custom, farmshops, svg, leaflet]
sources:
  - https://github.com/CodeforKarlsruhe/farmshops.eu
  - laravel/Modules/Geo/resources/js/components/map-picker-marker-config.js
related:
  - ./map-picker-runtime-asset-governance.md
  - ../../../docs/rules/xotbasefield-mandatory.md
---

# MapPicker Custom Marker Rule

## The Rule

**MapPicker MUST use a custom, repository-local SVG marker. NEVER use Leaflet default markers or unpkg/CDN assets.**

---

## Rationale

### Why Custom Marker?

1. **Brand Identity**: Consistent visual language across the application
2. **No External Dependencies**: No reliance on unpkg.com or CDN availability
3. **Retina/HiDPI Support**: SVG scales perfectly on all devices
4. **Style Control**: Full CSS/gradient control for theming
5. **Farmshops Inspiration**: Modern "location pin" aesthetic with strong contrast

### Why NOT Leaflet Default?

- ❌ Requires external PNG files from unpkg
- ❌ Breaks when offline or CDN fails
- ❌ No retina support without @2x versions
- ❌ Limited styling options

---

## Implementation

### File Structure

```
laravel/Modules/Geo/resources/
├── js/components/
│   ├── map-picker-lit.js           # Uses createMapPickerLeafletIcon()
│   └── map-picker-marker-config.js # Marker configuration
└── svg/
    └── map-picker-marker-fallback.svg # Fallback asset
```

### Marker Config (map-picker-marker-config.js)

```javascript
export function createMapPickerLeafletIcon(L, type = 'default') {
    const markerSvg = `
        <svg width="44" height="56" viewBox="0 0 44 56">
            <defs>
                <linearGradient id="geoMarkerMain" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#fb7185"/>  <!-- rose-400 -->
                    <stop offset="100%" stop-color="#e11d48"/> <!-- rose-600 -->
                </linearGradient>
                <filter id="geoMarkerDrop">
                    <feDropShadow dx="0" dy="3" stdDeviation="2.2" 
                        flood-color="#111827" flood-opacity="0.35"/>
                </filter>
            </defs>
            <g filter="url(#geoMarkerDrop)">
                <!-- Pin shape -->
                <path d="M22 2c-10.3 0-18.5 8.2-18.5 18.5 0 13.4 16.2 29 17.1 29.8.8.7 2 .7 2.8 0 .9-.8 17.1-16.4 17.1-29.8C40.5 10.2 32.3 2 22 2z" 
                    fill="url(#geoMarkerMain)"/>
                <!-- Inner circle (white) -->
                <circle cx="22" cy="20.5" r="9.2" fill="#fff"/>
                <!-- Center dot (dark rose) -->
                <circle cx="22" cy="20.5" r="5.2" fill="#9f1239"/>
            </g>
        </svg>
    `;

    return L.divIcon({
        className: 'map-picker-marker map-picker-marker--custom',
        html: `<div class="map-picker-marker__inner">${markerSvg}</div>`,
        iconSize: [44, 56],
        iconAnchor: [22, 54],    // Bottom center
        popupAnchor: [0, -42],   // Above marker
    });
}
```

### Design Specs

| Property | Value | Note |
|----------|-------|------|
| Size | 44×56px | Larger than standard for touch targets |
| Color | Rose gradient (#fb7185 → #e11d48) | Brand color, high contrast |
| Shadow | CSS drop shadow | Depth on all backgrounds |
| Inner | White circle | Visual focus point |
| Center | Dark rose dot | Precise location indicator |

---

## Farmshops.eu Inspiration

### What We Learned

From [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu):

```javascript
// Their approach: Color-coded markers by type
var farmMarker = L.ExtraMarkers.icon({
    icon: 'fa-number',
    markerColor: 'green-light',
    shape: 'square',
});
```

### Our Improvements

1. **No External Library**: Pure SVG instead of ExtraMarkers dependency
2. **Single Icon**: Unified design (vs. multiple colors per type)
3. **Better Proportions**: 44×56px with proper anchor point
4. **Modern Aesthetic**: Gradient + shadow vs. flat colors

---

## Usage in Components

```javascript
// In map-picker-lit.js
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';

_updateInternal(lat, lng) {
    if (!this._marker) {
        this._marker = L.marker([lat, lng], {
            draggable: true,
            icon: createMapPickerLeafletIcon(L),  // ✅ Custom marker
        }).addTo(this._map);
    }
}
```

---

## CSS Styling

```css
.map-picker-marker--custom {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.map-picker-marker__inner svg {
    display: block;
    width: 100%;
    height: 100%;
}
```

---

## Verification

```bash
# Check no default Leaflet markers are used
grep -r "L.Icon.Default" laravel/Modules/Geo/resources/js/
# Should return only marker-config files (no usage)

# Check no unpkg/CDN references
grep -r "unpkg\|cdn" laravel/Modules/Geo/resources/js/
# Should be empty
```

---

## Enforcement

**Non-negotiable rule**: All map components MUST use `createMapPickerLeafletIcon()`.  
**No exceptions**: Never use `L.Icon.Default`, never reference external marker URLs.

---

**Last Updated**: 2026-04-20  
**Rule Owner**: Geo Module Architecture
