# geo-map-popup — bem e template

## scopo

Card popup al click marker su `map-lit`: tipologia, stato, indirizzo, link mappe, cta scheda completa.

## block css (canonico)

| classe | ruolo |
|--------|--------|
| `popup` | Block principale (`<article>`) |
| `popup--loading` | Skeleton mentre arriva `/api/ticket-details/{id}` |
| `popup__header` | **`<div class="popup__header">`** — titolo + badge stato (una riga) |
| `popup__body` | Righe dati |
| `popup__footer` | Solo in stato **loaded** (cta + chiudi) — **mai** in loading |
| `popup-wrapper` | Classe su `L.popup` (contenitore leaflet) |

**Deprecato:** `geo-popup-segnalazione*`, `geo-popup*`; tag HTML `<header class="popup__header">`.

## flusso

1. Click marker → se `id`: popup loading (`popup popup--loading`, **senza** `popup__footer`)
2. Fetch api → `buildTicketPopupHtml` con `popup__footer` e azioni
3. `data-popup-open-detail` → `#modal-disservizio`

## file sorgente

| File | Contenuto |
|------|-----------|
| `laravel/Modules/Geo/resources/js/components/map/popup-ticket.js` | Template + `popupTicketStylesText` |
| `laravel/Modules/Geo/resources/js/components/map-lit.js` | `_openFeaturePopup`, inject stili, `className: 'popup-wrapper'` |

## spaziatura header → body

Ritmo verticale compatto (riferimento modal Design Comuni).

### incidente — vuoto sotto titolo (2026-06)

| | |
|--|--|
| **Sintomo** | Fascia bianca tra titolo/stato e label «TIPOLOGIA» su `/it` |
| **Causa** | `.dc-homepage-parity header { min-height: 222px !important }` sul tag `<header>` del popup |
| **Fix markup** | `<div class="popup__header">` — non eredita regole masthead |
| **Fix CSS** | `.dc-homepage-parity .leaflet-popup.popup-wrapper .popup__header { min-height: 0 !important }` in `07-map-clusters-and-leaflet.css`, `13-final-runtime-overrides.css`, `popupTicketStylesText` |
| **Fix Leaflet** | `.leaflet-popup-content { margin:0; padding:0; height:auto }`; no `maxHeight` al `popupopen` |

### layout header

- `popup__header-bar`: grid `1fr auto`, titolo col 1, badge col 2
- `popup__body`: `padding-top: 0`; prima riga `--type` compatta

## ricostruzione da documentazione

Checklist se il file JS manca:

1. Creare `popup-ticket.js` con `getPopupLabels`, `escapeHtml`, `buildTicketPopupHtml`, `buildTicketPopupLoadingHtml`, `popupTicketStylesText`.
2. Loading: **no** `popup__footer` nel template string.
3. Loaded: `popup__footer` con `data-popup-open-detail` e `data-popup-close`.
4. In `map-lit.js`: `L.popup({ className: 'popup-wrapper', maxWidth: 440 })`; inject `<style>${popupTicketStylesText}</style>`.
5. Applicare override tema (vedi guida ricostruzione).

Guida completa: [geo-map-lit-reconstruction-guide.md](./geo-map-lit-reconstruction-guide.md).

## regola bem

Vedi [bem-modifier-dom-contract.md](../rules/bem-modifier-dom-contract.md).

## collegamenti

- [geo-map-lit-farmshops-parity.md](./geo-map-lit-farmshops-parity.md)
- [ticket-type-vs-status-map-semantics.md](./ticket-type-vs-status-map-semantics.md)
- [geo-map-popup-leaflet-boundary.md](../../../../../Themes/Sixteen/docs/wiki/concepts/geo-map-popup-leaflet-boundary.md)
- [map-popup-bem-block-popup.md](../memories/map-popup-bem-block-popup.md)
