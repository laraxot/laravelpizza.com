---
name: filament-admin-coordinate-picker-theme-bundle-rule
description: Filament admin must load the same Sixteen theme JS bundle as frontoffice when using coordinate-picker-lit controls
type: concept
---

# Filament Admin Coordinate Picker Theme Bundle Rule

When `coordinate-picker-lit` is used inside Filament admin pages, loading Leaflet CSS alone is not enough.

## Symptom

- the map canvas is visible in admin;
- the overlay controls are missing in admin;
- the same controls are visible in `/it/tests/segnalazione-crea`.

## Root cause

The frontoffice page loads the Sixteen Vite bundle, which defines the Lit custom element and its controls.
The Filament admin panel may load the field view without loading that theme bundle.

## Required fix

- keep CSS registration in `Modules/Geo/Providers/GeoServiceProvider`;
- also register the compiled Sixteen `resources/js/app.js` bundle as a Filament JS asset for package `geo`;
- resolve the hashed file from `public_html/themes/Sixteen/manifest.json`.

## Files

- `laravel/Modules/Geo/app/Providers/GeoServiceProvider.php`
- `public_html/themes/Sixteen/manifest.json`
- `laravel/Themes/Sixteen/resources/js/app.js`
