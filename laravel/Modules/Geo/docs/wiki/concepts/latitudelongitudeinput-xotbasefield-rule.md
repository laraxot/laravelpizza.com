# LatitudeLongitudeInput XotBaseField Rule

## Regola

`LatitudeLongitudeInput` deve estendere `Modules\Xot\Filament\Forms\Components\XotBaseField`.

## Anti-pattern

- estendere `CoordinatePicker` (sibling coupling)
- estendere `Filament\Forms\Components\Field` direttamente

## Rationale

- governance Laraxot: wrapper XotBase obbligatori per i field custom
- separazione responsabilità: ogni picker mantiene la propria API minima
- maggiore stabilità in refactor della picker family
- DRY + KISS: `LatitudeLongitudeInput` non deve offrire toggle di presentazione come `showMap()` che duplicano branch UI senza introdurre nuovo comportamento di dominio

## Regola Operativa

- `LatitudeLongitudeInput` espone sempre la stessa UI essenziale: mappa + coordinate
- se serve un comportamento diverso, si introduce un componente dedicato invece di aggiungere booleani opzionali allo stesso field

## Collegamenti

- [map-picker-family-architecture](./map-picker-family-architecture.md)
- [map-picker-filament-field](./map-picker-filament-field.md)
