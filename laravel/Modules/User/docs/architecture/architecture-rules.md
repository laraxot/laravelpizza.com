---
title: "Architectural Rules & Guidelines"
type: rule
tags: [architecture, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "architecture-rules architectural rules & guidelines"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./architecture.md"
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

-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)
-   [Super Cow Methodology](../../xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../xot/docs/filament_extension_rules.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.
