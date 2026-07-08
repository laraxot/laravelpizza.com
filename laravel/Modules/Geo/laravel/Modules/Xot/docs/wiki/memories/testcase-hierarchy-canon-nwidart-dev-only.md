---
title: "TestCase Hierarchy — Canon (nWidart BaseTestCase dev-only)"
type: memory
tags: [testcase, xotbase, nwidart, laravel-modules, hierarchy]
created: 2026-06-12
updated: 2026-06-12
qmd_id: TestcaseHierarchyCanonNwidartDevOnly
related:
  - module-testcase-xotbase-hierarchy.md
  - ../../tests/TestCase.php
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/33"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/34"
---

# TestCase Hierarchy — Canon (nWidart BaseTestCase dev-only)

## TL;DR

Laraxot modules extend XotBaseTestCase, which extends Illuminate\Foundation\Testing\TestCase.

**DO NOT** extend `Nwidart\Modules\Tests\BaseTestCase` — it's for self-testing the nwidart/laravel-modules package, not for Laraxot app modules.

## Gerarchia canonica

```text
Modules/<Module>/tests/TestCase.php
  ↓ extends
Modules\Xot\Tests\XotBaseTestCase
  ↓ extends
Illuminate\Foundation\Testing\TestCase
```

## Verifica nWidart Vendor

After `composer install`:
- `vendor/nwidart/laravel-modules/tests/` — **does NOT exist**
- `vendor/nwidart/laravel-modules/src/` — contains `Nwidart\Modules\`
- `autoload-dev` → `Nwidart\Modules\Tests\` — **not distributed to consumers**

nWidart's own `tests/BaseTestCase.php` uses:
- Orchestra Testbench (package self-testing)
- sqlite `:memory:` (isolated testing)
- `migrate:reset` in setup (unsafe for Laraxot)

## Perché XotBaseTestCase è corretto

| Aspetto | nWidart (dev) | XotBaseTestCase (production) |
|---------|---|---|
| Parent | Orchestra Testbench | Illuminate\Foundation\Testing\TestCase |
| Database | sqlite `:memory:` | MySQL `.env.testing` |
| Setup | `migrate:reset` | `DatabaseTransactions` |
| Scope | Package self-test | Multi-modulo app with Tenant, Xot providers |
| Intention | Test the framework | Test Laraxot business logic |

XotBaseTestCase **is** the Laraxot platform layer for testing — not a wrapper trying to import nWidart's dev tooling.

## Documentation Upstream

[laravelmodules.com/docs/13/advanced/tests](https://laravelmodules.com/docs/13/advanced/tests):

> Use `phpunit.xml` with wildcard `Modules/*/tests` and Pest with `uses(Tests\TestCase::class)`.
> 
> (No mention of extending nWidart BaseTestCase — because it's not API.)

## Audit (16/16 modules)

All Laraxot modules (as of 2026-06-10) extend XotBaseTestCase correctly:
- Activity, Blog, Comment, Cms, Fixcity, Gdpr, Geo, Job, JobBatch, Lang, Media, Notify, Rating, Tenant, UI, User, Xot

## Revisit Only If

nWidart publishes `BaseTestCase` in `autoload` (not `autoload-dev`) with a public API contract in their docs.

Current status: **dev-only, not API, do not adopt.**

## Related

- [module-testcase-xotbase-hierarchy.md](./rules/module-testcase-xotbase-hierarchy.md) — rule
- [../../Activity/docs/wiki/concepts/testcase-hierarchy-architecture.md](../../Activity/docs/wiki/concepts/testcase-hierarchy-architecture.md) — module example
- Brainstorm: [../../../docs/chat/testcase-xotbase-vs-nwidart-brainstorm.md](../../../docs/chat/testcase-xotbase-vs-nwidart-brainstorm.md)
