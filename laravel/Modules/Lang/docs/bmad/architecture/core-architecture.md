---
title: "Architectural Rules & Guidelines"
module: "Lang"
type: concept
tags: [REDUNDANCY, ANALYSIS]
created: 2026-07-14
updated: 2026-07-14
qmd: "redundancy analysis"
related:
  - "./italian-text-refined-audit-report.md"
---
# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

-   [Super Cow Methodology](../../xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../xot/docs/filament_extension_rules.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.

## Collegamenti correlati
- [Composer merge plugin](composer-merge-plugin.md)

## Componenti core (da `ARCHITECTURE.md`, fuso 2026-10-05)

**Models:** `BaseModelLang`, `LanguageLine`, `Translation`.
**Actions:** `SyncTranslationsAction`, `ValidateTranslationsAction`.
**Filament Resources:** `LangResource` — main admin resource.

**Database Schema:** `lang_table` — tabella primaria con colonne standard Laravel (id, timestamps).

**Design Decisions:** XotBaseModel (base coerente), Filament v5 (admin standard), Laravel Queues (background per operazioni pesanti).

**Integration Points:** dipende da Xot; usato da Activity, Notify (logging).

**Quality Gates:** PHPStan L10 / PHPMD / Pest — vedi report qualità nel modulo.
