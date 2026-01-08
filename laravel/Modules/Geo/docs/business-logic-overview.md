# Geo Module - Business Logic Overview

## Core Business Logic Components

### 1. Geographic Data Management Architecture
The Geo module implements comprehensive geographic data management including address validation, geocoding, and location-based services for the healthcare platform.

#### Key Models
- **Address**: Complete address management with validation and standardization
- **Comune**: Italian municipality data with postal codes and geographic boundaries
- **Province**: Provincial administrative divisions with regional relationships
- **Region**: Regional geographic divisions with statistical data
- **Location**: Generic location model for coordinates and geographic references

#### Business Rules
- Address validation must follow Italian postal standards
- Geocoding coordinates required for location-based services
- Hierarchical relationships: Region → Province → Comune → Address
- Postal codes must be valid and correspond to correct geographic areas
- Distance calculations use Haversine formula for accuracy

### 2. Address Management Business Logic

#### Core Functionality
```php
// Address creation with validation and geocoding
Address::create([
    'street' => 'Via Roma 123',
    'city' => 'Milano',
    'postal_code' => '20121',
    'province_id' => $province->id,
    'comune_id' => $comune->id,
    'country' => 'IT',
    'latitude' => 45.4642,
    'longitude' => 9.1900
]);
```

#### Business Constraints
- Street addresses must be properly formatted
- Postal codes validated against official Italian postal system
- Coordinates automatically geocoded when address changes
- Province and Comune relationships must be consistent
- International addresses supported with country-specific validation

### 3. Geocoding and Location Services

#### Geographic Calculations
- **Distance Calculation**: Accurate distance between healthcare facilities and patients
- **Proximity Search**: Find nearest medical services within specified radius
- **Route Optimization**: Optimal routing for home healthcare services
- **Coverage Areas**: Define service coverage zones for healthcare providers

#### Business Benefits
- Efficient patient-provider matching based on location
- Accurate travel time estimates for appointments
- Service area optimization for healthcare delivery
- Emergency response coordination with precise locations

### 4. Administrative Divisions

#### Italian Geographic Hierarchy
- **Regions (20)**: Major administrative divisions (Lombardia, Lazio, etc.)
- **Provinces (110)**: Provincial administrative units (Milano, Roma, etc.)
- **Comuni (8000+)**: Municipal administrative units with postal codes
- **CAP Integration**: Complete postal code database with geographic mapping

#### Business Rules
- Each Comune belongs to exactly one Province
- Each Province belongs to exactly one Region
- Postal codes (CAP) are unique within geographic boundaries
- Administrative changes reflected in real-time updates
- Statistical data maintained for healthcare planning

## Testing Strategy

### Business Logic Tests Required

#### Address Model Tests
- Address creation with all required fields
- Address validation for Italian postal standards
- Geocoding accuracy and coordinate validation
- International address support
- Address standardization and formatting

#### Geographic Relationship Tests
- Hierarchical relationships (Region → Province → Comune)
- Postal code validation and mapping
- Administrative boundary consistency
- Geographic data integrity

#### Location Services Tests
- Distance calculation accuracy
- Proximity search functionality
- Geocoding service integration
- Route optimization algorithms

#### Integration Tests
- Healthcare facility location mapping
- Patient address validation
- Service area coverage calculation
- Emergency response coordination

## Configuration Management

### Geographic Data Sources
- Official Italian postal service data (Poste Italiane)
- ISTAT administrative division data
- OpenStreetMap integration for detailed mapping
- Google Maps API for geocoding services

### Service Integration
- Healthcare facility registration with location validation
- Patient registration with address verification
- Appointment scheduling with travel time calculation
- Emergency services with precise location data

## Dependencies

### External Packages
- `geocoder-php/geocoder`: Geocoding service integration
- `league/geotools`: Geographic calculations and utilities
- `spatie/laravel-geocoder`: Laravel geocoding integration

### Internal Dependencies
- User module for patient and provider location data
- Tenant module for multi-location healthcare facilities
- Notify module for location-based notifications

## Business Value

### Healthcare Service Delivery
- Efficient patient-provider matching reduces travel time
- Accurate location data improves emergency response
- Service area optimization maximizes healthcare coverage
- Geographic analytics support healthcare planning

### Operational Benefits
- Automated address validation reduces data entry errors
- Geocoding integration provides precise coordinates
- Distance calculations optimize resource allocation
- Administrative division data supports regulatory compliance

### Patient Experience
- Accurate travel time estimates for appointments
- Location-based service recommendations
- Emergency services with precise location sharing
- Accessibility analysis for healthcare facilities

---

**Last Updated**: 2025-08-28
**Module Version**: Latest
**Business Logic Status**: Core functionality implemented
