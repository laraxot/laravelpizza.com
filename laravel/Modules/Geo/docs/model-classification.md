# Geo Module - Model Classification

## Business-Relevant Models (Require Factories/Seeders)

### ✅ Core Geographical Entities
- **Address** - Physical addresses
- **Location** - Geographical locations
- **Comune** - Italian municipalities
- **Province** - Italian provinces
- **Region** - Italian regions
- **Place** - Points of interest
- **PlaceType** - Place categories
- **Locality** - Local areas
- **State** - States/territories
- **County** - Counties/districts

## Infrastructure & Base Classes (No Factories/Seeders Needed)

### 🔧 Traits & Scopes
- **GeoTrait** - Geographical functionality trait
- **HasAddress** - Address relationship trait  
- **HasPlaceTrait** - Place functionality trait
- **GeographicalScopes** - Geographical query scopes

### 📊 Static Data Models
- **GeoJsonModel** - JSON-based geographical data
- **ComuneJson** - JSON-based municipality data

### 🏗️ Base Classes
- **BasePivot** - Base pivot model class
- **BaseMorphPivot** - Base polymorphic pivot class
- **SushiToJsons** - Sushi-to-JSON interface

## Recommendations
- Focus factories/seeders on core geographical entities
- Traits and base classes should not have factories
- Static data models (JSON/Sushi) don't need factories as they use static data
- Test geographical business logic, not infrastructure classes