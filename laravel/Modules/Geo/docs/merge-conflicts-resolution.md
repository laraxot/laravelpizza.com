---
title: "merge conflicts resolution"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "merge conflicts resolution"
issues: []
discussions: []
status: draft
---

# Risoluzione Conflitti di Merge - Modulo Geo

## Panoramica
Data: [DATE]
Conflitti identificati: 34 file
Strategia: DRY, KISS, analisi contestuale

## Lista File con Conflitti

### Modelli (8 file)
- `app/Models/Address.php`
- `app/Models/County.php` 
- `app/Models/GeoNamesCap.php`
- `app/Models/Location.php`
- `app/Models/Place.php`
- `app/Models/PlaceType.php`
- `app/Models/State.php`
- `app/Models/Traits/GeographicalScopes.php`

### Actions (12 file)
- `app/Actions/Bing/GetAddressFromBingMapsAction.php`
- `app/Actions/CalculateDistanceAction.php`
- `app/Actions/ClusterLocationsAction.php`
- `app/Actions/Elevation/GetElevationAction.php`
- `app/Actions/FilterCoordinatesAction.php`
- `app/Actions/FilterCoordinatesInRadiusAction.php`
- `app/Actions/GetAddressDataFromFullAddressAction.php`
- `app/Actions/GoogleMaps/CalculateDistanceMatrixAction.php`
- `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php`
- `app/Actions/Mapbox/GetAddressFromMapboxAction.php`
- `app/Actions/Mapbox/GetAddressFromMapboxLatLngAction.php`
- `app/Actions/OptimizeRouteAction.php`

### Filament (4 file)
- `app/Filament/Resources/LocationResource.php`
- `app/Filament/Resources/Pages/ListLocations.php`
- `app/Filament/Resources/Pages/ViewLocation.php`
- `app/Filament/Widgets/LocationMapWidget.php`
- `app/Filament/Widgets/OSMMapWidget.php`

### Data Objects (2 file)
- `app/Datas/CoordinatesData.php`
- `app/Datas/RouteData.php`

### Services (2 file) — ELIMINATI — No-Services
- `app/Services/BaseGeoService.php` ❌ (rimosso, sostituito da Actions: `GetCoordinatesByAddressAction`, `GetAddressFromNominatimAction`, `CalculateDistanceAction` etc.)
- `app/Services/GoogleMapsService.php` ❌ (rimosso, sostituito da `Actions/GoogleMaps/*`)
- **Nota**: `app/Services/` non esiste più in Geo. Zero chiamanti in produzione (verificato con `grep -rn`).

### Configurazione e Risorse (6 file)
- `README.md`
- `docs/module_geo.md`
- `lang/en/geo.php`
- `resources/views/maps/farmshops/dist/js/app.js`
- `resources/views/maps/farmshops/resources/css/style.default.css`

## Strategia di Risoluzione

### Priorità
1. **Modelli**: Base dell'architettura, risoluzione critica
2. **Actions**: Logica business, mantenere coerenza Spatie
3. **Filament**: UI/UX, seguire convenzioni XotBase
4. **Configurazione**: Traduzioni e setup

### Principi
- **DRY**: Eliminare duplicazioni
- **KISS**: Mantenere semplicità
- **Analisi contestuale**: Studiare entrambe le versioni
- **Coerenza architetturale**: Rispettare pattern Laraxot

## Status Risoluzione
- [ ] Modelli (3/8) - ✅ Address.php, County.php, GeographicalScopes.php risolti
- [ ] Actions (0/12) 
- [ ] Filament (0/5)
- [ ] Data Objects (0/2)
- [x] Services (2/2) — ELIMINATI (No-Services, non ricreati)
- [ ] Configurazione (0/5)

## Risoluzioni Completate

### Address.php ✅
- **Conflitto**: Versione semplice vs versione completa con PHPDoc
- **Risoluzione**: Mantenuta versione completa con:
  - PHPDoc completo per tutte le proprietà
  - Relazioni morfiche (addressable)
  - Metodi per geolocalizzazione
  - Scope per ricerche geografiche
  - Implementazione Schema.org PostalAddress
- **Motivazione**: Versione avanzata segue best practice Laraxot

### GeographicalScopes.php ✅ (ELIMINATO — No-Services)
- **Conflitto**: Non applicabile; il file `app/Models/Traits/GeographicalScopes.php` è stato rimosso (zero chiamanti in produzione, sostituito da `GeoTrait::scopeWithDistance`).
- **Stato attuale**: Il trait non esiste. Le scope di distanza vivono in `GeoTrait.php`. Vedi [decision-log](./decision-log.md) 2026-10-20.

## Note Tecniche
- Tutti i conflitti sembrano essere nel modulo Geo
- Probabile merge tra branch con refactoring significativo
- Necessaria analisi approfondita per ogni file
- Aggiornamento documentazione dopo ogni risoluzione

## Collegamenti
- [Geo Module Architecture](architecture.md)
- [Geo Models Documentation](models/)
- [Geo Actions Documentation](../app/Actions/)
- [Merge Conflict Best Practices](../../Xot/project_docs/conflicts/)
