# Laraxot Architecture: The 10 Commandments of Xot (Quick Reference)

This document provides a quick reference to the 10 inviolable architectural commandments enforced by the `Xot` module, which is the foundational core of the Laraxot framework. Adhering to these rules is paramount for maintaining code quality, consistency, and future compatibility.

---

## The 10 Commandments of Xot

These rules are derived from `Modules/Xot/docs/filosofia-modulo-xot.md` and are essential for any developer working within the Laraxot ecosystem.

### 1. **Thou shalt not extend Filament directly.**
*   **Rule**: Always extend `Modules\Xot\Filament\Pages\XotBase*` classes (e.g., `XotBaseResource`, `XotBasePage`, `XotBaseSection`) instead of Filament's core classes directly.
*   **Motivation**: Centralized control, future compatibility, uniform behavior, and compliance with Laraxot's abstraction layer.

### 2. **Thou shalt always use `XotBase*`.**
*   **Rule**: For every Filament component or related class, utilize its `XotBase*` equivalent provided by the `Xot` module.
*   **Motivation**: Ensures consistency, leverages `Xot`'s automation, and maintains the framework's abstraction layer.

### 3. **Thou shalt not hardcode translations.**
*   **Rule**: All user-facing strings in Filament components (labels, placeholders, helper texts, tooltips) must rely on the intelligent translation system. Avoid direct string literals.
*   **Motivation**: Enables multi-language support, improves maintainability, and ensures consistency across the UI.

### 4. **Thou shalt prefer Actions over Services.**
*   **Rule**: Encapsulate business logic within Spatie Queueable Actions, using the `execute()` method as the primary entry point. Avoid creating traditional Service classes.
*   **Motivation**: Promotes testability, queueability, single responsibility, and cleaner dependency management.

### 5. **Thou shalt declare `strict_types=1`.**
*   **Rule**: Every PHP file must include `declare(strict_types=1);` as the first statement after the opening `<?php` tag.
*   **Motivation**: Ensures strict type safety, prevents type-related bugs, and facilitates PHPStan Level 10 compliance.

### 6. **Thou shalt not replicate base class methods.**
*   **Rule**: If a method's functionality is already provided by an `XotBase*` parent class, do not override or duplicate that method in a derived class unless truly necessary for specific customization.
*   **Motivation**: Adherence to DRY principles, reduces code duplication, and simplifies maintenance when base class logic is updated.

### 7. **Thou shalt not use `property_exists()` with Eloquent.**
*   **Rule**: When checking for attributes on Eloquent models, use `isset($model->attribute)` or `hasAttribute()` instead of `property_exists()`.
*   **Motivation**: Eloquent's magical properties can lead to incorrect results with `property_exists()`; `isset()` and `hasAttribute()` provide reliable checks.

### 8. **Thou shalt use `casts()` method, not `$casts` property.**
*   **Rule**: For attribute casting in Eloquent models, utilize the `casts()` method (Laravel 11+ syntax) instead of the deprecated `protected $casts` property.
*   **Motivation**: Adherence to modern Laravel conventions, improved type safety, and better integration with static analysis.

### 9. **Thou shalt use `TextColumn::make()->badge()`, not `BadgeColumn`.**
*   **Rule**: When displaying badges in Filament tables, use `TextColumn::make()->badge()` instead of the deprecated `BadgeColumn`.
*   **Motivation**: Adherence to modern Filament conventions and consistency in UI component usage.

### 10. **Thou shalt respect PSR-4 without `app/`.**
*   **Rule**: Ensure that module namespace declarations do not include `App` (or `app/`) as part of the path (e.g., `namespace Modules\User\Models;` is correct, not `namespace Modules\User\App\Models;`).
*   **Motivation**: Consistent autoloading, adherence to Laraxot conventions, and cleaner module structure.

---

## Related Documentation

*   [Xot Module Philosophy](./filosofia-modulo-xot.md)
*   [Composer and Module Dependency Management](./composer-module-dependency-management.md)
*   [Action Execution and Dependency Injection Rules](./actions/action-execution-and-di-rules.md)
