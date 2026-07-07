---
title: "studio farmshops.eu — cluster con icone tipologia (non stato)"
type: concept
module: Geo
tags: [map, cluster, farmshops, leaflet, markercluster, ticket-type, iconUrl]
created: 2026-06-06
updated: 2026-06-06
qmd: "farmshops cluster type icons markercluster geo-map-lit ticket type iconUrl getLabel"
issues: []
related:
  - geo-map-lit-farmshops-parity.md
  - map-lit-cluster-type-icons.md
  - ../../../Fixcity/docs/wiki/concepts/ticket-type-icon-fixcity-svg.md
  - ../../../../../../docs/stories/STORY-284-map-cluster-type-icons-farmshops-parity.md
reference: "https://github.com/CodeforKarlsruhe/farmshops.eu"
---

# Studio [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu) — cluster e icone tipologia

## Scopo

Confrontare la mappa Fixcity (`geo-map-lit`) con il reference open source [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu) (JS: `js/direktvermarkter.js`) e definire il gap sui **cluster**: mostrare le **icone delle tipologie presenti**, non i colori dello **stato** workflow.

## Cosa fa farmshops.eu (reference)

| Aspetto | Comportamento |
|---------|----------------|
| Marker singolo | `L.ExtraMarkers` per categoria (`farm`, `marketplace`, `vending_machine`, `beekeeper`) — icona + colore forma |
| Cluster zoom **&lt; 8** | Cerchio bianco, solo **conteggio** |
| Cluster zoom **≥ 8** | Conteggio + **mini-icone categoria** (`<img src="icons/farm.png">` …) per ogni tipo **presente** nel cluster |
| Raggruppamento cluster | `iconCreateFunction` scorre `markers[c].feature.properties.p` |
| Raggio | `maxClusterRadius`: 80 se zoom &lt; 12, altrimenti 45 |
| Plugin | leaflet.markercluster, leaflet ExtraMarkers, permalink, locate, sidebar |

Pattern chiave: il cluster comunica **diversità di offerta** (tipi POI), non stato operativo.

## Cosa fa Fixcity oggi

| Aspetto | Stato | Note |
|---------|--------|------|
| Marker singolo | ✅ | Corpo colorato **stato** + glifo **tipologia** (`iconUrl` da `TicketTypeEnum` / `ResolveTicketTypeMarkerPropertiesAction`) — STORY-130 |
| Dati su marker | ✅ | `typeValue`, `typeIconUrl`, `statusValue`, `statusColor` in `L.marker` options |
| Cluster zoom &lt; 8 | ✅ | Solo conteggio (allineato) |
| Cluster zoom ≥ 8 | ❌ **regressione** | `_createClusterIcon` usa `statusesPresent` + `buildClusterTypeDotHtml(statusColor)` |
| Documentazione | ⚠️ | `geo-map-lit-farmshops-parity.md` parla di `typeColor`; codice usa stato |

```javascript
// map-lit.js — da correggere (STORY-284)
markers.forEach(m => {
    const s = m.options.statusValue;  // ← errato per UX richiesta
    statusesPresent[s] = m.options.statusColor;
});
```

## Cosa vogliamo (business)

- **Cluster** = leggenda compatta delle **tipologie di segnalazione** presenti (come farmshops con farm/market/machine).
- **Icone** = stesso `iconUrl` del marker singolo (`getLabel` → SVG `fixcity::svg/*`), non pallini colore stato.
- **Stato** resta visibile sul **marker singolo** (fill corpo), filtri legenda stato, popup — non nel cerchio cluster.

## Soluzione proposta (STORY-284)

1. `_createClusterIcon`: deduplica per `typeValue`, raccogli `typeIconUrl` da child markers.
2. Zoom ≥ 8: `count` + `buildMarkerGlyphHtml(iconUrl, 14)` per ogni tipo presente (come farmshops, size locked).
3. Vietato nel cluster: `statusColor`, `buildClusterTypeDotHtml` per stato.
4. CSS: mantenere lock 10–16px in `.geo-cluster-type-icons` (già in `07-map-clusters-and-leaflet.css`).
5. Test Playwright: cluster contiene `<img>` con `src` da tipologia, non solo `<circle>` stato.
6. Aggiornare doc `map-lit-cluster-type-icons.md` (pallini solo se fallback tipo senza `iconUrl`).

## Altri miglioramenti opzionali (post-MVP)

| farmshops | Fixcity | Priorità |
|-----------|---------|----------|
| `showCoverageOnHover: true` | `false` | bassa |
| Permalink zoom/center | parziale | media |
| Sidebar layer control | controlli custom Lit | fuori scope |
| Lazy popup `details.json` | popup + API ticket-details Folio | già diverso, OK |

## SSoT dati

- GeoJSON `/data/tickets.json` → `properties.type.{ value, label, iconUrl }`
- PHP: `ResolveTicketTypeMarkerPropertiesAction` + enum `TicketTypeEnum::getLabel()` / SVG module Fixcity
- JS: `resolveFeatureTicketType()` in `map/feature-type.js`

## Collegamenti

- [ticket-type-icon-fixcity-svg.md](../../../Fixcity/docs/wiki/concepts/ticket-type-icon-fixcity-svg.md)
- [STORY-284](../../../../../../docs/stories/STORY-284-map-cluster-type-icons-farmshops-parity.md)
- Reference: [direktvermarkter.js](https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js)
