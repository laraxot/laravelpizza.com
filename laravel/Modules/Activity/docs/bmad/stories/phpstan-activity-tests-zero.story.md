---
title: "PHPStan Modules/Activity → 0 errori (test audit log)"
status: done
epic: code-quality
module: Activity
priority: P1
acceptance_criteria:
  - phpstan analyse Modules/Activity → 0 errori
  - TestCase canónico Modules\Activity\Tests\TestCase
  - ActivityLogger/Actions e viewer/download esercitati senza silenziare
  - Diario swarm Xot aggiornato
references:
  - ../../../../Xot/docs/bmad/stories/phpstan-modules-swarm-random.story.md
  - ./phpstan-conflict-markers-bootstrap.story.md
  - ../../wiki/concepts/testing.md
type: story
tags: [activity, phpstan, pest, audit-log, bmad]
qmd: "activity phpstan zero errors tests TestCase ActivityLogger log viewer download"
---

# Story — PHPStan Activity tests a zero

## Perché

Activity è audit/event log (Spatie + Filament log viewer). Gli errori PHPStan
(~151, quasi tutti in `tests/`) bloccavano il gate di qualità del modulo senza
riflettere bug di produzione: TestCase FQCN corrotto, `use` dopo il codice,
expectation Filament obsolete, helper Pest non caricati.

Supersede parziale: residui test documentati in
`phpstan-conflict-markers-bootstrap.story.md` (~112 typing Pest/harness).
Link da: diario `Xot/docs/bmad/stories/phpstan-modules-swarm-random.story.md`,
indice BMAD Activity.

Istruzione utente: portare PHPStan Modules/Activity a 0 errori; verificare Pest
se possibile; aggiornare docs bmad modulo + diario Xot swarm.

## Cosa è stato corretto

| Causa | Fix |
|-------|-----|
| `Modules\Activity\Modules\Activity\Tests\TestCase` | → `Modules\Activity\Tests\TestCase` |
| `use Assert`/`User`/`TestCase` dopo `test()` | `use` in testa al file |
| LogModel* con `$activity` undefined / `$action` unused | execute + assert su event/subject/causer |
| `fixtures/CanPaginateHarness` `$defaultPerPageOption` | → `$defaultRecordsPerPageSelectOption` |
| `Pest.php` non caricava `Helpers.php` | `require_once Helpers.php` (`mockeryExpect`) |
| Coverage / PartialMock / Adapter senza bootstrap | `uses(TestCase::class)` |
| Colonne Snapshot/StoredEvent obsolete nel test | allineate alle Table reali (event sourcing) |

## Gate

- **PHPStan:** `cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Activity --error-format=raw --no-progress` → **0 errori**.
- **Pest:** host `192.168.1.40` (non production). Suite Activity con `DatabaseTransactions` su connessione `user` tenta TCP verso MySQL `10.100.200.53:3306` e resta in hang (`EINPROGRESS`). Creato `database/test_data.sqlite` via `xot:build-test-sqlite`. Pest completo **non dichiarato verde** finché `.env.testing` non punta `user` allo sqlite condiviso (o host MySQL raggiungibile).

## Lock

`bashscripts/lock/lock.sh laravel/Modules/Activity`


## Aggiornamento gate Modules (2026-11-16)

Supersede: residui dell’output utente `phpstan analyse Modules` (7 errori test Activity).
Link da: `docs/sprint-status.yaml` → `Activity/phpstan-modules-residual-7-tests`.
Istruzione utente (verbatim): paste dei 7 errori su LogModel*/Listeners/OtherModels/ActivityPolicyTest.

| Errore | Fix nel working tree |
|---|---|
| `assign.unused` / `variable.unused` LogModelCreated | execute + assert event/subject (niente `$action` morto) |
| `cast.string` LogModelDeleted/Updated | `assertIsString` + confronto, niente `(string)` su mixed |
| `pest.test.emptyClosure` LoginListener / Snapshot / SnapshotPolicy | assertion PHPUnit |
| regressione fixture `$incrementing` `@var list<string>` | `@var bool` + `$keyType = 'string'` |

Verifica: `phpstan analyse` sui 6 file → **[OK] No errors**.  
Pest Activity: hang bootstrap su MySQL `10.100.200.53` (conn `user`) — skip documentato; host `192.168.1.40`.