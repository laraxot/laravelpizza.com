---
title: Ticket type vs status — mappa e filtri
type: decision
module: Geo
sources:
  - ./geo-map-widget-farmshops-pattern.md
  - ../../../../Fixcity/app/Actions/BuildTicketsGeoJsonAction.php
  - ../../../../Fixcity/app/Enums/TicketTypeEnum.php
  - ../../../../Fixcity/app/Enums/TicketStatusEnum.php
confidence: high
updated: 2026-06-03
related:
  - ../../../../../../docs/stories/STORY-125-map-legend-status-semantics-collapsible.md
  - ../../../../../../docs/stories/STORY-127-map-gps-filtri-legenda-farmshops.md
---

# Semantica type vs status (mappa `/it`)

## Regola (obbligatoria)

| Concetto | Enum | UI filtri sidebar | Pin mappa | Legenda mappa |
|----------|------|-------------------|-----------|---------------|
| **Tipologia** | `TicketTypeEnum` | Checkbox per `value`; **una sola** `iconUrl` (`fixcity::svg`) | Stesso glifo `<img>` nel pin | ❌ (già in sidebar) |
| **Stato workflow** | `TicketStatusEnum` | ❌ (non filtrare qui) | **Colore del pin** | ✅ pallino + label stato |

Il colore in `ticket_type_enum` (es. `#fbc02d`) serve ad altri contesti (admin Filament, badge tipo). **Non** va usato per riempire pin o voci filtro elenco.

## Contratto GeoJSON (`BuildTicketsGeoJsonAction`)

```json
{
  "properties": {
    "type": { "value", "label", "iconUrl": "/assets/fixcity/svg/waste-collection.svg" },
    "status": { "value", "label", "color": "#ea580c" }
  }
}
```

- `type`: **solo** `iconUrl` — file `Modules/Fixcity/resources/svg/{value-kebab}.svg`, riferimento `fixcity::svg/{value-kebab}.svg` ([regola icona](../../../Fixcity/docs/wiki/concepts/ticket-type-icon-fixcity-svg.md)).
- `status.color`: **sempre hex** (`ResolveTicketStatusMarkerPropertiesAction::resolveMapHexColor`).
- Vietato: `type.icon` heroicon + `iconUrl` UI in parallelo.

## Frontend

- `resolveFeatureTicketType` → filtro + glifo.
- `resolveFeatureTicketStatus` → colore pin + legenda + cluster LOD (pallini stato a zoom ≥ 8).
- `BuildSegnalazioniFilterAggregateAction` → aggrega solo metadati **tipo** senza `color`.

## Owner GitHub

Issue/discussion su **`laraxot/module_geo_fila5`** per `map-lit`, cluster, legenda.

## Collegamenti

- [STORY-125](../../../../../../docs/stories/STORY-125-map-legend-status-semantics-collapsible.md)
- [farmshops pattern](./geo-map-widget-farmshops-pattern.md)
