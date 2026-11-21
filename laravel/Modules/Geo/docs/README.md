---
qmd: "README"
issues: []
discussions: []
title: "Geo Module Documentation"
type: documentation
tags: [module, documentation, geospatial, mapping]
created: 2026-07-14
updated: 2026-07-14
---

# Modulo Geo

## Overview

Il modulo **Geo** gestisce tutte le funzionalità geospaziali della piattaforma Laraxot. Fornisce geocoding, calcolo distanze, map components, integrazione con provider di mappe (Google Maps, OpenStreetMap, etc) e gestione coordinate geografiche.

## Scopo

- Geocoding e reverse geocoding
- Calcolo distanze e route optimization
- Integrazione provider mappe multipli
- Filament form components per input geografici
- Map visualization e Web Components
- Location-based queries e radius filtering

## Funzionalità Principali

- **Geocoding**: Conversione indirizzi ↔ coordinate via Google Maps, OpenStreetMap, Nominatim
- **Distance Calculation**: Calcolo distanze usando formula haversine
- **Map Components**: Filament AddressInput, LatitudeLongitudeInput, LeafletMarkerMapInput
- **Web Components**: Map components via Lit + Leaflet
- **Location Filtering**: Filtra coordinate entro raggio specificato
- **Route Optimization**: Clustering e ottimizzazione percorsi
- **Elevation Data**: Recupero dati elevazione geografica
- **Multiple Providers**: Bing, Google, Here, Mapbox, LocationIQ, OpenCage, OpenStreetMap, Photon

## Struttura del Modulo

```
Modules/Geo/
├── app/
│   ├── Actions/
│   │   ├── GetCoordinatesAction.php
│   │   ├── CalculateDistanceAction.php
│   │   ├── FilterCoordinatesInRadiusAction.php
│   │   ├── OptimizeRouteAction.php
│   │   └── ClusterLocationsAction.php
│   ├── Services/
│   │   ├── GeocodingService.php
│   │   └── MapProviderService.php
│   ├── DataTransferObjects/
│   │   └── LocationDTO.php
│   ├── Exceptions/
│   │   └── InvalidLocationException.php
│   └── Filament/
│       ├── Fields/
│       │   ├── AddressInput.php
│       │   ├── LatitudeLongitudeInput.php
│       │   └── LeafletMarkerMapInput.php
│       └── Resources/
├── resources/
│   ├── views/
│   │   └── components/
│   └── js/
│       └── map-components/
├── tests/
├── docs/
│   └── README.md
├── module.json
└── composer.json
```

## Componenti Principali

| Classe | Scopo | Tipo |
|--------|-------|------|
| `GetCoordinatesAction` | Geocoding indirizzo → lat/lng | Action |
| `CalculateDistanceAction` | Distanza tra due punti | Action |
| `FilterCoordinatesInRadiusAction` | Query radius filtering | Action |
| `OptimizeRouteAction` | Route optimization | Action |
| `ClusterLocationsAction` | Clustering geografico | Action |
| `AddressInput` | Filament form field | Form Field |
| `LocationDTO` | Transfer object coordinate | DTO |

## Utilizzo Comune

### Scenario 1: Geocodare un Indirizzo

```php
use Modules\Geo\Actions\GetCoordinatesAction;

$location = GetCoordinatesAction::execute([
    'address' => 'Via Roma 1, Roma, Italia',
    'provider' => 'google', // google, nominatim, bing, etc
]);

// Result: LocationDTO con lat, lng, address, etc
echo $location->latitude;
echo $location->longitude;
```

### Scenario 2: Calcolare Distanza

```php
use Modules\Geo\Actions\CalculateDistanceAction;

$distance = CalculateDistanceAction::execute([
    'lat1' => 41.9028,
    'lng1' => 12.4964,
    'lat2' => 45.4642,
    'lng2' => 9.1900,
    'unit' => 'km', // km, mi, nm
]);

echo $distance; // 470.2 km
```

### Scenario 3: Filtrare Coordinate entro Raggio

```php
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;

$nearby = FilterCoordinatesInRadiusAction::execute([
    'center_lat' => 41.9028,
    'center_lng' => 12.4964,
    'radius' => 10, // km
    'points' => $locations, // array di LocationDTO
]);

// Result: solo locations entro 10km
```

