# regola: filename JS modulo Geo — solo inglese

## scopo

Nei path sotto `Modules/Geo/resources/js/` (e mirror tema se presente) **ogni segmento del filename** deve essere in inglese. Il dominio nel codice è **ticket**, non *segnalazione*.

**Perché:** `grep`, import Vite, story dev, ricostruzione da docs — un vocabolario unico. L’italiano resta in `lang/`, route slug pubblici, commenti che citano Design Comuni, label UI.

---

## regola

| Contesto | Convenzione | Esempio |
|----------|-------------|---------|
| File JS modulo Geo | kebab-case **inglese** | `popup-ticket.js`, `marker-config.js` |
| Cartella shared | `map/` (namespace path) | `map/popup-ticket.js` |
| Export funzioni | inglese + dominio ticket/map | `buildTicketPopupHtml` |
| Classi CSS BEM | possono essere corte (`popup`) | non legate al filename |
| Copy utente IT | `getPopupLabels()` / lang files | `Tipologia`, `Indirizzo` OK **dentro stringhe** |

---

## vietato

| Pattern | Motivo |
|---------|--------|
| `popup-segnalazione.js` | `segnalazione` italiano |
| `mappa-filtro.js` | italiano ([STORY-106](../../../../../docs/stories/STORY-106-playwright-vietato-nome-italiano-mappa-filtro.md)) |
| `buildSegnalazionePopupHtml` | italiano nel symbol |
| `geo-popup-segnalazione*` | ridondante + italiano (deprecato) |

---

## migrazione canonica (STORY-132)

| Deprecato | Canonico |
|----------|----------|
| `map/popup-segnalazione.js` | `map/popup-ticket.js` |
| `buildSegnalazionePopupHtml` | `buildTicketPopupHtml` |
| `buildSegnalazionePopupLoadingHtml` | `buildTicketPopupLoadingHtml` |
| `popupSegnalazioneStylesText` | `popupTicketStylesText` |

---

## eccezioni (non sono filename)

- URL `/it/segnalazione/crea` — routing prodotto
- `__('fixcity::segnalazione.*')` — traduzioni
- `data-page="ticket-list"` — slug pagina parity Design Comuni
- Commenti `// Reference: ticket-list.html`

---

## verifica CI / pre-merge

```bash
# zero match in JS sorgente Geo (salvo shim @deprecated espliciti)
rg 'popup-segnalazione|buildSegnalazione|popupSegnalazione' laravel/Modules/Geo/resources/js

# lista file con segmenti sospetti (review manuale)
find laravel/Modules/Geo/resources/js -name '*segnalazione*' -o -name '*mappa*' -o -name '*filtro*'
```

---

## collegamenti

- [map-js-module-naming-rule.md](../concepts/map-js-module-naming-rule.md) — layout cartella `map/`
- [geo-map-lit-reconstruction-guide.md](../concepts/geo-map-lit-reconstruction-guide.md)
- [STORY-132](../../../../../docs/stories/STORY-132-rename-popup-segnalazione-js-english.md)
- [STORY-063](../../../../../docs/stories/STORY-063-naming-convention-ticket-vs-segnalazioni.md)
- Tema: [no-italian-component-names.md](../../../../../Themes/Sixteen/docs/wiki/rules/no-italian-component-names.md)
