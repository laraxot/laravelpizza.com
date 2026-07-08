---
title: "Activity TestCase Hierarchy Decision"
type: memory
module: Activity
tags: [testcase, architecture, decision, memory, pest, phpstan]
created: 2026-06-10
updated: 2026-06-10
qmd: "activity testcase xotbasetestcase decision nwidart missing base testcase"
status: "active"
priority: "high"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/316
discussions:
  - https://github.com/laraxot/base_fixcity_fila5/discussions/316
related:
  - ../concepts/testcase-hierarchy-architecture.md
  - ../../../../Xot/docs/wiki/rules/module-testcase-xotbase-hierarchy.md
---

# Activity TestCase Hierarchy Decision

## Rule

Use this hierarchy:

```text
Module tests/TestCase
  -> Modules\Xot\Tests\XotBaseTestCase
  -> Illuminate\Foundation\Testing\TestCase
```

Do not use `Nwidart\Modules\Tests\BaseTestCase` unless a future installed package version actually provides that class.

## Reason

The current package is `nwidart/laravel-modules v13.0.0`. The installed vendor tree does not contain `Nwidart\Modules\Tests\BaseTestCase`. A rule that references it is not architecture; it is a false memory.

## Activity Application

- `Activity/tests/TestCase.php` extends `XotBaseTestCase`.
- It keeps `DatabaseTransactions` locally.
- It keeps `mysql`, `activity`, and `user` in `$connectionsToTransact`.
- It returns `parent::getPackageProviders($app)` plus `UserServiceProvider` and `ActivityServiceProvider`.

## Pest Discipline

Tests stay Pest. Use Pest `uses(TestCase::class)` in test files. Do not convert Pest files to PHPUnit classes. If PHPStan reports Pest internals, fix typing/bridge/helper code without changing `phpstan.neon`.

## Checklist

- TestCase extends `XotBaseTestCase`.
- No direct module TestCase inheritance from Laravel base unless documented as an exception.
- No reference to non-existent Nwidart test base.
- Every model connection used by the module is listed in `$connectionsToTransact`.
- Provider list composes the parent provider list.
- PHPStan command runs from `laravel` and uses `phpstan.neon` unchanged.
