---
title: "PHPStan zero-error: modulo Media"
type: concept
tags: [phpstan, testing, pest]
created: 2026-06-10
updated: 2026-10-28
qmd: "media phpstan pest assert database helper"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/330"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/331"
related:
  - "phpstan.md"
  - "../../../../docs/wiki/troubleshooting/phpstan-test-assertion-chaining.md"
status: draft
---

# PHPStan zero-error: modulo Media

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Media
```

0 errori **codice** (eventuale warning ignore pattern in `phpstan.neon` → solo utente).

## Pattern test

| Anti-pattern | Fix |
|--------------|-----|
| `expect()->toBe()` | `Assert::assertSame()` |
| `$this->assertDatabaseHas` in closure Pest | `assertMediaTableHas()` in `MediaBusinessLogicTest.php` |
| `pest()->uses()` in `Pest.php` | `uses(TestCase::class)` per file; helper in `TestCase` (vedi Pest.php sotto) |
| `MediaCollection` fantasma | Rimosso da `Pest.php` |
| `method_exists` triviali | `ReflectionClass::hasMethod` o assert su API reale |

## Pest.php

Attenzione: Pest legge `Pest.php` da un solo percorso per run (la root), quindi le funzioni libere dichiarate in `Modules/Media/tests/Pest.php`
non sono garantite a runtime (incidente 2026-08-19: 23 test con `Call to undefined function`). Regola stabile a `1e279198`: nessuna funzione libera
nel `Pest.php` del modulo, helper come metodi statici di `Modules\Media\Tests\TestCase`. Il merge `af9cc1b0` ha riportato la versione con le funzioni
libere: vedi [phpstan-zero-errors-media.story.md](./stories/phpstan-zero-errors-media.story.md), "Decisioni aperte".

## Dopo un merge del daemon

Se PHPStan di colpo segnala centinaia di `class.notFound` con il nome della classe nel namespace del file (`...\Tables\SelectFilter`, `...\Pages\Config`),
non creare classi: mancano gli `use`. Il merge del daemon di auto-commit ricombina i corpi senza gli import. I `method.nonObject` a catena spariscono da soli.
Prima di correggere guarda cosa ha tolto: `git -C Modules/Media diff <merge-padre> HEAD --diff-filter=D --name-only` (classi, fixture, lang cancellati per errore).

## Tooling condiviso

```bash
php scripts/phpstan/fix-pest-tests.php Modules/Media/tests
```

## Story

STORY-304 · issue [#330](https://github.com/laraxot/base_fixcity_fila5/issues/330)
