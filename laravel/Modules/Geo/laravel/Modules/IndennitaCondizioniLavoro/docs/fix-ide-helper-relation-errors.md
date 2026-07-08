# Fix IDE Helper Relation Errors

## Problem Statement
The `php artisan ide-helper:models -W` command was reporting an error in the `IndennitaCondizioniLavoro` module:
- `Error resolving relation model of Modules\IndennitaCondizioniLavoro\Models\ServizioEsterno:trasferte() : Class "Modules\Trasferte\Models\FuoriSedeDip" not found`. This happened because the `Trasferte` module might not be loaded in all environments.

## Solution
### 1. Robust Relation Handling
Updated `ServizioEsterno::trasferte()` to resolve the related model class before returning the relation:
- Used `class_exists()` to safely detect if `Modules\Trasferte\Models\FuoriSedeDip` is available.
- Checked the optional class with `is_subclass_of(..., Model::class)` before using it in `hasMany()`.
- If the class is missing, it falls back to `self::class` so the relation keeps a concrete Eloquent model class and PHPStan can infer `HasMany<Model, $this>`.
- Keep the `class-string<Model>` PHPDoc on a resolver method, not as an inline `@var` override.

### 2. Standardized Eloquent Relations
- Replaced `belongsToManyX` with standard `belongsToMany` in `ServizioEsterno` for `indennitaTipoDettaglio` and `tipoDettaglio`. This improves compatibility with automated tools like `ide-helper` while maintaining the exact same behavior via the `using()` and `withPivot()` methods.

## Verification
- Ran `php artisan ide-helper:models -W` and confirmed that the "Class not found" error for `trasferte()` is resolved.
