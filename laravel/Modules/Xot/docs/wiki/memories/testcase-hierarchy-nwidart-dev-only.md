---
title: "nWidart Tests namespace is dev-only for app TestCase hierarchy"
type: memory
module: Xot
tags: [testing, testcase, nwidart, xotbase, composer, memory]
created: 2026-06-10
updated: 2026-06-10
qmd: "Nwidart Modules Tests BaseTestCase dev-only installed package XotBaseTestCase"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/33"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/34"
related:
  - ../rules/module-testcase-xotbase-hierarchy.md
  - ../../BRAINSTORM-TestCase-Hierarchy-XotBase-2026-06-10.md
---

# nWidart Tests namespace is dev-only

## Memory

Do not build Laraxot module TestCases on `Nwidart\Modules\Tests\BaseTestCase`.

The idea is attractive because the project uses `nwidart/laravel-modules`, but the installed package exposes `Nwidart\Modules\` from `src`, not upstream test classes.

**Nuance (2026-06-10 brainstorm):** `BaseTestCase.php` exists on GitHub at `tests/BaseTestCase.php` (v13.0.0) and extends Orchestra Testbench — it is for **package self-tests**, not app module tests. `composer.json` `autoload-dev` does not ship it to consumers.

## Correct durable rule

Use Xot as the application testing platform:

```text
Module TestCase -> Modules\Xot\Tests\XotBaseTestCase -> Illuminate\Foundation\Testing\TestCase
```

`XotBaseTestCase` may evolve when nWidart changes public testing support, but it must not depend on upstream dev-only namespaces.

## Investigation anchors

- GitHub source studied: `https://github.com/nWidart/laravel-modules`
- Official docs studied: `https://laravelmodules.com/docs/13/advanced/tests`
- Local package checked: `laravel/vendor/nwidart/laravel-modules/composer.json`
- GitHub tag v13.0.0: `tests/BaseTestCase.php` (Orchestra Testbench, dev-only)
- Brainstorm: [docs/chat/2026-06-10-testcase-brainstorm-activity-nwidart.md](../../../../../../docs/chat/2026-06-10-testcase-brainstorm-activity-nwidart.md)

## Practical implication

When refactoring module tests:

- replace direct Laravel base extension with `XotBaseTestCase`;
- keep `DatabaseTransactions` in module TestCase when the module needs transactions;
- call `parent::getPackageProviders($app)` and append module providers;
- do not add a fake or copied `Nwidart\Modules\Tests\BaseTestCase`.
