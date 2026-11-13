# GeoMapLit — Farmshops.eu Parity Implementation

**Last updated**: 2026-06-03  
**Ricostruzione completa:** [geo-map-lit-reconstruction-guide.md](./geo-map-lit-reconstruction-guide.md)
**Story**: 8-81 (COMPLETED ✅)
**Reference**: https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js

## Overview

The `geo-map-lit` component has been refactored to match the farmshops.eu direktvermarkter.js implementation pattern for marker clustering, popup handling, and GeoJSON loading.

## Key Parity Features Implemented

### 1. L.geoJson with pointToLayer + onEachFeature

Following farmshops.eu pattern:
```javascript
this._geojsonLayer = L.geoJson(data, {
    pointToLayer: (feature, latlng) => {
        const color = feature.properties?.type_color || '#0066cc';
        const marker = L.marker(latlng, {
            icon: createGeoMapLeafletIcon(L, color),
            typeValue: feature.properties?.type,
            typeColor: color,
            typeLabel: feature.properties?.type_label || feature.properties?.type,
        });
        this._allMarkers.push(marker);
        return marker;
    },
    onEachFeature: (feature, layer) => {
        const p = feature.properties || {};
        layer.bindPopup(`...`, { maxWidth: 260 });
    },
});
```

### 2. Cluster LOD (Level of Detail) — Zoom-Based

Matching farmshops.eu `iconCreateFunction`:

| Zoom Level | Cluster Display |
|-------------|-----------------|
| **< 8** | Count only (e.g., "12") |
| **>= 8** | Count + colored category dots (farmshops pattern) |

```javascript
_createClusterIcon(cluster) {
    const markers = cluster.getAllChildMarkers();
    const count = markers.length;
    const zoom = this._map.getZoom();

    if (zoom >= 8) {
        // Category breakdown with colored dots
        const typesPresent = {};
        markers.forEach(m => {
            const t = m.options.typeValue;
            if (t && !typesPresent[t]) {
                typesPresent[t] = m.options.typeColor || '#607d8b';
            }
        });
        const dotsHtml = Object.entries(typesPresent)
            .map(([type, color]) => `<span style="..."></span>`)
            .join('');
        return L.divIcon({ html: `<div>...</div>`, ... });
    }
    // Zoom < 8: count only
    return L.divIcon({ html: `<div>${count}</div>`, ... });
}
```

### 3. maxClusterRadius — Zoom-Based

Matching farmshops.eu `GetClusterRadius()`:
```javascript
this._markersLayer = L.markerClusterGroup({
    maxClusterRadius: (z) => z < 12 ? 80 : 45,  // farmshops pattern
    minimumClusterSize: 2,  // prevents single-marker clusters
    iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
});
```

### 4. Popup on Marker Click — AJAX Detail Fetch

Matching farmshops.eu pattern (`$.getJSON('data/' + id + '/details.json')`):
```javascript
onEachFeature: (feature, layer) => {
    const p = feature.properties || {};
    layer.bindPopup(`<div class="geo-popup">...</div>`, { maxWidth: 260 });

    if (p.id) {
        layer.once('click', () => {
            fetch(`/api/ticket-details/${p.id}`)
                .then(res => res.ok ? res.json() : null)
                .then(detail => {
                    if (detail) {
                        layer.getPopup().setContent(`...rich content...`);
                    }
                });
        });
    }
}
```

### 5. Popup Resize on Open

Matching farmshops.eu `map.on('popupopen', ...)`:
```javascript
this._map.on('popupopen', (e) => {
    const mapH = this._map.getContainer().clientHeight;
    const mapW = this._map.getContainer().clientWidth;
    e.popup.options.maxHeight = Math.floor(mapH * 0.4);
    e.popup.options.maxWidth  = Math.floor(mapW * 0.9);
    e.popup.update();
});
```

### 6. Refresh Clusters on Zoom End

```javascript
this._map.on('zoomend', () => this._markersLayer?.refreshClusters?.());
```

This ensures the cluster icon LOD updates when zooming in/out (farmshops uses zoom-based cluster content).

## Data Flow

```
GeoJSON (/data/tickets.json)
    ↓
L.geoJson() with pointToLayer + onEachFeature
    ↓
Populates this._allMarkers[] (for filterByType)
    ↓
Adds to L.markerClusterGroup (this._markersLayer)
    ↓
Cluster icons rendered via _createClusterIcon() (zoom-based LOD)
    ↓
Popup on click → AJAX fetch /api/ticket-details/{id}
```

## Differences from Farmshops.eu

| Aspect | Farmshops.eu | GeoMapLit |
|--------|---------------|------------|
| **Framework** | Vanilla JS | Lit 3.x Web Component |
| **Leaflet Import** | Global `L` via `<script>` | ES Module `import L from 'leaflet'` |
| **Marker Icons** | `L.ExtraMarkers.icon()` | `createGeoMapLeafletIcon(L, color)` (SVG inline) |
| **Search** | Separate plugin | `renderSearch(ctx)` from shared module |
| **Controls** | `L.control.zoom()` | `renderControls(ctx)` from shared module |
| **Fullscreen** | Custom implementation | `toggleFullscreen(ctx)` with body scroll lock |
| **Heatmap** | Not present | `L.heatLayer()` from same GeoJSON data |

