---
name: XotBaseField view rule
description: Components extending XotBaseField must not define a protected string $view; view is resolved dynamically via Spatie Queryable actions (getViewBy...).
type: concept
---

# XotBaseField View Calculation Rule

## Rule
Any Filament form field class that extends `XotBaseField` **must not** declare a protected property `$view` (or any other static view identifier). The view file path is computed at runtime using the Spatie Queryable actions pattern, typically via a method like `getViewBy*()`.

## Why
- **Dynamic resolution**: Views depend on component context (module, theme, locale) and are built from reusable snippets.
- **Consistency**: Centralises view selection logic, avoiding duplicate hard‑coded paths across modules.
- **Maintainability**: Changing the view location only requires updating the Queryable action, not every field class.

## How to Apply
1. Remove any `protected string $view` declaration from the field class.
2. Ensure the class uses the `XotBaseField` trait that provides `view()` which internally resolves the view via Spatie Queryable actions.
3. Implement or rely on existing actions such as `getViewByName()` or `getViewByModel()` that return the Blade view string.
4. If a custom view is required, extend the Queryable action rather than setting `$view` directly.

## Example
```php
class AddressPicker extends XotBaseField
{
    // WRONG – static view path
    // protected string $view = 'geo::components.address-picker';

    // Correct – rely on dynamic resolution
    public function getViewByName(): string
    {
        return 'geo::components.address-picker';
    }
}
```

## Enforcement
- Linting rule can flag any `$view` property in classes extending `XotBaseField`.
- Unit tests should assert that `view()` returns a non‑empty string derived from a Queryable action.

## References
- Spatie Queryable package documentation.
- `laravel/Modules/Geo/docs/wiki/concepts/coordinate-picker-field.md` for a concrete implementation.
