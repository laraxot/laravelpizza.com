---
title: "coordinate picker field"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-14
qmd: "coordinate picker field"
issues: []
discussions: []
status: draft
---

# CoordinatePicker Field (Geo)

## Context

`CoordinatePicker` e un campo Filament riusabile progettato per usare un unico stato form (`coordinates`) e delegare la persistenza finale a colonne separate (`latitude`, `longitude`).

## Decisioni

1. **Stato unico nel form**: riduce coupling e sincronizzazioni manuali tra sibling path.
2. **Mapping esplicito a submit**: `CoordinatePicker::extractCoordinates()` mantiene il DB invariato.
3. **Alpine bridge minimale**: lo stato Livewire e legato con `$wire.$entangle(statePath)` (non con `$wire.$watch` / `$wire.$set`, assenti nella vista `coordinate-picker.blade.php`); i cambiamenti arrivano da eventi custom (`coords-changed`, `address-selected`, `fullscreen-changed`).
4. **Web component UI-only**: Lit + Leaflet senza dipendenze da Filament/Livewire.
5. **Light DOM intenzionale**: scelto per compatibilita operativa con pane/controls CSS di Leaflet.

## Contratto evento

Il componente emette:

- `coords-changed` (emesso da `handleMapInteraction()` in `resources/js/components/map/events.js`, non da `coordinate-picker-lit.js` direttamente)
  - `detail.latitude: number`
  - `detail.longitude: number`
  - `detail.lat`, `detail.lng`: alias degli stessi valori
  - `detail.source`: origine (`manual`, `search`, `geolocation`, `programmatic`...)
  - `detail.address`, `detail.display_name`: `null`, salvo con `source === 'search'` (in quel caso le chiavi non sono nel `detail`)
  - `bubbles: true`
  - `composed: true`

L'indirizzo scelto dalla ricerca arriva a parte, con l'evento `address-selected`.

## Classi PHP

Esistono due classi `CoordinatePicker`: `Modules\Geo\Filament\Forms\Components\CoordinatePicker` (estende `XotBaseField`, usa il trait `HasCoordinatePicker` con `zoom()`, `center()` ed `extractCoordinates()`) e `Modules\Geo\Forms\Components\CoordinatePicker` (estende `Field`, ha `zoom()` ed `extractCoordinates()`, vista `geo::filament.forms.components.coordinate-picker`). Quale delle due renda la vista: (non verificato).

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
- [coordinate-picker module docs](../coordinate-picker.md)

## Verifica

Verificato il 2026-10-14 su `app/Filament/Forms/Components/**`, `app/Forms/Components/CoordinatePicker.php`, `resources/views/filament/forms/components/coordinate-picker.blade.php` e `resources/js/components/**`: classi e metodi PHP, `$entangle`, light DOM (`createRenderRoot() { return this; }`), assenza di riferimenti a Livewire/Filament nel Lit (solo un commento), forma del `detail` di `coords-changed`. Corretto: il "bridge" Alpine non usa `$watch`/`$set`.
