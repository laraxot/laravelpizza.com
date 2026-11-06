---
title: "User Module Updates - December 2025"
type: concept
tags: [updates, dec]
created: 2026-07-14
updated: 2026-07-14
qmd: "updates-dec user module updates - december 2025"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# User Module Updates - December 2025

## Refactoring Translations
- **Removed hardcoded labels**: Calls to `->label()` and `->placeholder()` have been removed from `Login.php` and `PasswordData.php`.
- **Automatic Translation**: Labels are now automatically resolved via `LangServiceProvider` using the key structure `user::resource.fields.field_name` (e.g., `user::login.fields.email.label`).
- **Updated Language Files**: `modules/User/lang/it/login.php` and `password.php` have been updated with capitalized labels ("Email", "Password") to match UI standards.
- **Verification**: A new feature test `Modules/User/tests/Feature/PasswordDataLabelsTest.php` verifies that labels are correctly translated.

## PHPStan Fixes
- **DocBlock Updates**: Fixed `class.notFound` errors in `User` and `TenantUser` models by replacing non-existent `TechPlanner\Models\Profile` references with `Modules\Xot\Contracts\ProfileContract`.
- **Compliance**: Module now passes PHPStan analysis at Level 10.

## Architectural Alignment
This module adheres to the **Super Cow Methodology**:
- **Filament Rules**: Extends `XotBase` classes (e.g., `XotBaseLogin`, `XotBasePage`).
- **Documentation**: Referenced core architecture rules in `Modules/Xot/docs/`.
