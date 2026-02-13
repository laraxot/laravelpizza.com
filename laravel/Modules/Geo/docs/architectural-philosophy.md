# 🏛️ Architectural Philosophy - Geo Module

## 🎯 Core Principles

### **Separation of Concerns (SoC)**
The Geo module follows a strict separation between:
- **UI Layer (Filament Actions)**: Presentation logic, user interaction, notifications
- **Business Logic Layer (Spatie Queueable Actions)**: Core business rules, data processing
- **Data Layer (Models & Services)**: Data persistence, API integration

### **Reusability & DRY (Don't Repeat Yourself)**
- **Cross-module actions** must be defined in the module that owns the domain logic
- **UI actions** should be reusable across different resources
- **Business logic** should be encapsulated in queueable actions

## 🔄 Action Architecture Pattern

### **Three-Tier Action System**

```
┌─────────────────────────────────────────────────────────┐
│                    UI Layer (Filament)                   │
├─────────────────────────────────────────────────────────┤
│  UpdateCoordinatesBulkAction (Filament Bulk Action)     │
│  • User interaction                                     │
│  • Notifications                                        │
│  • Record selection handling                            │
└─────────────────────────────┬───────────────────────────┘
                              │
                              │ Calls
                              ▼
┌─────────────────────────────────────────────────────────┐
│           Business Logic Layer (Queueable Actions)       │
├─────────────────────────────────────────────────────────┤
│  UpdateCoordinatesFromAddressAction (Spatie Queueable)  │
│  • Core business logic                                  │
│  • Geocoding processing                                 │
│  • Error handling                                       │
│  • Queue support                                        │
└─────────────────────────────┬───────────────────────────┘
                              │
                              │ Uses
                              ▼
┌─────────────────────────────────────────────────────────┐
│               Data Layer (Services & Models)             │
├─────────────────────────────────────────────────────────┤
│  GetAddressDataFromFullAddressAction                    │
│  • API integration                                      │
│  • Data transformation                                  │
│  • External service calls                               │
└─────────────────────────────────────────────────────────┘
```

## 🚫 Anti-Pattern: Direct Implementation in Resources

### **❌ WRONG - Violates Clean Code**
```php
// In TechPlanner/ListClients.php
public function getTableBulkActions(): array
{
    return [
        'updateCoordinates' => BulkAction::make('updateCoordinates')
            ->action(function (Collection $records) {
                // Direct geocoding logic here ❌
                $action = app(GetAddressDataFromFullAddressAction::class);
                // Complex business logic mixed with UI code
            })
    ];
}
```

### **✅ CORRECT - Follows Architectural Principles**
```php
// In TechPlanner/ListClients.php
public function getTableBulkActions(): array
{
    return [
        \Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction::make(),
        // Reusable, clean, follows SoC ✅
    ];
}
```

## 🧠 Philosophical Foundation

### **1. Domain Ownership Principle**
- **Geo module** owns all geocoding and coordinate management logic
- **Other modules** consume Geo functionality through well-defined interfaces
- **No cross-module business logic duplication**

### **2. Interface Contract Principle**
- **Filament Actions** define the UI contract
- **Queueable Actions** define the business logic contract
- **Services** define the data access contract
- Each layer has clear responsibilities and boundaries

### **3. Testability Principle**
- **UI Actions** can be tested for user interaction
- **Queueable Actions** can be tested for business logic
- **Services** can be tested for data integrity
- Clear separation enables isolated testing

## 🔧 Implementation Strategy

### **Step 1: Identify Domain Ownership**
1. **Question**: "Which module owns this business logic?"
2. **Answer**: Geo module owns coordinate management
3. **Action**: Move logic to Geo module

### **Step 2: Design Action Hierarchy**
1. **UI Action**: `UpdateCoordinatesBulkAction` (Filament)
2. **Business Action**: `UpdateCoordinatesFromAddressAction` (Queueable)
3. **Service Action**: `GetAddressDataFromFullAddressAction` (Service)

### **Step 3: Implement Clean Interfaces**
```php
// UI Action interface
interface GeoBulkActionInterface {
    public function processRecords(Collection $records): void;
    public function sendNotifications(...): void;
}

// Business Action interface
interface CoordinateUpdateInterface {
    public function execute(Model $model): bool;
    public function onQueue(string $queue): self;
}
```

## 📚 Documentation Requirements

### **For Each Action Type**
1. **Purpose**: What problem does it solve?
2. **Usage**: How to use it in other modules?
3. **Dependencies**: What does it depend on?
4. **Testing**: How to test it?
5. **Error Handling**: How are errors managed?

### **Cross-Module Integration Guide**
```markdown
## Using Geo Actions in Other Modules

### Bulk Coordinate Updates
```php
use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;

public function getTableBulkActions(): array
{
    return [
        UpdateCoordinatesBulkAction::make(),
        // Other actions...
    ];
}
```

### Single Record Updates
```php
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;

$action = app(UpdateCoordinatesFromAddressAction::class);
$success = $action->execute($client);
```

## 🎨 Design Patterns Applied

### **Strategy Pattern**
- Different geocoding providers (Google Maps, Mapbox, Here)
- Interchangeable through dependency injection

### **Command Pattern**
- Queueable actions as commands
- Can be executed synchronously or asynchronously

### **Adapter Pattern**
- Adapt external API responses to internal data structures
- Standardize data formats across providers

### **Observer Pattern**
- Notifications for action completion
- Event-driven architecture for extensibility

## 🔍 Quality Assurance

### **PHPStan Compliance**
- All actions must pass PHPStan level 10
- Type safety across all interfaces
- No mixed types or ambiguous returns

### **Testing Coverage**
- Unit tests for business logic
- Integration tests for API calls
- Feature tests for UI interactions

### **Documentation Completeness**
- Every action must be documented
- Usage examples for consumers
- Error scenarios and handling

## 🚀 Evolution & Maintenance

### **Backward Compatibility**
- Public interfaces must remain stable
- New functionality through new actions
- Deprecation with clear migration paths

### **Performance Considerations**
- Queueable actions for heavy processing
- Caching for repeated API calls
- Batch processing for bulk operations

### **Security Considerations**
- API key management
- Rate limiting
- Input validation and sanitization

---


**Architectural Version**: 2.0
**Compliance**: PHPStan Level 10 ✅
**Patterns**: Strategy, Command, Adapter, Observer ✅
**Principles**: SoC, DRY, Interface Segregation ✅
