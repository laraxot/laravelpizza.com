---
title: js file english naming standing rule
type: memory
module: Geo
updated: 2026-06-03
related:
  - ../rules/js-file-english-naming-rule.md
  - ../concepts/map-js-module-naming-rule.md
  - ../../../../../docs/stories/STORY-132-rename-popup-segnalazione-js-english.md
---

# Memoria — JS Geo: mai italiano nel filename

## Regola

- Path `resources/js/**`: segmenti filename **solo inglese**.
- Dominio codice: **ticket** (non `segnalazione` nel file path).
- Italiano solo in `lang/`, label `getPopupLabels`, slug route.

## Caso STORY-132 (completato 2026-06-03)

`map/popup-ticket.js` — export `buildTicketPopupHtml`, `buildTicketPopupLoadingHtml`, `popupTicketStylesText`. Vietato reintrodurre `popup-segnalazione.js` o `buildSegnalazione*`.

## Verifica rapida

```bash
rg 'popup-segnalazione|buildSegnalazione' laravel/Modules/Geo/resources/js
```

## Collegamenti

- [js-file-english-naming-rule.md](../rules/js-file-english-naming-rule.md)
