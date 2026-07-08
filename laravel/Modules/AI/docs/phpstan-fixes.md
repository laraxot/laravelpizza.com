# PHPStan Compliance — AI Module

**Last Updated**: 2026-06-13  
**Status**: ✅ Zero Errors  
**PHPStan Level**: max

## Issues Resolved

### 1. Test Base Class Import
- **File**: `tests/TestCase.php`
- **Issue**: Undefined `CreatesApplication` trait
- **Fix**: Added `use Orchestra\Testbench\Concerns\CreatesApplication;` to `Modules/Xot/tests/XotBaseTestCase.php`
- **Impact**: Resolved "unknown class" errors for test inheritance

### 2. Pest DSL Type Stubs
- **File**: `phpstan_constants.php` (bootstrap file)
- **Issue**: Pest functions (`expect()`, `it()`, `uses()`) not recognized by PHPStan
- **Fix**: Added type stubs in bootstrap file with proper return types:
  - `expect()` → `\Pest\Expectation\Expectation<T>`
  - `it()` → `\Pest\PendingCalls\TestCall`
  - `uses()` → `void`
- **Impact**: PHPStan now understands Pest DSL syntax

## Test Files (Pest Format)

- `tests/Unit/Actions/GeneratePredictionsActionTest.pest.php` — Pest format with proper type hints
- `tests/Unit/Actions/GeneratePredictionDraftsActionTest.php` — PHPUnit format (legacy)

## Validation

```bash
./vendor/bin/phpstan analyse Modules/AI
# Result: [OK] No errors
```

## Key Learning

Pest DSL is fully compatible with PHPStan when:
1. Bootstrap file provides type stubs
2. Test closures include type hints: `/** @var TestCase $this */`
3. `uses()` directive uses fully qualified class names

## Related Rules

- [PHPStan Sacred Configuration](../../docs/wiki/rules/phpstan-neon-sacred.md)
- [Pest DSL with PHPStan](../../docs/wiki/skills/pest-phpstan-compatibility.md)
