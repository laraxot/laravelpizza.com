# Type Safety Refactoring: Elimination of `mixed` Types

**Session Date**: 2026-09-04  
**Status**: In Progress (Phase 2/5 Complete, Phases 3-5 In Progress)  
**Target**: Achieve 100% type safety across all Modules by replacing `mixed` with proper type hints

## Overview

This document tracks the systematic elimination of `mixed` type usage across Laravel Modules to improve type safety and enable PHPStan Level 10 compliance.

## Executive Summary

### Completed Work

**Phase 1: Discovery & Analysis**
- Identified 36 files across Modules with `mixed` usage
- Categorized by type: parameter types, return types, docblocks, collection items
- Found 4 occurrences in User module (all fixable)
- Found 21 occurrences in Xot module (9 fixable, 12 architectural/API)

**Phase 2: User Module (COMPLETE)**
- Fixed 4 occurrences of `mixed`
- Changes:
  - `Confirm.php:26` - `render(): mixed` → `render(): View`
  - `ChangePasswordAction.php:46` - Filament callback extraction with type narrowing
  - `ChangePasswordHeaderAction.php:60` - Same pattern
  - `ChangeProfilePasswordAction.php:73` - Same pattern with array type documentation

### Key Patterns Established

#### Pattern 1: External API Callbacks (Filament)

**Problem**: Filament's `$get` callable returns `mixed` because it's a generic field accessor.

**Solution**: Extract callback to named function with explicit type assertion in docblock:

```php
// Before
->rule('required', /** @param callable(string): mixed $get */
    static fn (callable $get): bool => (bool) $get('new_password')
)

// After
->rule('required',
    static function (callable $get): bool {
        $newPassword = $get('new_password');
        /** @var string|null $newPassword */
        return (bool) $newPassword;
    }
)
```

**Why**: Makes intent clear, enables PHPStan to understand the narrowed type, improves readability.

#### Pattern 2: View Rendering Methods

**Problem**: Livewire `render()` methods declared as `mixed` instead of `View`.

**Solution**: Use `Illuminate\Contracts\View\View` return type.

```php
use Illuminate\Contracts\View\View;

public function render(): View
```

#### Pattern 3: Magic Methods (PHP Requirement)

**Exception**: `__call()`, `__get()`, `__set()`, etc. MUST return `mixed` per PHP specification.

```php
// Required by PHP - DO NOT CHANGE
public function __call(string $name, array $parameters): mixed
```

#### Pattern 4: Polymorphic Data Accessors

**Architectural**: Methods that access schemaless/dynamic data inherently need `mixed` for the values they return.

**Solution**: Document why polymorphism exists, use union types where possible, add assertions for narrowing:

```php
/**
 * Retrieves a schemaless attribute value.
 * Values can be any JSON-serializable type.
 *
 * @param  mixed  $default  Default value if attribute doesn't exist
 * @return string|int|bool|array|null The attribute value or default
 */
public function getExtraAttribute(string $key, mixed $default = null): string|int|bool|array|null
```

## Modules Status

| Module | Total Mixed | Fixable | Architecture | Status |
|--------|------------|---------|--------------|--------|
| User | 4 | 4 | - | ✅ COMPLETE |
| Xot | 21 | 9 | 12 | 🔄 IN PROGRESS |
| Seo | 4 | 4 | - | ⏳ PENDING |
| Notify | 7 | 5 | 2 | ⏳ PENDING |
| Geo | 4 | 4 | - | ⏳ PENDING |
| Lang | 3 | 3 | - | ⏳ PENDING |
| Cms | 1 | 1 | - | ⏳ PENDING |
| Job | 1 | 1 | - | ⏳ PENDING |

## Type Narrowing Reference

### Webmozart\Assert Usage

Available assertions for narrowing types:

```php
use Webmozart\Assert\Assert;

// Usage examples
Assert::isInstanceOf($value, UserContract::class);
Assert::isString($value);
Assert::isArray($value);
Assert::isInt($value);
Assert::isBool($value);
Assert::isCallable($value);
Assert::implementsInterface($value, ContractName::class);
```

### Union Types for Narrowing

Instead of `mixed`, use union types:

```php
// Instead of
public function getValue(mixed $data): mixed

// Use
public function getValue(string|array $data): string|int|bool|array|null
```

### Contracts for Model Types

Instead of concrete model classes or `mixed`, use contracts:

```php
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Contracts\ProfileContract;

public function process(UserContract $user): void
```

## Contract System

Available contracts at `Modules/Xot/app/Contracts/`:

- **Core Domain**: `UserContract`, `ProfileContract`
- **Model Behaviors**: `ModelContract`, `ModelWithAuthorContract`, `ModelWithUserContract`
- **Relations**: `HasRecursiveRelationshipsContract`, `MorphToOneRelationContract`
- **Features**: `StateContract`, `WithStateStatusContract`, `ExtraContract`

## Testing & Verification

### PHPStan Analysis

```bash
# Analyze single module
./vendor/bin/phpstan analyse Modules/User --memory-limit=-1

# Analyze specific file
./vendor/bin/phpstan analyse Modules/User/app/Http/Livewire/Auth/Passwords/Confirm.php --memory-limit=-1
```

### Test Coverage

Run module tests after changes:

```bash
./vendor/bin/pest Modules/User/tests -c Modules/User/phpunit.xml --no-coverage
```

## Remaining Work

### Phase 3: Xot Module Fixes

Priority fixes:
1. `HasSchemalessAttributes::getExtraAttribute()` - narrow return type
2. `HasXotTable::invokeTableHook()` - document/narrow return
3. `MeasureAction::execute()` - document closure returns
4. `GetCurrentRouteViewAction` map - narrow to string
5. `ExportXlsLazyAction` mapping - narrow row/return types

### Phase 4: Other Modules (Seo, Notify, Geo, Lang, Cms, Job)

Apply same narrowing patterns for standard data accessors and utilities.

### Phase 5: Documentation & Patterns

Create reusable patterns library documenting:
- Generic data accessor types
- Callback type narrowing
- Collection item typing
- Utility method polymorphism

## Session Commits

- [PENDING] User module type safety fixes (4 occurrences)
- [PENDING] Xot module type safety fixes (9 occurrences)
- [PENDING] Remaining modules (14 occurrences)

## Notes

- Do NOT change PHP magic method signatures
- Do NOT modify external API contracts
- Use Webmozart\Assert for runtime type narrowing where needed
- Prefer explicit type hints over type casts
- Document architectural reasons for polymorphism
- Keep methods under 40 lines for clarity

## References

- PHPStan Documentation: https://phpstan.org/
- Webmozart\Assert: https://github.com/webmozart/assert
- Laravel Type Hints: https://laravel.com/docs/validation#available-validation-rules
