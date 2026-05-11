# Map Picker Location JSON Contract

## Purpose
The Geo picker family should expose one canonical public state: `location`.

This keeps the Filament contract simple, aligns with Leaflet naming, and reduces repeated conversion logic across PHP, Blade, Alpine, and Lit.

## Canonical Shape

```json
{
    "lat": 41.9028,
    "lng": 12.4964,
    "address": "Via Roma 1, Milano, Lombardia, Italia",
    "address_details": {},
    "street": "Via Roma",
    "street_number": "1",
    "city": "Milano",
    "postcode": "20100",
    "state": "Lombardia",
    "province": "Città metropolitana di Milano",
    "country": "Italia",
    "country_code": "it",
    "suburb": "Centro",
    "provider": "nominatim",
    "display_name": "Via Roma 1, Milano, Lombardia, Italia",
    "raw": {}
}
```

## Naming Rule

- canonical runtime keys: `lat`, `lng`
- compatibility aliases only: `latitude`, `longitude`

The canonical API follows Leaflet naming to avoid unnecessary translation at every layer.

## Persistence Rule

When a real `location` column exists, it should persist the full payload as JSON/array.

When legacy `latitude` and `longitude` columns already exist:

1. keep them for backward compatibility
2. hydrate `location.lat` and `location.lng` from them if needed
3. sync them on save from `location.lat` and `location.lng`

This means legacy columns remain a persistence bridge, not the public contract.

## Component Boundary

`CoordinatePicker::make('location')` must operate on one single state path.

The picker family may expose different UIs, but they should converge on the same payload shape unless there is a documented exception.

## Clean Code Implication

The more layers translate between `lat/lng` and `latitude/longitude`, the more duplication and drift appear.

Preferred split:

- PHP trait: normalization and persistence bridge
- Blade/Alpine: thin state sync
- Lit: map UI and emitted events in canonical `lat/lng` form

## Related Files

- `laravel/Modules/Geo/app/Filament/Forms/Components/CoordinatePicker.php`
- `laravel/Modules/Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`
- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

## Related Docs

- [coordinate-picker-purpose](./coordinate-picker-purpose.md)
- [coordinate-picker-filament5-save-pattern](./coordinate-picker-filament5-save-pattern.md)
- [coordinate-picker-state-binding-rule](./coordinate-picker-state-binding-rule.md)
