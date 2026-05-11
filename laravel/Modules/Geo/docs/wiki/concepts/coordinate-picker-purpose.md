# CoordinatePicker Purpose in Admin Ticket Creation

## Overview
The `coordinate-picker-lit` map component is used in the FixCity admin ticket creation page (`/fixcity/admin/tickets/create`) to allow staff to precisely select the location of an issue on a Leaflet map.

## Purpose
1. **Precise Location Selection**: Staff can click on the map or drag a marker to set latitude/longitude for a ticket.
2. **Geolocation**: Automatically detects user's current position via browser geolocation API when coordinates are empty (`geolocateWhenEmpty`).
3. **Address Search**: Integrates with address search (`search-input.js`) to geocode addresses and position the marker.
4. **Layer Switching**: Staff can switch between street, satellite, and topo map layers for better context.
5. **Fullscreen Mode**: Toggle fullscreen for detailed area inspection.

## Component Architecture
- **PHP**: `CoordinatePicker` form component (`Modules/Geo/Filament/Forms/Components/CoordinatePicker.php`)
- **Blade**: `coordinate-picker.blade.php` (wrapper with Livewire/Filament state sync)
- **Lit JS**: `coordinate-picker-lit.js` (Leaflet map logic, markers, controls)
- **Icons**: `geo-heroicons.js` imports SVG files from `Modules/Geo/resources/svg/` (Filament way - no hardcoded SVGs)

## Usage in Admin Wizard
The map appears in the ticket creation form. It is bound to the `location` field (latitude/longitude object).

## Key Technical Details
- **Visibility Fix**: Deep `MutationObserver` (depth 20) detects when Filament wizard step becomes visible, triggering `invalidateSize()`.
- **No CDN**: All marker icons use local SVG files via `geo-heroicons.js` imports (`?raw` suffix for Vite).
- **SVG Assets**: Located in `Modules/Geo/resources/svg/` (magnifying-glass.svg, arrows-pointing-out.svg, arrows-pointing-in.svg, map-pin.svg, squares-2x2.svg, plus.svg, minus.svg).
- **Interactive Controls**: Fullscreen, geolocation, layer switch, zoom in/out - all using `geoIcon()` function.

## Quality Checks
- PHPStan: passed on related PHP files
- PHPMD: no critical issues
- Build: Vite builds successful (Geo module + Sixteen theme)
- Visual: map controls visible and clickable

## Related Files
- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- `laravel/Modules/Geo/resources/js/components/geo-heroicons.js`
- `laravel/Modules/Geo/resources/svg/*.svg`
- `laravel/Modules/Geo/resources/views/filament/components/address-search-input.blade.php`
- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

## Related Docs
- [leaflet-wizard-invalidate-size.md](./leaflet-wizard-invalidate-size.md)
- [lit-icons-filament-way.md](./lit-icons-filament-way.md)
- [svg-asset-architecture.md](./svg-asset-architecture.md)
- [map-purpose.md](./map-purpose.md)
