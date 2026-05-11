# CoordinatePicker: Architectural Core

The `CoordinatePicker` is a senior-grade Filament component designed for geographic data entry. It follows the principles of DRY (Don't Repeat Yourself), KISS (Keep It Simple, Stupid), and Clean Code.

## State Management

The component uses Alpine.js entanglement to synchronize its state with Livewire.

### Entanglement Syntax

```javascript
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}
```

**Why this specific syntax?**

1.  **Filament v5 Standard**: Using `$applyStateBindingModifiers()` ensures that the component respects the modifiers set in the PHP schema, such as `->live()` or `->defer()`.
2.  **Livewire Modifiers**:
    - If the field is `live()`, updates are sent to the server immediately (real-time).
    - If the field is `defer()` (default), updates are bundled with the next request, saving network bandwidth.
3.  **Correct Nesting**: Using `{$getStatePath()}` ensures the field works correctly when nested inside Repeaters or Groups.

## Multi-Column Mapping

The picker is typically named `location` (a virtual attribute) but persists data to `latitude` and `longitude` columns.

### Senior Pattern (Trait-based)

Instead of manually mutating data in every Resource, the mapping is handled automatically by the `HasCoordinatePicker` trait:

1.  **Hydration**: Automatically pulls from DB columns into the component array.
2.  **Saving**: Uses `saveRelationshipsUsing()` hook to update the model's coordinate columns after the main save operation.
3.  **Clean DB**: Uses `dehydrated(false)` on the main field to avoid errors with the virtual `location` column.

## Usage

```php
CoordinatePicker::make('location')
    ->latitudeColumn('lat')  // defaults to 'latitude'
    ->longitudeColumn('lng') // defaults to 'longitude'
    ->zoom(15)
    ->geolocateWhenEmpty()
    ->reverseGeocoding()
```
