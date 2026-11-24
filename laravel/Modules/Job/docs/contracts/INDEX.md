---
title: "INDEX contratti — Job"
type: index
module: Job
status: active
created: 2026-11-23
updated: 2026-11-24
qmd: "job contracts index copertura invarianti backlog"
---

# Indice dei contratti — Job

Copertura = `coperto` solo se per ogni ID esiste `->group('<ID>')` nei test del modulo
(verifica: `rg -n "group\('<ID>'\)" laravel/Modules/Job/tests`, nessun risultato per questi ID).

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Invalidare la cache degli schedule | [clear-schedule-cache-action](clear-schedule-cache-action.md) | `Modules\Job\Actions\Schedule\ClearScheduleCacheAction` | JOB-CACHE-INV-1, JOB-CACHE-INV-2 | non coperto | `vendor/bin/pest --group=JOB-CACHE-INV-1` |
| Ammettere un comando Artisan dal pannello | [assert-allowed-artisan-command-action](assert-allowed-artisan-command-action.md) | `Modules\Job\Actions\Console\AssertAllowedArtisanCommandAction` | JOB-CMD-INV-1, JOB-CMD-INV-2 | non coperto (test esistenti senza group) | `vendor/bin/pest --group=JOB-CMD-INV-1` |
| Costruire il comando del worker | [build-queue-worker-command-action](build-queue-worker-command-action.md) | `Modules\Job\Actions\BuildQueueWorkerCommandAction` | JOB-WORKER-INV-1, JOB-WORKER-INV-2 | non coperto (test esistenti senza group) | `vendor/bin/pest --group=JOB-WORKER-INV-1` |

I comandi `--group` restituirebbero zero test finche' i gruppi non sono aggiunti ai test (fuori scope docs).

## Note

- Marker `@contract` presente solo in `Actions/Schedule/ClearScheduleCacheAction.php`; mancante in `AssertAllowedArtisanCommandAction` e `BuildQueueWorkerCommandAction` (fuori scope docs).
- `Actions/ClearScheduleCacheAction.php` (root) e' un duplicato `@deprecated` dichiarato nel suo docblock: il contract vale per la versione `Schedule\`.

## Backlog contract

Action ad alto rischio senza contract:

- `laravel/Modules/Job/app/Actions/ExecuteTaskAction.php`: lancia sempre `BadMethodCallException` («not implemented yet»); contract da scrivere quando sara' implementata.
- `laravel/Modules/Job/app/Actions/Schedule/GetActiveSchedulesAction.php`: legge/popola la cache con `rememberForever` (accoppiata al contract della cache).

Totale Action nel modulo: 16 file in `app/Actions` (`find app/Actions -name '*.php' | wc -l`), di cui 3 con contract.
