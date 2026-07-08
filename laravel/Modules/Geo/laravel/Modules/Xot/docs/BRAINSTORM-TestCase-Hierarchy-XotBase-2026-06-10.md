---
title: "Brainstorm: TestCase hierarchy with XotBaseTestCase"
type: brainstorm
module: Xot
created: 2026-06-10
updated: 2026-06-10
status: completed
tags: [bmad, brainstorm, testcase, xotbase, nwidart, modules, completed]
qmd: "brainstorm testcase hierarchy xotbase nwidart modules tests"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/33"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/34"
related:
  - ./wiki/rules/module-testcase-xotbase-hierarchy.md
  - ./wiki/memories/testcase-hierarchy-nwidart-dev-only.md
---

# Brainstorm: TestCase hierarchy with XotBaseTestCase

## Objective

Decide the correct inheritance rule for `laravel/Modules/<Module>/tests/TestCase.php` after studying nWidart Laravel Modules v13 and the current Laraxot code.

## User Hypothesis (2026-06-10)

> _"Modules/<Module>/tests/TestCase.php should extend XotBaseTestCase, and XotBaseTestCase should extend Nwidart\Modules\Tests\BaseTestCase"_

### Investigation

Deep investigation of nWidart/laravel-modules v13.0.0 (installed locally + GitHub source):

1. **nWidart v13 docs** (`laravelmodules.com/docs/13/advanced/tests`): describes only `phpunit.xml` wildcard config for module test discovery. No `BaseTestCase` mentioned as public API.
2. **Composer autoload** in installed package (`vendor/nwidart/laravel-modules/composer.json`):
   ```json
   { "Nwidart\\Modules\\": "src" }
   ```
   No `tests/` directory is autoloaded. The `Nwidart\Modules\Tests\*` namespace exists only for the package's own internal test suite.
3. **`find vendor/nwidart -name 'BaseTestCase.php'`** → no results.
4. **Conclusion**: `Nwidart\Modules\Tests\BaseTestCase` is NOT available as app-consumable code. The user hypothesis is architecturally sound in intent but technically impossible with the current installed package version.

### If nWidart ever exports BaseTestCase

Should nWidart publish a stable, autoloaded `BaseTestCase`, the hierarchy could become:

```text
Modules/<Module>/tests/TestCase.php
  -> Modules\Xot\Tests\XotBaseTestCase
  -> Nwidart\Modules\Tests\BaseTestCase   (future, if published)
  -> Illuminate\Foundation\Testing\TestCase
```

This is tracked in `../wiki/memories/testcase-hierarchy-nwidart-dev-only.md`.

## Selected techniques

1. 5 Whys: find the real reason for a shared module TestCase.
2. Reverse brainstorming: identify how this rule can fail.
3. SCAMPER: refine the hierarchy without adding unnecessary layers.

## 5 Whys

Problem: module TestCases extend different base classes.

1. Why? Some modules copied Laravel's default `Tests\TestCase` pattern.
2. Why is that a problem? Shared setup is duplicated or missing.
3. Why centralize it? Xot owns Laraxot platform bootstrap and common helpers.
4. Why not use nWidart's test namespace? It is not exposed by the installed package autoload.
5. Why keep Xot as the boundary? It protects app code from upstream dev-only internals.

Root cause: the project needs an app-owned testing platform layer, not a direct dependency on framework or package internals.

## Reverse brainstorming

Ways to make this fail:

- Extend `Illuminate\Foundation\Testing\TestCase` directly in every module.
- Pretend `Nwidart\Modules\Tests\BaseTestCase` is public API even when Composer does not autoload it.
- Put module-specific providers into XotBaseTestCase.
- Put DB transactions into pure unit test bases that do not need a database.
- Update docs without indexes, logs or QMD ingest.

Inverted principles:

- Module TestCases extend `XotBaseTestCase`.
- XotBaseTestCase extends Laravel's testing base until nWidart publishes a public test base.
- XotBaseTestCase is platform-only.
- Module TestCases own module providers and connections.
- Docs live in Xot wiki and are linked from Activity docs when Activity is only a consumer.

## SCAMPER

- Substitute: replace direct Laravel base in modules with `XotBaseTestCase`.
- Combine: keep Laravel app bootstrap and Xot provider setup in one Xot-owned base.
- Adapt: follow nWidart docs for module test discovery, not for a non-public base class.
- Modify: keep `DatabaseTransactions` in module TestCases when needed instead of forcing it into every base.
- Eliminate: remove the false "XotBaseTestCase extends Nwidart Tests BaseTestCase" assumption.
- Reverse: do not let Activity define the global rule; Xot defines it, Activity consumes it.

## Decision

Canonical hierarchy:

```text
Modules/<Module>/tests/TestCase.php
  -> Modules\Xot\Tests\XotBaseTestCase
  -> Illuminate\Foundation\Testing\TestCase
```

`Nwidart\Modules\Tests\BaseTestCase` is not part of the app hierarchy because it is not available in the installed package.

## Migration Status (2026-06-10) ✅ COMPLETED

All 16 module TestCase files now extend `XotBaseTestCase`.

| Module | Before | After |
|--------|--------|-------|
| Activity | XotBaseTestCase | ✅ (already correct) |
| Cms | XotBaseTestCase | ✅ (already correct) |
| Comment | XotBaseTestCase | ✅ (already correct) |
| Xot | XotBaseTestCase | ✅ (already correct) |
| User | BaseTestCase | ✅ migrated |
| Geo | BaseTestCase | ✅ migrated |
| Media | BaseTestCase | ✅ migrated |
| UI | BaseTestCase | ✅ migrated |
| Lang | BaseTestCase | ✅ migrated |
| Notify | BaseTestCase | ✅ migrated |
| Gdpr | BaseTestCase | ✅ migrated |
| Job | BaseTestCase | ✅ migrated |
| Fixcity | BaseTestCase | ✅ migrated |
| Tenant | BaseTestCase | ✅ migrated |
| Seo | BaseTestCase | ✅ migrated |
| Rating | Tests\CreatesApplication (app) | ✅ migrated |

### Migration pattern applied

```php
// BEFORE (anti-pattern)
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    // ...
    protected function getPackageProviders($app): array { return [XotServiceProvider::class, ...]; }
}

// AFTER (canonical)
use Modules\Xot\Tests\XotBaseTestCase;
abstract class TestCase extends XotBaseTestCase
{
    // ...
    protected function getPackageProviders(mixed $app): array {
        return [...parent::getPackageProviders($app), ModuleServiceProvider::class];
    }
}
```

### PHPStan result after migration
- Parse errors: **0**
- Pure prod errors: **0**
- Total: **0** (excluding test files)
