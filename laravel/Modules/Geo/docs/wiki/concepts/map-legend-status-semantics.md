# Legenda mappa — semantica stato vs tipologia (STORY-125)

## Scopo

Correggere un errore di prodotto introdotto con STORY-094: la legenda mostrava **tipologie con pallino colore**, ma nel modello Fixcity:

| Canale | Significato business |
|--------|----------------------|
| Icona / glifo nel pin | **Tipologia** (`TicketTypeEnum`, heroicon / iconUrl) |
| Colore riempimento pin | **Stato** (`TicketStatusEnum`: open, pending, in_progress, resolved, …) |

Le tipologie sono **già** nel pannello filtri desktop (`filters-sidebar`, issue #11) — non duplicarle sulla mappa.

## Stato attuale (2026-06-03)

- `legend.js` → `collectLegendTypesFromFeatures()` — **da rimuovere/sostituire**
- `map-lit.js` → `createGeoMapLeafletIcon(L, ticketStatus.color, ticketType.iconUrl)` — colore **stato**, glifo **iconUrl** fixcity
- GeoJSON `tickets.json` → `type.color` presente, `status` solo stringa

## Decisione UX (brainstorming #31)

Preferenza: **legenda collassabile solo stati**, default chiusa — oppure **nessuna legenda** su `/it` dopo fix marker (opzione A).

Attributo proposto su `<map-lit>`:

- `legend-mode="off"` — nessuna legenda
- `legend-mode="status-collapsed"` — solo stati, chiusa (default `/it`)
- `legend-mode="status-open"` — stati espansi

## Implementazione prevista

Vedi story: `docs/stories/STORY-125-map-legend-status-semantics-collapsible.md`

## GitHub

- Issue: [#30](https://github.com/laraxot/module_geo_fila5/issues/30)
- Discussion: [#31](https://github.com/laraxot/module_geo_fila5/discussions/31)
- Supersede parziale: [#14](https://github.com/laraxot/module_geo_fila5/issues/14) STORY-094

## Collegamenti

- [map-lit-legend-types.md](./map-lit-legend-types.md) — documentazione STORY-094 (obsoleta per tipologie)
- [map-lit-it-incidents-2026-06.md](../troubleshooting/map-lit-it-incidents-2026-06.md)
