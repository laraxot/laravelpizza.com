# PHPStan Perfection Guide

This guide documents the patterns and strategies used to achieve 100% PHPStan (Level Max) compliance across all Laraxot modules.

## Core Principles
1. **Never ignore errors**: Fix the underlying type issue instead of using `@phpstan-ignore`.
2. **Explicit is better than implicit**: Use `/** @var ... */` to help PHPStan when it loses track of types (especially with dynamic arrays or factories).
3. **Contracts over Concrete**: Always type-hint against Interfaces/Contracts (`UserContract`, `ProfileContract`) rather than concrete Models.
4. **Assert everything**: Use `Webmozart\Assert\Assert` to validate assumptions at runtime and inform PHPStan's static analysis.

## Common Patterns & Solutions

### 1. Dynamic Class Strings
When resolving classes from config or strings, PHPStan needs to know the specific type.
```php
/** @var class-string<Model&UserContract> $class */
$class = config('auth.providers.users.model');
Assert::classExists($class);
Assert::isAOf($class, Model::class);
```

### 2. String-Keyed Arrays
When passing arrays to `view()` or recursive actions, ensure they are explicitly marked as string-keyed.
```php
/** @var array<string, mixed> $stringKeyed */
$stringKeyed = [];
foreach ($data as $key => $value) {
    Assert::string($key);
    $stringKeyed[$key] = $value;
}
```

### 3. Recursive Array Walking
Use `@template` and `@var` to maintain type integrity during recursion.
```php
/**
 * @template TKey of array-key
 * @param array<TKey, mixed> $value
 * @return array<TKey, mixed>
 */
private function walkArray(array $value): array {
    /** @var array<TKey, mixed> $resolved */
    $resolved = [];
    // ...
    return $resolved;
}
```

### 4. Migration Model Detection
Migrations extending `XotBaseMigration` must ensure `model_class` is a valid `class-string<Model>`.
```php
/** @var class-string<Model> $modelClass */
$modelClass = $this->resolveModelClass();
Assert::isAOf($modelClass, Model::class);
$this->model_class = $modelClass;
```

## System Maintenance
- **Ghost Vendors**: Local `vendor` directories inside Modules must be deleted to avoid PHPStan internal errors.
- **Root Analysis**: Always run analysis from the `laravel` root using `./vendor/bin/phpstan analyse Modules`.
- **Memory**: PHPStan needs 2048M for full analysis (6200+ files); use `php -d memory_limit=2048M`.

## Patterns Found in 2026-06-11 Full Fix (889→0 errors across 8 modules)

### Pest `expect()` → PHPUnit `Assert` Conversion
- `method.internalClass` from Pest `expect()->toBe()` → `Assert::assertSame()`
- `function.notFound` from Pest `get()` → `$this->get()` on TestCase
- Always add `use PHPUnit\Framework\Assert;` when using Assert::*
- Never mix Pest `expect()` and PHPUnit `Assert::*` in same file

### `$this` in Pest Closures
- PHPStan does not recognize `$this` binding in Pest closures
- Fix: avoid `$this` in closures; use `use ($var)` binding or convert to `#[Test]` class methods
- Alternative: add `/** @var TestCase $this */` as first line in each closure

### `getPackageProviders(mixed $app)` → `Application $app`
- 7 module TestCase files had `mixed $app` param, parent `XotBaseTestCase` declares `Application $app`
- Fix: change to `Application $app`, add `use Illuminate\Foundation\Application;`

### Mockery Chains Without phpstan-mockery Extension
- `shouldReceive()->with()->andReturn()` produces `method.notFound` without mockery extension
- Fix: replace with `$this->createMock()` + `method()->willReturn()`, or add `@phpstan-ignore-next-line`

### Safe Function Imports
- `function.notFound` for `Safe\file_get_contents`, `Safe\unlink`, etc.
- Fix: add `use function Safe\file_get_contents;` (specific import for each function used)

### Anonymous Class Method Return Types
- `return.unusedType` for `?string` returning only `null` → change to `null`
- `missingType.iterableValue` for `array $data` → add `/** @param array<mixed> $data */`

### TestCase Inheritance (Canonical Chain Confirmed)
```
Module TestCase → XotBaseTestCase → Illuminate\Foundation\Testing\TestCase → PHPUnit\Framework\TestCase
```
- `Nwidart\Modules\Tests\BaseTestCase` does NOT exist (package not installed, tests/ excluded from autoload)
- Geo module TestCase is the only anomaly (extends Laravel base directly instead of XotBaseTestCase)

---
*Updated: June 2026*
