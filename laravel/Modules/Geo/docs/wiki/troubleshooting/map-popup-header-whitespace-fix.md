# popup mappa — vuoto verticale header → Tipologia

## scopo

Runbook per l’area bianca segnata in UX tra titolo/badge e la prima riga **TIPOLOGIA** nel popup Leaflet su `/it` (STORY-129).

**Business impact:** l’utente percepisce il popup «rotto» e non legge subito tipologia/indirizzo — perdita fiducia nel servizio segnalazioni.

---

## sintomo

- Popup con titolo «Rifiuti abbandonati» e badge «Risolto» in alto.
- Fascia bianca ~25–40% altezza card **prima** del bordo e della riga Tipologia.
- Screenshot riferimento: `tooltip/1.png` (cartella utente Screenshots fixcity).

---

## cause (ordine di scoperta)

### 1. Regola CSS globale su `header` (principale)

`design-comuni-visual-fix.css` (e in passato selettori troppo larghi) imponevano:

```css
header { min-height: 222px !important; }
```

Il popup usava `<header class="popup__header">` → ereditava l’altezza del **masthead** del sito, non del popup.

### 2. Flex errato sul titolo (secondaria, già corretta)

`flex: 1 1 100%` + `order: -1` sul badge creava una seconda riga flex vuota (~44px) quando si usava ancora flex-wrap.

### 3. Markup

Passaggio a **`<div class="popup__header">`** per non matchare regole AGID sul tag `header`.

---

## fix canonico (ricostruibile)

### markup (`popup-ticket.js`)

- Usare `<div class="popup__header">`, non `<header>`.
- `popup__header-bar`: griglia `grid-template-columns: 1fr auto` (titolo | badge).

### CSS modulo (`popupTicketStylesText`)

```css
.leaflet-popup.popup-wrapper .popup__header,
.dc-homepage-parity .leaflet-popup.popup-wrapper .popup__header,
.popup__header {
  min-height: 0 !important;
  height: auto !important;
  padding: 0.5rem 2.25rem 0.3rem 0.85rem !important;
}
```

### CSS tema

| File | Regola |
|------|--------|
| `07-map-clusters-and-leaflet.css` | override `.leaflet-popup.popup-wrapper .popup__header` |
| `13-final-runtime-overrides.css` | stesso override in coda cascade |
| `design-comuni-visual-fix.css` | esclusione `header.popup__header`; sito solo `header.it-header-wrapper` |

### homepage parity

In `07-map-clusters-and-leaflet.css` **non** usare `.dc-homepage-parity header` generico — solo `.dc-homepage-parity .it-header-wrapper`.

---

## verifica

1. DevTools: ispezionare `.popup__header` → `min-height` deve essere `0`, altezza ~40–50px totale header.
2. Nessun gap tra `.popup__header-bar` e `border-bottom` del header.
3. Prima riga body: label `TIPOLOGIA` visibile subito sotto il bordo.
4. `npm run build` + hard refresh.

---

## anti-pattern

- `<header class="popup__header">` con tema che stila `header { min-height: … }`.
- Nascondere footer loading con CSS descendant invece di ometterlo dal DOM.
- Aumentare `padding-top` su `.popup__body` per «compensare» il vuoto (maschera il bug).

---

## collegamenti

- [geo-map-popup-bem.md](../concepts/geo-map-popup-bem.md)
- [geo-map-lit-reconstruction-guide.md](../concepts/geo-map-lit-reconstruction-guide.md)
- [geo-map-popup-leaflet-boundary.md](../../../../../Themes/Sixteen/docs/wiki/concepts/geo-map-popup-leaflet-boundary.md)
- [STORY-129](../../../../../docs/stories/STORY-129-map-marker-icon-first-popup-ux.md)
