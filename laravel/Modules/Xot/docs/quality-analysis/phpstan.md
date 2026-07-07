# PHPStan Analysis and Legacy Cleanup (2026-05-13)

## Overview
As part of the continuous quality improvement process, a PHPStan analysis was performed on all modules. This led to the discovery of architectural violations and legacy misplaced directories that were interfering with the static analysis and potentially causing runtime confusion.

## Misplaced Directories Removed
The following directories were identified as misplaced/legacy (existing outside the standard `app/` structure) and were removed:
- `laravel/Modules/Activity/Filament/`
- `laravel/Modules/Xot/Filament/`

These directories contained files that were either duplicates of those in `app/Filament/` or legacy versions extending non-existent classes (e.g., `Filament\Schemas\ConfiguredSchema`).

## Core Principles Reaffirmed
- **Laraxot Standard Structure**: All Filament-related code must reside in `Modules/{ModuleName}/app/Filament/`.
- **No Direct Extension**: Never extend Filament classes directly; always use `XotBase*` counterparts.
- **Single Source of Truth**: Duplicate files in different paths of the same module are strictly prohibited.

## Missing Dependencies Identified
- `spatie/laravel-model-states`: Referenced in `WithStateStatusContract.php` and `XotBaseState.php`. This package needs to be officially added to `Modules/Xot/composer.json`.

## Results
Removing these directories and applying targeted fixes has resulted in **0 errors** in the PHPStan analysis of the `Modules` directory (Level: Max).

### Final Checklist Status
- [x] Misplaced directories removed.
- [x] Type-safety errors fixed in `Geo` module.
- [x] PHPDoc parse errors resolved in table classes.
- [x] No errors remaining in `Modules`.


---
**See also:**
- [ERRORE CRITICO: Mai Estendere Classi Filament Direttamente](../errori-critici/mai-estendere-filament-direttamente.md)
- [Directory Structure Rules](../../docs/wiki/rules/directory-structure.md)
