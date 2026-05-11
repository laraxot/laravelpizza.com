---
title: GeoMapLit Implementation Guide
description: Complete implementation guide for GeoMapLit component with farmshops.eu parity
category: geo-patterns
---

# GeoMapLit Implementation Guide

## Overview

The `geo-map-lit` component is a Lit web component that provides Leaflet map functionality with marker clustering matching farmshops.eu behavior.

## Key Features

1. **Marker Clustering**: Using Leaflet.markercluster with farmshops.eu parity
2. **Dynamic Cluster Icons**: Zoom-based LOD (Level of Detail)
3. **AJAX Popups**: Fetch detailed ticket information on marker click
4. **Responsive Design**: Works on mobile, tablet, and desktop
5. **MutationObserver**: Depth 12 for Filament 5 wizard compatibility

## Implementation Details

### Cluster Icon Creation

The `_createClusterIcon` method implements farmshops.eu pattern:

```javascript
_createClusterIcon(cluster) {
    const markers = cluster.getAllChildMarkers();
    const count = markers.length;
    const zoom = this._map ? this._map.getZoom() : 0;

    // Fixed cluster size (farmshops pattern)
    const circleStyle = 'background:#fff;border:2.5px solid #0066cc;border-radius:50%;width:80px;height:80px;...';

    if (zoom >= 8) {
        // Show type indicators (colored SVG dots)
        const typesPresent = {};
        markers.forEach(m => { /* collect types */ });
        const icons = Object.entries(typesPresent)
            .map(([, color]) => `<svg>...<circle fill="${color}"/></svg>`)
            .join('');
        return L.divIcon({
            html: `<div style="${circleStyle}"><strong>${count}</strong><div>${icons}</div></div>`,
            iconSize: L.point(80, 80),
        });
    }

    // Zoom < 8: show count only
    return L.divIcon({
        html: `<div style="${circleStyle}"><strong>${count}</strong></div>`,
        iconSize: L.point(80, 80),
    });
}
```

### Data Loading (farmshops.eu Pattern)

```javascript
_loadGeoJson() {
    fetch(url).then(res => res.json()).then(data => {
        this._allFeatures = data.features || [];
        this._allMarkers = [];

        // Farmshops.eu pattern: create markers directly
        this._allFeatures.forEach(feature => {
            const coords = feature.geometry?.coordinates;
            if (!coords || coords.length < 2) return;

            const latlng = L.latLng(coords[1], coords[0]); // GeoJSON is [lng, lat]
            const color = feature.properties?.type_color || '#0066cc';

            const marker = L.marker(latlng, {
                icon: createGeoMapLeafletIcon(L, color),
                typeValue: feature.properties?.type,
                typeColor: color,
            });

            // Initial popup with basic info
            marker.bindPopup(`<div class="geo-popup">...</div>`, { maxWidth: 260 });

            // AJAX detail fetch on click
            if (feature.properties?.id) {
                marker.once('click', () => {
                    fetch(`/api/ticket-details/${feature.properties.id}`)
                        .then(res => res.ok ? res.json() : null)
                        .then(detail => {
                            if (!detail) return;
                            marker.getPopup().setContent(`<div class="geo-popup">...</div>`);
                        });
                });
            }

            this._allMarkers.push(marker);
        });

        // Add all markers to cluster group
        if (this._markersLayer && this._allMarkers.length > 0) {
            this._markersLayer.addLayers(this._allMarkers);
        }

        // Fit bounds to show all markers
        if (this._allMarkers.length > 0) {
            const bounds = new L.featureGroup(this._allMarkers).getBounds();
            if (bounds.isValid()) {
                this._map.fitBounds(bounds, { padding: [40, 40], maxZoom: 11 });
            }
        }
    });
}
```

## Cluster Radius Logic

Matching farmshops.eu:
```javascript
maxClusterRadius: (z) => z < 12 ? 80 : 45,
minClusterSize: 2, // No cluster for single markers
```

## Styling

### Cluster Circle Styles
```css
.geo-cluster-circle {
    background: #fff;
    border: 2.5px solid #0066cc;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.35);
}
```

## Testing

### Playwright Tests
- Verify cluster rendering at zoom < 12 (80px) and zoom >= 12 (45px)
- Test type indicators appear at zoom >= 8
- Verify AJAX popup loads details on marker click
- Check responsive behavior on mobile (390px), tablet (768px), desktop (1280px)

## Files Modified
- `laravel/Modules/Geo/resources/js/components/geo-map-lit.js`
- `laravel/Modules/Geo/docs/wiki/concepts/geo-map-cluster.md`
- `laravel/Modules/Fixcity/docs/wiki/concepts/farmshops-clustering-integration.md`
- `laravel/Modules/Geo/docs/prompts/geo-map-widget.txt`

## Related Documentation
- [Farmshops Clustering Integration](../concepts/farmshops-clustering-integration.md)
- [Map Marker Config](./map-marker-config.md)
- [Second Brain: Geo Cluster Memory](../../../../.agents/docs/claude/memory/geo-cluster.md)