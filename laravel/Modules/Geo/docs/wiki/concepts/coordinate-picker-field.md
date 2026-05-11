# CoordinatePicker Field (Geo)

## Context

`CoordinatePicker` e un campo Filament riusabile progettato per usare un unico stato form (`coordinates`) e delegare la persistenza finale a colonne separate (`latitude`, `longitude`).

## Decisioni

1. **Stato unico nel form**: riduce coupling e sincronizzazioni manuali tra sibling path.
2. **Mapping esplicito a submit**: `CoordinatePicker::extractCoordinates()` mantiene il DB invariato.
3. **Alpine bridge minimale**: usa solo `$wire.$watch`, `$wire.$set` ed eventi custom.
4. **Web component UI-only**: Lit + Leaflet senza dipendenze da Filament/Livewire.
5. **Light DOM intenzionale**: scelto per compatibilita operativa con pane/controls CSS di Leaflet.

## Contratto evento

Il componente emette:

- `coords-changed`
  - `detail.latitude: number`
  - `detail.longitude: number`
  - `bubbles: true`
  - `composed: true`

## Uso tipico

```php
CoordinatePicker::make('coordinates')
    ->zoom(15)
    ->center(45.464211, 9.191383);
```

```php
$data = CoordinatePicker::extractCoordinates($data);
```

## Backlinks

- [geo wiki index](../index.md)
- [map-picker-filament-field](./map-picker-filament-field.md)
- [coordinate-picker module docs](../../coordinate-picker.md)
