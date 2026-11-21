---
qmd: "adr pest testcase binding uses per file Pest.php modulo uses()->in TestCaseAlreadyInUse test-directory redundantLocalUse"
title: "ADR — Il TestCase di modulo si lega in ogni file di test, mai con uses()->in() nel Pest.php del modulo"
type: decision
module: Xot
tags: [adr, pest, test, testcase, phpstan]
created: 2026-11-19
updated: 2026-11-19
status: accepted
related:
  - ../../tests/Unit/ModulePestBootstrapDoesNotBindTestCaseTest.php
  - ../stories/sync-unrelated-histories-repair.story.md
  - ../../../Rating/docs/testing-and-coverage.md
---

# ADR: il TestCase si lega per file

## Contesto

I test di un modulo si lanciano in due modi, e i due leggono configurazioni diverse:

| Come | Quale `Pest.php` gira |
|---|---|
| `vendor/bin/pest Modules/<M>/tests/...` (runner di root, CI, `pest-scratch-db.sh`) | solo `laravel/tests/Pest.php` |
| `vendor/bin/pest --test-directory=Modules/<M>/tests ...` | quello del modulo |

Con un `uses(TestCase::class)->in('Feature', 'Unit')` nel `Pest.php` del modulo:
- col runner di root il binding **non avviene**: i test che usano metodi del TestCase
  (`$this->createTestUser()`, `mockService()`, ...) falliscono senza applicazione
  ("Target class [config] does not exist"), e nessuno se ne accorge finché non li si esegue;
- con `--test-directory` il binding si somma a quello dei file che lo dichiarano già:
  `TestCaseAlreadyInUse`, la suite non parte (Cms, Notify, Xot nella baseline del 2026-10-26);
- il plugin PHPStan di Pest legge il `Pest.php` del modulo e segnala come ridondanti
  (`pest.config.redundantLocalUse`) proprio i binding per file che servono.

Misurato il 2026-11-19: Cms, Tenant e Rating avevano quel binding; 53 file lo usavano senza legare
nulla. Tolto il binding dal `Pest.php` e aggiunto ai file, 110 test che non partivano passano.

## Decisione

- Ogni file di test che usa l'applicazione o i metodi del TestCase del modulo dichiara
  `uses(\Modules\<M>\Tests\TestCase::class);` (eventualmente con `->group(...)`).
- Il `Pest.php` di un modulo o tema contiene solo helper ed espansioni; mai `uses(...)->in(...)` né
  `pest()->extend(...)->in(...)`. Se gli helper servono al runner di root, li include
  `laravel/tests/Pest.php` con `require_once` (come Geo e Gdpr).
- Segnale in PHPStan: `Call to an undefined method PHPUnit\Framework\TestCase::<helper>()` in un test
  vuol dire che il file non lega il proprio TestCase.

## Alternative scartate

- **Binding solo nel `Pest.php` del modulo**: non gira col runner di root, che è quello usato da CI e
  dagli agenti.
- **Binding nel `laravel/tests/Pest.php` per cartella** (`uses(...)->in('../Modules/Cms/tests')`):
  un file di root che conosce ogni modulo, e torna il doppio binding con `--test-directory`.

## Guardia

`Modules/Xot/tests/Unit/ModulePestBootstrapDoesNotBindTestCaseTest.php` fallisce se un `Pest.php` di
modulo o tema torna a legare un TestCase.
