# Code Quality Guidelines for Laravel Modules

## Overview
This document outlines the best practices for maintaining high code quality within a Laravel module. Adhering to these standards ensures consistency, readability, and maintainability across the codebase.

## Key Principles
1. **Strict Typing**: Always use strict typing in PHP to prevent type-related errors and improve code reliability.
2. **Static Analysis**: Utilize tools like PHPStan for static analysis to catch potential issues before runtime.
3. **Consistent Formatting**: Follow PSR-12 coding standards for consistent code formatting.
4. **Documentation**: Document all public methods and classes using PHPDoc to aid in code understanding and maintenance.

## Implementation Guidelines
### 1. PHP Strict Types
- Declare strict types at the beginning of every PHP file to enforce type safety.
  ```php
  declare(strict_types=1);
  ```

### 2. PHPStan Configuration
- Configure PHPStan for each module with a `phpstan.neon.dist` file to set analysis levels and paths.
  ```neon
  parameters:
      level: 5
      paths:
          - app
  ```
- Use higher levels (e.g., 5 or 8) for new modules or projects to enforce stricter checks.

### 3. Safe Library Usage
- Use the `Safe` library for safer function calls that throw exceptions instead of returning `false`.
  ```php
  use function Safe\file_get_contents;
  $content = Safe\file_get_contents('file.txt');
  ```

### 4. Class and Method Length
- Keep methods under 20 lines and classes under 200 lines to maintain readability and single responsibility.

### 5. Dependency Injection
- Use dependency injection to avoid direct instantiation of dependencies, promoting testability and flexibility.

<<<<<<< HEAD






































































=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 50d6b63f (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 17684f52 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 50d6b63f (.)
>>>>>>> 17684f52 (.)
=======
>>>>>>> 88e35986 (.)
=======
>>>>>>> e0b8ebe3 (.)
=======
>>>>>>> cc52d333 (.)
=======
>>>>>>> 90d386aa (.)
=======
>>>>>>> 3eee6f79 (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> cc52d333 (.)
<<<<<<< HEAD
>>>>>>> f8f76a284 (.)
=======
=======
>>>>>>> 90d386aa (.)
<<<<<<< HEAD
>>>>>>> 5e6e0d054 (.)
=======
=======
>>>>>>> 3eee6f79 (.)
<<<<<<< HEAD
>>>>>>> 0117b849c (.)
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
>>>>>>> 50d6b63f (.)
>>>>>>> 551c768c4 (.)
>>>>>>> 38b70c7ba (.)
## Code Quality Tools

### Automation Scripts

- [fix_docs_case](../../../../../bashscripts/project_docs/docs/fix_docs_case.md) - Automatic standardization of documentation filenames
- Run automation scripts regularly to maintain code consistency

## Strumenti di Qualità del Codice

### Scripts di Automazione

- [fix_docs_case](../../../../../bashscripts/project_docs/docs/fix_docs_case.md) - Standardizzazione automatica dei nomi file nella documentazione
- Eseguire gli script di automazione regolarmente per mantenere la coerenza del codice

<<<<<<< HEAD





































































=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 50d6b63f (.)
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 17684f52 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 50d6b63f (.)
>>>>>>> 17684f52 (.)
=======
>>>>>>> 88e35986 (.)
=======
>>>>>>> e0b8ebe3 (.)
=======
>>>>>>> cc52d333 (.)
=======
>>>>>>> 90d386aa (.)
=======
>>>>>>> 3eee6f79 (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> cc52d333 (.)
<<<<<<< HEAD
>>>>>>> f8f76a284 (.)
=======
=======
>>>>>>> 90d386aa (.)
<<<<<<< HEAD
>>>>>>> 5e6e0d054 (.)
=======
=======
>>>>>>> 3eee6f79 (.)
<<<<<<< HEAD
>>>>>>> 0117b849c (.)
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 399f46d3 (.)
>>>>>>> laraxot/develop
>>>>>>> 50d6b63f (.)
>>>>>>> 551c768c4 (.)
>>>>>>> 38b70c7ba (.)
## Common Issues and Fixes
- **Type Errors**: Ensure all methods and functions have explicit return types and parameter types to avoid type-related bugs.
- **Static Analysis Failures**: Address PHPStan errors by refining code or updating the baseline for existing code.
- **Code Duplication**: Refactor duplicated code into reusable methods or traits to reduce maintenance overhead.

## Testing and Verification
- Run PHPStan analysis regularly to maintain code quality (`./vendor/bin/phpstan analyse`).
- Use automated tools in CI/CD pipelines to enforce coding standards on every commit or pull request.

## Documentation and Updates
- Document any deviations from these guidelines or custom quality rules in the relevant module's documentation folder.
- Update this document if new tools or standards for code quality are introduced.

## Links to Related Documentation
- [Xot Base Classes](../Xot/project_docs/XOT_BASE_CLASSES.md)
- [Filament Extension Pattern](../../Notify/project_docs/FILAMENT_EXTENSION_PATTERN.md)
- [Filament Extension Pattern Analysis](../../Notify/project_docs/FILAMENT_EXTENSION_PATTERN_ANALYSIS.md)
- [Patient Module - Namespace Conventions](../../Patient/project_docs/NAMESPACE_CONVENTIONS.md)
- [Patient Module - Validation Errors](../../Patient/project_docs/VALIDATION_ERRORS.md)
- [PHP Strict Types](./PHP-STRICT-TYPES.md)
- [PHPStan Implementation Guide](./PHPSTAN-IMPLEMENTATION-GUIDE.md)
- [Naming Conventions](./NAMING-CONVENTIONS.md)
- [Service Provider Best Practices](./SERVICE-PROVIDER-BEST-PRACTICES.md)
- [Filament Best Practices](./FILAMENT-BEST-PRACTICES.md)
