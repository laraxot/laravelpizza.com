---
title: map popup bem block popup
type: memory
module: Geo
updated: 2026-06-03
related:
  - ../rules/bem-modifier-dom-contract.md
  - ../concepts/geo-map-popup-bem.md
---

# Memoria — popup mappa: block `popup`

## Regola

- Block: **`popup`** (non `geo-popup-segnalazione`, non `geo-popup` nel card interno).
- Loading: **`popup--loading`** e **nessun** `popup__footer` nel HTML.
- **Mai** `.popup--loading .popup__footer { display: none }`.
- Element footer: **`popup__footer`** (doppio underscore), non `popup--footer`.

## Shell Leaflet

`className: 'popup-wrapper'` su `L.popup`.

## popup header

Usare `<div class="popup__header">` — mai `<header>` (conflitto `min-height: 222px` tema). Vedi [map-popup-header-whitespace-fix.md](../troubleshooting/map-popup-header-whitespace-fix.md).

## STORY

[STORY-129](../../../../../docs/stories/STORY-129-map-marker-icon-first-popup-ux.md) · issue [#43](https://github.com/laraxot/module_geo_fila5/issues/43)

## ricostruzione

[geo-map-lit-reconstruction-guide.md](../concepts/geo-map-lit-reconstruction-guide.md)
