# CoordinatePicker: State Management and Multi-Column Mapping

## State Entanglement in Filament v5

The `CoordinatePicker` component uses a specific syntax for binding its Alpine.js state to Livewire:

```javascript
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}
```

### Why this syntax?

1.  **Canonical Filament v5 Standard**: This is the official recommendation for custom components that need to manage complex state (like a map) while staying in sync with Livewire.
2.  **Modifier Support**: By using `$applyStateBindingModifiers()`, the component automatically respects modifiers like `->live()`, `->lazy()`, or `->defer()` set in the form schema.
    - If the field is `live()`, updates are sent to the server immediately.
    - If not, updates are bundled with the next request, improving performance.
3.  **Encapsulation**: The `$getStatePath()` method call ensures that the field works correctly even when nested inside `Repeater`, `Section`, or `Group` components, as it resolves the full path on the Livewire component.

## Multi-Column Mapping (DRY Architecture)

A common challenge with geographic pickers is that they often use a single UI element (the map) to update multiple database columns (`latitude`, `longitude`).

### The Senior Implementation

To keep the architecture DRY and the Resources "thin", we implement the mapping logic directly within the component's trait (`HasCoordinatePicker`):

1.  **Hydration (`afterStateHydrated`)**: When the form loads, the trait pulls values from the real model columns and populates the field's internal array state `{latitude: X, longitude: Y}`.
2.  **Dehydration (`dehydrated(false)`)**: We mark the main field as NOT dehydrated. This prevents Filament from trying to save the whole array to a column named after the field (e.g., `location`), which usually doesn't exist.
3.  **Custom Saving (`saveRelationshipsUsing`)**: We use this hook to perform the actual database update. Since it's called after the model is saved, we can safely update the `latitude` and `longitude` columns using the values from the field's state.

### Usage in Resource

Thanks to this encapsulation, using the picker is as simple as:

```php
CoordinatePicker::make('location')
    ->latitudeColumn('lat')  // optional, defaults to 'latitude'
    ->longitudeColumn('lng') // optional, defaults to 'longitude'
```

No manual data mutation is required in the `CreateRecord` or `EditRecord` pages.
