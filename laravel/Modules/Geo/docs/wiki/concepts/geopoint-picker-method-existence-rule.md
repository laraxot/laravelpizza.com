## Rule: GeopointPicker Method Existence Check

### Why This Rule
When developing GeopointPicker components, always verify that Blade templates only call methods explicitly defined in the PHP class. Missing methods cause runtime errors like `Method GeopointPicker::getLatitude does not exist` or `Method GeopointPicker::showSearch does not exist`.

### How to Apply
1. **In Blade**: Before using `$field->method()` or `@json($field->method)`, confirm the method exists in `GeopointPicker.php`
2. **In PHP**: Use strict typing (`?string`, `?bool`) and IDE auto-completion to discover available methods
3. **Automated Checks**: Run `phpstan` and `phpmd` (standalone) after modifying Geo module files to catch missing method calls

### Examples
```php
// BETTER
{{ $field->getLatitude() }}
{{ $field->showSearch() }}

// PRONE TO ERRORS
{{ $field->missingMethod() }}

// Blade template fix:
<!-- Before -->
@json($field->showSearch())
<!-- After -->
@json($field->getShowSearchState())
```

### Prevention
- Always read Blade templates before writing PHP classes
- Document all methods in `GeopointPicker.php` for Blade reuse
- Enforce PHP type hints to catch missing method usage early