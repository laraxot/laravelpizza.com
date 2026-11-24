---
title: "Architectural Rules & Guidelines"
type: concept
tags: [architecture]
created: 2026-07-14
updated: 2026-07-14
qmd: "architecture architectural rules & guidelines"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./architecture-rules.md"
  - "./auth-blade-structure.md"
  - "./component-registration.md"
  - "./readme.md"
  - "./structure.md"
  - "./testing-structure.md"
  - "./user-gdpr-decoupling.md"
  - "./user-gdpr-oupling.md"
---

# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

- [Super Cow Methodology](../../xot/docs/super-cow-methodology.md)
- [PHP Quality Guide](../../xot/docs/php-quality-guide.md)
- [Filament Extension Rules](../../xot/docs/filament-extension-rules.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.
