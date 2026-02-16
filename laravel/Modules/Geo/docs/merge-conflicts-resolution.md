# Risoluzione Conflitti di Merge - Modulo Geo

## Panoramica
Data: 2025-07-30
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

### Services (2 file)
- `app/Services/BaseGeoService.php`
- `app/Services/GoogleMapsService.php`

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
- [ ] Services (0/2)
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

### GeographicalScopes.php ✅
- **Conflitto**: Già risolto correttamente
- **Stato**: Utilizza correttamente `GetDistanceExpressionAction` centralizzata
- **Implementazione**: 
  - Scope `scopeWithDistance` per calcolo distanza
  - Scope `scopeOrderByDistance` per ordinamento geografico
  - Metodo `getDistanceExpression` che delega all'action
- **Motivazione**: Segue principi DRY e KISS, action centralizzata

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
