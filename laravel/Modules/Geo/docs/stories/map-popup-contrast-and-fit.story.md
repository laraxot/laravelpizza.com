# Popup dei marker: testo bianco su bianco, popup tagliato, azioni fuori vista

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (riproduzione, causa radice, fix, verifica nel browser)
- Owner: Modules/Geo (`popup-ticket.js`), tema Sixteen (CSS)

## Problema

Cliccando un marker della mappa il popup mostrava codice e indirizzo in bianco su bianco; il popup era piu' alto della mappa
(tagliato in basso, "Dettagli" e "Chiudi" non raggiungibili) e su mobile era piu' largo della mappa.

## Riproduzione

Il database ha 0 segnalazioni, quindi nessun marker. Playwright intercetta `/api/tickets/geojson*` e `/api/ticket-details/*`,
inietta una feature, clicca il marker e misura contrasto (WCAG, colori normalizzati con canvas), geometria e visibilita' delle azioni.
Solo la **home** era rotta, la pagina `/it/tickets` no: per questo non si vedeva ovunque.

## Cause radice

1. `civic-design-visual-fix.css`: `main section:has(#welcome-heading) h1, h2, p, a { color:#fff !important }` pensata per l'hero.
   La mappa della home sta nella stessa `section`, quindi anche `p` e link del popup Leaflet diventavano bianchi con `!important`.
   Il codice del popup aveva gia' toppe `!important` inline e il commento "avoid white-on-white": bug gia' tornato in passato.
2. `height: auto !important` su `.leaflet-popup-content`, duplicato in `popup-ticket.js` e in `07-map-clusters-and-leaflet.css`,
   annullava l'`height` inline che Leaflet imposta con `maxHeight` (0.65 x mappa, `map-lit.js`): niente scroll, popup oltre la mappa.
3. Larghezza `min(440px, 94vw)`: usa il viewport, non la mappa; su mobile la mappa e' piu' stretta e Leaflet riserva 72px a sinistra.

## Modifiche

- CSS hero: le regole escludono la mappa con `:not(.leaflet-container *)`.
- Rimosso `height: auto !important` da entrambe le copie.
- Larghezza `calc(100vw - 4.5rem)`, e `calc(100vw - 8.5rem)` sotto 480px.
- Footer con le azioni `position: sticky; bottom: 0` quando il popup scorre (`.leaflet-popup-scrolled`).
- `popup-ticket-styles.js` e' una copia morta (nessun import): non toccata, da eliminare in una story di pulizia.

## Verifica (produzione, build 6)

- Contrasto: 0 problemi su tutti i 9 stati del `TicketStatusEnum`, home e segnalazioni.
- Geometria: popup dentro la mappa e azioni visibili a 1280 e 390px su `/it` e `/it/tickets`.
- Build: `npm run build` nel tema, tutte le pagine 200 in it/en/de/es.

## Aperto

- Dati reali: status e tipo mostrati come slug (`open`, `road`) se l'API non fornisce le etichette tradotte.
- Tre `<style>` duplicati del popup (JS, JS morto, CSS tema): unificare.
- La regola `p, span, body { color:#1a1a1a !important }` e le altre `!important` globali del tema continuano a generare questa classe di bug.
