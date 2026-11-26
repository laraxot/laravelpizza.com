---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 23 file oltre target 100.

### `architecture.md` — Job: architettura


# Job: architettura

Documento verificato sul codice (2026-11-25). Dove un'affermazione della documentazione storica contraddiceva il
codice, qui vince il codice e la differenza e' segnalata. Cio' che non funziona ancora e' in [audit.md](audit.md).

## Provider e pannello

- `Providers/JobServiceProvider` estende `XotBaseServiceProvider` (`$name = 'Job'`). Nel `boot()` chiama
  `Import::polymorphicUserRelationship()` ed `Export::polymorphicUserRelationship()` sui modelli di Filament e
  `registerQueue()`; **`registerQueue()` e `registerSchedule()` sono interamente commentati**: il modulo non
  aggancia ne' gli eventi della coda (`Queue::before/after/failing`) ne' lo scheduler su DB.
- `Providers/Filament/AdminPanelProvider` estende `XotBasePanelProvider` (`$module = 'Job'`): il modulo ha 

### `audit.md` — Job: audit, decisioni ed epiche


# Job: audit, decisioni ed epiche

Sintesi dell'audit source-first del 2026-11-16 (inventario filesystem, `rg` con `path:line`, lettura dei file
critici), **ri-verificata sul codice il 2026-11-25**: ogni finding riporta lo stato di oggi. Dove codice e docs
divergevano, ha vinto il codice. L'esposizione runtime dei finding sull'autorizzazione non e' stata provata in un
browser: e' dedotta dal codice e va chiusa con Pest.

## Stato dei finding

| ID | Finding | Stato 2026-11-25 |
|---|---|---|
| P0-1 | `create()` = true su `Job`/`FailedJob`/`JobBatch`: chiunque entri nel pannello puo' scrivere un `payload` nella tabella che il worker consuma | **chiuso** (E1): le tre policy estendono `JobBasePolicy`, `create()` = false; `JobResource` senza `CreateJob`/`EditJob` |
| P0-2 | Scheduler su DB no

### `contracts/assert-allowed-artisan-command-action.md` — AssertAllowedArtisanCommandAction


# AssertAllowedArtisanCommandAction

Controlla che un comando Artisan richiesto dal pannello `JobStatus` sia nella whitelist. Codice: `app/Actions/Console/AssertAllowedArtisanCommandAction.php:10-22`. Decisione di fondo: [ADR 0001](../adr/0001-controlli-operativi-solo-super-admin-e-whitelist.md).

## Input

- `string $command`: stringa inviata dal client Livewire.
- `list<string> $allowed`: comandi ammessi. Nel pannello sono i nomi restituiti da `JobStatus::getAllowedCommands()` (`app/Filament/Pages/JobStatus.php:59`).

## Output

- `void` se il comando e' ammesso.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMD-INV-1` | Il confronto e' esatto e strict (`in_array(..., true)`): nessun prefisso, nessun argomento libero. Esempio: `migrate:fresh --force` non passa solo perche'

### `contracts/build-queue-worker-command-action.md` — BuildQueueWorkerCommandAction


# BuildQueueWorkerCommandAction

Costruisce la riga di shell con cui `worker:check` avvia `queue:work`. Codice: `app/Actions/BuildQueueWorkerCommandAction.php:14-27`.

## Input

- Nessun argomento. Legge `JobConfigData::make()`: `timeout_seconds`, `sleep_seconds`, `max_attempts`, tutti `int` (`app/Datas/JobConfigData.php:30-36`, default 60, 5, 3).

## Output

- `string`, con uno spazio iniziale: ` /usr/local/bin/php <base_path()>/artisan queue:work --timeout=<n> --sleep=<n> --tries=<n> > /dev/null & echo $!` (righe 22-26).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-WORKER-INV-1` | Le uniche parti variabili della riga sono i tre interi di `JobConfigData`: nessun valore scelto da un utente entra nella shell se non come numero. | `tests/Unit/Datas/JobConfigDataTest.php:48,59

### `contracts/clear-schedule-cache-action.md` — ClearScheduleCacheAction (Schedule)


# ClearScheduleCacheAction (Schedule)

Invalida la voce di cache degli schedule. Codice: `app/Actions/Schedule/ClearScheduleCacheAction.php:17-27`.

## Input

- Nessun argomento. Legge `config('job::cache.store')` e `config('job::cache.key')`, entrambe asserite `string` (righe 23-24).
title: "Contratto — ClearScheduleCacheAction"
type: contract
action: "Modules\Job\Actions\ClearScheduleCacheAction"
tags: [contract, action, cache, schedule, legacy]
created: 2026-11-24
updated: 2026-11-24
---

