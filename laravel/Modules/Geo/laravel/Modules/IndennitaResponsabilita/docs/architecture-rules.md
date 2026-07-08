# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
5.  **Specialized Components**: Never decompose specialized components (e.g., `WorkerColumn`) into primitive columns unless explicitly instructed. Always use explicit keys (e.g., `'lavoratore' => WorkerColumn::make(...)`).
6.  **Action Return Types**: Filament Actions that trigger downloads or return responses MUST explicitly declaring the return type (e.g., `function (): BinaryFileResponse`) and use the `return` keyword. Do not use `void` or implicit returns for actions that generate responses.
