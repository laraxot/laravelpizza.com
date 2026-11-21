---
id: Activity/phpstan-conflict-markers-bootstrap
title: "Risoluzione marker conflitto Git PHP — sblocco PHPStan bootstrap Activity"
status: done
epic: quality-gates
module: Activity
priority: P0
qmd: "Activity git conflict markers PHPStan bootstrap QueueableAction Filament XotBase"
references:
  - ../../wiki/concepts/queueable-action-execute-entrypoint.md
  - ../../wiki/concepts/schemas-tables-pattern.md
  - ../../conflict-resolution.md
  - ../../../../../../docs/sprint-status.yaml
  - ../../../../../../bashscripts/ai/wiki/memories/feedback-scan-committed-conflict-markers-first-on-bootstrap-crash.md
---

# Story — Conflict markers Activity (PHP)

## Perché

I marker `<<<<<<<` / `=======` / `>>>>>>>` nei PHP di Activity fanno fallire il
bootstrap PHPStan (parse error) per tutta la fleet. Scopo: ripristinare codice
eseguibile preservando la funzionalità più completa (audit log, Actions Spatie,
Filament XotBase).

## Acceptance criteria

- [x] Nessun marker di conflitto in `Modules/Activity/**/*.php` (app/ tests/ lang).
- [x] `php -l` verde su tutti i file toccati.
- [x] `phpstan analyse Modules/Activity`: **0 errori su app/**; residui test documentati (~112 typing Pest/harness).
- [x] Decisioni di merge motivate da scopo (non merge cieco).
- [x] Docs modulo + nota second brain aggiornate; status → done.

## Lock

`bash bashscripts/lock/lock.sh activity-conflict-markers 45`

## Decisioni chiave

| Area | Scelta | Perché |
|------|--------|--------|
| LogModel* / LogUser* | `?Model`/`?UserContract` + `execute(?T $x = null)` | Compatibile con DI Spatie e passaggio esplicito; contract User non model User |
| Activity model | Un solo class body + `ActivityScopes` + `@method` ricchi + `typedQuery`/`typedGet` | PHPStan + Action tipizzate; niente residuo `/** > */` |
| GetActivityStatistics | `typedQuery` + `typedGet` + `normalizeStatistics` + cache key `match` | Contratto tipizzato + cache robusta; niente doppio return |
| LogViewer | `translation()` helper, un solo `->label()` | Evita cast cieco e doppie chiamate da merge |
| BuildLogViewerState | `is_string(__())` senza overwrite | Messaggio generico sicuro |
| Resources | Solo `$model` (XotBase discovery) | Form in Schemas/*; no `getFormSchemaOld` |
| List pages | Thin, no getTable* | Tabella in `*Table`; XotBaseListRecords |
| Tables | Colonne complete + IDColumn + Safe json / ViewColumn | Audit UI utile; no filtri Restaurant contaminati |

## File risolti (app PHP)

Vedi esito chiusura in fondo story dopo PHPStan.


## Chiusura

- Marker PHP eliminati; `php -l` OK.
- PHPStan Activity: **app_errors=0**, test_errors≈112 (import/`$this` Pest, non marker).
- File app riparati: Models/Activity, Actions (Log*, Query/GetActivityStatistics, Log/BuildLogViewerState),
  Adapters/ActivityLogger, Filament Resources/Pages/Tables/LogViewer.
- Pest: non dichiarato verde qui — host non production (`192.168.1.40`); suite Activity dipende da sqlite condiviso;
  gate Pest da ripetere in ambiente testing con DB raggiungibile.

