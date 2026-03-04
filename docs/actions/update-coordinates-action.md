# `UpdateCoordinatesAction` (Spatie Queueable Action)

This document describes the `UpdateCoordinatesAction`, a Spatie Queueable Action responsible for handling the core business logic of geocoding and updating the geographic coordinates (latitude/longitude) of a collection of Eloquent models. It is designed to be highly reusable, type-safe, and capable of processing large batches efficiently.

## Location

`laravel/Modules/Geo/app/Actions/UpdateCoordinatesAction.php`

## Purpose

To encapsulate the geocoding process and coordinate update logic for various Eloquent models. This action supports bulk processing, error tracking, and adheres to Laraxot principles by separating business logic from UI concerns.

## Key Features

*   **Spatie Queueable Action:** Can be dispatched as a job to the queue, allowing for asynchronous processing of large datasets.
*   **Bulk Processing:** Designed to process a `Collection` of models efficiently.
*   **Delegated Geocoding:** Utilizes `Modules\Geo\Actions\GetAddressDataFromFullAddressAction` for the actual geocoding, ensuring modularity.
*   **Error Tracking:** Collects detailed error messages for each model that fails to update, returning them as part of the `UpdateCoordinatesResult`.
*   **Configurable Address Attribute:** Allows specifying which model attribute contains the full address for geocoding (defaults to `'full_address'`).
*   **Type-Safe:** Fully type-hinted and PHPStan-compliant (Level 10) for robust code.

## Usage Example

The action is typically invoked by a Filament action (like `UpdateCoordinatesBulkAction`) or directly within services/commands:

```php
use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Actions\UpdateCoordinatesAction;
use Modules\TechPlanner\Models\Client;

// Example: Processing a collection of Clients
$clientsToUpdate = Client::whereNull('latitude')->orWhereNull('longitude')->get();

/** @var UpdateCoordinatesAction $action */
$action = app(UpdateCoordinatesAction::class);
$result = $action->execute($clientsToUpdate);

if ($result->isCompleteSuccess()) {
    // All models updated successfully
} else {
    // Handle partial success or failures
    foreach ($result->errors as $error) {
        // Log or notify about $error['model'] and $error['error']
    }
}
```

## Technical Details

*   **Extends:** Uses `Spatie\QueueableAction\QueueableAction` trait.
*   **`execute(Collection $models, string $addressAttribute = 'full_address'): UpdateCoordinatesResult`:**
    *   Main entry point for the action.
    *   Iterates through the provided `$models` collection.
    *   For each model:
        *   Retrieves the `full_address` from the specified `$addressAttribute`.
        *   Invokes `GetAddressDataFromFullAddressAction` to perform geocoding.
        *   Updates the model's `latitude` and `longitude` attributes based on the geocoding result.
        *   Collects success/failure counts and detailed error messages.
    *   Returns an `UpdateCoordinatesResult` object containing processing statistics and errors.
*   **`getModelName(Model $model): string`:** A private helper method to generate a human-readable name for models, used primarily in error messages. It attempts to use common name attributes ('name', 'company_name', 'title', 'id') before falling back to class name and ID.

## `UpdateCoordinatesResult` Data Structure

The `UpdateCoordinatesResult` object contains:
*   `totalProcessed`: Total number of models attempted.
*   `successCount`: Number of models successfully updated.
*   `failureCount`: Number of models that failed to update.
*   `errors`: A `Collection` of arrays, each containing `model` (identifier) and `error` (message).

## Adherence to Laraxot Principles

*   **DRY (Don't Repeat Yourself):** Centralizes geocoding and coordinate update logic, preventing duplication across different Filament resources or other parts of the application.
*   **KISS (Keep It Simple, Stupid):** The action provides a clear, focused responsibility.
*   **SOLID (Single Responsibility Principle):** The action is solely responsible for updating coordinates based on addresses.
*   **Modularization:** Resides within the `Geo` module, encapsulating geography-related business logic.
*   **Separation of Concerns:** Clearly separates the geocoding business logic from UI actions (e.g., `UpdateCoordinatesBulkAction`).

## Related Documentation

*   [`UpdateCoordinatesBulkAction` Documentation](`./filament/actions/update-coordinates-bulk-action.md`)
*   [`GetAddressDataFromFullAddressAction` Documentation](`./get-address-data-from-full-address-action.md`)
*   [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
