---
type: decision
title: "BMAD — Geo: ritiro Geo Services (Services → Actions, wave3)"
status: verified
updated: 2026-10-20
date: 2026-10-20
module: Geo
tags: [bmád, geo, services, actions, queueable-action, zombie, services-to-actions, no-services]
qmd: "geo services zombie delete services-to-actions actions actions-over-services bmad decision"
related:
  - ../stories/services-to-actions-geo.story.md
  - ../stories/services-zombie-delete-wave3.story.md
  - ../architecture/actions-over-services.md
  - ../decision-log.md
---

# Decisione BMAD — Ritiro Geo Services

## Perché esiste questo file
Documenta il ritiro definitivo della cartella `app/Services/` nel modulo Geo (wave3 del giro globale "services-to-queueable-actions"). Evita che future sessioni riesumino i file `GeoDataService`, `GeoService`, `BaseGeoService`, `GoogleMapsService`, `HereService`, `GeoDataValidator` dal merge.

## Scopo
- Confermare che `Modules/Geo/app/Services/` è assente per policy (ratchet `archAllowedServicesDirs()` = `[]`)
- Documentare la corrispondenza Service → Action / Adapter
- Registrare il difetto trovato nel probe (`Distance/BuildHaversineSqlAction`: parentesi SQL mancante, corretto con test rosso→verde)

## Decisione
**Choose**: directory `app/Services/` assente; i 5 file zombie (`GeoDataValidator`, `GeoDataService`, `GeoService`, `BaseGeoService`, `GoogleMapsService`) non ricreati come Action nuove ma sostituiti da Action esistenti (`ValidateGeoDataIntegrityAction`, `LoadGeoHierarchyAction`, `GoogleMapsHttpAction`, `CalculateDistanceAction`, `ClusterLocationsAction`, ecc.).

**Over**: ricreare Service come Action «temporanee»; mantenere `app/Services/` con allowlist Geo.

**Because**:
- Regola `no-services`: un Service senza confini è una classe senza caso d'uso; Action ha `execute()` tipizzato, accodabile, testabile
- 0 chiamanti produzione (`rg --files Modules -g '*Service.php'` → solo `TermsOfService` User)
- I 5 file erano zombie riesumati da merge (`b1bc1fb3` → `60524329` cancellati → `32ff7286` riaggiunti → `05f8ba18` cancellati di nuovo)
- Equivalenza dimostrata con probe: 330 confronti uguali, 20 diversi, tutti spiegati; difetto SQL corretto

## Verifica
- `find laravel/Modules/Geo/app/Services/` = 0 file, 0 directory
- `php artisan about` parte; 246 classi `app/` caricate; PHPStan Modules 0
- Pest: `LookupPlaceActionTest` 5 test; dataset mappa 6 test; nessun peggioramento

## Non appianato (lasciato al proprietario)
- `getCities` ha cambiato forma (lista coppie nel Service → mappa `codice => nome` nelle Action)
- `comuni.json` reale non ha struttura `regions` richiesta dal codice GeoData
- `GeoServiceFacade` accessor `geo.service` senza binding
- Documentato in `services-to-actions-geo.story.md`
