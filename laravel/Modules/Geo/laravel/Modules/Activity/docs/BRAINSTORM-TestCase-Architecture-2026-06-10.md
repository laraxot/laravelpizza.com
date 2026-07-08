---
title: "Brainstorm: TestCase Architecture for Laravel Modules"
date: 2026-06-10
objective: "Valutare se Modules/<Module>/tests/TestCase.php debba estendere XotBaseTestCase e se XotBaseTestCase debba estendere un BaseTestCase Nwidart"
status: "completed"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/316
discussions:
  - https://github.com/laraxot/base_fixcity_fila5/discussions/316
sources:
  - https://laravelmodules.com/docs/13/advanced/tests
  - https://github.com/nWidart/laravel-modules
---

# Brainstorm: TestCase Architecture for Laravel Modules

## Objective

Valutare la proposta:

```text
Modules/<Module>/tests/TestCase.php
  -> XotBaseTestCase
  -> Nwidart\Modules\Tests\BaseTestCase
```

## Facts First

- La documentazione ufficiale Laravel Modules v13 sui test mostra Pest con `uses(Tests\TestCase::class)` e runner `vendor/bin/pest`.
- Il package installato in `composer.lock` e' `nwidart/laravel-modules v13.0.0`.
- Nel vendor installato non esiste `Nwidart\Modules\Tests\BaseTestCase`.
- Gli stub test del package usano `Tests\TestCase`, non una base class Nwidart.

## Convergence

La parte corretta della proposta e': i TestCase dei moduli devono convergere su `Modules\Xot\Tests\XotBaseTestCase` per ridurre duplicazioni.

La parte da scartare e': far estendere `XotBaseTestCase` a `Nwidart\Modules\Tests\BaseTestCase`, perche' la classe non esiste nella versione installata.

## Canonical Hierarchy

```text
Modules/<Module>/tests/TestCase.php
  -> Modules\Xot\Tests\XotBaseTestCase
  -> Illuminate\Foundation\Testing\TestCase
```

## Layer Responsibilities

`XotBaseTestCase`:

- bootstrap Laraxot condiviso
- `CreatesApplication`
- provider Xot
- helper comuni
- cleanup connessioni

`Modules/<Module>/tests/TestCase.php`:

- `DatabaseTransactions` se serve
- `$connectionsToTransact`
- provider del modulo e dipendenze
- helper specifici del modulo

## Reverse Brainstorming

Come fallire:

- basarsi su una classe vendor non verificata
- mettere connessioni Activity dentro Xot
- usare `RefreshDatabase` o `migrate:fresh` in un DB condiviso
- convertire Pest in PHPUnit per aggirare PHPStan
- modificare `phpstan.neon` per nascondere errori

Inverso operativo:

- verificare vendor/composer prima di ogni regola architetturale
- tenere Xot base condiviso e moduli espliciti
- usare `DatabaseTransactions` con connessioni dichiarate
- mantenere Pest e correggere typing/helper
- lasciare `phpstan.neon` all'utente

## Action Taken

- `Modules/Activity/tests/TestCase.php` ora estende `XotBaseTestCase`.
- `Modules/Xot/tests/TestCase.php` ora estende `XotBaseTestCase`.
- `XotBaseTestCase` documenta che le transazioni appartengono ai TestCase dei moduli.
- PHPStan mirato sui tre file e' pulito usando `laravel/phpstan.neon`.

## Verification Command

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Activity/tests/TestCase.php Modules/Xot/tests/TestCase.php Modules/Xot/tests/XotBaseTestCase.php --error-format=raw --no-progress
```

## Full migration completed (2026-06-10)

All 16 `Modules/*/tests/TestCase.php` files now extend `XotBaseTestCase`.
Modules migrated: User, Geo, Media, UI, Lang, Notify, Gdpr, Job, Fixcity, Tenant, Seo, Rating.
See canonical rule: `Modules/Xot/docs/wiki/rules/module-testcase-xotbase-hierarchy.md`
PHPStan after migration: 0 parse errors, 0 pure prod errors.
