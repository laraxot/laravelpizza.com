<<<<<<< .merge_file_knaL4R
---
title: "PHPStan Roadmap: User Module"
type: note
qmd: "phpstan roadmap user"
---
=======
>>>>>>> .merge_file_aCPOID
# PHPStan Roadmap: User Module

**Date**: 2026-01-12
**Errors**: 13

## 1. Filament Resource Typing
**Files**:
- `app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `app/Filament/Resources/ClientResource.php`

**Issue**: `getModel()` returns `string` or `class-string`, but contract expects `class-string<Model>`.
**Plan**: Ensure explicit casting or strict return type in `getModel()`. Verify `XotBaseResource` inheritance.

## 2. API Resource properties
**Files**:
- `app/Http/Resources/ClientResource.php`

**Issue**: Access to undefined property `$this->owner`.
**Plan**: `JsonResource` proxies to the underlying model, but PHPStan doesn't know the model type. Add `@mixin` or `@property` PHPDoc to the Resource class.

## 3. PHPDoc Namespace Issues
**Files**:
- `app/Models/Role.php`
- `app/Models/Traits/HasTeams.php`

**Issue**: Unknown classes in PHPDoc (e.g., `Modules\User\Models\Carbon`).
**Plan**:
- Check imports in `Role.php` and `HasTeams.php`.
- The PHPDoc likely lacks FQCN or correct `use` statements.
- `HasTeams.php`: `pluck()` on unknown class `Collection`. Likely missing `use Illuminate\Support\Collection`.

## Execution Order
1. Fix PHPDoc Namespace issues (Role, HasTeams).
2. Fix API Resource properties.
3. Fix Filament Resource typing.
# PHPStan Roadmap - User Module

> **Date**: 2026-01-14
> **Status**: ✅ Fully Compliant (Level 10)
> **Errors**: 0

## Current Status
The **User** module is fully compliant with PHPStan Level 10. No errors were reported in the latest analysis.

## Documentation Note
> [!NOTE]
> This folder contains numerous legacy documentation files (`.md`).
> This file (`phpstan-roadmap.md`) is the **authoritative source** for PHPStan status and strategy.
> Older files relating to PHPStan fixes (e.g., `phpstan-fixes-*.md`) are preserved for historical context but should be considered archived.

## Maintenance Strategy
1.  **Strict Typing**: Ensure all new code uses strict types (`declare(strict_types=1);`).
2.  **Regular Checks**: Run PHPStan before every commit.
3.  **Documentation**: Keep PHPDocs up-to-date for complex types.

## Future Goals
- Clean up legacy documentation files to reduce clutter.
- Maintain 0 errors.
---
module: theme
topic: phpstan-roadmap
canonical: ../../../Themes/docs/shared-components/phpstan-roadmap-Modules.md
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/phpstan-roadmap-Modules.md