## Verification Checklist

- [x] L.geoJson() with pointToLayer + onEachFeature
- [x] Cluster LOD: zoom < 8 count-only, zoom >= 8 category dots
- [x] maxClusterRadius based on zoom (farmshops pattern)
- [x] minimumClusterSize: 2 (no single-marker clusters)
- [x] Popup resize on open (popupopen handler)
- [x] refreshClusters on zoomend
- [x] AJAX detail fetch on marker click (once)
- [x] Search toggle via lens icon (_searchOpen)
- [x] Fullscreen with body scroll lock
- [ ] Playwright test: markers/clusters visible (PENDING - browser setup)
- [ ] Playwright test: cluster LOD changes on zoom (PENDING)

## Files Modified

- `laravel/Modules/Geo/resources/js/components/geo-map-lit.js` — complete rewrite to match farmshops pattern
- `laravel/Modules/Geo/resources/js/components/map-picker-search.js` — shared search module
- `laravel/Modules/Geo/resources/js/components/map-picker-controls.js` — shared controls module
- `laravel/Modules/Geo/resources/js/components/map-marker-config.js` — SVG marker factory
- `public_html/data/tickets.json` — GeoJSON data (50+ features for clustering)

## Next Steps

1. Complete Playwright browser setup for visual testing
2. Verify cluster rendering at different zoom levels
3. Test popup content and AJAX detail fetch
4. Document any remaining issues in Known Issues section

---

## Aggiornamento 2026-06 — implementazione corrente

> **Nota:** la sezione `L.geoJson` con `pointToLayer` sopra è il pattern farmshops originale.
> Su Fixcity (STORY-122+) i marker sono aggiunti **singolarmente** a `markerClusterGroup`
> per stabilità con `refreshClusters` e filtri `filterByTypes`.

Implementazione attuale in `map-lit.js`:

- `features.forEach` → `L.marker` → `this._markersLayer.addLayer(marker)`
- Cluster config: vedi [map-lit-it-incidents-2026-06.md](../troubleshooting/map-lit-it-incidents-2026-06.md)
- Elemento DOM canonico: `<map-lit>` (non `<geo-map-lit>`)

Test Playwright:

- `tests/Playwright/map-lit-cluster-hover-stability.spec.js`
- `tests/Playwright/map-lit-gps-cluster-stability.spec.js`

### Marker icon-first e popup (2026-06)

Riferimento UX: [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu) — icona tipologia dominante, contenitore minimo.

| Elemento | Implementazione Fixcity |
|----------|-------------------------|
| Marker | `createGeoMapLeafletIcon` — `__inner` 36px stato, `__glyph-pad` 28px, glifo 22px, `__point` 8px ([geo-map-marker-status-background.md](./geo-map-marker-status-background.md)) |
| Popup click | Leaflet `bindPopup` + block `popup`; header **`<div class="popup__header">`** ([geo-map-popup-bem.md](./geo-map-popup-bem.md)) |
| UX click | Popup immediato da GeoJSON; arricchimento AJAX se `p.id` |

CSS tema: `07-map-clusters-and-leaflet.css` — glifo marker 22px; no transform su `.leaflet-marker-icon`.

Ricostruzione completa: [geo-map-lit-reconstruction-guide.md](./geo-map-lit-reconstruction-guide.md).

Build tema: `laravel/Themes/Sixteen` → `npm run build` → `map-lit-*.js` in `public_html/themes/Sixteen/assets/`.

---

## Aggiornamento 2026-06-10 (sessione Cursor / STORY-293)

### Marker singolo — ExtraMarkers `shape: square` (ibrido STORY-130)

- `marker-config.js`: corpo **quadrato arrotondato** 40×40px, ancoraggio al **centro** (come farmshops), **senza punta** a goccia.
- Colore corpo = **stato** workflow (`ticketStatus.color`); glifo bianco = **tipologia** (invariato STORY-130).

### Cluster LOD

- `map-lit.js`: `zoomend` → `refreshClusters()` per aggiornare icone tipologia a zoom ≥ 8 (pattern `direktvermarkter.js`).

### Popup ticket (farmshops `#wrapper`)

- `popup-ticket.js`: griglia indirizzo + link mappe (OSM, OpenRouteService, Google); hero image; headline `h1`; loading con icona tipologia.
- Build obbligatoria: `cd laravel/Themes/Sixteen && npm run build && npm run copy`.

### Story

- [STORY-293](../../../../docs/stories/STORY-293-map-farmshops-popup-parity.md) — A1–A5 ancora da chiudere; marker/popup base sopra.

### Collegamenti

- [farmshops-cluster-type-icons-study.md](./farmshops-cluster-type-icons-study.md)
- [architecture-map-farmshops-parity](../../../../docs/wiki/architecture/map-farmshops-parity.md)
