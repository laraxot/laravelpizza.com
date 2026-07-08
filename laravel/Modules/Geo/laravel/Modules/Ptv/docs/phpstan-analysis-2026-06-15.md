---
title: "PHPStan Analysis - Ptv Module"
module: "Ptv"
date: "2026-06-15"
status: "resolved"
errors_found: 0
resolution_note: "ListaAszTipCodEsclusoSubito usa $scheda->asz()->ofRangeDate() — mai Asz00k1::query() bypass"
---

# PHPStan Analysis — Ptv Module (2026-06-15)

## Summary

Full PHPStan analysis (level max) on Ptv module identified **133 errors** across 31 files. Primary categories:

| Category | Count | Files Affected | Priority |
|----------|-------|-----------------|----------|
| `method.nonObject` | ~45 | app/Actions/Scheda/*, BaseScheda.php, Check/* | High |
| `argument.type` | ~30 | Filament/Resources, Actions, Models | High |
| `property.nonObject` | ~15 | BaseScheda.php, Actions | Medium |
| `array.duplicateKey` | ~~12~~ **0** | lang/it/actions.php, en/actions.php | ✅ Fixed |
| `class.notFound` | ~8 | Models/User.php (Spatie/Permission) | Low |
| Other | ~23 | Various | Medium |

## Fixed (Session 2026-06-15)

### Array Duplicate Keys — ✅ RESOLVED
- **Files:** `Ptv/lang/it/actions.php`, `Ptv/lang/en/actions.php`
- **Issue:** 12 duplicate translation keys
- **Root Cause:** Copy-paste templates with overlapping key definitions
- **Fix Applied:** Removed 6 duplicate entries per file, kept improved versions
  - `copy_from_last_year`, `populate_year`, `trova_esclusi`
  - `showing_records`, `showing_limited_results`, `modal_title`
- **Result:** 145 → 133 errors

## Remaining Errors (133)

### 1. method.nonObject (~45 errors)
**Location:** Primarily in `app/Actions/Scheda/*` and `BaseScheda.php`

**Pattern:**
```php
// Example from Ptv/app/Models/BaseScheda.php
$budgetImportato?->importo  // Property access on potentially null value
```

**Root Cause:** Unsafe property/method access on nullable or mixed-type values

**Typical Files:**
- `app/Actions/Scheda/UpdateBudgetAssegnatoAction.php`
- `app/Actions/Scheda/UpdateQuotaTeoricaAction.php`
- `app/Models/BaseScheda.php`
- Check/* actions

**Impact:** Potential runtime null reference errors

**Fix Strategy:**
- Add null checks before property access
- Use optional chaining or null coalescing
- Add property type hints

### 2. argument.type (~30 errors)
**Location:** Filament/Resources, Models/User.php

**Pattern:**
```php
hasMany(string $class)  // Expects class-string<Model>, got string
```

**Root Cause:** 
- Laravel macros (belongsToManyX, hasMany) type inference issues
- PHPDoc type hints mismatch with actual parameters

**Files Affected:**
- `Ptv/app/Models/User.php` (Spatie Permission macros)
- `Ptv/app/Models/Valutatore.php`
- Filament Resource classes

**Fix Strategy:**
- Add explicit type casts for string → class-string conversions
- Use type assertions (Assert::classExists, Assert::subclassOf)
- Update PHPDoc signatures

### 3. property.nonObject (~15 errors)
**Location:** BaseScheda.php, Actions

**Pattern:**
```php
$object->property  // Access on mixed/unknown type
```

**Fix Strategy:**
- Type guard before property access
- Add type hints to class properties
- Use isset() checks

## Architecture Notes

### Module Structure
```
Ptv/
├── app/
│   ├── Actions/
│   │   ├── Scheda/        ← High error concentration (41+ errors)
│   │   ├── Check/         ← 11 errors
│   │   ├── CriteriEsclusione/  ← 5 errors
│   │   └── PopulateByYearAction.php  ← 3 errors
│   ├── Filament/
│   │   ├── Resources/     ← 13 errors
│   │   ├── Actions/       ← 2 errors
│   │   └── Filters/       ← 1 error
│   ├── Models/
│   │   ├── BaseScheda.php ← 7 errors
│   │   ├── User.php       ← 2 errors
│   │   └── Valutatore.php ← 1 error
│   └── Policies/
└── lang/
    ├── it/actions.php     ← ✅ Fixed
    └── en/actions.php     ← ✅ Fixed
```

### Key Models
- **BaseScheda:** Central domain model for "Scheda" (form/record)
- **User:** Extends base User with Ptv-specific roles/permissions (Spatie)
- **Valutatore:** Evaluator/appraiser model

### Action Patterns
- **Scheda Actions:** Heavy domain logic (budget calculations, quota updates, rest calculations)
- **Check Actions:** Validation/checking actions (noposiz, nodisci, etc.)
- **Criteria Actions:** Business rule evaluations (exclusion criteria)

## Recommended Fix Order

1. **Quick Wins (1-2 hours):**
   - Fix remaining 2 duplicate keys (if any)
   - Add null checks in simple property accesses
   - Type cast string → class-string in straightforward cases

2. **Medium Priority (2-4 hours):**
   - Audit app/Actions/Scheda/* for common patterns
   - Add type hints to BaseScheda properties
   - Fix Spatie Permission macro type mismatches

3. **Architecture Review (4+ hours):**
   - Review domain logic in actions
   - Consider extracting magic strings to enums
   - Document action contract expectations

## Known Issues / Constraints

- **Spatie/Permission Macros:** Type system doesn't fully understand dynamic macro-added methods
  - Workaround: Use explicit type assertions or update Spatie binding
  
- **Laravel Magic Methods:** hasMany, belongsToMany accept dynamic class strings
  - Workaround: Add type assertions or use typed constructors

- **Mixed Property Types:** Some BaseScheda properties used in multiple contexts
  - Consider: Separate DTOs for different calculation phases

## Next Steps

1. Run per-action PHPStan analysis to identify patterns
2. Create type guards/helpers for common patterns
3. Update BaseScheda property type hints
4. Document action interfaces in each Actions/* folder
5. Consider creating Ptv-specific type stubs if needed

---

**Generated:** 2026-06-15 10:38 UTC  
**Analysis Tool:** PHPStan v2.1.56 (level max)  
**Session:** Gate Entry + Comprehensive Analysis
