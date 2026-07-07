---
title: "Pest uses() — FQCN obbligatorio (Geo)"
type: rule
tags: [pest, phpstan, geo, testcase, fqcn]
created: 2026-06-12
updated: 2026-06-12
qmd: "Geo Pest uses TestCase LightTestCase FQCN PHPStan class not found namespaced"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/354"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/355"
related:
  - ../../../../docs/wiki/rules/testing-modules-pest.md
  - ../../../../docs/wiki/PHPSTAN-INDEX.md
  - ../../../Xot/docs/wiki/rules/module-testcase-xotbase-hierarchy.md
---

# Pest `uses()` — FQCN obbligatorio

## Problema

In file con `namespace Modules\Geo\Tests\Unit\...`, PHPStan risolve:

```php
uses(TestCase::class);  // ❌ → Modules\Geo\Tests\Unit\Actions\TestCase
```

anche se esiste `use Modules\Geo\Tests\TestCase`.

## Regola

```php
uses(\Modules\Geo\Tests\TestCase::class);
uses(\Modules\Geo\Tests\LightTestCase::class);
uses(\Modules\Geo\Tests\UnitTestCase::class);
```

## `Pest.php` modulo

- **Vietato** `uses()->in()` (PHPStan `method.internalClass`).
- Ogni file test dichiara il proprio `uses()` FQCN.
- Pattern: `Modules/Cms/tests/Pest.php`, `Modules/Comment/tests/Pest.php`.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Geo
```
