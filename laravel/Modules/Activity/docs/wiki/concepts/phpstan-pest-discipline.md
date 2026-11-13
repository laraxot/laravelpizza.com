---
title: "Activity PHPStan Pest Discipline"
type: concept
module: Activity
tags: [activity, phpstan, pest, testing, second-brain]
created: 2026-06-10
updated: 2026-06-13
qmd: "Activity phpstan pest discipline requirePage createUnitMock skipTest namespace uses fqcn"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/328"
  - "https://github.com/laraxot/module_activity_fila5/issues/15"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/329"
  - "https://github.com/laraxot/module_activity_fila5/discussions/16"
related:
  - ../../../../../../docs/wiki/rules/phpstan-pest-tests-stay-pest.md
  - ../../../../../../docs/wiki/troubleshooting/phpstan-test-assertion-chaining.md
---

# Activity PHPStan Pest Discipline

Activity partecipa alla campagna `cd laravel && ./vendor/bin/phpstan analyse Modules` con una regola stretta:

- eseguire PHPStan sempre dal root Laravel: `cd laravel && ./vendor/bin/phpstan analyse Modules/Activity` oppure, a fine swarm, `cd laravel && ./vendor/bin/phpstan analyse Modules`;
- non eseguire PHPStan da dentro `Modules/Activity` e non usare eventuali config di modulo;
- non modificare, creare o rigenerare `phpstan*.neon`: `laravel/phpstan.neon` e' gestito solo dall'utente;
- non convertire test Pest in classi PHPUnit;
- correggere gli errori PHPStan nei test usando file Pest, helper tipizzati, bridge o assertion pubbliche dentro closure Pest;
- per proprietà nullable su `TestCase` (es. `$page`) usare accessor `requirePage(): ListLogActivities` invece di `$this->page->…` nelle closure;
- policy test: `namespace Modules\Activity\Tests\Unit` + `uses(\Modules\Activity\Tests\TestCase::class)` + `@var TestCase $this` + `createUnitMock()` (non `createMock()`);
- skip condizionale: `$this->skipTest('…')` via wrapper public su `XotBaseTestCase` (non `markTestSkipped()` diretto);
- documentare ogni pattern riusabile nel wiki locale e, quando lo scope lo consente, nella chat agenti.

## Pattern operativo

```php
use PHPUnit\Framework\Assert;

test('activity row is produced', function (): void {
    $event = 'created';

    Assert::assertSame('created', $event);
});
```

Il runner, la discovery e la semantica restano Pest. `Assert::assert*()` e' solo API pubblica di assertion quando PHPStan non riesce a tipizzare la DSL `expect()`.

## Anti-pattern

- `final class ... extends TestCase` per sostituire un file Pest.
- `pest()->extend(...)` o catene su oggetti interni Pest quando PHPStan le segnala come `method.internalClass`.
- nuove ignore o baseline PHPStan.

## Pattern PHPStan L10 osservati

- `namespace` deve arrivare subito dopo `declare(strict_types=1);`; import e `uses(TestCase::class)` vanno dopo il namespace.
- Nei file Pest usare `describe()` per contenitori logici e `test()` per casi eseguibili. Evitare `test()` annidati dentro altri `test()`.
- Per fixture in-memory condivise preferire helper locali tipizzati con array-shape invece di stato su `$this` quando PHPStan non riesce a risolvere il binding Pest.
- Se un test deve usare il TestCase del modulo, importare solo `Modules\Activity\Tests\TestCase`; non duplicare con `Tests\TestCase`.

## Verifica 2026-06-13 (gate chef)

- `cd laravel && ./vendor/bin/phpstan analyse Modules` → **[OK] No errors** (6275 file, include Activity).
- Fix batch su 7 file `tests/Unit/Actions/`: rimosso `expect()->toBe*()` / `toHaveCount` / `->throws()`; sostituito con `PHPUnit\Framework\Assert` e try/catch per eccezioni.
- `UserFactory::new()->createOne()` al posto di `make()` dove il costruttore Action richiede `User` o `Model` non-null.
- Eccezione attesa: **non** usare `test(...)->throws()` — PHPStan vede `test()` come `void` (`function.void`, `method.nonObject`).
- Overview modulo: [overviews/completion-status.md](../overviews/completion-status.md).

## Verifica 2026-06-10

- `cd laravel && ./vendor/bin/phpstan analyse Modules/Activity` passa con `[OK] No errors`.
- Pest sui file Activity toccati e' stato eseguito, ma l'ambiente locale blocca il bootstrap Laravel con `PDOException SQLSTATE[HY000] [1045] Access denied for user 'forge_mysql_25_1'@'localhost'` prima delle assertion.