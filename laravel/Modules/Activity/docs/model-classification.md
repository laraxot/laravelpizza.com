# Activity Module - Model Classification

## Business-Relevant Models (Require Factories/Seeders)

### ✅ Core Business Entities
- **Activity** - User activity tracking
- **Snapshot** - System state snapshots  
- **StoredEvent** - Event sourcing storage

## Base Classes (No Factories/Seeders Needed)

### ⚠️ Abstract Base Classes
- **BaseActivity** - Abstract base for activity models
- **BaseSnapshot** - Abstract base for snapshot models
- **BaseStoredEvent** - Abstract base for stored events

## Recommendations
- Only create factories/seeders for concrete business entities (Activity, Snapshot, StoredEvent)
- Base classes should not have factories as they're not instantiable
- Focus testing on the core business models