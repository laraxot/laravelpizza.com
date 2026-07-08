---
title: "Filament Resource Zen Pattern (Rating Module)"
type: concept
sources: []
confidence: high
created: 2026-05-06
updated: 2026-05-06
tags: [filament, xotbase, zen-pattern, rating-module]
related:
  - ../../Xot/docs/wiki/concepts/xotbase-resource-zen-pattern.md
  - ../../Xot/docs/wiki/concepts/xotbase-resourceform-zen-pattern.md
  - ../../Xot/docs/wiki/concepts/xotbase-resource-table-zen-pattern.md
---

# Filament Resource Zen Pattern (Rating Module)

## Overview (2026-05-06)

Implementation of Zen philosophy for Rating module Filament resources per `wizard.txt` instructions.

## Core Zen Rules

1. **XotBaseResource does the magic** - don't override `form()`/`table()`
2. **XotBaseResourceForm** - `getFormSchema()` must be **static**
3. **XotBaseResourceTable** - no `configure()` override, only `getTable*()` static methods
4. **Safe functions mandatory** - `use function Safe\...` never removed
5. **No `->label()`/`->tooltip()`** - LangServiceProvider owns translations

## Rating Module Resources Status

| Resource | Form Schema | Table Schema | Zen Compliant |
|----------|-------------|--------------|---------------|
| RatingResource | ✅ RatingForm.php | ✅ RatingTable.php | ✅ Fixed 2026-05-06 |
| RatingMorphResource | ✅ RatingMorphForm.php | ✅ RatingMorphTable.php | ✅ Fixed 2026-05-06 |

## Key Fixes Applied (2026-05-06)

### RatingResource.php
- Removed wrong `table()` override (Zen: XotBaseResource does magic)
- Created `Tables/RatingTable.php` with correct `getTableColumns()` static method
- Fixed `getTableActions()` return type to match parent `array<int|string, Action|ActionGroup>`
- Fixed `getTableBulkActions()` return type to match parent `array<int|string, BulkAction|BulkActionGroup>`

### RatingMorphResource.php
- Removed wrong `table()` override
- Created `Tables/RatingMorphTable.php` with correct static methods

## PHPStan Results

All Rating module resources now pass PHPStan level 5 with:
- **0 errors**
- **0 ignores**
- **0 baselines**
- Per project protocol: never modify `laravel/phpstan.neon`

## Generic Type Limitation (Known Issue)

PHPStan shows 3 generic type false positives in:
- `Rating/app/Models/Contracts/HasRatingContract.php`
- `Rating/app/Models/Traits/HasRating.php`

These are **PHPStan/Larastan limitations** with `MorphToMany<Rating, static>`, not code bugs.
Documented in: `Rating/docs/wiki/troubleshooting/phpstan-generic-limitation-morphtomany.md`

## References

- Base class: `Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- Wizard prompt: `laravel/Themes/Sixteen/docs/prompts/wizard.txt`
- Project wiki: `laravel/docs/wiki/index.md`
- Zen patterns: `laravel/Modules/Xot/docs/wiki/concepts/`
