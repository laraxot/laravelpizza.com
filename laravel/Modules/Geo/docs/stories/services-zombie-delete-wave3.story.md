---
title: Geo — delete Services riesumati (wave3 post-phpstan-zero)
type: story
module: Geo
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [services-to-actions, geo, boy-scout]
qmd: "geo services zombie delete hereservice geodataservice googlemaps geodata actions delete-again"
related:
  - ../decision-log.md
  - ../architecture/actions-over-services.md
  - ../scopo.md
  - ../../Xot/docs/stories/services-to-actions-global-wave.story.md
  - ../../Xot/docs/bmad/brainstorming-services-to-actions-wave.md
  - ../../Xot/docs/stories/phpstan-modules-zero-wave3.story.md
---

# Geo: Services zombie eliminati

## Perche'

I cinque file in `app/Services/` erano copie riesumate dal merge dopo che
`b112b61b` (2026-10-08) li aveva sostituiti con Actions. Scopo reale:

| Service rimosso | Caso d'uso | Action canonica |
|-----------------|------------|-----------------|
| `GeoDataValidator` | struttura e integrita' del JSON geografico | `Actions/GeoData/ValidateGeoDataIntegrityAction` |
| `GeoDataService` | gerarchia regioni/province/citta/CAP | `Actions/GeoData/LoadGeoHierarchyAction` (+ GetCities/Regions) |
| `GoogleMapsService` / `BaseGeoService` | HTTP Google Maps | `Actions/GoogleMaps/GoogleMapsHttpAction` (+ siblings) |
| `GeoService` | distanza / polygon / facade naming | `Actions/Distance/*`, `Actions/Polygon/*`; facade → Action |

`rg` su produzione (esclusi docs/tests): nessun `use Modules\Geo\Services\…` vivo —
solo menzioni in commenti Action («Sostituisce…»).

## Ciclo riesumazione (stesso giorno)

1. Story marcata done con cartella assente.
2. Mid-sessione: cinque PHP di nuovo su disco (merge/staging).
3. Verifica: 0 caller reali → **delete-again** (non convertire).
4. Gate: directory `app/Services/` assente; `archAllowedServicesDirs()` resta `[]`.

## Verifica

- Directory `app/Services/` assente, inclusi placeholder e backup
- Hub wave: [services-to-actions-global-wave](../../Xot/docs/stories/services-to-actions-global-wave.story.md)
- `phpstan analyse Modules` resta a 0 (remeasure coordinatore; preferire `--memory-limit=2G` se OOM)
