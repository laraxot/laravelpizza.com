---
title: "geo actions sumy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "geo actions sumy"
issues: []
discussions: []
status: draft
---

# Geo Actions Summary

## Overview

The Geo module provides a comprehensive set of Actions for geocoding, distance calculation, elevation data, and location clustering. All actions have been cleaned and verified to be PHPStan compliant.

## Available Actions

### Core Geocoding Actions

1. **GetCoordinatesAction** - Converts addresses to coordinates using Google Maps API
2. **BingMaps/GetAddressFromBingMapsAction** - Reverse geocoding using Bing Maps API

### Distance and Calculation Actions

3. **CalculateDistanceAction** - Calculates distance between coordinates using Google Maps API
4. **FilterCoordinatesAction** - Filters coordinates based on geographic criteria

### Elevation Actions

5. **Elevation/FetchOpenElevationAction** - Gets elevation data from OpenElevation API
6. **Elevation/GetElevationAction** - Gets elevation data using Google Maps Elevation API

### Location Processing Actions

7. **ClusterLocationsAction** - Groups nearby locations into clusters
8. **UpdateCoordinatesAction** - Updates coordinates for a single place
9. **UpdateCoordinatesBulkAction** - Bulk updates coordinates for multiple places

## Filament Integration

### Bulk Actions
- **UpdateCoordinatesBulkAction** - Filament bulk action for updating coordinates in admin interface

## PHPStan Compliance

All actions in the Geo module are now PHPStan compliant:
- ✅ Proper type hints and return types
- ✅ Correct exception handling
- ✅ No duplicate imports or throws
- ✅ Proper documentation with PHPDoc

## Usage Examples

```php
// Get coordinates for an address (?LocationData)
$location = app(GetCoordinatesAction::class)->execute('Via Roma 1, Milano');

// Calculate distance between two points (LocationData, LocationData): array
$distance = app(CalculateDistanceAction::class)->execute($origin, $destination);

// Get elevation for a point (LocationData): float
$elevation = app(GetElevationAction::class)->execute($location);

// Cluster locations
$clusters = app(ClusterLocationsAction::class)->execute($locations, $radius);
```

## Configuration

All actions require proper API keys configured in `config/services.php`:

```php
'google' => [
    'maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY'),   // letta da GetCoordinatesAction
    ],
    'maps_api_key' => env('GOOGLE_MAPS_API_KEY'), // letta da GetAddressFromGoogleMapsAction, GetCoordinatesByAddressAction
],
'bing' => [
    'maps_api_key' => env('BING_MAPS_API_KEY'),
],
```

## Error Handling

Actions implement consistent error handling:
- `GetCoordinatesAction`: `RuntimeException` se manca la chiave API o l'HTTP fallisce; `null` se Google risponde con status diverso da `OK`
- Le altre Actions variano: leggere il metodo `execute()` prima di assumere il contratto

## Performance Considerations

- Actions implement caching where appropriate
- Bulk operations use efficient batch processing
- API calls include proper timeout handling
- Rate limiting considerations for external APIs

## Testing

All actions include comprehensive unit tests covering:
- Successful API responses
- Error conditions
- Edge cases (empty addresses, invalid coordinates)
- Network failures

## Documentation

For detailed implementation guides and advanced usage, see:
- `docs/actions/` directory for action-specific documentation
- `docs/services/geocoding.md` (storico: i Services sono ritirati, vale il layer Actions)
- Language files in `lang/it/actions.php` for UI translations
