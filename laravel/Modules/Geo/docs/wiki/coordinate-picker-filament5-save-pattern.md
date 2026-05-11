# CoordinatePicker Multi-Column Save Pattern (Filament 5)

## Problem

When using `CoordinatePicker` component in back-office forms (e.g. `/fixcity/admin/tickets`), the location data is stored across two separate database columns (`latitude` / `longitude`) instead of a single `location` JSON column. This creates a data persistence problem:

- Filament's `$this->fill(['location' => [...])` receives an array `{latitude, longitude, address}`
- If the model has no `location` column, the data is silently lost
- No model mutator exists to split the array into separate columns
- The `HasCoordinatePicker` trait handles state hydration but provides no save-side transformation

## Solution: Eloquent Mutator

Create an Eloquent mutator named `location()` in your model. This mutator intercepts the array sent by Filament and maps it to the correct database columns.

### Implementation

```php
use Illuminate\Database\Eloquent\Casts\Attribute;

// In your model (e.g. Tickets.php)
protected function location(): Attribute
{
    return Attribute::set(function (mixed $value): array {
        if (! is_array($value)) {
            return [];
        }

        return [
            'latitude'  => isset($value['latitude'])  ? (string) $value['latitude']  : null,
            'longitude' => isset($value['longitude']) ? (string) $value['longitude'] : null,
        ];
    });
}
```

### Key Points

- **Mutator name**: Must be exactly `location()` (matches the `$fillable` / field name used in Forms)
- **Return type**: Returns an **array** with keys `latitude` and `longitude`
- **Casts configuration**: **Remove** `'location' => 'array'` from `$casts` — the mutator handles this, a redundant cast can cause confusion
- **Works for both create and update**: The mutator is invoked on every `fill()` / `save()`

## Why This Works

1. Filament calls `$model->fill(['location' => $state])` where `$state` is `{latitude, longitude, address}`
2. The `location()` mutator intercepts this value
3. The mutator returns an array with only `latitude` and `longitude` (as strings)
4. Eloquent persists these values to the respective `latitude` / `longitude` columns

## Files Involved

- `Ticket.php` (already has the mutator from story 8-64)
- `CoordinatePicker.php` (uses `HasCoordinatePicker` trait)
- `HasCoordinatePicker.php` (trait with `afterStateHydrated` and state management; no save-side logic needed)

## Related

- [CoordinatePicker Multi-Column Save Rule](bashscripts/ai/.claude/rules/coordinatepicker-multi-column-save.md)
- [Story 8-64: Implementation artifacts](_bmad-output/implementation-artifacts/8-64-coordinatepicker-filament5-custom-field-save-fix-and-docs.md)
- [Wiki: concepts/coordinate-picker-filament5-save-pattern.md]( (indexed))
