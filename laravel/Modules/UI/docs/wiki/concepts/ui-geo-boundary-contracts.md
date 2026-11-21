---
title: "ui geo boundary — niente contratti mappa in UI"
type: concept
module: UI
tags: [ui, geo, contracts, adapters, boundary]
created: 2026-07-22
updated: 2026-07-22
qmd: "UI Geo boundary no Location Map Geocoding contracts adapters LocationSelector InteractiveMap"
issues: []
discussions: []
related:
  - ../../geo-boundary.md
  - ../../second-brain.md
  - ./block-rendering-and-optional-services.md
---

# UI ↛ Geo — confini (senza contratti in UI)

## Perché

`Modules\UI` = design system. Geografia/mappe = dominio `Geo`.

Il pattern “contract + null-adapter in UI” era un compromesso sbagliato: spostava il **dominio** geografico dentro UI sotto forma di interfacce. Se serve mappa/location, vive in `Modules/Geo` (quando il monorepo lo include).

## Stato (2026-07-22)

**Rimossi da UI** (non ricreare):

- `app/Adapters/Location/`, `app/Adapters/Map/`
- `LocationDataProviderContract`, `MapServiceContract`, `GeocodingServiceContract`
- `LocationSelector`, `InteractiveMap`
- `bindIf` Geo in `UIServiceProvider`

### Come corretto

Delete del layer geografico + cleanup provider; **non** sostituito con stub. Push documentato in [../../multi-org-sync-laraxot-provtv.md](../../multi-org-sync-laraxot-provtv.md).

Canon operativo: [../../geo-boundary.md](../../geo-boundary.md)

## Verifica

```bash
cd laravel/Modules/UI
test ! -d app/Adapters
rg 'LocationDataProviderContract|MapServiceContract|GeocodingServiceContract' app --glob '*.php'
# deve essere vuoto
```
