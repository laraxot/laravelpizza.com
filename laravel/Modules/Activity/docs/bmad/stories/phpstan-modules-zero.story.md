---
id: Activity/phpstan-modules-zero
title: "Azzerare PHPStan Modules/Activity"
status: done
epic: quality-gates
module: Activity
priority: P0
qmd: "Activity PHPStan zero errors Pest TestCase Assert audit log Actions Filament"
references:
  - ../stories/phpstan-conflict-markers-bootstrap.story.md
  - ../../wiki/phpstan-l10-coverage.md
  - ../../../../../../docs/sprint-status.yaml
  - ../../../../../../bashscripts/ai/wiki/memories/php-array-one-key-per-line.md
---

# Story — PHPStan Modules/Activity → 0

## Perché

Il gate PHPStan su `Modules/Activity` era a **151 file_errors** (inventario
`/tmp/phpstan_ptvx_fila5/modules/Activity.json`). Quasi tutti nei test: import
`TestCase`/`Assert` fuori posto dopo merge, Pest empty/redundant, cast
`(string)` su chiavi morph dell'audit log. Scopo del modulo: audit trail Spatie
+ Actions Queueable + UI Filament XotBase — i test devono tipizzare quel
contratto, non silenziare PHPStan.

Supersede il debito typing residuo di
[phpstan-conflict-markers-bootstrap](phpstan-conflict-markers-bootstrap.story.md)
(app già a 0).

## Acceptance criteria

- [x] `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Activity --no-progress` → **0 errori**
- [x] Nessun `@phpstan-ignore` / baseline
- [x] `mixed` non introdotto come scorciatoia; cast ciechi su `getKey()`/`id` rimossi
- [x] Array PHP una chiave per riga dove toccati
- [x] Lock `phpstan-activity` + unlock a fine
- [x] Docs/story aggiornate; status → done

## Lock

`bash bashscripts/lock/lock.sh phpstan-activity 60`

## Famiglie errori e decisioni (scopo)

| Famiglia | Scopo codice | Fix |
|----------|--------------|-----|
| `class.notFound` TestCase/Assert/User/ReflectionMethod | Bootstrap Pest sul modulo Activity (XotBaseTestCase) | `use` in cima; `Modules\Activity\Tests\TestCase`; `PHPUnit\Framework\Assert`; `Modules\User\Models\User` |
| `variable.undefined` `$logger`/`$activity` | Action/Adapter logger audit | Assegnazione + `execute()` prima delle assert sul record Activity |
| `cast.string` su `getKey()`/`subject_id` | Morph subject/causer dell'activity log | `assertSame` senza cast — stesse chiavi scritte da `LogModel*Action` |
| `pest.test.emptyClosure` | Listener auth + Snapshot/Policy | Assert su `handle` / tabella `snapshots` / `isInstantiable` |
| `pest.expectation.redundant` | Stesso pezzo con `toBeInstanceOf(new X)` | Reflection/`getTable` invece di instance-of ridondante |
| Harness `CanPaginate` | Paginazione Filament List log | Property trait: `defaultRecordsPerPageSelectOption` |

## File toccati (questa chiusura)

- `tests/Unit/Actions/LogModelCreatedActionTest.php`
- `tests/Unit/Actions/LogModelDeletedActionTest.php`
- `tests/Unit/Actions/LogModelUpdatedActionTest.php`
- `tests/Unit/Listeners/ActivityListenersTest.php`
- `tests/Unit/Models/OtherModelsTest.php`
- `tests/Unit/Models/Policies/ActivityPolicyTest.php` (già allineato in parallelo)

## Misura

- Iniziale (inventario): **151** file_errors
- Finale: **0**

## Pest gate

Host `192.168.1.40` (non production): suite Activity dipende da sqlite condiviso;
Pest non dichiarato verde qui — ripetere in ambiente testing con DB raggiungibile.

## Chiusura

PHPStan Activity **[OK] No errors** (2026-11-16). Unlock `phpstan-activity`.
