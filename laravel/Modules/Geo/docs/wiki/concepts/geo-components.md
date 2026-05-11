# Geo Components Specification

This document details the technical implementation and features of geographic components in the Geo module, adhering to the "Super Mucca" architecture.

## Unified Features

Following the 2026 standardization, all geographic components (`CoordinatePicker`, `MapPicker`, `GeopointPicker`, etc.) support the following standardized features:

### 1. Multi-Layer Map Support
All map interfaces now include a Layer Switcher providing 4 distinct layers for maximum clarity:
- **Street**: Standard OpenStreetMap view for urban navigation.
- **Satellite**: ESRI World Imagery for real-world visual verification.
- **Topography**: OpenTopoMap for terrain and height visualization.
- **Terrain**: ESRI World Topo Map for a clean relief view.

### 2. Premium Interaction Controls
All geographic components prioritize stability in dynamic contexts (like Filament Wizards):
- **Guarded Light DOM**: Components utilize `createRenderRoot() { return this; }` (Light DOM) but protect the critical Leaflet map container using Lit's `guard` directive. This prevents the framework from clearing the map instance during parent state updates.
- **Robust Icon Rendering**: UI icons are rendered as `html` template results (not raw strings) to ensure they are correctly parsed as SVGs by Lit and visible to the user.
- **Safe Fullscreen**: Integrated via a high z-index (`999999`) overlay to ensure it appears above all UI layers.

### 3. Wizard Persistence & Recovery
Maps placed inside tabs or wizards that are initially hidden suffer from "Zero-Dimension Initialization":
- **Resize Recovery**: Every component implements a `ResizeObserver` that automatically calls `invalidateSize()` once the map container gains physical dimensions (>0px).
- **Delayed Invalidation**: A 350ms delay is applied after visibility changes to ensure the CSS transitions of the wizard are complete before the map redraws.

### 4. Structured Address Handling
The components now bridge the gap between geographic coordinates and human-readable addresses using the `HasCoordinatePicker` trait and Nominatim.

#### Data Schema
When a location is selected, the component returns a structured state to Livewire:
```json
{
  "latitude": 41.9028,
  "longitude": 12.4964,
  "address": "Piazza del Popolo, Roma, RM, Lazio, Italy",
  "address_details": {
    "road": "Piazza del Popolo",
    "city": "Roma",
    "postcode": "00187",
    "country": "Italy",
    "house_number": "1"
  }
}
```

#### Reverse Geocoding
- **Automatic**: Triggered on coordinates change if `hasReverseGeocoding()` is enabled.
- **Structured**: Extracts city, zip code, and road names for downstream use (e.g., auto-filling city fields in a wizard).

## Component List & Specific Zen

| Component | Zen | Core Usage |
|-----------|-----|------------|
| `CoordinatePicker` | Accuracy | Technical forms, precise pinpointing. |
| `MapPicker` | Discovery | Public reporting (Segnalazione) with layers and search. |
| `GeopointPicker` | Persistence | Mapping DB entries with spatial types. |
| `LocationPicker` | Context | Finding locations primarily via address. |
| `GeoLatLngInput` | Explicitness | Debugging and raw data manipulation. |
| `PlacePicker` | Readout | Simplified selection with coordinate display. |

## Implementation Layers

1. **The Spirit (Trait - PHP)**: `Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker`
2. **The Body (Blade - HTML/Alpine)**: `Modules/Geo/resources/views/filament/forms/components/*.blade.php`
3. **The Mind (Lit JS - Light DOM)**: `Modules/Geo/resources/js/components/*-lit.js`

## CSS Tokens
Components should respect the following CSS tokens for parity:
- `--cp-z-index`: Base z-index for the map shell.
- `--cp-overlay-z-index: 1000`: For UI controls inside the map.
- `--cp-fullscreen-z-index: 999999`: For absolute dominance in fullscreen.

---
*Created: 2026-04-22*
*Part of: Geo Module Wiki Standard v2.0*
