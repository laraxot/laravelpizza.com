---
title: bem modifier e dom contract
type: rule
module: Geo
confidence: high
updated: 2026-06-03
related:
  - ../concepts/geo-map-popup-bem.md
---

# BEM — modifier e DOM (religione Geo map UI)

## Scopo

Evitare selettori CSS «furbo» che nascondono parti del componente invece di modellare stati nel markup. Anti-pattern nato da nomi troppo lunghi (`geo-popup-segnalazione--loading .geo-popup-segnalazione__footer`).

## Block canonico popup mappa

| Ruolo | Classe | Esempio |
|-------|--------|---------|
| Block | `popup` | `<article class="popup">` |
| Modifier stato | `popup--loading` | skeleton, niente footer |
| Element | `popup__footer` | solo nel DOM «loaded» |
| Shell Leaflet | `popup-wrapper` | su `.leaflet-popup` (integrazione libreria) |

**Non** usare block composti tipo `geo-popup-segnalazione` o `ticket-map-popup-card` nel JS del popup: il file è già in `Modules/Geo`, il namespace è il modulo.

## Regole obbligatorie

1. **Modifier sul block** — `popup--loading`, non classi parallele inventate.
2. **Element con `__`** — `popup__footer`, `popup__header` (mai `popup--footer`: `--` è solo modifier).
3. **Stato = DOM diverso** — in loading **non** renderizzare `popup__footer`; vietato:
   ```css
   /* VIETATO */
   .popup--loading .popup__footer { display: none; }
   ```
4. **Niente concatenazione dominio nel block** — il tema Sixteen non mette classi dominio (`ticket-*`); il modulo Geo usa prefisso `geo-` solo su **marker/cluster/legenda** (`geo-map-marker-card`), non sul popup card (block corto `popup`).
5. **Stili** — SSoT stringa in `map/popup-ticket.js` (`popupTicketStylesText`), iniettata da `map-lit.js` (`#popup-styles`).

## Data attributes (JS)

| Attributo | Uso |
|-----------|-----|
| `data-popup-close` | Chiudi popup Leaflet |
| `data-popup-open-detail` | Apre `#modal-disservizio` |
| `data-popup-state="loading"` | Telemetria / test |

## Verifica

```bash
rg 'popup--loading.*popup__footer|geo-popup-segnalazione' laravel/Modules/Geo/resources/js
# atteso: zero match
```

## Collegamenti

- [geo map popup bem](../concepts/geo-map-popup-bem.md)
- [geo map lit farmshops parity](../concepts/geo-map-lit-farmshops-parity.md)
