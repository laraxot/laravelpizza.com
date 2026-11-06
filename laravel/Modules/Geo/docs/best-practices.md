---
title: "best practices"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "best practices"
issues: []
discussions: []
status: draft
---

# Best Practices – Geo Module

## Principi DRY/KISS

- **DRY**: Centralizza la logica di geolocalizzazione nelle Action di `Modules\Geo\Actions` (`GeoService` e' stato ritirato, vedi [la story](./stories/services-to-actions-geo.story.md)). Usa metodi statici solo per costanti.
- **KISS**: Mantieni i componenti Leaflet leggeri; usa `L.divIcon` con SVG inline per evitare dipendenze CDN esterne.
- **Clean Code**: Segui la regola `CoordinatePicker Multi-Column Save` – evita `dehydrated(false)` e usa `dehydrateStateUsing()`.

## Componenti

- Usa `LatitudeLongitudeInput` per campi diretti lat/lng (non estendere `CoordinatePicker`).
- Usa `CoordinatePicker` per selezione interattiva mappa con stato composito.
- Usa `AddressInput` per input testuale con suggerimenti e geocodifica.

## Test

- Implementa test unitari per le Action di geocoding (`GetCoordinatesAction`, `Geocoding/GeocodeAddressAction`). `GeoService::geocode()` non esiste: la classe aveva solo distanza, haversine e punto in poligono.
- Implementa test E2E per componenti Lit.
- Verifica assenza di `unpkg` o `L.Icon.Default` in bundle JS.

## Documentazione

- Aggiorna sempre `docs/INDEX.md` quando aggiungi file.
- Riferisciti alle regole in `bashscripts/ai/.claude/rules/` per approfondimenti.
