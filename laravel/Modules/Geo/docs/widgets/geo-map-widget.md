# GeoMapWidget (Filament v5)

## Overview
The `GeoMapWidget` is a high-performance Leaflet-based map explorer for Filament dashboards. It is designed to handle up to 3000 points from a single GeoJSON source with intelligent clustering and multiple visualization layers.

## Features
- **Client-Side Clustering**: Uses `leaflet.markercluster` for smooth aggregation.
- **LOD (Level of Detail)**: Dynamically adjusts visualization based on zoom level.
- **Multi-Layer Support**:
  - Points (individual markers)
  - Clusters
  - Heatmap (via `leaflet.heat`)
  - Zones (GeoJSON polygons)
- **Web Component Isolation**: Built with **Lit** for zero style leaks and predictable lifecycle management.
- **Vite Integrated**: Fully bundled via the project's Vite pipeline (no CDNs).

## Usage

```php
use Modules\Geo\Filament\Widgets\GeoMapWidget;

protected function getHeaderWidgets(): array
{
    return [
        GeoMapWidget::make()
            ->geojsonUrl('/data/points.geojson')
            ->initialZoom(12)
            ->centerLat(41.9028)
            ->centerLng(12.4964),
    ];
}
```

## Configuration
| Option | Type | Default | Description |
|---|---|---|---|
| `geojsonUrl` | `string` | `null` | URL to the GeoJSON dataset. |
| `initialZoom` | `int` | `13` | Initial map zoom level. |
| `centerLat` | `float` | `41.9028` | Initial latitude. |
| `centerLng` | `float` | `12.4964` | Initial longitude. |

## Technical Architecture
1. **PHP Wrapper**: `Modules\Geo\Filament\Widgets\GeoMapWidget.php` provides the Filament interface.
2. **Blade Template**: `Modules\Geo\resources/views/filament/widgets/geo-map-widget.blade.php` renders the custom element.
3. **Lit Element**: `<geo-map-widget>` manages Leaflet initialization and data loading.
4. **Data Cache**: The dataset is fetched once and stored in the Web Component state.
