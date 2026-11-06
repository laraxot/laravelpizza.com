# Controlli e popup della mappa tradotti in it, en, de, es

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (sweep delle pagine, causa, fix, verifica in browser)
- Owner: Modules/Geo (`resources/js/components/map/`)
- Collegata a: [auth-pages-i18n-en-de-es-2026-10-07.story.md](../../../User/docs/stories/auth-pages-i18n-en-de-es.story.md),
  [tickets-ux-theme-symlink-geolocation-2026-10-07.story.md](../../../../Themes/Sixteen/docs/stories/tickets-ux-theme-symlink-geolocation.story.md)

## Problema

Su `/en`, `/de`, `/es` i pulsanti della mappa avevano nome accessibile e tooltip in italiano
(`Cerca`, `Usa la mia posizione`, `Schermo intero`, zoom, layer), i messaggi di errore della
geolocalizzazione erano in italiano, e il popup del marker in de/es ricadeva sull'italiano.

## Causa radice

- `map-lit.js` impostava nel costruttore le etichette dei controlli in italiano fisso, e le view
  non passano l'attributo `labels`.
- `geolocation.js` conteneva i 5 messaggi d'errore come stringhe italiane.
- `popup-ticket.js` aveva `LABELS` solo per it ed en, con `?? LABELS.it` come fallback.

## Modifiche

- Nuovo `map/labels.js`: `getMapLabels()` legge `<html lang>` e restituisce le etichette in
  it, en, de, es (stesso schema di `getPopupLabels()`). Una view puo' ancora sovrascrivere
  passando `labels` a `<map-lit>`.
- `map-lit.js`: `this.labels = getMapLabels()`.
- `controls/geolocation.js`: messaggi `geo_insecure`, `geo_unsupported`, `geo_failed`,
  `geo_denied`, `geo_blocked` dalle stesse etichette.
- `map/popup-ticket.js`: aggiunti `de` ed `es`.
- Build del tema: `npm run build` in `Themes/Sixteen` (bundle `map-lit-YvOF8FCn.js`).

## Verifica

- Pulsanti mappa su `/{it,en,de,es}/tickets`: tutti nella lingua della pagina
  (es. en: Search, Fullscreen, Use my location, Change layer, Zoom in, Zoom out).
- Popup (ticket finto via route mock): etichette tradotte nelle quattro lingue.
- Geolocalizzazione su HTTPS con permesso: mappa su 45.07, 7.687 zoom 15 in tutte e quattro le lingue.
- Permesso negato: messaggio nella lingua della pagina (en: "Allow location access in your browser
  and try again.").
- HTTP: il proxy di sviluppo risponde 307 verso HTTPS, quindi la pagina si apre sempre in contesto sicuro.
- Contrasto popup: `bashscripts/tools/visual/map-popup-contrast.cjs` verde, minimo 4.83.

## Aperto

- Altri componenti con etichette italiane fisse non toccati: `coordinate-picker-lit.js`,
  `map-picker-lit.js`, `geopoint-picker-lit.js` (modulo Fixcity, form di segnalazione).
- `legend_title` e le etichette dei filtri di stato della legenda non sono state controllate in de/es.
- Una nuova lingua va aggiunta in `labels.js` e in `popup-ticket.js`.
