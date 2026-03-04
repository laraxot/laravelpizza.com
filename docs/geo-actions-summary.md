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
// Get coordinates for an address
$coordinates = app(GetCoordinatesAction::class)->execute('Via Roma 1, Milano');

// Calculate distance between two points
$distance = app(CalculateDistanceAction::class)->execute(
    $lat1, $lng1, $lat2, $lng2
);

// Get elevation for coordinates
$elevation = app(GetElevationAction::class)->execute($latitude, $longitude);

// Cluster locations
$clusters = app(ClusterLocationsAction::class)->execute($locations, $radius);
```

## Configuration

All actions require proper API keys configured in `config/services.php`:

```php
'google' => [
    'maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY'),
    ],
],
'bing' => [
    'maps_api_key' => env('BING_MAPS_API_KEY'),
],
```

## Error Handling

Actions implement consistent error handling:
- Return `null` for API failures
- Throw specific exceptions for invalid input
- Log errors for debugging purposes

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
- `docs/services/` for service layer documentation
- Language files in `lang/it/actions.php` for UI translations
