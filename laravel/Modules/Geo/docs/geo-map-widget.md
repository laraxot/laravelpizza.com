# GeoMapWidget

## Overview

`GeoMapWidget` è un widget Filament v5 del modulo `Geo` che renderizza una mappa Leaflet tramite Web Component Lit, usando un payload GeoJSON caricato una sola volta dal backend.

## Architecture

- PHP widget: `app/Filament/Widgets/GeoMapWidget.php`
- Payload action: `app/Actions/Maps/BuildGeoMapWidgetPayloadAction.php`
- View: `resources/views/filament/widgets/geo-map-widget.blade.php`
- Lit element: `resources/js/components/maps/geo-map-widget.element.js`
- Moduli JS di supporto:
  - `geo-map-state.js`
  - `geo-map-geojson-adapter.js`
  - `geo-map-popup-renderer.js`
  - `geo-map-leaflet-renderer.js`
  - `geo-map-layer-manager.js`

## Features

- dataset GeoJSON statico serializzato dal backend;
- cluster con `leaflet.markercluster`;
- layer points / cluster / heatmap / zones;
- popup marker;
- filtro client-side;
- selezione punto;
- fullscreen;
- switch base layer strada / satellite.

## Notes

- Nessuna dipendenza da CDN.
- Gli asset Filament sono registrati in `app/Providers/Filament/AdminPanelProvider.php`.
- Il build frontend del modulo `Geo` resta il build locale del modulo.
