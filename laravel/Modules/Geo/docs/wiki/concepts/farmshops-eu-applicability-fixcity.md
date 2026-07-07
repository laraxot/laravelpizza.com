---
title: "farmshops.eu — cosa riusare in Fixcity (studio 2026)"
type: concept
module: Geo
sources:
  - https://github.com/CodeforKarlsruhe/farmshops.eu
  - https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js
  - https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/popupcontent.js
  - https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/update_data.js
  - ./geo-map-widget-farmshops-pattern.md
  - ../../../farmshops-integration-analysis.md
confidence: high
updated: 2026-06-10
related:
  - ../../../../Fixcity/docs/wiki/concepts/ticket-list-map-architecture.md
  - ../../../../../docs/stories/STORY-064-farmshops-eu-study-second-brain.md
---

# farmshops.eu — applicabilità Fixcity

## Scopo

[Sintesi operativa](https://github.com/CodeforKarlsruhe/farmshops.eu) del pattern **dataset GeoJSON statico + Leaflet client-side** per mappa segnalazioni, filtri e cluster — senza copiare jQuery, ExtraMarkers o stack legacy.

Documenti correlati (non duplicare qui l’analisi lunga):

- [geo-map-widget-farmshops-pattern.md](./geo-map-widget-farmshops-pattern.md) — decisione architetturale Geo
- [farmshops-integration-analysis.md](../../../farmshops-integration-analysis.md) — analisi estesa
- [ticket-list-map-architecture.md](../../../../Fixcity/docs/wiki/concepts/ticket-list-map-architecture.md) — flusso `tickets.json` + `map-lit`

## Architettura farmshops (verificata su repo)

```text
update_data.js (Node + query-overpass)
    → data/*.geojson (static, committato o deploy)
index.html + js/direktvermarkter.js
    → fetch GeoJSON una volta
    → L.geoJSON + pointToLayer (icona per tipo)
    → L.markerClusterGroup (raggio cluster ∝ zoom)
    → popup: click → getJSON data/{id}/details.json (lazy)
```

**Perché funziona:** zero round-trip server su pan/zoom/filter; dataset nell’ordine di migliaia di punti resta < 1 MB.

## Matrice: farmshops → Fixcity

| Pattern farmshops | Utile? | Implementazione Fixcity | Gap / story |
|-------------------|--------|-------------------------|-------------|
| GeoJSON statico in `/data` | Sì | `public_html/data/tickets.json` | Rigenerare da admin (`GenerateTicketsJsonAction`) — [#136](https://github.com/laraxot/base_fixcity_fila5/issues/136) |
| Export batch (update_data.js) | Sì (adattato) | Action PHP da DB ticket, non OSM | Schedule/cron opzionale |
| `pointToLayer` per tipologia | Sì | `properties.type` + enum `TicketType` in Feature | STORY-051 / module_geo #4 |
| MarkerCluster + radius per zoom | Sì | `map-lit.js` | Verificare parity cluster vs reference |
| Popup da properties locali | Sì | Popup in `map-lit` da Feature | Design Comuni testo/link |
| Popup lazy `details.json` per id | No (KISS) | Tutto in `properties` nel GeoJSON | — |
| L.ExtraMarkers colorati | No | SVG/enum icon (no dipendenza ExtraMarkers) | [geo-map-lit-farmshops-parity.md](./geo-map-lit-farmshops-parity.md) |
| jQuery + $.getJSON | No | Lit + `fetch` | — |
| Leaflet Permalink (URL zoom/center) | Forse | Non su `/it` elenco | Backlog UX |
| Sidebar v2 | No | Layout Design Comuni + `map-filter-lit` | STORY-062 |
| Filtri client-side | Sì | `map-filter-lit` → `map-lit.filterByTypes()` | STORY-053 |
| OSM tiles + satellite toggle | Parziale | OSM in map-lit; satellite se previsto | — |
| opening_hours.js | No (dominio) | Orari ticket non in scope elenco | — |
| Poligoni + pin al centro | Forse | Ticket solo Point oggi | Futuro zone segnalazioni |

## File farmshops da leggere (ordine)

| File | Cosa copiare come *idea* |
|------|-------------------------|
| [update_data.js](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/update_data.js) | Pipeline export → file statico; no query live in runtime |
| [direktvermarkter.js](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js) | `pointToLayer`, cluster radius vs zoom, resize popup |
| [popupcontent.js](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/popupcontent.js) | Template popup HTML da oggetto dati (no Blade) |

## Anti-pattern da non importare

- CDN Leaflet/jQuery in pagina (regola progetto: npm/Vite).
- Secondo fetch per ogni marker al click se i dati stanno già nel GeoJSON.
- Logica business (tipi ticket, visibilità FO) nel JS mappa — resta in PHP all’export.

## Checklist operativa dev

1. Dopo modifica ticket/location: esportare `tickets.json`.
2. Verificare `total` e `features.length` > 0 su `/data/tickets.json`.
3. `/it` tab Mappa: `map-lit` carica JSON; filtri allineati (STORY-053).
4. Build tema: `cd laravel/Themes/Sixteen && npm run build && npm run copy`.

## GitHub

- Issue studio: [module_geo_fila5](https://github.com/laraxot/module_geo_fila5/issues) (vedi STORY-064)
- Discussion: [module_geo #5](https://github.com/laraxot/module_geo_fila5/discussions/5)
- Mono elenco: [discussion #133](https://github.com/laraxot/base_fixcity_fila5/discussions/133)

---

## Aggiornamento 2026-06 — lezioni cluster e hover

Verificato su `/it` dopo allineamento a [direktvermarkter.js](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js):

| Regola farmshops | Fixcity | Note |
|------------------|---------|------|
| No refresh manuale cluster | `_scheduleClusterRefresh` rimosso | Plugin gestisce da solo |
| divIcon dimensione fissa + anchor centrato | 80×80, anchor 40,40 | |
| Hover senza `transform` su marker-icon | `07-map-clusters-and-leaflet.css` | **Tema**, non solo Lit |
| `removeOutsideVisibleBounds` | `false` su Fixcity | GPS lontano da ticket — STORY-124 |

Incidenti: [map-lit-it-incidents-2026-06.md](../troubleshooting/map-lit-it-incidents-2026-06.md)

---

## Aggiornamento 2026-06-10 — confronto fine sorgente + verifica empirica popup

Studio architettura BMAD: `_bmad-output/architecture-map-farmshops-parity-2026-06-10.md` (decisioni A1–A5 con trade-off e traceability — non duplicare qui).

**CSS farmshops verificato** (`css/style.css`): `#offen` verde / `#geschlossen` rosso; `a.button` blu `#4ca7ce`; `.leaflet-popup-content-wrapper` border-radius 0, Verdana 10px; resize popup su `popupopen` con `maxHeight = 0.8 * mapH`, `maxWidth = 0.95 * mapW` (Fixcity: 0.4 / 0.9).

**Difetti reali misurati live su `/it`** (Puppeteer, non parity gap):

| # | Difetto | Misura | Fix (vedi doc BMAD) |
|---|---------|--------|---------------------|
| 1 | Controlli custom coprono il popup aperto | `.layer-controls-overlay` z-index 3001 > popup pane 700 | A1 — `autoPanPaddingTopLeft` |
| 2 | Badge stato sovrapposto al titolo nell'header popup | header 440px, titolo senza riserva spazio badge+close | A2 — header flex + line-clamp |
| 3 | Popup vuoto se aperto via `openPopup()` programmatico | contentLen 0 (fill solo su `click`, come farmshops `once("click")`) | A3 — fill su `popupopen` |

Confermato: marker Fixcity (colore=stato + glifo=tipo) già **superiore** a farmshops (solo tipo); cluster già parity — non toccare (vedi sezione 2026-06 sopra).
