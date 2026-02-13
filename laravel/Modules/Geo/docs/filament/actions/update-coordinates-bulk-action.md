# `UpdateCoordinatesBulkAction` (Filament Bulk Action)

This document describes the `UpdateCoordinatesBulkAction`, a reusable Filament Bulk Action designed to update the geographic coordinates (latitude/longitude) of multiple Eloquent models simultaneously. It leverages the `UpdateCoordinatesAction` (a Spatie Queueable Action) for its core business logic, adhering to the principle of separating UI concerns from business logic.

## Location

`laravel/Modules/Geo/app/Filament/Actions/UpdateCoordinatesBulkAction.php`

## Purpose

To provide a convenient and reusable interface within Filament admin panels for bulk geocoding and coordinate updates. This action is designed to work with any Eloquent model that has `full_address`, `latitude`, and `longitude` attributes.

## Usage Example

To add this bulk action to a Filament `ListRecords` page (e.g., `ClientResource`):

```php
// In a ListRecords page (e.g., Modules\TechPlanner\Filament\Resources\ClientResource\Pages\ListClients.php)
use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;

public function getTableBulkActions(): array
{
    return [
        UpdateCoordinatesBulkAction::make(),
        // ... other bulk actions
    ];
}
```

## Key Features

*   **Reusable:** Designed to be dropped into any Filament `ListRecords` page.
*   **Delegated Logic:** Delegates the complex geocoding and model update logic to `Modules\Geo\Actions\UpdateCoordinatesAction` (a Spatie Queueable Action).
*   **Notification Feedback:** Provides clear success/warning notifications to the user, detailing processed records and any encountered errors.
*   **Internationalization:** Labels and notification messages are translatable via `__('geo::actions.update_coordinates.bulk.label')` etc.

## Technical Details

*   **Extends:** `Filament\Actions\BulkAction`
*   **`getDefaultName()`:** Returns `'update_coordinates_bulk'`, used for action key and translation.
*   **`setUp()`:** Configures the action with an icon (`heroicon-o-map-pin`), sets it to deselect records after completion, and defines the `action` callback.
*   **`action(Collection $records)`:** The main callback executed when the bulk action is triggered. It calls `processRecords($records)`.
*   **`processRecords(Collection $records)`:**
    *   Instantiates and executes `Modules\Geo\Actions\UpdateCoordinatesAction::class` with the selected `$records`.
    *   Calls `sendNotifications()` to provide user feedback based on the result (`UpdateCoordinatesResult`).
*   **`getRecordName(Model $record)`:** A helper method to generate a human-readable name for records in error messages (prioritizes 'name', 'company_name', 'title', 'id').
*   **`sendNotifications(...)`:** Handles sending Filament notifications for success and errors. It truncates long error lists for readability.

## Integration with `UpdateCoordinatesAction`

The `UpdateCoordinatesBulkAction` serves as the UI layer, initiating the `UpdateCoordinatesAction`. This separation of concerns ensures that the geocoding and update logic is encapsulated and can be used independently of the Filament UI.

## Adherence to Laraxot Principles

*   **DRY (Don't Repeat Yourself):** Reuses the core `UpdateCoordinatesAction` logic.
*   **KISS (Keep It Simple, Stupid):** The bulk action focuses solely on UI orchestration and delegating complex tasks.
*   **Modularization:** Resides within the `Geo` module, encapsulating geography-related functionality.
*   **Separation of Concerns:** Clearly separates UI (Filament Action) from business logic (Queueable Action).

## Related Documentation

*   [`UpdateCoordinatesAction` Documentation](`./update-coordinates-action.md`)
*   [Filament Class Extension Rules](../../../docs/filament/filament-class-extension-rules.md)
