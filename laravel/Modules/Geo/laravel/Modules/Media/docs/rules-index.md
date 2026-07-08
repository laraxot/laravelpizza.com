# Rules Index

This module follows the global Laraxot coding standards.

## Global Canonical Rules

- [Coding Standards](../../../../docs/laraxot-coding-standards.md)
- [XotBaseField Mandatory](../../../../docs/rules/xotbasefield-mandatory.md)
- [Leaflet Class Selector](../../../../docs/rules/leaflet-class-selector.md)

## Geo Runtime Canonical Pages

- [README.md](./README.md)
- [Wiki Index](./wiki/index.md)
- [MapPicker Filament Field](./wiki/concepts/map-picker-filament-field.md)
- [MapPicker Runtime UX](./wiki/concepts/mappicker-runtime-ux.md)
- [LatitudeLongitudeInput XotBaseField Rule](./wiki/concepts/latitudelongitudeinput-xotbasefield-rule.md)

## Permanent Reminder

- `MapPicker.php` deve estendere `Modules\Xot\Filament\Forms\Components\XotBaseField`.
- I field Filament del modulo Geo non estendono `Field` direttamente.
- Se `latitude` o `longitude` mancano, `MapPicker` deve tentare geolocalizzazione browser e valorizzare entrambe.
- Se emerge una nuova regola persistente, aggiornare docs del modulo, LLM Wiki locale, LLM Wiki root e memory/rules locali dell'agente.
