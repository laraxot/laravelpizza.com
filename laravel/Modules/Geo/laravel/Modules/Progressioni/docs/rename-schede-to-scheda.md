# Renaming Schede Model to Scheda

## Rationale
Following Laravel conventions and general OOP best practices, Model names should be singular (e.g., `Scheda`), while table names remain plural (`schede`). The previous name `Schede` was plural, which is inconsistent with the rest of the application and Laravel's expectations.

**Why Singular Names?**
- In Laravel/Eloquent, a model represents a single entity/record
- Framework convention: Model = Singular, Table = Plural
- Examples: `User` model → `users` table, `Post` model → `posts` table
- Italian examples: `Scheda` model → `schede` table, `Bando` model → `bandi` table

## Changes Completed (2026-03-10)

### Core Files
1. **Model File**: Renamed `app/Models/Scheda.php` → `app/Models/Scheda.php`
2. **Class Name**: Updated class name from `Schede` to `Scheda`
3. **Factory**: Renamed `database/factories/SchedeFactory.php` → `database/factories/SchedaFactory.php`
4. **Policy**: Renamed `app/Models/Policies/SchedePolicy.php` → `app/Models/Policies/SchedaPolicy.php`

### Code Updates
5. **Use Statements**: Updated all `use Modules\Progressioni\Models\Schede;` → `use Modules\Progressioni\Models\Scheda;`
6. **Class References**: Updated all `Schede::` → `Scheda::`
7. **PHPDoc**: Updated all `@property Collection<int, Schede>` → `@property Collection<int, Scheda>`
8. **Type Hints**: Updated all method signatures referencing `Schede $model` → `Scheda $model`
9. **Filament Resource Path**: Renamed support path `Filament/Resources/SchedeResource/*` → `Filament/Resources/SchedaResource/*`
10. **Cross-Module Alignment**: Applied same singular rule in `Modules/Legge104` (`Scheda`, `SchedaFactory`)

## Verification
- ✅ All `use` statements updated
- ✅ All class references updated
- ✅ All PHPDoc annotations updated
- ✅ All type hints updated
- ✅ Factory and Policy renamed
- ✅ Filament resource namespace/path updated
- ✅ Legge104 aligned on singular model naming

## Related Documentation
- [Model Naming Convention](../../../../docs/MODEL_NAMING_CONVENTION.md)
- [.windsurf/rules/model-naming-singular.md](../../../../.windsurf/rules/model-naming-singular.md)
- [.cursor/rules/model-naming-singular.md](../../../../.cursor/rules/model-naming-singular.md)

## Backward Compatibility
This is a breaking change. Any external code referencing `Schede` must be updated to `Scheda`.

## Migration Guide
```php
// Before
use Modules\Progressioni\Models\Schede;
$scheda = Schede::find(1);

// After
use Modules\Progressioni\Models\Scheda;
$scheda = Scheda::find(1);
```

---
**Date**: 2026-03-10  
**Type**: Breaking Change  
**Priority**: High
