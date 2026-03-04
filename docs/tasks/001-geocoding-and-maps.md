# Task 001: Implement Geocoding and Maps Integration

## Description
Create comprehensive geocoding services, map visualization, and location management with support for multiple providers and coordinate systems.

## Context
The Geo module needs robust geocoding capabilities, map integration, and location management for features like user locations, distance calculations, and geographic analysis.

## Requirements

### Functional Requirements
- Geocoding (address → coordinates)
- Reverse geocoding (coordinates → address)
- Multiple provider support (Google Maps, Mapbox, OpenStreetMap, HERE)
- Map visualization widgets
- Location management
- Distance calculations
- Area/region management
- Coordinate system conversions
- Batch geocoding

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- DatabaseTransactions for tests
- Multiple geocoding provider APIs

## Implementation Steps

### 1. Database Schema
- [ ] Create `geo_locations` table
  - id (uuid/ulid)
  - tenant_id
  - address (string)
  - city (string, nullable)
  - state (string, nullable)
  - country (string)
  - postal_code (string, nullable)
  - latitude (decimal, 10, 8)
  - longitude (decimal, 11, 8)
  - formatted_address (string)
  - place_id (string, nullable, from provider)
  - accuracy (float, nullable)
  - provider (enum: 'google', 'mapbox', 'osm', 'here')
  - metadata (json, nullable)
  - timestamps

- [ ] Create `geo_areas` table
  - id, tenant_id, name, type (enum: 'polygon', 'circle', 'rectangle'), coordinates (json), center_lat, center_lng, radius (nullable), metadata

- [ ] Create `geo_geocoding_cache` table
  - id, query (string), result (json), provider, expires_at

### 2. Models
- [ ] Create `GeoLocation` model
- [ ] Create `GeoArea` model
- [ ] Create `GeoGeocodingCache` model

### 3. Geocoding Service
- [ ] Create `GeocodingService`
  - `geocode(string $address, string $provider = 'google'): GeoLocation`
  - `reverseGeocode(float $lat, float $lng, string $provider = 'google'): array`
  - `batchGeocode(array $addresses, string $provider): array`
  - `validateCoordinates(float $lat, float $lng): bool`
  - `formatAddress(array $components): string`

### 4. Provider Adapters
- [ ] Create `GeocodingProviderAdapter` interface
  - `geocode(string $address): array`
  - `reverseGeocode(float $lat, float $lng): array`

- [ ] Implement Google Maps adapter
- [ ] Implement Mapbox adapter
- [ ] Implement OpenStreetMap adapter
- [ ] Implement HERE adapter

### 5. Distance Calculation Service
- [ ] Create `DistanceCalculationService`
  - `haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float` (km)
  - `vincentyDistance(float $lat1, float $lng1, float $lat2, float $lng2): float`
  - `findNearby(float $lat, float $lng, float $radius, string $unit = 'km'): Collection`
  - `isWithinRadius(float $lat1, float $lng1, float $lat2, float $lng2, float $radius): bool`
  - `calculatePolygonArea(array $coordinates): float`

### 6. Coordinate System Service
- [ ] Create `CoordinateSystemService`
  - `ddToDms(float $decimal): array` (decimal to degrees/minutes/seconds)
  - `dmsToDd(array $dms): float` (degrees/minutes/seconds to decimal)
  - `utmToLatLon(string $zone, string $easting, string $northing): array`
  - `latLonToUtm(float $lat, float $lng): array`

### 7. Map Widgets
- [ ] Create `LocationMapWidget` (XotBaseWidget)
  - Display location on map
  - Multiple markers support
  - Custom styling
  - Click to get coordinates

- [ ] Create `AreaMapWidget` (XotBaseWidget)
  - Display polygon areas
  - Draw areas on map
  - Calculate area

- [ ] Create `NearbyLocationsWidget` (XotBaseWidget)
  - Show nearby locations
  - Radius search
  - Distance display

### 8. Filament Resources
- [ ] Create `GeoLocationResource`
  - Location management
  - Geocoding interface
  - Map view

- [ ] Create `GeoAreaResource`
  - Area management
  - Draw areas on map
  - Area calculation

### 9. API Endpoints
- [ ] `POST /api/geo/geocode` - Geocode address
- [ ] `POST /api/geo/reverse-geocode` - Reverse geocode
- [ ] `GET /api/geo/distance` - Calculate distance
- [ ] `GET /api/geo/nearby` - Find nearby locations

### 10. Tests
- [ ] Create `GeocodingServiceTest`
- [ ] Create `DistanceCalculationTest`
- [ ] Create `CoordinateSystemTest`

### 11. Documentation
- [ ] Create geocoding guide
- [ ] Document provider configuration
- [ ] Create map widget guide

## Acceptance Criteria
- [ ] Geocoding works with all providers
- [ ] Reverse geocoding returns correct addresses
- [ ] Distance calculations are accurate
- [ ] Map widgets display correctly
- [ ] Areas can be drawn and calculated
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- Filament 5.x (admin UI)
- Geocoding provider APIs

## Estimated Time
- Database schema: 2 hours
- Models: 2 hours
- Geocoding service: 5 hours
- Provider adapters: 8 hours (4 adapters × 2h)
- Distance calculation: 3 hours
- Coordinate system: 3 hours
- Map widgets: 6 hours
- Filament integration: 4 hours
- API endpoints: 2 hours
- Tests: 6 hours
- Documentation: 2 hours

**Total: 43 hours (~5 days)**

## Priority
**High** - Core geo functionality

## Related Tasks
- Task 002: Advanced Geo Features

## Notes
- Implement caching for geocoding results
- Use rate limiting for provider APIs
- Fallback to secondary provider if primary fails
- Support multiple coordinate systems
- Consider offline geocoding for privacy

---

**Status**: Pending
**Assignee**: TBD