### Scenario 4: Form Input Geografico

```php
use Modules\Geo\Filament\Fields\AddressInput;

$schema = [
    AddressInput::make('address')
        ->label('Indirizzo')
        ->required()
        ->provider('google') // Google Maps Geocoding
        ->storeCoordinates(true),
];
```

## Configuration

### Map Provider Configuration

Configurare provider in `laravel/config/local/geo/config.php`:

```php
return [
    'default_provider' => 'google',
    
    'providers' => [
        'google' => [
            'key' => env('GOOGLE_MAPS_KEY'),
            'secret' => env('GOOGLE_MAPS_SECRET'),
        ],
        'nominatim' => [
            'url' => 'https://nominatim.openstreetmap.org',
        ],
        'bing' => [
            'key' => env('BING_MAPS_KEY'),
        ],
    ],
    
    'distance_unit' => 'km', // km, mi, nm
    'default_radius' => 10, // km
];
```

## Filament Form Fields

### AddressInput

Campo input con auto-completo indirizzo e geolocalizzazione browser:

```php
AddressInput::make('address')
    ->label('Location')
    ->provider('google')
    ->storeCoordinates(true) // auto-popola lat/lng
    ->showMap(true)
```

### LatitudeLongitudeInput

Input lat/lng con validazione formato:

```php
LatitudeLongitudeInput::make('latitude', 'longitude')
    ->label('Coordinates')
    ->required()
```

### LeafletMarkerMapInput

Map picker con marker interattivo:

```php
LeafletMarkerMapInput::make('map')
    ->label('Seleziona posizione')
    ->storeAs('latitude', 'longitude')
```

## Testing

```bash
# Run Geo module tests
./vendor/bin/pest Modules/Geo/tests

# Run specific test
./vendor/bin/pest Modules/Geo/tests/Feature/GeocodingTest.php

# With coverage
./vendor/bin/pest Modules/Geo/tests --coverage
```

## Quality Standards

- **PHPStan**: Level 10 (zero baseline)
- **Test Coverage**: Minimum 80%
- **Code Style**: PSR-12 via Pint

Run locally:
```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse --level=max Modules/Geo
./vendor/bin/pest Modules/Geo/tests --coverage
./vendor/bin/pint Modules/Geo
```

## Design Principles

### Domain Ownership

Geo module possiede TUTTE le concern geospaziali:
- Geocoding, coordinate, mappe, timezone
- Form components per input geografici
- Map visualization components
- Non duplicare logica geo in altri moduli

### Component Reuse

- One `AddressInput`, many consumers
- Extend existing Geo components rather than duplicating
- Avoid reimplementing geolocation UX in other modules

### Provider Abstraction

- Interface unica per provider geocoding multipli
- Switch provider via configurazione, non codice
- Graceful fallback se provider non disponibile

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md) — Always dependency
- [User - Authentication](../../User/docs/README.md) — For user locations
- [Tenant - Multi-tenancy](../../Tenant/docs/README.md) — For tenant-scoped geo data
- [Cms - Content](../../Cms/docs/README.md) — For location-based content

## Documenti Correlati

- [Geo Models Domain Analysis](./geo-models-domain-analysis.md)
- [Map Component Architecture](./map-component-architecture.md)
- [Geocoding Provider Integration](./geocoding-providers.md)
- [Leaflet/Lit Map Reconstruction](./wiki/concepts/geo-map-lit-reconstruction-guide.md)
- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes** — Never extend Laravel/Filament directly
2. **Use namespace `Modules\Geo`** — Never `app\Geo`
3. **Strict typing** — `declare(strict_types=1);` in all files
4. **One geocoding service** — All geocoding via service, not direct API calls
5. **Type-safe LocationDTO** — Use DTO for coordinate transfer
6. **No Log statements** — Let Laravel handle exceptions
7. **Provider agnostic** — Code should work with any provider

## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

---

**Status**: ✅ Production  
**Last Updated**: 2026-07-14  
**Requirements**: PHP 8.3+, Laravel 12  
**PHPStan Level**: 10 (Compliant)
