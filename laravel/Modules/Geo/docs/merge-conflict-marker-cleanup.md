# Merge Conflict Marker Cleanup

> Updated: 2026-04-21

## Current Rule

Geo conflict cleanup must preserve Laraxot ownership boundaries:

- Filament widgets extend Xot base wrappers when available.
- Geo map assets are loaded through the theme/Vite path unless the module explicitly owns a registered Filament asset.
- Translation conflicts that differ only by spacing should follow surrounding PHP array style.

## Decisions Applied

- `GeoMapWidget.php`: kept the `XotBaseWidget` plus `BuildGeoMapWidgetPayloadAction` implementation.
- `geo-map-widget.blade.php`: kept the view that calls `$this->getPayload()`.
- `map-picker.php`: removed spacing-only conflict markers.
- `BuildGeoMapWidgetPayloadAction.php`: removed style-only conflicts in non-empty string checks.

## Verification

```bash
php -l Modules/Geo/app/Filament/Widgets/GeoMapWidget.php
php -l Modules/Geo/app/Actions/Maps/BuildGeoMapWidgetPayloadAction.php
php -l Modules/Geo/lang/it/map-picker.php
```

