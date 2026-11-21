---
title: "Architectural Rules & Guidelines"
module: "Lang"
type: rule
tags: [migration, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migration filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)
-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)
-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.

## Collegamenti correlati
- [Composer merge plugin](composer-merge-plugin.md)
- [Composer merge plugin](composer-merge-plugin.md)
- [Composer merge plugin](composer-merge-plugin.md)
- [Composer merge plugin](composer-merge-plugin.md)
- [Composer merge plugin](composer-merge-plugin.md)
