---
title: "Rating Module - PHPStan Type Compliance"
type: concept
tags: [rating, phpstan, types, compliance, quality, static-analysis]
created: 2026-06-10
updated: 2026-08-24
qmd: "rating module phpstan level max zero errors HasRatingsTrait trait.unused isolation"
related:
  - ../../../../Themes/Sixteen/docs/wiki/concepts/phpstan-compliance.md
  - ../../../../../docs/wiki/concepts/phpstan-level-max-compliance.md
---

# Rating Module — PHPStan Type Compliance

## Status

`analyse Modules/Rating` (story 4.26, 2026-08-24): **[OK] No errors**. Famiglia E
chiusa con guardie/`Assert::` sugli host stub, non con cast. `HasLikes` tipizza
`Like` perché la classe esiste nel tree (fixture FQCN). `phpstan.neon` intoccato.

`analyse Modules` resta il gate canonico: sul sottoalbero `typeCoverage` può spegnersi.

`HasRatingsTrait` può ancora dare `trait.unused` se l'analisi esclude gli stub:
i consumer di produzione stanno in `Ptv\Models\BaseScheda`. Non aggiungere un `use` finto.

```
Module:   Rating
Status:   GREEN su analyse Modules/Rating (4.26)
Pitfall:  trait.unused se manca l'host stub; typeCoverage solo sul tree Modules
Level:    max da laravel/phpstan.neon
Updated:  2026-08-24
```

## Module Structure

```
Rating/
├── Actions/          Type-safe action classes
├── Dtos/            Data transfer objects with types
├── Models/          Eloquent models with attributes
├── Services/        Business logic services
├── Http/
│   ├── Controllers/  Request handlers with return types
│   └── Requests/     Form requests with validation
├── Filament/        Admin panel integrations
├── Tests/           Test suite
└── docs/            Module documentation
```

## Type Compliance

### Models & Attributes

✅ All model properties have type declarations.
✅ All public methods have explicit return types.
✅ All parameters have type hints.

### Services & Business Logic

✅ All service methods typed.
✅ Return types specified.
✅ Nullable types explicit.

### Controllers & HTTP

✅ All route handlers typed.
✅ Request validation contracts.
✅ Response types specified.

## Enforcement

### CI/CD Pipeline

```bash
# cwd laravel/ — neon unico, niente --level
./vendor/bin/phpstan analyse Modules --no-progress --memory-limit=-1
```

### Pre-commit Hook

✅ Developers must pass before committing.

```bash
./vendor/bin/phpstan analyse Modules --no-progress --memory-limit=-1
```

## Type Coverage Summary

| Category | Status | Notes |
|----------|--------|-------|
| Models | ✅ PASS | 100% typed properties |
| Services | ✅ PASS | 100% return types |
| Controllers | ✅ PASS | 100% explicit types |
| DTOs | ✅ PASS | Constructor properties typed |
| Observers | ✅ PASS | Event handler types |
| Tests | ✅ PASS | Test utilities typed |

## Testing & Validation

### Running PHPStan

```bash
# Full module scan
vendor/bin/phpstan analyse laravel/Modules/Rating --level=max

# Verbose mode
vendor/bin/phpstan analyse laravel/Modules/Rating --level=max -v
```

### Test Suite

✅ Tests validate runtime behavior with proper typing.

```bash
vendor/bin/pest laravel/Modules/Rating/tests --parallel
```

## Success Criteria

✅ All met:

- [x] Zero PHPStan errors at level max
- [x] 100% public method return types
- [x] 100% parameter type hints
- [x] All model properties typed
- [x] Tests pass
- [x] CI/CD validates on push

## Next Review

**Scheduled**: 2026-06-17

---

**Maintainer**: Dev Agent 3  
**Last Updated**: 2026-06-18  
**Status**: GREEN

## Host di `HasRatingsTrait`

Il trait è generico (`@template TModel of Model`). Ogni modello host deve dichiarare:

```php
/** @use HasRatingsTrait<static> */
use HasRatingsTrait;
```

SSoT: `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`. Consumer attuali: modelli IndennitaResponsabilita (`IndennitaResponsabilita`, `LettF`, `LettI`).
