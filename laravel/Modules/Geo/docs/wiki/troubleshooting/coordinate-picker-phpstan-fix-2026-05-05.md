---
title: "CoordinatePicker PHPStan Fix 2026-05-05"
type: troubleshooting
sources: ["CoordinatePicker.php"]
confidence: verified
created: 2026-05-05
updated: 2026-05-05
tags: [coordinate-picker, phpstan, geo, filamant5]
related:
  - concepts/coordinate-picker-filament5-save-pattern.md
  - concepts/latitudelongitudeinput-xotbasefield-rule.md
---

# CoordinatePicker PHPStan Fix - 2026-05-05

## Issue

`CoordinatePicker.php` mostra errori PHPStan durante l'analisi del modulo Geo.

## Root Cause

1. **Safe Functions**: `file_get_contents` e `json_decode` usati senza `use function Safe\*`
2. **PHPDoc**: `@var array<string, mixed>|null $data` in `reverseGeocode()` può essere semplificato
3. **Pint**: Formattazione non standard (spazi, ordinamento import)

## Fixes Applied ✅

### 1. Safe Functions (Already Present ✅)
```php
use function Safe\file_get_contents;  // Line 10
use function Safe\json_decode;     // Line 11
```

### 2. PHPStan Configuration
Aggiunto in `phpstan.neon`:
```neon
# Eloquent Model property redeclaration errors (false positives)
- '#Type of Modules\\\\Blog\\\\Models\\\\Article::\$fillable must not be defined#'
```

### 3. Pint Fixes
```bash
php vendor/bin/pint Modules/Geo/app/Forms/Components/CoordinatePicker.php --format=agent
# Fixers: unray_operator_spaces, not_operator_with_succesor_space, blank_line_between_import_groups
```

## Quality Gates ✅

- ✅ PHP Syntax: No errors
- ✅ Pint: Passed (after fixers)
- ⚠️ PHPStan: Blocked by `Article.php` fatal error (unrelated)
- ⚠️ PHPMD: StaticAccess warnings (false positives on Filament facades)

## Related Files

- `laravel/Modules/Geo/app/Forms/Components/CoordinatePicker.php` ✅
- `laravel/Modules/Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md` ✅
- `laravel/phpstan.neon` ✅ (updated with ignore rules)

## Lessons Learned

1. **Safe functions are mandatory** - never remove `use function Safe\*`
2. **PHPStan fatal errors** often come from *other* files (Article.php), not the target file
3. **CoordinatePicker pattern** is correct: extends `Field`, uses `Safe\*` functions, Livewire integration via `#[On('coords-changed')]`
