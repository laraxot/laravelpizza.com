---
title: "Module TestCase XotBase Hierarchy"
type: concept
module: Xot
tags: [testing, pest, phpstan, laravel-modules, xotbasetestcase, architecture]
created: 2026-06-10
updated: 2026-06-11
qmd: "testcase xotbasetestcase nwidart laravel modules pest phpstan hierarchy"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/316
discussions:
  - https://github.com/laraxot/base_fixcity_fila5/discussions/316
related:
  - ../../testing/xot-base-testcase-rule.md
  - ../concepts/phpstan-pest-bridge-discipline.md
  - ../../../../Activity/docs/wiki/concepts/testcase-hierarchy-architecture.md
sources:
  - https://laravelmodules.com/docs/13/advanced/tests
  - https://github.com/nWidart/laravel-modules
---

# Module TestCase XotBase Hierarchy

## Decision

For this repository, module test cases use this hierarchy:

```text
Modules/<Module>/tests/TestCase.php
  -> Modules\Xot\Tests\XotBaseTestCase
  -> Illuminate\Foundation\Testing\TestCase
```

Do not make `XotBaseTestCase` extend `Nwidart\Modules\Tests\BaseTestCase` in the current codebase.

## Evidence

- Installed package: `nwidart/laravel-modules v13.0.0` from `laravel/composer.lock`.
- Local vendor tree has no `Nwidart\Modules\Tests\BaseTestCase` class under `vendor/nwidart/laravel-modules/src`.
- The package PSR-4 autoloads `Nwidart\Modules\` from `src`, so a missing `src/Tests/BaseTestCase.php` means the class is not available.
- Upstream v13 testing docs show Pest with `uses(Tests\TestCase::class)` and `vendor/bin/pest`; they do not require a Nwidart test base class.

## Responsibilities

`XotBaseTestCase` owns shared Laraxot bootstrap:

- `Modules\Xot\Tests\CreatesApplication`
- Xot service provider composition
- translator fallback for Filament-oriented tests
- shared helper methods
- teardown connection cleanup

The module `TestCase` owns module-specific behavior:

- `DatabaseTransactions` when transactional isolation is needed
- `$connectionsToTransact`
- module providers via `parent::getPackageProviders($app)` plus module dependencies
- module-specific fixtures or helpers

## Canonical Template

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\ServiceProvider;
use Modules\Example\Providers\ExampleServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var array<int, string> */
    protected $connectionsToTransact = [
        'mysql',
        'example',
    ];

    /**
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders(mixed $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            ExampleServiceProvider::class,
        ];
    }
}
```

## Pest Rule

Tests remain Pest. Prefer `uses(Modules\<Module>\Tests\TestCase::class)` in each Pest file. Avoid module-level `pest()->extend(...)->in(...)` when PHPStan reports Pest internal APIs as `method.internalClass`.

## PHPUnit config

Use only `laravel/phpunit.xml` from `laravel/`:

```bash
./vendor/bin/pest Modules/<Module>/tests/ --configuration phpunit.xml
```

See [phpunit-central-config-only.md](../rules/phpunit-central-config-only.md).

## Verification

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/<Module>/tests/TestCase.php Modules/Xot/tests/XotBaseTestCase.php
./vendor/bin/pest Modules/<Module>/tests --configuration phpunit.xml --filter="relevant test"
```
