---
title: "Module TestCase must extend XotBaseTestCase"
type: rule
module: Xot
tags: [testing, testcase, xotbase, nwidart, modules, pest]
created: 2026-06-10
updated: 2026-06-11
reverified: 2026-06-11
status: enforced
qmd: "module tests TestCase extends XotBaseTestCase nwidart Tests BaseTestCase dev-only"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/33"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/34"
related:
  - ../memories/testcase-hierarchy-nwidart-dev-only.md
  - ../concepts/unit-test-case-pattern.md
  - ../../BRAINSTORM-TestCase-Hierarchy-XotBase-2026-06-10.md
---

# Module TestCase must extend XotBaseTestCase

## Rule

Every module integration TestCase should extend `Modules\Xot\Tests\XotBaseTestCase`, not `Illuminate\Foundation\Testing\TestCase` directly.

Canonical hierarchy:

```text
Modules/<Module>/tests/TestCase.php
  -> Modules\Xot\Tests\XotBaseTestCase
  -> Illuminate\Foundation\Testing\TestCase
```

Do not extend `Nwidart\Modules\Tests\BaseTestCase`. Investigation confirmed:
- nWidart v13.0.0 does NOT autoload its `tests/` directory
- `Nwidart\Modules\Tests\BaseTestCase` exists only as a dev-only internal class
- `find vendor/nwidart -name 'BaseTestCase.php'` returns no results
- Official docs (`laravelmodules.com/docs/13/advanced/tests`) describe only `phpunit.xml` config, not a public base class

If nWidart ever publishes a stable autoloaded `BaseTestCase`, revisit this rule. Until then, `XotBaseTestCase` is the canonical boundary.

## Why

`XotBaseTestCase` is the project platform layer for tests. It owns shared app bootstrap, Xot provider setup, translator binding, teardown connection cleanup and reusable helpers.

Module `tests/TestCase.php` files should contain only module-specific details:

- module provider registrations;
- extra dependency providers;
- `$connectionsToTransact`;
- module config overrides;
- module-specific helpers and fixtures.

## nWidart v13 evidence

Official nWidart v13 docs describe adding module test folders to `phpunit.xml` and using Pest with a TestCase class, but they do not document an app-consumable `Nwidart\Modules\Tests\BaseTestCase`.

The installed package in this repo autoloads:

```json
{
  "Nwidart\\Modules\\": "src"
}
```

The upstream package has `Nwidart\Modules\Tests\*` only as development test namespace. Composer install does not make it available for Laraxot module TestCases.

## Allowed variants

Pure unit tests that intentionally avoid DB transactions may use a local `UnitTestCase`, but it should still use the Xot bootstrap discipline. See `../concepts/unit-test-case-pattern.md`.

## Migration status (2026-06-10)

**16/16** `Modules/*/tests/TestCase.php` con `TestCase.php` presente estendono `XotBaseTestCase` (Geo allineato 2026-06-10).

Moduli senza `tests/TestCase.php` dedicato (Blog, AI): usano Pest `uses()` o test leggeri — vedi skill `module-testcase-xotbase-hierarchy`.

Key changes per modulo allineato:
- Removed `use CreatesApplication;` (inherited from `XotBaseTestCase`)
- Removed `use Modules\Xot\Providers\XotServiceProvider;` (registered in parent)
- Changed `getPackageProviders($app)` to `getPackageProviders(Application $app)` with `...parent::getPackageProviders($app)`
- Added `use Illuminate\Foundation\Application;` import
- Rating: replaced app-level `Tests\CreatesApplication` with `XotBaseTestCase`

## Anti-pattern

```php
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
```

This bypasses the shared platform layer and duplicates setup across modules.

## Correct pattern

```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\XotBaseTestCase;

abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            ModuleServiceProvider::class,
        ];
    }
}
```
