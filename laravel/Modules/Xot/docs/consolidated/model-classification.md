# Xot Module - Model Classification

## Business-Relevant Models (Require Factories/Seeders)

### ✅ Core Framework Entities
- **Module** - System modules
- **Extra** - Additional data storage
- **Feed** - Data feeds
- **Log** - System logs
- **Cache** - Cache storage

## Infrastructure & Base Classes (No Factories/Seeders Needed)

### 🏗️ Base Classes
- **BaseTreeModel** - Base tree structure model
- **BaseExtra** - Base extra data class
- **XotBaseUuidModel** - Base UUID model
- **XotBasePolicy** - Base policy class
- **BaseComment** - Base comment model
- **BaseMorphPivot** - Base polymorphic pivot
- **XotBaseModel** - Base model class
- **BaseRating** - Base rating model
- **BaseRatingMorph** - Base polymorphic rating

### 🔧 Traits
- **HasExtraTrait** - Extra data functionality trait
- **RelationX** - Advanced relationship trait

### 📊 Infrastructure Models
- **CacheLock** - Cache locking mechanism
- **InformationSchemaTable** - Database schema information
- **HealthCheckResultHistoryItem** - Health check history
- **Session** - User sessions
- **PulseAggregate** - System performance aggregates
- **PulseEntry** - Performance metrics
- **PulseValue** - Performance values

## Recommendations
- Focus factories/seeders on core framework entities if they represent business data
- Most Xot models are infrastructure/base classes that shouldn't have factories
- Base classes and traits are for inheritance only
- Infrastructure models typically don't need factories as they're system-managed
- Evaluate if all these models are actually used in business logic
- Consider that many Xot models may be framework infrastructure rather than business entities