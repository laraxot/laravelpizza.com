---
title: "phpstan Seo fix"
type: note
tags: [documentation]
qmd: "phpstan Seo fix"
issues: []
discussions: []
id: phpstan-Seo-fix
slug: phpstan-Seo
scope: [module:Seo, project:base_workorder_fila5]
status: Done
priority: High
created: 2026-09-06
updated: 2026-09-07
---

## Problema
PHPStan errors in Modules/Seo (4, resurfaced after the 2026-09-06 22:05
phpstan.neon Larastan/Pest-extension regression — owner confirmed config
stays as-is).

## Solution
1. Analyze with phpstan -> 4 `method.nonObject` errors in `tests/TestCase.php`
   on `$this->app['config']->set(...)` (ArrayAccess on the container resolves
   to `mixed` without Larastan).
2. Fix: use the `config()` helper instead of `$this->app['config']` — Laravel's
   own conditional-return-type PHPDoc on the helper resolves to
   `Repository` without needing Larastan.
3. Verify: phpstan 0; phpmd (1 pre-existing non-actionable finding, see
   coverage.md); pest 35/47 passing — 12 pre-existing failures
   (`Target class [config] does not exist`), confirmed via `git stash`
   NOT caused by this fix, unrelated container/testbench issue.
4. Git sync: pending commit+push in this module's own repo.
