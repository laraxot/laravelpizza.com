# Admin map magnifier and controls visibility

## Problema

Nella route admin ticket create, la lente di ricerca risultava visivamente troppo dominante e i controlli mappa non erano chiaramente visibili/usabili.

## Root cause

1. Icona lente nel field wrapper Blade dipendente dal rendering dell'icon component (rischio scaling non uniforme con CSS globali).
2. Overlay controlli Lit non sufficientemente hardenizzato lato posizione/z-index in tutte le condizioni runtime.
3. Evento `dragend` marker su `CoordinatePicker` con accesso diretto a `e.latlng` non robusto su tutte le emissioni.

## Fix applicati

- Sostituita la lente nel Blade con SVG inline a dimensione fissa (`h-4 w-4 min-h-4 min-w-4`).
- Overlay controlli in `coordinate-picker-lit` rinforzato:
  - `top/right` espliciti
  - `left:auto`
  - `z-index` alto
  - sizing bottoni/icone forzato.
- `dragend` marker corretto con `e.target.getLatLng()` + guard.
- Corretto anche `map-picker-lit` da `mapPickerStyles` a `mapPickerStylesText` nel blocco `<style>`.

## Verifica tecnica

- `npm run build` modulo Geo: OK
- `npm run copy` modulo Geo: OK
- asset pubblicati in `public_html/assets/geo`

## Riferimenti

- [lit light dom map controls and sync](./lit-light-dom-map-controls-and-sync.md)
- [filament admin panel map visibility contract](./filament-admin-panel-map-visibility-contract.md)
