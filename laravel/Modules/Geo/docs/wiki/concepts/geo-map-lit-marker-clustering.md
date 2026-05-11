# GeoMapLit Marker Clustering — Corrected Implementation

## Overview
The `geo-map-lit` web component uses Leaflet.markercluster with a custom `iconCreateFunction` that replicates the farmshops.eu pattern with Level of Detail (LOD) behavior.

## Cluster Icon LOD (Level of Detail)

Implemented in `_createClusterIcon(cluster)`:

| Zoom Level | Cluster Appearance | Condition |
|-------------|--------------------|------------|
| **< 8** | White circle with count only | Always |
| **>= 8** | White circle with count + colored type dots | **Only if 2+ different `typeValue` in cluster** |
| **Single marker** | Never clustered (minimumClusterSize: 2) | Always individual pin |

### Key Rule (Zero Tolerance)
```javascript
if (zoom >= 8) {
    const typesPresent = {};
    markers.forEach(m => {
        const t = m.options.typeValue;
        if (t && !typesPresent[t]) {
            typesPresent[t] = m.options.typeColor || '#607d8b';
        }
    });
    // ONLY show type diversity when multiple types exist
    if (Object.keys(typesPresent).length > 1) {
        // Render count + colored dots (SVG circles)
        return L.divIcon({ ... });
    }
}
// Default: count-only circle
return L.divIcon({ html: `<div ...>${count}</div>` });
```

## Cluster Group Configuration
```javascript
this._markersLayer = L.markerClusterGroup({
    maxClusterRadius: (z) => z < 12 ? 80 : 45,  // farmshops.eu parity
    minimumClusterSize: 2,        // no single-marker clusters
    chunkedLoading: true,
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: true,
    removeOutsideVisibleBounds: true,
    iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
});
this._map.addLayer(this._markersLayer);
```

## Marker Addition
Markers are added directly to the cluster group (not via L.geoJson layer group):
```javascript
data.features?.forEach(feature => {
    const marker = L.marker([lat, lng], {
        icon: createGeoMapLeafletIcon(L, color),
        typeValue: p.type,
        typeColor: color,
    });
    this._allMarkers.push(marker);
    this._markersLayer.addLayer(marker);  // direct to cluster
});
```

## Common Pitfalls
1. **Forgetting `Object.keys(typesPresent).length > 1`** → shows type dots even for single-type clusters.
2. **Not adding cluster group to map** → `this._map.addLayer(this._markersLayer)` is required.
3. **Using L.geoJson to add markers** → breaks clustering; add markers directly.
4. **minimumClusterSize: 1** → single markers get clustered incorrectly.

## farmshops.eu Parity Checklist
- [x] Zoom-based LOD
- [x] Type diversity only when 2+ types
- [x] minimumClusterSize: 2
- [x] Spiderfy on max zoom
- [x] Dynamic maxClusterRadius
- [x] Inline styles for cluster icon (resistance to CSS overrides)

## References
- Component source: `laravel/Modules/Geo/resources/js/components/geo-map-lit.js`
- Shared modules: `map-picker-controls.js`, `map-marker-config.js`
- farmshops.eu reference: https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js

---
*Updated: 2026-04-30 — fixed cluster LOD condition (typesPresent > 1)*
