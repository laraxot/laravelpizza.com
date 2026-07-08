# PHPStan property_exists Fix

## Issue Fixed

Fixed usage of `property_exists()` function in test helpers that was inappropriate for Eloquent models.

## Problem

In `Modules/Ptv/tests/Pest.php`, line 29:
```php
expect()->extend('toHaveProperty', fn (string $property) => expect(property_exists($this->value, $property))->toBeTrue());
```

The `property_exists()` function doesn't work correctly with Eloquent models because they use magic properties via `__get()`, `__set()`, and `__isset()` methods. This would cause tests to fail incorrectly when checking for database attributes.

## Solution

Replaced with `isset()` which respects the magic `__isset()` method:

```php
expect()->extend('toHaveProperty', fn (string $property) => expect(isset($this->value->$property))->toBeTrue());
```

## Why This Matters

- `property_exists()` only checks for explicitly declared class properties
- `isset()` respects magic methods and works with Eloquent's dynamic attributes
- This ensures test assertions work correctly with Eloquent models
- Aligns with project-wide policy against using `property_exists()` with Eloquent models

## Files Modified

- `Modules/Ptv/tests/Pest.php` - Updated test helper function

## Related Documentation

See also: `@.cursor/rules/property-exists-rule.md` for the complete policy on this topic.