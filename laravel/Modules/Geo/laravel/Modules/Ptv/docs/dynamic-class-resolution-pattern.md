# Pattern: Dynamic Class Resolution for Cross-Module Relations

## Problem

When models in different modules have relations to the same entity (e.g., `Scheda`), we need a flexible way to resolve the class:
- If the current module has its own `Scheda` class → use it
- Otherwise → fallback to the main module's `Scheda` (e.g., `Progressioni`)

## Solution

Use Laravel's `Str` helper to dynamically build the class name:

```php
use Illuminate\Support\Str;
use Modules\Progressioni\Models\Scheda;

public function scheda(): HasMany
{
    $schedaClass = Str::of(static::class)
        ->beforeLast('\\')
        ->append('\\Scheda')
        ->toString();
    $modelClass = class_exists($schedaClass) ? $schedaClass : Scheda::class;

    /** @phpstan-ignore-next-line */
    return $this->hasMany($modelClass, 'valutatore_id', 'id');
}
```

## How It Works

1. `static::class` → gets the current model's FQCN (e.g., `Modules\Ptv\Models\StabiDirigente`)
2. `beforeLast('\\')` → extracts the namespace (e.g., `Modules\Ptv\Models`)
3. `append('\\Scheda')` → adds the target class (e.g., `Modules\Ptv\Models\Scheda`)
4. `class_exists()` → checks if a local `Scheda` exists in that module
5. Fallback → if not, use the default `Scheda::class` (from `Progressioni`)

## Use Cases

- **StabiDirigente** in Ptv → tries `Ptv\Scheda`, falls back to `Progressioni\Scheda`
- **Valutatore** in Ptv → same pattern
- **CriteriEsclusione** in Ptv → same pattern
- **Child models** in Progressioni → inherit from Ptv, use the parent's resolution

## Benefits

1. **Modularity**: Each module can extend the base model
2. **Fallback**: No errors if the local class doesn't exist
3. **PHPStan Compatible**: Use `@phpstan-ignore-next-line` for dynamic resolution
4. **DRY**: Single pattern used across all cross-module relations

## Files Using This Pattern

- `Modules/Ptv/app/Models/StabiDirigente.php`
- `Modules/Ptv/app/Models/Valutatore.php`
- `Modules/Ptv/app/Models/CriteriEsclusione.php`

## Related Documentation

- [Model Naming Convention](../../../../docs/MODEL_NAMING_CONVENTION.md)
- [Refactoring Plural to Singular](../../../../docs/REFACTORING_PLURAL_TO_SINGULAR.md)
