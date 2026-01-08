# Git Conflicts Resolution Log

## Files with Git Conflicts (28 total)

All conflicts are in the Geo module (`laravel/Modules/Geo/`):

### Models (8 files)
1. `app/Models/Place.php`
2. `app/Models/County.php`
3. `app/Models/Address.php`
4. `app/Models/Location.php`
5. `app/Models/GeoNamesCap.php`
6. `app/Models/Traits/GeographicalScopes.php`
7. `app/Models/PlaceType.php`
8. `app/Models/State.php`

### Data Objects (2 files)
9. `app/Datas/RouteData.php`
10. `app/Datas/CoordinatesData.php`

### Services (2 files)
11. `app/Services/GoogleMapsService.php`
12. `app/Services/BaseGeoService.php`

### Filament Components (6 files)
13. `app/Filament/Widgets/LocationMapTableWidget.php`
14. `app/Filament/Widgets/OSMMapWidget.php`
15. `app/Filament/Widgets/LocationMapWidget.php`
16. `app/Filament/Resources/Pages/ListLocations.php`
17. `app/Filament/Resources/Pages/ViewLocation.php`
18. `app/Filament/Resources/LocationResource.php`

### Actions (10 files)
19. `app/Actions/Bing/GetAddressFromBingMapsAction.php`
20. `app/Actions/Mapbox/GetAddressFromMapboxAction.php`
21. `app/Actions/Mapbox/GetAddressFromMapboxLatLngAction.php`
22. `app/Actions/GoogleMaps/CalculateDistanceMatrixAction.php`
23. `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php`
24. `app/Actions/OptimizeRouteAction.php`
25. `app/Actions/GetAddressDataFromFullAddressAction.php`
26. `app/Actions/FilterCoordinatesInRadiusAction.php`
27. `app/Actions/Elevation/GetElevationAction.php`
28. `app/Actions/ClusterLocationsAction.php`

## Resolution Status

- [ ] **Priority 1: Models** (8 files) - Core business logic
- [ ] **Priority 2: Services** (2 files) - Service layer
- [ ] **Priority 3: Actions** (10 files) - Business actions
- [ ] **Priority 4: Data Objects** (2 files) - DTOs
- [ ] **Priority 5: Filament Components** (6 files) - UI layer

## Resolution Log

*Files will be logged here as they are resolved*

## Documentation Updates Required

- [ ] Update Geo module documentation
- [ ] Create/update backlinks to root docs
- [ ] Verify PHPStan level 10 compliance
- [ ] Update any affected integration documentation

---
*Created: 2025-07-31T09:09:37+02:00*