# ClearScheduleCacheAction

Sorgente: `app/Actions/ClearScheduleCacheAction.php`. Chiamanti: `Observers/ScheduleObserver.php::clearCache()`
(su created/updated/saved/deleted di `Schedule`, solo se `config('job::cache.enabled')`) e

### `contracts/dummy-action.md` — DummyAction


# DummyAction

Action di prova per verificare che una Action parta in coda. Codice: `app/Actions/DummyAction.php:9-20`.

## Input

- Nessun argomento.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-DUMMY-INV-1` | `execute()` scrive `hello` seguito da `PHP_EOL` su stdout e non fa altro. | Test: nessuno comportamentale. `tests/Unit/Actions/DummyActionTest.php:18-53` verifica solo struttura. |

## Effetti collaterali

### `contracts/execute-task-action.md` — ExecuteTaskAction


# ExecuteTaskAction

Dovrebbe eseguire un task schedulato per id. Oggi non fa nulla. Codice: `app/Actions/ExecuteTaskAction.php:10-21`.

## Input

- `string $taskId`: non letto. Non c'e' validazione.

## Output

- Nessuno. Il tipo dichiarato e' `string`, ma il metodo non restituisce mai: lancia sempre.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-EXEC-INV-1` | `execute()` lancia sempre `BadMethodCallException` con messaggio che cita `ROADMAP-2026.md`. Nessun effetto collaterale prima del lancio. | Test: nessuno comportamentale. `tests/Unit/Actions/ExecuteTaskActionTest.php:18-62` verifica firma e struttura. |

## Effetti collaterali

### `contracts/get-active-schedules-action.md` — GetActiveSchedulesAction (Schedule)


# GetActiveSchedulesAction (Schedule)

Restituisce gli schedule attivi, con cache opzionale. Codice: `app/Actions/Schedule/GetActiveSchedulesAction.php:13-52`.

## Input

- Nessun argomento. Legge `config('job::cache.enabled')`, `job::cache.store`, `job::cache.key` e `job::model` (senza default).

## Output

- `Illuminate\Support\Collection<int, Schedule>`: il risultato di `active()->get()` del modello risolto.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-SCHED-INV-1` | Con cache disabilitata restituisce `active()->get()` del modello risolto da `config('job::model')`, dopo `app()` e asserzione `instanceof Schedule`. | Test: nessuno comportamentale. `tests/Unit/Actions/Schedule/ScheduleActionsTest.php:16` (solo struttura). |
| `JOB-SCHED-INV-2` | `config('job::model')` senza

### `contracts/get-command-arguments-actions.md` — GetCommandArgumentsActions


# GetCommandArgumentsActions

Elenca gli argomenti dichiarati da un comando Artisan. Codice: `app/Actions/Command/GetCommandArgumentsActions.php:10-29`. Nome del file al plurale: la classe e' `GetCommandArgumentsActions`.

## Input

- `Symfony\Component\Console\Command\Command $command`: letto solo tramite `getDefinition()->getArguments()`.

## Output

- `array<int, array{name: string, default: mixed, required: bool}>`, nell'ordine della definizione.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMDARG-INV-1` | Un elemento per ogni argomento della definizione, nello stesso ordine, con `name`, `default` (valore grezzo) e `required` (`isRequired()`). | `tests/Unit/Actions/Command/GetCommandArgumentsActionsTest.php:26` ("returns array of arguments"): il titolo dichiara l'intent

### `contracts/get-command-options-actions.md` — GetCommandOptionsActions


# GetCommandOptionsActions

Separa le opzioni di un comando Artisan in quelle che accettano un valore e quelle che sono solo flag. Codice: `app/Actions/Command/GetCommandOptionsActions.php:10-43`.

## Input

- `Symfony\Component\Console\Command\Command $command`: letto tramite `getDefinition()->getOptions()`.

## Output

- `array{withValue: array<int, object>, withoutValue: array<int, string>}`.
  - `withValue`: oggetti (`stdClass`) con `name`, `default`, `required` (`isValueRequired()`).
  - `withoutValue`: nomi di flag.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMDOPT-INV-1` | `withoutValue` contiene sempre, all'inizio, `verbose`, `quiet`, `ansi`, `no-ansi`, anche se il comando non le dichiara (righe 21-26). | `tests/Unit/Actions/Command/GetCommandOptionsActionsTest.ph

### `contracts/get-commands-action.md` — GetCommandsAction


