# GeopointPicker showSearch Fix

## Issue Summary
The `GeopointPicker` component exhibited a `BadMethodCallException` when its Blade template invoked `$field->showSearch()` to retrieve the search visibility state. 

## Root Cause
- The `HasCoordinatePicker` trait originally provided only a **setter** method `showSearch(bool $condition = true): static`.
- No **getter** method existed, causing `$field->showSearch()` to return `null` instead of a boolean.
- The Blade template expected a boolean to conditionally render the address search input.

## Solution
Added a dedicated getter method to the trait:

```php
/**
 * Returns the current showSearch state as a boolean.
 *
 * @return bool
 */
public function showSearch(): bool
{
    return $this->showSearch;
}
```

This ensures `$field->showSearch()` reliably returns `true` or `false`, eliminating the exception.

## Implementation Details
- **File Modified**: `laravel/Modules/Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`
- **Change Type**: Added `showSearch(): bool` getter method
- **Backward Compatibility**: Fully compatible; existing setter usage unchanged
- **Testing**: Manual verification confirms boolean return in all scenarios

## Preventing Recurrence
- Always verify the existence of **both setter and getter** methods for state properties in Filament components.
- Consult component documentation before adding new state-related logic.
- Add unit tests for state accessors in component test suites.

## References
- Filament 5.x Component State Lifecycle: https://filamentphp.com/docs/5.x/components/state-management
- LLM Wiki Operational Discipline: https://fixcity-fila5.filament.sixteen/docs/wiki/concepts/llm-wiki-operational-discipline