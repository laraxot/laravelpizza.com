# CoordinatePickerLit Component Implementation

## Overview

This document describes the implementation of the `coordinate-picker-lit` web component - a custom interactive map picker using Lit.js and Leaflet.js, integrated with Filament forms.

## Component Structure

### File Location
- **Source**: `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- **Styles**: `laravel/Modules/Geo/resources/js/components/coordinate-picker-styles.js`
- **Blade View**: `laravel/Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php`

### Key Features

1. **Light DOM**: Uses light DOM so Leaflet tiles, controls and fullscreen interact predictably with Filament/Livewire (avoids common Shadow DOM stacking issues).
2. **Interactive Map**: Uses Leaflet.js for mapping functionality
3. **Custom SVG Marker**: Inline SVG marker (no external image dependencies)
4. **4 Map Layers**: OSM Street, Esri Satellite, OpenTopo Terrain, Esri Topo
5. **Custom Controls**: All overlay buttons (locate, zoom+, zoom-, fullscreen)
6. **Fullscreen Mode**: Covers entire viewport, hides info bar
7. **Structured Address Data**: Passes road, number, city, postcode to form
8. **Events**: Dispatches `coords-changed` and `fullscreen-changed`

## Usage

### HTML Element

```html
<coordinate-picker-lit
    latitude="41.9028"
    longitude="12.4964"
    zoom="13"
    height="400px"
></coordinate-picker-lit>
```

### Listening for Coordinate Changes

```javascript
element.addEventListener('coords-changed', (event) => {
    const { latitude, longitude, source, address } = event.detail;
    console.log(`Coordinates: ${latitude}, ${longitude}`);
    console.log(`Address: ${address?.road}, ${address?.city}`);
});
```

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| latitude | Number | null | Latitude coordinate |
| longitude | Number | null | Longitude coordinate |
| zoom | Number | 13 | Map zoom level |
| height | String | '400px' | Map container height |
| isExpanded | Boolean | false | Fullscreen state (internal) |
| isLocating | Boolean | false | Geolocation loading state (internal) |
| isFullscreen | Boolean | false | Fullscreen active state (internal) |

## Events

### coords-changed

Fired when coordinates are updated via marker drag, map click, or geolocation.

```javascript
detail: {
    latitude: number;
    longitude: number;
    source: 'manual' | 'drag' | 'geolocation' | 'geocode';
    address: {
        display_name: string;
        road: string;
        house_number: string;
        city: string;
        state: string;
        country: string;
        postcode: string;
        lat: string;
        lon: string;
    } | null;
}
```

### fullscreen-changed

Fired when fullscreen mode toggles.

```javascript
detail: { isFullscreen: boolean }
```

## Map Layers

The component includes 4 map layers, switchable via the layer control (top-right):

1. **Stradale (OSM)**: OpenStreetMap standard tiles
2. **Satellitare (Esri)**: Esri World Imagery
3. **Terreno (Topo)**: OpenTopoMap (elevation data)
4. **Topografica (Esri)**: Esri World Topo Map

## Fullscreen Mode

When entering fullscreen:
- Map covers entire viewport (100vw × 100vh)
- Info bar is hidden
- Close button appears
- Body overflow is locked

## Structured Address Data

When reverse geocoding is enabled, the component receives and passes structured address data:

| Field | Description |
|------|-------------|
| display_name | Full address string |
| road | Street name |
| house_number | Street number |
| city | City/town/municipality |
| state | State/region |
| country | Country |
| postcode | Postal code |

## Integration with Filament

The Blade view (`coordinate-picker.blade.php`) provides Alpine.js integration:

```blade
CoordinatePicker::make('location')
    ->zoom(15)
    ->height('340px')
    ->reverseGeocoding()
```

**Alpine.js Integration:**
- Uses `x-data` to manage state
- Handles `coords-changed` event from web component
- Passes full state including address data to Livewire
- Handles `fullscreen-changed` to show/hide info bar

## Browser Support

- Modern browsers with ES6+ support
- Leaflet.js for map rendering
- Lit.js for web component lifecycle

## Performance Considerations

1. **Lazy Initialization**: Leaflet initialized in `firstUpdated()`
2. **Event Debouncing**: Coordinates sync with 350ms debounce
3. **Cleanup**: Proper disposal in `disconnectedCallback`
4. **Invalidate Size**: Automatic map resize after fullscreen toggle

## Changelog

### 2026-04-22
- Added 4 map layers (OSM, Satellite, Terrain, Topo)
- Added all control buttons (locate, zoom+, zoom-, fullscreen)
- Added fullscreen mode covering 100% viewport
- Added structured address data passing (road, number, city, etc.)
- Added info bar that hides in fullscreen
- Added close button in fullscreen mode
- Fixed Zoom In/Out using Leaflet methods (`zoomIn()`/`zoomOut()`)
