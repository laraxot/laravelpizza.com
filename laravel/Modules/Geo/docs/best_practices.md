# Best Practices – Geo Module

## Principi DRY/KISS

- **DRY**: Centralizza la logica di geolocalizzazione in `GeoService`. Usa metodi statici solo per costanti.
- **KISS**: Mantieni i componenti Leaflet leggeri; usa `L.divIcon` con SVG inline per evitare dipendenze CDN esterne.
- **Clean Code**: Segui la regola `CoordinatePicker Multi-Column Save` – evita `dehydrated(false)` e usa `dehydrateStateUsing()`.

## Componenti

- Usa `LatitudeLongitudeInput` per campi diretti lat/lng (non estendere `CoordinatePicker`).
- Usa `CoordinatePicker` per selezione interattiva mappa con stato composito.
- Usa `AddressInput` per input testuale con suggerimenti e geocodifica.

## Test

- Implementa test unitari per `GeoService::geocode()`.
- Implementa test E2E per componenti Lit.
- Verifica assenza di `unpkg` o `L.Icon.Default` in bundle JS.

## Documentazione

- Aggiorna sempre `docs/INDEX.md` quando aggiungi file.
- Riferisciti alle regole in `bashscripts/ai/.claude/rules/` per approfondimenti.
