---
title: "[DEV] PHPStan a zero su Modules/Activity"
type: dev-story
status: done
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, activity, rebase, log-viewer]
---
# Dev story: PHPStan a zero su Modules/Activity

Storia: [phpstan-zero-errors-activity.story.md](./phpstan-zero-errors-activity.story.md).

## Metodo
1. `git -C laravel/Modules/Activity status/log/show/diff` (sola lettura): HEAD detached in rebase, `36463864` = auto-commit di un conflitto.
2. `git archive 7083148f` in scratchpad per leggere il modulo com'era prima del rebase (nessuna copia cieca nel working tree).
3. Per ogni gruppo di errori: causa → classe/funzione attesa → riscritta sullo stato corrente.

## Gruppi di errori → fix
| Errori | Causa | Fix |
|---|---|---|
| 43 `Adapters\ActivityLogger` | file cancellato dal rebase | `app/Adapters/ActivityLogger.php` rimesso (coordinatore: delega alle Action con costruttore) |
| 86+25+8 LogViewer / `BuildLogViewerStateAction` / `LogViewerStateData` | 9 Action `Log/`, 6 Data, `InvalidLogFileException`, `Pages/LogViewer` cancellati | rimessi; aggiunti `lang/{it,en}/log_viewer.php` e la pagina Folio di download (senza, la pagina mostrava chiavi grezze e il download dava 404) |
| ~110 nei due `ListLogActivities*CoverageTest` + parte di `CoverageHundredActionsTest` (`ListLogActivitiesPageHarness`, `ActivitySubjectHarness`, ...) | 19 fixture cancellate | rimesse in `tests/Fixtures/` (page harness che espone i metodi privati via `ReflectionMethod`, subject con/senza `activities()`, risorsa `canRestore` controllabile, Action `RestoreActivityAction` no-op/che fallisce) |
| `new.noConstructor`, `arguments.count` (Action `LogModel*`, `LogUser*`) | Action tornate a `execute($model)` | costruttore `(?Model $model, ?Model $user)` + `execute(?Model $model = null)`; `LogUser*` con `UserContract` |
| `json_encode` unsafe, `return.type` (`ListLogActivities`) | `use function Safe\json_encode` perso | import ripristinato |
| `mixed` in `EventSourcingBusinessLogicTest` | i dati arrivano da `(object) $array` | narrowing esplicito dei dati nei test, non cast |
| `HasFactory`/`Factory` in `TestActivityModel` | `use` persi | ripristinati |
| (regressione trovata leggendo i diff) | `LogActivityAction`/`Actions\ActivityLogger` con classe concreta `User`; `created/updated/deleted` ignoravano `$user` | `UserContract` (come da `decision-log.md` 2026-10-08), `$user` passato alle Action |

## Regola da ricordare
Se un modulo ha centinaia di `class.notFound` e il suo repo mostra `rebase in progress`, **non riscrivere i test**: guarda `git status` del modulo e
`git diff <onto> HEAD --name-status`. Un albero uguale a `onto` (`git diff <orig-head> <onto>` vuoto) dice qual e' lo stato corretto da raggiungere.

## Verifiche
- `php -l` sui file toccati: pulito.
- `./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1 --no-progress --error-format=raw`: 0 errori.
- Pest: non eseguito (`.env.testing` = MySQL). I test di `Unit/Actions/Log/*` e `LogDownloadPageTest` ripristinati non sono stati lanciati.
