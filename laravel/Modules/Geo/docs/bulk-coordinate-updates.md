# Bulk Coordinate Updates

**Last Update**: 18 Dicembre 2025
**Status**: ✅ Implementation Complete
**Module**: Geo

## Overview

This document describes the proper architecture for bulk coordinate updates using the Spatie QueueableAction and Filament Action patterns.

## Architecture Pattern

### Components Structure
```
Geo Module
├── app/
│   ├── Actions/
│   │   └── UpdateClientCoordinatesBulkAction.php (QueueableAction)
│   └── Filament/
│       └── Actions/
│           └── UpdateClientCoordinatesBulkAction.php (Filament Action)
```

### Clean Code Principles Applied

1. **Separation of Concerns**:
   - UI logic in Filament Action
   - Business logic in QueueableAction
   - Reusable across different resources

2. **Single Responsibility**:
   - Each action has one specific purpose
   - Easy to test and maintain

3. **Reusability**:
   - Actions can be used across multiple resources
   - Consistent behavior across the application

## Implementation Details

### QueueableAction: UpdateClientCoordinatesBulkAction

Handles the core business logic for updating client coordinates in bulk:
- Accepts a collection of Client models
- Processes each client to get coordinates
- Updates latitude/longitude fields
- Handles errors gracefully
- Provides notifications for success/failure

### FilamentAction: UpdateClientCoordinatesBulkAction

Handles the UI integration:
- Provides the bulk action for Filament tables
- Handles user interaction
- Calls the QueueableAction
- Shows notifications to users

## Usage Pattern

```php
// In any Filament resource that needs coordinate updates
use Modules\Geo\Filament\Actions\UpdateClientCoordinatesBulkAction;

public function getTableBulkActions(): array
{
    return [
        UpdateClientCoordinatesBulkAction::make(),
    ];
}
```

## Benefits

1. **Clean Architecture**: Proper separation between UI and business logic
2. **Reusability**: Same action can be used across different resources
3. **Maintainability**: Changes to business logic only require updating one place
4. **Testability**: Each component can be tested independently
5. **Consistency**: Uniform behavior across the application

## Migration from Inline Actions

**Before (Violates Clean Code):**
- Inline bulk actions in resource files
- Mixed UI and business logic
- Not reusable

**After (Follows Clean Code):**
- Dedicated QueueableAction for business logic
- Dedicated FilamentAction for UI integration
- Reusable across resources
- Proper separation of concerns

---

*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