# GetCommandsAction

Costruisce l'elenco dei comandi Artisan come `CommandData`, per il form di schedulazione. Codice: `app/Actions/Command/GetCommandsAction.php:16-78`.

## Input

- Nessun argomento. Legge `Illuminate\Contracts\Console\Kernel::all()`.

## Output

- `DataCollection<int, CommandData>`: una voce per comando, con `name`, `description`, `signature` (uguale al nome), `full_name` (`nome - descrizione`), `arguments` e `options`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CMDLIST-INV-1` | Una `CommandData` per ogni comando restituito da `kernel->all()`, indici rinumerati. | `tests/Unit/Actions/Command/GetCommandsActionTest.php:59` ("has execute method returning DataCollection"): solo tipo di ritorno. |
| `JOB-CMDLIST-INV-2` | `options.withValue` contiene **tutte*

### `contracts/get-job-status-commands-action.md` — GetJobStatusCommandsAction


# GetJobStatusCommandsAction

Lista fissa dei comandi Artisan che il pannello di stato dei job puo' eseguire. Codice: `app/Actions/Console/GetJobStatusCommandsAction.php:9-29`.

## Input

- Nessuno.

## Output

- `list<string>`: `queue:clear`, `queue:failed`, `queue:flush`, `queue:prune-batches`, `queue:prune-failed`, `queue:restart`, `queue:retry`, `worker:check`, `route:list`, in questo ordine.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CONSOLE-INV-1` | L'output e' la lista letterale sopra: nessuna scoperta dinamica dei comandi, nessun filtro. | Test: nessuno diretto. `tests/Unit/Filament/JobStatusAuthorizationTest.php:144` ("derives the allowlist from the page buttons") copre la derivazione dal pannello, non questa lista in isolamento. |

## Effetti collaterali

### `contracts/get-queue-subcommands-action.md` — GetQueueSubcommandsAction


# GetQueueSubcommandsAction

Elenca i sottocomandi `queue:*` ammessi. Codice: `app/Actions/Console/GetQueueSubcommandsAction.php:9-27`.

## Input

- Nessuno.

## Output

- `list<string>`: `clear`, `failed`, `flush`, `prune-batches`, `prune-failed`, `restart`, `retry` (senza il prefisso `queue:`).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CONSOLE-INV-2` | L'output e' la lista letterale sopra, senza prefisso. | Test: nessuno. |

## Effetti collaterali

### `contracts/get-schedule-status-commands-action.md` — GetScheduleStatusCommandsAction


# GetScheduleStatusCommandsAction

Lista fissa dei comandi di schedulazione mostrabili nel pannello. Codice: `app/Actions/Console/GetScheduleStatusCommandsAction.php:9-29`.

## Input

- Nessuno.

## Output

- `list<string>`: `job:schedule-list`, `schedule:clear-cache`, `schedule:list`, `schedule:run`, `schedule:test`, `schedule:work`, `schedule-monitor:sync`, `schedule-monitor:list`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CONSOLE-INV-3` | L'output e' la lista letterale sopra, nell'ordine dato. | Test: nessuno. |

## Effetti collaterali

### `contracts/get-task-commands-action.md` — GetTaskCommandsAction


# GetTaskCommandsAction

Restituisce tutti i comandi Artisan con un ordine stabile. Codice: `app/Actions/GetTaskCommandsAction.php:13-40`.

## Input

- Nessun argomento. Legge `Artisan::all()`.

## Output

- `Collection<int, Symfony\Component\Console\Command\Command>`, ordinata e rinumerata con `values()`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-TASKCMD-INV-1` | Un comando senza `:` nel nome viene prima di tutti quelli con `:` (chiave di ordinamento `':'.$name`), salvo nomi che iniziano con una cifra. Dentro ciascun gruppo l'ordine e' alfabetico. | Test: nessuno. `tests/Unit/Actions/GetTaskCommandsActionTest.php:19-59` verifica firma, container e struttura. |
| `JOB-TASKCMD-INV-2` | Ogni elemento deve essere un `Command` con nome stringa, altrimenti asserzione fallita.

### `contracts/get-task-frequencies-action.md` — GetTaskFrequenciesAction


# GetTaskFrequenciesAction

Restituisce le frequenze di schedulazione definite in `totem.frequencies`. Codice: `app/Actions/GetTaskFrequenciesAction.php:10-28`.

## Input

- Nessun argomento. Legge `config('totem.frequencies')`.

## Output

- `array<int|string, mixed>`: il valore di configurazione, senza trasformazioni.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-FREQ-INV-1` | Se la config e' un array, lo restituisce tale e quale. | `tests/Unit/JobDeepCoverageTest.php:22-24` ("execute returns config array"). |
| `JOB-FREQ-INV-2` | Se la config non e' un array lancia `\Exception` con messaggio `[<riga>][GetTaskFrequenciesAction]`. | Test: nessuno comportamentale; `tests/Unit/GetTaskFrequenciesActionTest.php:13-98` verifica solo struttura. |


