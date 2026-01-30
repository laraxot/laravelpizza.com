# Geo Module - Nested Resource Implementation Guide

## Overview

The Geo module provides geographic data management with support for regions, provinces, cities, and addresses using the Sushi package for SQLite-based data. Nested resources in this module focus on organizing geographic hierarchies and address-related data in a logical structure that reflects real-world geographic relationships.

## Current Relationship Structure

### Region Model Relationships
- `Region` hasMany `Province`
- `Region` hasMany `Comune` (via provinces)

### Province Model Relationships
- `Province` belongsTo `Region`
- `Province` hasMany `Comune` (City)
- `Province` hasMany `Address` (via addresses table)

### Comune/City Model Relationships
- `Comune` belongsTo `Province`
- `Comune` belongsTo `Region` (via province)
- `Comune` hasMany `Address` (via addresses table)

### Address Model Relationships
- `Address` belongsTo `City` (locality)
- `Address` belongsTo `Province` (administrative_area_level_2)
- `Address` belongsTo `Region` (administrative_area_level_1)
- `Address` belongsTo `Place` (via place relationship)

### Place Model Relationships
- `Place` belongsTo `PlaceType`
- `Place` belongsTo `Address`
- `Place` hasMany `Address` (via address relationship)

## Potential Nested Resource Applications

### 1. Region-Province Hierarchy
**Parent Resource:** RegionResource
**Child Resource:** ProvinceResource
**Relationship:** Region hasMany Provinces
**Justification:** Organize provinces within their respective regions to reflect administrative hierarchy.

### 2. Province-Comune Hierarchy
**Parent Resource:** ProvinceResource
**Child Resource:** ComuneResource (CityResource)
**Relationship:** Province hasMany Comuni
**Justification:** Organize cities within their respective provinces for geographic data management.

### 3. Comune-Address Hierarchy
**Parent Resource:** ComuneResource (CityResource)
**Child Resource:** AddressResource
**Relationship:** Comune hasMany Addresses
**Justification:** Group addresses by city for geographic organization and data management.

### 4. Place Type Organization
**Parent Resource:** PlaceTypeResource
**Child Resource:** PlaceResource
**Relationship:** PlaceType hasMany Places
**Justification:** Organize places by their type (e.g., hotel, restaurant, hospital) for categorization.

### 5. Address-Place Relationship
**Parent Resource:** AddressResource
**Child Resource:** PlaceResource
**Relationship:** Address hasMany Places (or belongsTo in some contexts)
**Justification:** Manage places associated with specific addresses for location-based services.

### 6. Province Address Management
**Parent Resource:** ProvinceResource
**Child Resource:** AddressResource
**Relationship:** Province hasMany Addresses (via administrative_area_level_2)
**Justification:** Organize addresses by province for regional management.

### 7. Region Address Hierarchy
**Parent Resource:** RegionResource
**Child Resource:** AddressResource
**Relationship:** Region hasMany Addresses (via administrative_area_level_1)
**Justification:** Group addresses by region for large-scale geographic organization.

### 8. Place-Address Context
**Parent Resource:** PlaceResource
**Child Resource:** AddressResource
**Relationship:** Place belongsTo Address (or hasOne in some contexts)
**Justification:** Manage address information for specific places.

## Implementation Approach

### Using Filament Nested Resources Package
Following the documented approach in `Modules/UI/docs/filament/nested-resource.md`:

1. **Child Resource Implementation:**
   ```php
   use SevendaysDigital\FilamentNestedResources\NestedResource;
   use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

   class ProvinceResource extends NestedResource
   {
       public static function getParent(): string
       {
           return RegionResource::class;
       }
   }
   ```

2. **Parent Resource Enhancement:**
   ```php
   use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;
   
   public static function table(Table $table): Table
   {
       return $table->columns([
           TextColumn::make('name'),
           ChildResourceLink::make(ProvinceResource::class),
       ]);
   }
   ```

3. **Page Configuration:**
   Apply the `NestedPage` trait to all nested resource pages (List, Edit, Create).

4. **For Sushi-based models:**
   ```php
   // In the child model, add scope for parent filtering
   public function scopeOfRegion($query, $regionId)
   {
       // For Sushi models, filtering might be different
       return $query->where('region_id', $regionId);
   }
   ```

## Benefits of Nested Resource Implementation

### 1. Improved Geographic Organization
- Hierarchical representation of geographic relationships
- Context-aware geographic data management
- Better representation of real-world administrative structures

### 2. Enhanced Data Management
- Geographic hierarchy reflects real-world relationships
- Better data integrity through parent-child relationships
- Improved search and filtering capabilities

### 3. Better User Experience
- Intuitive geographic browsing and navigation
- Context-aware geographic operations
- Natural geographic hierarchy representation

### 4. Scalability
- Modular approach to geographic data management
- Easy to extend with additional geographic levels
- Consistent user experience across geographic operations

## Considerations

### 1. Performance
- Sushi SQLite database has different performance characteristics
- Ensure efficient queries for geographic hierarchies
- Optimize for read-heavy geographic data access patterns

### 2. Data Integrity
- Geographic hierarchies must maintain consistency
- Sushi models have read-only nature considerations
- Handle updates to geographic boundaries appropriately

### 3. Integration with Other Modules
- Coordinate with modules that use geographic data (e.g., address fields)
- Handle relationships between geographic models and business models
- Consider performance implications of geographic lookups

### 4. User Experience
- Geographic hierarchies should be intuitive to navigate
- Consider performance implications for large geographic datasets
- Provide efficient search and filtering for geographic data

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic Region-Province relationship

### Phase 2: Core Functionality
- Implement Province-Comune relationships
- Add Comune-Address organization
- Create place type categorization

### Phase 3: Advanced Features
- Implement cross-module geographic integration
- Add advanced geographic search capabilities
- Create geographic analytics and reporting

## Future Enhancements

### 1. Advanced Geographic Features
- Geographic boundary management
- Spatial search and analysis capabilities
- Geographic hierarchy visualization tools

### 2. Integration with Business Modules
- Address validation and enrichment
- Geographic-based business intelligence
- Location-aware business processes

### 3. Performance Optimization
- Geographic data caching strategies
- Spatial indexing for geographic queries
- Efficient handling of large geographic datasets