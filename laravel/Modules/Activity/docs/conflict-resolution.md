---
title: "Conflict resolution — Activity PHP markers"
type: troubleshooting
module: Activity
status: active
qmd: "Activity git conflict markers resolution PHPStan bootstrap QueueableAction Filament"
related:
  - ./bmad/stories/phpstan-conflict-markers-bootstrap.story.md
  - ./wiki/concepts/queueable-action-execute-entrypoint.md
  - ./wiki/concepts/schemas-tables-pattern.md
---

# Conflict resolution — Activity (PHP)

## Scopo

I marker `<<<<<<<` / `=======` / `>>>>>>>` nei PHP del modulo Activity
rompevano il bootstrap PHPStan. Risoluzione manuale per preservare audit log,
Actions Spatie Queueable e Filament XotBase.

## Esito

- Marker PHP: **0** in `app/` + `tests/` + `lang` PHP.
- `php -l` verde sui file toccati.
- PHPStan `Modules/Activity`: **0 errori su `app/`**; residui solo in test
  (typing Pest / harness, ~112) documentati nella story.

## Decisioni (perché)

| Area | Scelta |
|------|--------|
| LogModel*/LogUser* | Nullable + `execute(?T)` con fallback a proprietà |
| Activity model | Un body, `ActivityScopes` + `@method` + `typedQuery`/`typedGet` |
| Statistics | `typedQuery`/`typedGet` + normalize + cache `match` |
| Resources | Solo `$model` (Schemas/Tables discovery) |
| List pages | Thin (no getTable*) |
| Tables | Colonne complete + IDColumn; no filtri Restaurant |
| Adapter | `UserContract` (non `User` relativo al namespace Adapter) |

## Seconda ondata: test Pest con marker annidati

Il sync dei moduli condivisi (`bashscripts/git/subtrees/merge_remote_repo_2.sh`) ha rimesso marker
`<<<<<<<` annidati (fino a 8 livelli) in 10 test sotto `tests/Unit/`. In quasi tutti il lato "locale" era
vuoto o ridotto agli `use`, mentre il corpo del test stava nel lato remoto: la risoluzione corretta e' il
corpo completo, non un lato scelto alla cieca.

Regola di verifica: un test risolto e' buono solo se asserisce il comportamento della classe di produzione
**attuale** (`app/`), non quello di una versione precedente.

| File di test | Classe sotto test | Esito |
|--------------|-------------------|-------|
| `Actions/ActivityActionsUnitTest.php` | `ActivityMaintenanceAction`, `LogModel*Action`, `LogUser*Action` | corpo completo, verde |
| `Actions/Log/ListLogFilesActionTest.php` | `ListLogFilesAction`, `LogFileData` | corpo completo, verde |
| `Actions/Log/ResolveLogFilePathActionTest.php` | `ResolveLogFilePathAction` | verde |
| `Actions/QueryAndValidationTest.php` | `Query/*Action`, `ActivityLogger`, adapter | corretto: `TestCase::mockeryExpect()` (la funzione globale non esiste nelle run scoped sul modulo) e `with()` a 4 argomenti come `ActivityRecorder::record()` |
| `CanPaginateUnitTest.php` | trait `CanPaginate` + `CanPaginateHarness` | corpo completo, verde |
| `Filament/ListLogActivitiesDeepCoverageTest.php`, `Filament/ListLogActivitiesRemainingCoverageTest.php` | `ListLogActivities`, `ListLogActivitiesAction` | marker risolti; i test che scrivono su `activity_log` richiedono la tabella nel DB di test (vedi sotto) |
| `ListLogActivitiesPageCoverageTest.php` | `ListLogActivities` | verde |
| `Listeners/LogoutListenerTest.php` | `LogoutListener` | verde (un caso `skipped` dichiarato) |
| `Models/SnapshotBusinessLogicTest.php` | `Snapshot` | il caso "query builder methods documented" asseriva `@method` che `Snapshot` non dichiara piu': ora asserisce le `@property` delle colonne persistite |

### Limite ambientale noto

Nel DB `laravelpizza_data_test` manca la tabella `activity_log`. Ogni test che fa `Activity::create(...)`
fallisce con `SQLSTATE[42S02]`, compreso `Actions/CoverageHundredActionsTest.php`, che non ha mai avuto marker:
non dipende dalla risoluzione dei conflitti. Non si risolve con `RefreshDatabase` ne' con `migrate:fresh`
(dati sacri): serve applicare la migration `Activity` al DB di test in modo esplicito.

## Backlink

- Story: [phpstan-conflict-markers-bootstrap](./bmad/stories/phpstan-conflict-markers-bootstrap.story.md)
- Story: [01.activity-sync-marker-repair](./stories/01.activity-sync-marker-repair.story.md)
