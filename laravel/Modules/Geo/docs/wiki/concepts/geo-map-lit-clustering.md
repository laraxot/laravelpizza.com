# geo-map-lit Clustering Specification

## Overview
The `geo-map-lit` component implements a 1:1 replica of farmshops.eu's marker clustering behavior with strict adherence to the following constraints:

### Core Requirements
- **Zero custom clustering logic** — exclusively use `leaflet.markercluster` ESM module
- **Cluster icon differentiation** — categorize by type (waste, roadwork, greenspace) via SVG icons
- **LOD precision** — 
  - `zoom < 8` → 80px cluster circle + count only
  - `8 ≤ zoom < 12` → 80px circle + 6 max type indicators (SVG)
  - `zoom ≥ 12` → 45px radius reduction
- **Max radius enforcement** — strict `maxClusterRadius: (z) => z < 12 ? 80 : 45`

### Marker Processing Pipeline
1. **GeoJSON Ingestion** — Single fetch → `data.features`
2. **Validation Pass** — 
   - Geometry must be Point ([lng, lat] format)
   - Coordinates must be finite numbers
   - Range validation (`-90° ≤ lat ≤ 90°`, `-180° ≤ lng ≤ 180°`)
3. **Cluster Assignment** — Per-leaflet.markercluster algorithm
4. **Icon Factory** — `_createClusterIcon(category)` → `L.divIcon` with inline SVG
5. **Boundary Calculation** — `fitBounds` with `[40,40]` pixel padding

### Visual Requirements
- **Cluster States**:
  - Unclustered markers → use `createGeoMapLeafletIcon(L, color)`
  - Single-cluster → 80px SVG circle (base)
  - Multi-cluster → 80px circle + category-specific SVG overlays
  - High-zoom clusters → 45px circles
- **Category Indicators** (max 6 per cluster at zoom ≥ 8):
  - `waste` → 🗑️  
  - `roadwork` → 🚧  
  - `greenspace` → 🌳  
  - `building` → 🏢  
  - `other` → 📍  
  - `custom` → 🔶 (fallback)

### Technical Constraints
- **ESM Compatibility** — all plugins imported as side-effect only
- **Leaflet Initialization** — `window.L = L` before plugin import
- **Bundle Size** — ≤ 200KB gzipped
- **Performance** — chunked loading + `removeOutsideVisibleBounds: true`
- **Memory** — 500+ markers supported with virtual viewport culling