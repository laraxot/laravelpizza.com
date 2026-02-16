# PHPStan Corrections - CMS Module

## Fixed Issues

### 1. HTTP Client PromiseInterface|Response Union Type (Multiple Action files)
**Date**: [DATE]
**Files affected**:
- app/Actions/Bing/GetAddressFromBingMapsAction.php
- app/Actions/GetCoordinatesAction.php
- app/Actions/GetCoordinatesByAddressAction.php
- app/Actions/GoogleMaps/CalculateDistanceMatrixAction.php
- app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php
- app/Actions/GoogleMaps/OptimizeRouteAction.php
- app/Actions/Here/GetAddressFromHereMapsAction.php
- app/Actions/LocationIQ/GetAddressFromLocationIQAction.php
- app/Actions/Mapbox/GetAddressFromMapboxLatLngAction.php
- app/Actions/Nominatim/GetAddressFromNominatimAction.php
- app/Actions/OpenCage/GetAddressFromOpenCageAction.php
- app/Actions/Weather/GetOpenWeatherDataAction.php

**Issue**: Laravel's `Http::get()` returns `PromiseInterface|Response` union type, causing PHPStan errors when calling methods like `successful()` and `json()`.

**Solution**: Added type checking and casting after HTTP calls:
```php
// Handle PromiseInterface|Response union type
if ($response instanceof \GuzzleHttp\Promise\PromiseInterface) {
    $response = $response->wait();
}

/** @var \Illuminate\Http\Client\Response $response */
```

### 2. Missing BASE_URL Constant
**File**: app/Actions/GoogleMaps/OptimizeRouteAction.php
**Issue**: Undefined constant `BASE_URL`
**Fix**: Added the missing constant:
```php
private const BASE_URL = 'https://maps.googleapis.com/maps/api/directions/json';
```

## Status
✅ **0 errors** - All PHPStan errors have been resolved

## Technical Notes
- Correct namespace for PromiseInterface is `GuzzleHttp\Promise\PromiseInterface`
- All HTTP client responses now properly handle both synchronous and asynchronous cases
- PHPDoc casting ensures PHPStan recognizes the correct type after Promise resolution

## Test Corrections (Pest)
- Nei test, la connessione `user` usa SQLite in-memory: la tabella `users` deve esistere (altrimenti le factory falliscono con `no such table: users`).
- Evitare assert fragili su stringhe hardcoded di localizzazione (il sito funziona): preferire stringhe realmente presenti nel markup o key/valori di traduzione attuali.
