# Research: farmshops.eu Architecture Study

## Project Overview
- **Project**: farmshops.eu (formerly direktvermarkter)
- **Repo**: https://github.com/CodeforKarlsruhe/farmshops.eu
- **Stack**: Leaflet, jQuery, MarkerCluster, OSM (OpenStreetMap)

## Core Logic (direktvermarkter.js)
- **Data Initialization**: Loads a static GeoJSON file containing all direct marketers.
- **Dynamic Updates**: Uses Overpass API for bounding-box queries when the map moves (if enabled), but the primary performance pattern is the single large GeoJSON load.
- **Clustering**: Implements `leaflet.markercluster` with custom `iconCreateFunction` to show aggregated category icons inside clusters.
- **LOD (Level of Detail)**:
  - Zoom-dependent `maxClusterRadius`.
  - Content aggregation changes based on zoom level.
- **Filtering**: Client-side filtering of markers based on properties (tags).

## Key Components to Replicate
1. **GeoJSON Cache**: Store the dataset in component memory to avoid network round-trips.
2. **Layer Manager**: Ability to toggle between raw points, clusters, and heatmap.
3. **Responsive Sidebars**: Info panels for filtering and details (replicate sidebar-v2 pattern).

## Improvements for GeoMapWidget
1. **Modern Stack**: Use Lit Web Components instead of jQuery.
2. **Vite Bundling**: No CDNs, everything local for better reliability and performance.
3. **Filament Integration**: Deep integration with Filament v5 dashboard patterns.
