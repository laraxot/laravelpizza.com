---
title: "Activity TestCase Hierarchy Architecture"
type: concept
module: Activity
tags: [testcase, architecture, hierarchy, inheritance, testing, pest, phpstan]
created: 2026-06-10
updated: 2026-06-10
qmd: "activity testcase xotbasetestcase laravel modules pest phpstan hierarchy"
status: "active"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/316
discussions:
  - https://github.com/laraxot/base_fixcity_fila5/discussions/316
related:
  - ../../../../Xot/docs/wiki/rules/module-testcase-xotbase-hierarchy.md
  - ../../../tests/TestCase.php
  - ../../../tests/Pest.php
sources:
  - https://laravelmodules.com/docs/13/advanced/tests
  - https://github.com/nWidart/laravel-modules
---

# Activity TestCase Hierarchy Architecture

## Decision

`Modules\Activity\Tests\TestCase` extends `Modules\Xot\Tests\XotBaseTestCase`.

It must not extend `Nwidart\Modules\Tests\BaseTestCase` because that class is not present in the installed `nwidart/laravel-modules v13.0.0` package.

```text
Modules\Activity\Tests\TestCase
  -> Modules\Xot\Tests\XotBaseTestCase
  -> Illuminate\Foundation\Testing\TestCase
```

## Why

Activity needs Laraxot bootstrap from Xot, but must keep Activity-specific concerns local:

- `DatabaseTransactions` remains in Activity `TestCase`.
- `connectionsToTransact` explicitly includes `mysql`, `activity`, and `user`.
- Providers are composed with `parent::getPackageProviders($app)`, then `UserServiceProvider` and `ActivityServiceProvider`.

This keeps DRY/KISS without hiding module database boundaries.

## Verified Facts

- Official Laravel Modules v13 test docs show Pest usage through `uses(Tests\TestCase::class)` and `vendor/bin/pest`.
- Upstream `tests/BaseTestCase.php` (GitHub v13.0.0) extends Orchestra Testbench — dev-only, not in consumer autoload.
- Local vendor package has no autoloaded `Nwidart\Modules\Tests\BaseTestCase` class.
- The upstream test stubs use the application `Tests\TestCase`, not a package-provided test base.

## Anti-Patterns

- Extending `Illuminate\Foundation\Testing\TestCase` directly in module test cases duplicates Laraxot bootstrap.
- Extending a non-existent `Nwidart\Modules\Tests\BaseTestCase` creates `class.notFound` and runtime fatal errors.
- Moving Activity providers or Activity connections into `XotBaseTestCase` pollutes the platform layer.
- Replacing Pest files with PHPUnit classes violates the current test rule.

## Activity Pattern

```php
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
        'activity',
        'user',
    ];

    protected function getPackageProviders(mixed $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            ActivityServiceProvider::class,
        ];
    }
}
```

## Verification

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Activity/tests/TestCase.php Modules/Xot/tests/TestCase.php Modules/Xot/tests/XotBaseTestCase.php
./vendor/bin/pest Modules/Activity/tests --filter="Activity"
```