### `contracts/root-clear-schedule-cache-action.md` — ClearScheduleCacheAction (root, superseded)


# ClearScheduleCacheAction (root, superseded)

Duplicato flat, marcato `@deprecated` nel docblock (`app/Actions/ClearScheduleCacheAction.php:11-18`). Il contratto attivo e' [clear-schedule-cache-action](clear-schedule-cache-action.md).

## Input

- Nessun argomento. Stesse config di `job::cache.store` e `job::cache.key` (righe 25-26), asserite `string`.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CACHE-ROOT-INV-1` | Stessa logica dell'Action Schedule: `forget` della sola chiave `job::cache.key` nello store `job::cache.store`. | Test: nessuno dedicato. |
| `JOB-CACHE-ROOT-INV-2` | Config non stringa: `InvalidArgumentException` (stesso comportamento di INV-2 del contratto Schedule). | Test: nessuno. |


### `contracts/root-get-active-schedules-action.md` — GetActiveSchedulesAction (root, superseded)


# GetActiveSchedulesAction (root, superseded)

Duplicato flat, `@deprecated` (`app/Actions/GetActiveSchedulesAction.php:13-17`). Il contratto da usare e' [get-active-schedules-action](get-active-schedules-action.md).

## Input

- Nessun argomento. Il modello e' risolto nel **costruttore** da `config('job::model', Schedule::class)`: qui il default esiste (riga 26).

## Output

- `Collection<int, Schedule>`, come la versione Schedule.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-SCHED-ROOT-INV-1` | Il modello e' risolto nel costruttore; senza `job::model` usa `Schedule::class` e non lancia. | Test: `tests/Unit/Actions/GetActiveSchedulesActionTest.php:42` (solo "has model property", struttura). |
| `JOB-SCHED-ROOT-INV-2` | Con cache disabilitata restituisce `active()->get()`; 

### `quality.md` — Job: qualita', gate e test


# Job: qualita', gate e test

Solo cio' che e' ancora vero e verificabile. I rapporti storici di sessione (correzioni PHPStan di gennaio 2025,
analisi con file di policy corrotti dal merge del 2025-11, punteggi DRY/KISS di ottobre 2025, censimenti
automatici di metodi omonimi) descrivevano un codice che non esiste piu' e non sono stati conservati.

## Gate

Dalla cartella `laravel/`:

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Job --no-progress
./vendor/bin/pest Modules/Job/tests --no-coverage      # solo fuori produzione, con DB di test raggiungibile
./vendor/bin/pint Modules/Job
```

| Gate | Ultimo esito noto |
|---|---|
| PHPStan `Modules/Job` | 0 errori (livello del progetto, nessuna baseline, nessun `@phpstan-ignore` senza motivo), misurato il 2026-11-16, an

### `stories/0017-continuation.story.md` — Job Module — Continuation Task

# Job Module — Continuation Task

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0018-docs-index-audit.story.md` — Docs index audit — modulo Job

# Docs index audit — modulo Job

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0019-job-module-bmad-setup.story.md` — Job Module BMAD Setup

# Job Module BMAD Setup

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `troubleshooting.md` — Job: risoluzione dei problemi


# Job: risoluzione dei problemi

Sintomi realmente osservabili in questo modulo, con la causa nel codice. Per i problemi generici delle code di
Laravel (timeout, memoria, tentativi) valgono le opzioni standard di `queue:work` (`--timeout`, `--tries`,
`--max-jobs`, `--max-time`, `--memory`) e i comandi `queue:failed`, `queue:retry`, `queue:flush`.

| Sintomo | Causa e rimedio |
|---|---|
| Il worker non parte dal pulsante di `JobStatus` o da `worker:check` | Il comando avvia `queue:work` con una riga di shell (`> /dev/null & echo $!`) e controlla il PID salvato in `queue.pid` sul disco `cache`. Il percorso dell'eseguibile PHP (`/usr/local/bin/php`) e' scritto in `BuildQueueWorkerCommandAction`: vale per l'immagine attuale. Verificare il PID e il disco `cache` |
| I job vengono rieseguiti m
