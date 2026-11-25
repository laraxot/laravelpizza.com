---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 180 file oltre target 100.

### `.github/links.md` — links

https://gist.github.com/milon/5173255b58564a0e50548cfbe879181e


### `analysis.md` — Job Module Analysis


# Job Module Analysis

## Overview
The Job module provides specialized functionality within the Laravel application.

## Directory Structure
```
Modules/Job/
├── app/
│   ├── Models/
│   ├── Http/
│   └── Providers/
├── config/
├── database/
├── resources/
└── routes/
```

## Key Components

### `bmad/audit.md` — Audit BMAD — Job


# Audit BMAD — Job

SSoT dettagliata (inventario, evidenze `path:line`, non-finding): [audits/job-audit.md](./audits/job-audit.md).

**Scopo in una frase:** Job rende visibile e governabile ciò che accade fuori dalla richiesta HTTP — code, import, export, pianificazioni — e soprattutto i loro fallimenti ([purpose.md](./purpose.md)).

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 176 |
| Test | 84 |
| Resources | 9 |
| Actions | 16 |
| Services | 1 |
| Policy `return true` | 5 |
| Marker | 0 |

## Lo scopo in una frase **Job rende visibile e governabile tutto cio' che accade fuori dalla richiesta HTTP: code, importazioni, esportazioni, lavori pianificati — e soprattutto i loro

### `bmad/audits/job-audit.md` — Audit approfondito — Job


# Audit approfondito — Job

## Metodo

Source-first (2026-11-16): inventario filesystem, `rg` su policy/marker/label,
lettura purpose esistente, PHPStan globale Modules già a 0 errori. Nessuna UI
inventata. Pest dichiarato solo se eseguito.

## Inventario misurato

| Area | Conteggio |
|---|---:|
| PHP in `app/` | 176 |
| Test PHP | 84 |
| Models (`app/Models/*.php`) | 17 |
| Policy files (approx) | 32 |
| Resource Filament | 9 |
| Actions | 16 |
| Services | 1 |

### `bmad/bmad-dossier.md` — Job — BMAD dossier

# Job — BMAD dossier
## Product brief / PRD
Run imports, exports, notifications and scheduled work reliably without losing transactions.
## Architecture / UX / security
Laravel queue/jobs use after-commit dispatch, idempotency and safe replay; domain meaning stays with owner modules.
## Epics and stories
Worker reliability; failed-job operations; replay/retention.
## Gaps / release
Worker, failed_jobs, alerts, idempotency and RPO/RTO are not candidate-verified. Release requires failure injection and replay evidence.

### `bmad/brainstorming/livewire-to-page.md` — Brainstorming


# Brainstorming

SSoT: [../livewire-widget-brainstorming.md](../livewire-widget-brainstorming.md)

### `bmad/brainstorming.md` — Brainstorming — Job


# Brainstorming — Job

Opzioni sui finding dell'[audit](./audits/job-audit.md). La scelta va a [decision-log](./decision-log.md). Storico Livewire → pagina: [brainstorming/livewire-to-page.md](./brainstorming/livewire-to-page.md).

## O1 — Scheduler su DB (D-2)

| Opzione | Pro | Contro |
|---|---|---|
| A. Cablare (`registerSchedule` + hook coda + `ExecuteTaskAction`) | realizza lo scopo; storico e alert di "non parte più" | codice da scrivere/testare; rischio doppio `schedule:run` |
| B. Ritirare dalla UI | meno superficie, niente promesse false | scopo ridotto a "monitor" |
| C. Delegare a `spatie/laravel-schedule-monitor` | già nel vocabolario del modulo (`schedule-monitor:*` negli allowlist) | dipendenza e due fonti di verità |

Domanda aperta: esiste un committente che pianifica com

### `bmad/decision-log.md` — Decision log — Job


# Decision log — Job

Append-only, più recente in alto. Il registro precedente (`../decision-log.md`) contiene la decisione sull'enum `Status` di `Schedule` (2026-10-08) e un'entry template; resta come storico.

| ID | Data | Stato | Decisione | Perché | Evidenza |
|---|---|---|---|---|---|
| D-5 | 2026-11-16 | **APPROVATA** | Le tre policy Team (`Job`, `FailedJob`, `JobBatch`) passano a `JobBasePolicy` | Deny-by-default e bypass `job::admin`; oggi `create()` = true | `JobPolicy.php:11,32` |
| D-4 | 2026-11-16 | **APPROVATA** | Riaprire la story 12.1 (ritiro `Http/Livewire`) | Era `done`, il codice dice il contrario (`Broad.php:41` con `dd()`) | `docs/stories/12.1.retire-job-http-livewire.story.md`, `Http/Livewire/_components.json` |
| D-3 | 2026-11-16 | **APPROVATA** | `JobResource` senz

### `bmad/epics/livewire.md` — Epic 12


# Epic 12

SSoT: [../livewire-widget-epics.md](../livewire-widget-epics.md)

### `bmad/epics.md` — Epics — Job


# Epics — Job

Derivate dai finding dell'[audit profondo](./audits/job-audit.md). Storico Livewire: [epics/livewire.md](./epics/livewire.md).
Ogni epic diventa una story BMAD prima di toccare il codice.

## E1 — Autorizzazione di `Job`, `FailedJob`, `JobBatch` (P0-1)

**Perché:** `create()` = true su una tabella che il worker esegue.
**AC:**
- [x] 3 policy su `JobBasePolicy`, senza metodi Team (D-5).
- [x] `JobResource` senza `CreateJob`/`EditJob` in `getPages()` (D-3; classi orfane da rimuovere in cleanup).
- [x] Pest unit deny-default + `before` admin; Feature 403 su `/create` opzionale (rotta rimossa).
- Story: [0005-e1-job-policy-create-deny.story.md](stories/0005-e1-job-policy-create-deny.story.md).

## E2 — Scheduler: decidere e allineare (P0-2)

**Perché:** la UI promette esecuzion

### `bmad/livewire-inventory.md` — Inventario: Livewire HTTP → Filament — modulo Job


# Inventario: Livewire HTTP → Filament — modulo Job

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Job per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../Cms/docs/bmad/livewire-inventory.md) e [Modules/Xot/docs/bmad/livewire-inventory.md](../../Xot/docs/bmad/livewire-inventory.md).

Differenza rispetto a Cms/Xot: in Job **esistono mount reali** (`<livewire:...>` in viste Blade), quindi la classificazione non è "tutto orfano": un componente è montato dentro una pagina del panel `job::admin`, gli altri solo in viste legacy `adm_theme` prive di renderer.

## Metodo (codice, non assunzione)

```bash
find Modules/Job/app/Http/Livewire -type f -name '*.ph

### `bmad/piano-miglioramento.md` — Piano di miglioramento — Job


# Piano di miglioramento — Job

Derivato dall'[audit](./audits/job-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 5) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (1) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 84 test / 176 app PHP).
3. Allineare Filament (resources=9) a XotBase* e traduzioni Lang.
4. Spezzare dipendenze inverse verso verticali peer se rilevate con `rg`.

## P2


### `bmad/stories/0001-root-hygiene-conflict-markers.story.md` — 12.3: marker conflitto in README + igiene root Job

# 12.3: marker conflitto in README + igiene root Job

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


### `bmad/stories/0002-git-hygiene-queue-pid-graphify-out-aaa.story.md` — 12.4: igiene git residua (queue.pid, graphify-out, .aaa) + incidente agente concorrente

# 12.4: igiene git residua (queue.pid, graphify-out, .aaa) + incidente agente concorrente

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


### `bmad/stories/0003-docs-reorg-core.story.md` — Story — riorganizzazione docs core: Job

# Story — riorganizzazione docs core: Job

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


### `bmad/stories/0004-docs-zen-conventions.story.md` — Job: bonifica convenzioni docs

# Job: bonifica convenzioni docs

## Context and Problem Statement

Lane E dello swarm [docs-zen-conventions-swarm](../../../../Xot/docs/bmad/stories/0066-docs-zen-conventions-swarm.story.md).
Job era il modulo piu' rumoroso della lane: ogni documento esisteva in 2-4 varianti (`X.md`, `X-2.md`, `X-3.md`, `X-MAIUSCOLO.md`).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

### `bmad/stories/0007-phpstan-conflict-markers-bootstrap.story.md` — phpstan-conflict-markers-bootstrap (Job)

# phpstan-conflict-markers-bootstrap (Job)

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


### `bmad/stories/0008-phpstan-modules-zero.story.md` — Story: PHPStan modules zero — Job

# Story: PHPStan modules zero — Job

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


### `bmad/stories/0009-phpstan-zero-merge-markers-job.story.md` — PHPStan zero + merge markers — Job

# PHPStan zero + merge markers — Job

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


### `bmad/stories/continuazione-domani.md` — Job — Continuazione Domani

# Job — Continuazione Domani

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


### `code-redundancy-audit.md` — Code redundancy audit — Job


# Code redundancy audit — Job

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 289 |
| Rischio ridondanza | high |
| Basename duplicati locali | 12 |
| Hash normalizzati duplicati cross-owner | 3 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 1 |
| File PHP con marker Git | 0 |

## Evidenze

### `components/schedule-crud.md` — Schedule Crud Component

# Schedule Crud Component

## Panoramica
Componente Livewire per la gestione dei task schedulati nel modulo Job.

## Caratteristiche
- Visualizzazione dei task schedulati
- Creazione di nuovi task
- Esecuzione manuale dei task
- Integrazione con Artisan commands
- Gestione delle frequenze di esecuzione

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri e return types
2. Gestione null-safe dei comandi Artisan
3. Rimozione di codice commentato non utilizzato
4. Correzione dei type hints per le Collection
5. Implementazione corretta delle interfacce

### `concepts/xotbase-never-extend-filament.md` — Mai `Filament\*` — sempre `Modules\Xot\Filament\...\XotBase*`


# Mai `Filament\*` — sempre `Modules\Xot\Filament\...\XotBase*`

Bridge on-demand. Contenuto canonico: [docs/wiki/rules/xotbase-critical-rules.md](../../../../docs/wiki/rules/xotbase-critical-rules.md).

## Zen (riassunto)

Nessuna classe in `Modules/Job` estende una classe `Filament\...` direttamente.
Si estende sempre lo "specchio" in `Modules\Xot\Filament\...` allo stesso
percorso relativo (es. `Filament\Tables\Columns\ViewColumn` ->
`Modules\Xot\Filament\Tables\Columns\XotBaseViewColumn`). Se manca il
mirror, va creato in Xot prima di usarlo qui, mai come scorciatoia nel modulo.

Non pre-caricare questo file: leggi la fonte canonica solo quando il task lo richiede.

### `conflicts.md` — Risoluzione Conflitti - Job


# Risoluzione Conflitti - Job

## File modificati

## Decisioni adottate

## Marcatori di conflitto nel codice dopo il sync del 24/11/2026

`merge_remote_repo_2.sh` ha committato marcatori in `tests/Unit/Services/ScheduleServiceTest.php`: i due lati erano lo stesso test,
uno con `use Modules\Job\Tests\TestCase` e `uses(TestCase::class)`, l'altro con `uses(\Modules\Job\Tests\TestCase::class)`.
Tenuta la forma con l'import (stesso comportamento, nessun test perso). Il test verifica che `Modules\Job\Services\ScheduleService`
esista ancora (vedi `scopo.md`). Storia: `stories/12.5.job-sync-marker-repair.story.md`.

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

### `contracts-naming.md` — Contracts Naming & Placement in Job


# Contracts Naming & Placement in Job

> A contract is an **agreement**, not a PHP keyword. We name it `*Contract` and place it under `app/Contracts/`.

## Rule

- ✅ `app/Contracts/ExampleContract.php`
- ❌ `app/Interfaces/ExampleInterface.php`

## Why

- `Contract` describes the domain concept (a pact between components).
- `interface` describes a PHP implementation detail.
- One folder (`app/Contracts/`) keeps the module language consistent and reduces cognitive noise.
- Aligned with Laravel `Illuminate\Contracts\*` convention.

## Verification

```bash

### `copilot-redundancy-audit.md` — copilot-redundancy-audit


Copilot Redundancy Audit — 2026-05-25

Sintesi
- Template e job-related docs ripetuti (job.txt, worker.txt, queue patterns).

Raccomandazioni
- Consolidare pratiche raccomandate per queue/jobs in un unico documento di riferimento e usare link canonical.
- Documentare convenzioni di naming per classi Job e per i file di configurazione.

Autore: Copilot CLI

### `cosa-migliorare.md` — Cosa migliorare — modulo Job


# Cosa migliorare — modulo Job

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 116 |
| PHPInsights — Code | 88.2 % |
| PHPInsights — Architecture | 71.4 % |
| PHPInsights — Style | 90.1 % |
| File PHP | 475 |
| Casi di test | 347 |
| Casi di test per file | 0.73 |
| Coverage di riga | **mai misurata** |

### `coverage.md` — Code Coverage: Job


# Code Coverage: Job

**Lines Coverage:** N/A (Failed to parse)
**Test Exit Code:** 2

## Output

```text
▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m

### `cyclomatic-complexity-report.md` — Cyclomatic Complexity Report - Module: Job


# Cyclomatic Complexity Report - Module: Job

**Analyzer:** Super Mucca 🐮

---

title: "cyclomatic complexity report"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "cyclomatic complexity report"
issues: []
discussions: []
## 📊 Summary Statistics

| Metric | Value |
|--------|-------|
| Total PHP Files | 250 |

### `decision-log.md` — Decision Log — Job

# Decision Log — Job

A threaded, append-only record of decisions made across BMAD planning workflows.
Every later skill (brief, PRD, architecture, stories) appends here so the reasoning
behind the plan stays visible and consistent.

**How to use:** add a new entry at the top of the log (newest first). Never rewrite
or delete past entries — supersede them with a new entry that references the old one.

### 2026-10-08: Schedule all'enum Status (ultima versione buona)
- **Choose**: Ripristinare `Models/Schedule.php` dal blob `788ff149`, la versione del commit `97fe8f09` (07/10 06:37) che sostituisce le costanti `STATUS_*` con l'enum `Status`.
- **Over**: La versione del 06/10 (costanti), o quella attuale.
- **Because**: Il commit delle 13:01 del 07/10 (re-import `431b5e66` e successivi) aveva

### `dependencies.md` — Dependencies (Module Job)


# Dependencies (Module Job)

Canonical dependency map:

- [../../../../docs/dependencies.md](../../../../docs/dependencies.md)

Module/theme specific notes:

- (add notes here when a dependency is directly used by this module/theme)

Installed packages index:

- [../../../../docs/packages/index.md](../../../../docs/packages/index.md)

### `dependency-intelligence.md` — Dependency Intelligence - Module Job


# Dependency Intelligence - Module Job

Aggiornato da `composer show` il 2026-03-02.

## Runtime dependencies (`require`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Dev dependencies (`require-dev`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Declared but missing from installed set

- Nessun pacchetto mancante nel lock corrente.

### `directory-structure-rules.md` — Directory Structure Rules


# Directory Structure Rules

Per il modulo Job valgono queste regole:

- `lang/lang/` non deve esistere;
- `_docs/` non deve esistere;
- le traduzioni ufficiali stanno in `lang/<locale>/`;
- la documentazione ufficiale sta in `docs/`.

Le vecchie cartelle duplicate individuate erano `Job/lang/lang` e `Job/_docs`.

Regola canonica: [no-lang-lang-and-no-underscore-docs-rule](../../../../bashscripts/ai/wiki/concepts/modules-structure-rules.md#no-lang-lang-and-no-underscore-docs-rule).

### `docs-health.md` — Docs Health - Job


# Docs Health - Job

## Snapshot

- Scope directory: laravel/Modules/Job/docs
- Markdown files (top-level in this docs folder): 137
- Has canonical index 00-index.md: yes
- Has README.md: yes

## Confidence Checklist

- [ ] 00-index links only canonical docs (no obsolete duplicates)
- [ ] README and 00-index are coherent and do not diverge
- [ ] New docs use stable names (no dates in filename)
- [ ] Deprecated docs are explicitly marked and linked to canonical replacements
- [ ] Every technical decision has one canonical reference doc

## Canonical Rules


### `duplicate-methods-analysis.md` — Analisi Metodi Duplicati - Modulo Job


# Analisi Metodi Duplicati - Modulo Job

**Totale Gruppi di Duplicati**:

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Job** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 0 |
| **Base Class** | 2 |
| **Interface** | 6 |
| **Altro** | 2 |

## Dettaglio Metodi Duplicati


### `duplicate-methods.md` — Metodi duplicati — Job

# Metodi duplicati — Job

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **211**
- Metodi duplicati trovati: **45**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getTableColumns` | 21 | candidato a trait/helper |
| `getFormSchema` | 19 | candidato a trait/helper |
| `casts` | 15 | candidato a trait/helper |
| `definition` | 15 | candidato a trait/helper |
| `up` | 13 | candidato a trait/helper |
| `update` | 11 | candidato a trait/helper |
| `__construct` | 10 | candidato a trait/helper |
| `getInfolistSchema` | 9 | candidato a trait/helper |
| `execute` | 8 | candidato a trait/helper |

### `enterprise-job-system-roadmap.md` — Job Module - Comprehensive Job Management System


# Job Module - Comprehensive Job Management System

## Overview

The Job module provides enterprise-grade job management, scheduling, and execution capabilities with advanced workflow automation, tracking, and reporting features for modern web applications.

## Current Implementation Status

### 🔴 **State**: Basic/Placeholder  
**Completion**: 10%  
**Priority**: High  
**Estimated Development Time**: 6-8 weeks

### Existing Structure
```
Modules/Job/
├── app/
│   ├── Models/
│   │   ├── Job.php             (Basic)

### `epics/job-epics-and-stories.md` — Job Epics and User Stories

# Job Epics and User Stories

## Epic 1: Core Functionality
As a User, I want to use Job features so that I can accomplish my tasks.

### Story 1.1: Basic Operations
**Acceptance Criteria**:
- [ ] Create Job records
- [ ] Read Job data
- [ ] Update Job records
- [ ] Delete Job records

## Technical Specifications
- Standard CRUD implementation
- Validation and error handling
- Integration with Laraxot patterns

---
## Story Template
```

### `filament-5x-compatibility.md` — Filament 5.x compatibility - modulo Job


# Filament 5.x compatibility - modulo Job

**Versione Filament:** v5.2.1

## Stato compatibilità

Il modulo Job è **compatibile** con Filament 5.x. Nessun breaking change funzionale rispetto a Filament 4.x.

## Regole architetturali

Tutte le classi Filament **devono** estendere le classi `XotBase*`:

| Tipo | Classe base |
|------|------------|
| Resource | `XotBaseResource` |
| ListRecords | `XotBaseListRecords` |
| CreateRecord | `XotBaseCreateRecord` |
| EditRecord | `XotBaseEditRecord` |
| ViewRecord | `XotBaseViewRecord` |

### `filament-table-architecture.md` — La tabella si configura nella Table class, non nella pagina


# La tabella si configura nella Table class, non nella pagina

Vale per ogni Resource di questo modulo.

## La regola

Colonne, filtri e azioni di una Resource stanno in
`app/Filament/Resources/<Nome>Resource/Tables/<Plurale>Table.php`, che estende
`Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`.

**Non** nella pagina `Pages/List<Plurale>.php`. Quello che scrivi li' dentro non viene
letto da nessuno.

```php
namespace Modules\Job\Filament\Resources\FooResource\Tables;

use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FoosTable extends XotBaseResourceTable

### `filament-version.md` — Filament Version Declaration — Job


# Filament Version Declaration — Job

**Current Version**: Filament v5 (Livewire v4 + Schemas)

This module/theme is developed against **Filament v5**.

All resources, forms, tables, infolists, widgets and actions must follow the v5 + XotBase patterns documented in:

- `docs/wiki/rules/filament-rules-summary.md`
- `docs/wiki/memories/filament-version-policy.md`
- `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md`

**Legacy v4 documents** in this folder (if any) are historical only and must not be used as current reference.

**Last verified**: 2026-05-21

**Firmato:** Cursor Agent (Composer) — template propagato ai package `docs/`

### `filament.md` — filament



https://gitlab.com/amvisor/filament-failed-jobs/-/blob/master/src/FilamentFailedJobsServiceProvider.php

https://github.com/croustibat/filament-jobs-monitor

https://medium.com/@laravelprotips/laravel-filament-top-12-plugins-simplified-with-demonstrations-a87aa3b63a6d




### `frameworks.md` — Job — Framework Integration Notes

# Job — Framework Integration Notes

Integration guidelines for caveman, graphify, bmad-method, headroom, ponytail.

**Status:** Awaiting Phase 3 framework research results

## Code Review (caveman)

Surgical editing patterns:
- Single-file edits encouraged
- Multi-file refactors discouraged
- Mechanical renames via caveman agent

## Architecture (graphify)

Dependency analysis:
- Module dependencies: [TBD — graphify analysis]
- Circular deps: [TBD]
- Cross-theme usage: [TBD]


### `git-multi-org-sync-handoff.md` — Handoff — multi-org sync (STORY-003)


# Handoff — multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_job_fila5/issues/16 |
| Discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Hub base issue | https://github.com/provtv/base_ptv_fila5/issues/203 |
| Hub base discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Story monorepo | `docs/stories/STORY-003-multi-org-sync-geo-boundary-bashscripts.md` |

### `glossary.md` — Glossario di dominio Job


# Glossario di dominio Job

Termini verificati nel codice con `rg`. Se glossario e codice divergono vale il codice.

| Termine | Significato | Nel codice |
|---|---|---|
| Schedule | Comando Artisan pianificato con espressione cron, parametri, ambienti, opzioni, log e flag `without_overlapping` / `even_in_maintenance_mode`. | `app/Models/Schedule.php`; risorsa `app/Filament/Resources/ScheduleResource.php` |
| Schedule attivo | Schedule il cui `status` e' in `Status::activeCases()`: e' quello eseguito dallo scheduler. | `Schedule::scopeActive()` (`app/Models/Schedule.php:167`), `app/Enums/Status.php` |
| Status | Stato di uno Schedule: `active`, `inactive`, `trashed`, piu' `One` = valore legacy `'1'`, equivalente ad `active`. | `app/Enums/Status.php` |
| Storico esecuzioni | Output e param

### `implementation.md` — Implementazione Job


# Implementazione Job

## Struttura del Codice

### Convenzioni
- Seguire PSR-12 per lo stile del codice
- Mantenere una lunghezza massima di 120 caratteri per riga
- Utilizzare indentazione di 4 spazi
- Inserire una riga vuota tra i metodi
- Utilizzare parentesi graffe su nuova riga per classi e metodi

### Nomenclatura
- **Classi**: PascalCase (es. `JobResource`)
- **Metodi**: camelCase (es. `validateJob`)
- **Variabili**: camelCase (es. `jobStatus`)
- **Costanti**: UPPER_SNAKE_CASE (es. `MAX_JOBS`)
- **Interfacce**: PascalCase con suffisso Interface (es. `JobServiceInterface`)
- **Trait**: PascalCase con suffisso Trait (es. `JobTrait`)


### `index-generated.md` — Job Module Documentation Index (Generated)

# Job Module Documentation Index (Generated)

**Generated:** 2026-07-28  
**Scope:** Complete index of `laravel/Modules/Job/docs/`  
**Total Files:** 483 (363 .md + 120 .txt)  
**Total Directories:** 25  
**Status:** Generated with intelligent categorization and deduplication analysis

---

## Table of Contents

1. [Statistics](#statistics)
2. [Quick Navigation](#quick-navigation)
3. [Core Documentation by Category](#core-documentation-by-category)
4. [Recently Updated Files](#recently-updated-files)
5. [Subdirectory Inventory](#subdirectory-inventory)
6. [Recommendations](#recommendations)

---

### `integration.md` — Integrazione Documentazione


# Integrazione Documentazione

## Documentazione Collegata

### Filament
- [Risorse Filament](../../docs/filament-risorse.md)
- [Personalizzazioni Avanzate](../../Cms/docs/filament-personalizzazioni-avanzate-2.md)
- [Gestione Contenuti](../../docs/gestione-contenuti-json.md)

### Struttura e Convenzioni
- [Namespace Convention](../../docs/namespace-convention.md)
- [Namespace Structure](../../docs/namespace-structure.md)
- [Namespace Rules](../../Notify/docs/namespace-rules-2.md)

### Implementazione
- [Standard Codice](../../docs/standard-codice.md)
- [Traduzioni](../../docs/traduzioni.md)
- [Componenti e Blocchi](../../Cms/docs/componenti-blocchi-contenuto-2.md)


### `investigation/investigation.md` — Investigation: Multi-Agency Job Board Sync

# Investigation: Multi-Agency Job Board Sync

## Problem Statement
Analisi delle feature mancanti nel modulo Job.

## Current State
- Documentazione esistente: 26 stories
- Architettura: Actions,Console,Contracts,Datas,Entities,Enums,Events,Filament,Http,Models,Notifications,Observers,Phpstan,Providers,Rules,Services,Traits,View,entities,

## Feature Missing
1. Feature A - descrizione
2. Feature B - descrizione
3. Feature C - descrizione

## Proposed Solution
- Implementare le feature A/B/C usando le regole BMAD
- Seguire: no controller, no services layer, module providers manifest

## Acceptance Criteria
- [ ] APCA contrast ≥75 body, ≥45 large-bold

### `job-reports.md` — Job Module PDF Reports


# Job Module PDF Reports

## 📋 Overview

Guida completa per generare report PDF del sistema di code e job utilizzando HTML2PDF con integrazione nativa nel modulo Job.

---

title: "job reports"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "job reports"
issues: []
discussions: []
## 🎯 Tipi di Report Disponibili

### 1. Queue System Report

### `lang-link.md` — Collegamento alle Traduzioni del Modulo Job


# Collegamento alle Traduzioni del Modulo Job

Questo modulo utilizza le traduzioni centralizzate nella cartella [Lang](../../Lang/docs/).

Consulta la documentazione delle traduzioni:
- [Introduzione alle Traduzioni](../../Lang/docs/introduction.md)
- [Struttura delle Traduzioni](../../Lang/docs/structure.md)
- [Gestione dei File di Lingua](../../lang/docs/module_lang.md)

## Collegamento Bidirezionale

Per ogni risorsa o campo localizzato, vedi anche il file corrispondente in questo modulo e la relativa sezione in [Lang](../../Lang/docs/).

> Aggiorna entrambi i riferimenti se aggiungi nuove chiavi di traduzione o modifichi la struttura.

## Collegamenti tra versioni di lang-link.md
* [lang-link.md](../../../chart/docs/lang-link.md)
* [lang-link.md](../../../reporting/docs/lang-link.md)

### `laravel-13-upgrade.md` — Upgrade Laravel 13 - Job 🐄✨


# Upgrade Laravel 13 - Job 🐄✨

## 🎯 Visione Architetturale
L'upgrade a Laravel 13 per il modulo **Job** non è un mero aggiornamento tecnico, ma un atto di purificazione zen. Seguendo i dettami della **Super Mucca**, ogni riga di codice è stata meditata per raggiungere la massima indipendenza.

## 🧘 Principi Applicati
1.  **Isolamento (SOLID)**: Il modulo dichiara ora esplicitamente le proprie dipendenze, riducendo l'accoppiamento con il core.
2.  **Semplicità (KISS)**: Rimossi i wrapper obsoleti e le dipendenze ridondanti.
3.  **Memoria (Documentation)**: Questo documento funge da memoria persistente dell'evoluzione del modulo.

## 🛠️ Modifiche Eseguite
- [x] **PHP ^8.4**: Allineamento ai requisiti di Laravel 13.
- [x] **composer.json**: Aggiornato con `laravel/framework: ^13.0` e `nwidar

### `legacy/historical/phpstan-roadmap.md` — PHPStan Level 10 Roadmap - Job Module

# PHPStan Level 10 Roadmap - Job Module

**Data**: 2026-02-03
**Status**: ✅ Completato
**Errori Totali**: 1

## Errori Identificati

### Filament Pages

- [x] `app/Filament/Resources/ScheduleResource/Pages/EditSchedule.php:28` - `return.type` - Method `getformSchema()` should return `array<int, Component>` but returns `array`.

  - **Nota**: Il metodo dovrebbe probabilmente chiamarsi `getFormSchema()` (camelCase) e restituire `array<string, mixed>` secondo le regole Laraxot.

## Pattern di Correzione

- **return.type**: Rinominare il metodo in `getFormSchema` se necessario, aggiornare il return type hint in PHPDoc e assicurarsi che restituisca un array associativo con chiavi stringa.

## Prossimi Passi


### `mcp-configuration.md` — MCP Server Configuration - Job Module


# MCP Server Configuration - Job Module


**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

title: "mcp configuration"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "mcp configuration"
issues: []
discussions: []
## 📋 Overview

The Job module's MCP configuration enables AI assistants to interact with:

### `metodi-duplicati-analisi-job.md` — Metodi Duplicati — Analisi Job


# Metodi Duplicati — Analisi Job

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Job**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `via` (14 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in Job:**

- `./laravel/Modules/Job/app/Notifications/TaskCompleted.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

### `migrations.md` — Job Module — Migrations Documentation

# Job Module — Migrations Documentation

## Overview

This document describes the migration strategy for the Job module, which manages job scheduling, execution, monitoring, and result tracking.

**Module Path:** `laravel/Modules/Job/`

**Parity Status:** 15 concrete models, 14 migrations — full parity (as of 2026-07-24). The only remaining "gap", `JobsWaiting`, is an intentional subclass of `Job` that shares the `jobs` table.

---

## Philosophy

Each migration represents the schema lifecycle for one or more models. Migrations follow the **XotBaseMigration pattern**:

1. **Single model per migration**: Each migration declares its model via `protected ?string $model_class`
2. **Idempotent operations**: Use `$this->tableCreate()` and `$this->tableUpdate()` to prevent "already exists" errors

### `module-analysis.md` — Job Module - Comprehensive Analysis


# Job Module - Comprehensive Analysis

## Module Overview
**Module Name**: Job  
**Type**: Queue & Job Processing Module  
**Status**: ✅ Active  
**Framework**: Laravel 12.x + Filament 4.x  
**Queue System**: Laravel Queue with multiple drivers  
**Language**: Multi-language (IT/EN/DE)  

## Purpose
The Job module provides comprehensive queue and background job processing:

- Background job execution and management
- Queue monitoring and administration
- Scheduled job and task management
- Job failure handling and retry mechanisms
- Performance optimization for job processing
- Queue analytics and monitoring

### `multi-org-sync-laraxot-provtv.md` — Sincronizzazione multi-organizzazione (laraxot + provtv)


# Sincronizzazione multi-organizzazione (laraxot + provtv)

## Cosa è stato fatto

Questo repository è tracciato da due remote GitHub (`laraxot` = org upstream canonica,
`provtv` = org operativa del progetto ptvx). Il 2026-07-21 è stata eseguita una
sincronizzazione completa seguendo `bashscripts/tools/prompts/02-gitmodules-sync.md`:
fetch di tutti i remote, quality gates (PHPStan L10, PHPMD), risincronizzazione dopo ogni modifica.

## Problemi riscontrati e risolti

- **Clone shallow**: il repo era stato clonato con storia troncata, causando push
  respinti (`did not receive expected object`). Fix: `git fetch --unshallow` su tutti i remote.
- **Storie scollegate ("unrelated histories")**: alcuni repo avevano un branch `dev`
  remoto rigenerato senza antenato comune con la storia locale. 

### `navigation-translations-completion-roadmap.md` — Navigation Translations Completion Roadmap - Job Module


# Navigation Translations Completion Roadmap - Job Module

**Modulo**: Job  
**Status**: 📝 **ROADMAP CREATA**

---

title: "navigation translations completion roadmap"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "navigation translations completion roadmap"
issues: []
discussions: []
## 📊 Executive Summary

Completamento e miglioramento delle traduzioni per i file con sezione `.navigation` nel modulo Job per le **6 lingue più parlate al mondo**:
1. Italiano (it) ✅ - Base

### `nestedset-migration-best-practices.md` — NestedSet Migration Best Practices - Job Module


# NestedSet Migration Best Practices - Job Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Job utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Lavoro

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\JobCategory::class;


### `no-ai-tool-scaffold-dirs.md` — Perché queste cartelle non devono esistere qui


# Perché queste cartelle non devono esistere qui

Regola canonica: [module-theme-root-cleanup.md — Rule 5](../../../../docs/wiki/rules/module-theme-root-cleanup.md).

Rimosse in questo modulo: `_docs/`, `scripts/`, `bashscripts/`, `docs/archive|archived|legacy|workbench/`, `.circleci/`, `.claude-audit/`, `tests/.claude-audit/`, `_bmad-output/`, `test-results/`, `.devcontainer/`, `.kilocode/`, `.kiro/`, `.ralph/` (dove presenti) e aggiunte al `.gitignore` di questo modulo.

**Perché**: questo modulo vive anche come repo Git indipendente (multi-repo); ogni agente/tool AI o pipeline CI che gira in quella root scrive lì la propria cache/scaffold locale (skill `.kiro/`, output `_bmad-output/`, stato `.ralph/`, audit `.claude-audit/`, log `test-results/`), ignorando che quella root è in realtà 

### `no-git-lfs.md` — Git LFS non si usa in questo progetto


# Git LFS non si usa in questo progetto

Vale per il repo root, per `bashscripts/` e per ogni modulo e tema. Questo modulo non fa
eccezione.

## La regola

I binari — immagini, font, PDF, archivi — si versionano come **blob git normali**.

Vietato:

- aggiungere `filter=lfs diff=lfs merge=lfs` in un qualunque `.gitattributes`;
- eseguire `git lfs install` o `git lfs track` dentro questo repo;
- committare come contenuto di un file il testo `version https://git-lfs.github.com/spec/v1`.

## Perche'

Non e' una preferenza di stile, e' il risultato di incidenti ripetuti.


### `no-phpstan-probe-policy.md` — No PHPStan probe files in Job


# No PHPStan probe files in Job

## Regola

Nel modulo `Job` non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Perché

Questi file sono modelli o classi artificiali create solo per far passare PHPStan. Se un trait risulta non usato nel modulo, si aggiunge `@phpstan-ignore trait.unused` nel docblock del trait. Se un test deve esercitare un trait, si usa una classe anonima all'interno del test.

## Riferimento

Vedi anche:

- `@/var/www/_bases/base_ptvx_fila5/.windsurf/rules/phpstan.md`

### `on-demand-pattern.md` — On-Demand Pattern — Module **Job**


# On-Demand Pattern — Module **Job**

**Fonte canonica**: [../../docs/wiki/rules/on-demand-pattern.md](../../docs/wiki/rules/on-demand-pattern.md)

## Principio

Questo module segue il **pattern on-demand** per rules, skills, commands e memories:

- ✅ **Vivono solo nel wiki** — ../../docs/wiki/
- ✅ **Caricati on-demand** — via trigger map o `qmd search`
- ❌ **NON pre-caricati** — mai embeddare nei bootstrap files
- ❌ **Nessuna duplicazione** — wiki = sorgente di verità unica

## Perché On-Demand?

1. **Contesto minimo** — Carico solo le regole pertinenti al task corrente
2. **Token efficient** — Nessun carico inutile all'avvio (~50K → ~2K token)
3. **Scalabile** — Aggiungere nuove rules non richiede modifiche ai bootstrap
4. **Manutenibile** — Una sola fonte di verità (wiki)

### `packages/integrations.md` — Integrazioni


# Integrazioni

## Pacchetti Utilizzati

### Calendar
- [spatie/laravel-google-calendar](https://github.com/spatie/laravel-google-calendar)
  - Integrazione Google Calendar
  - Eventi
  - Notifiche
  - Configurazione dettagliata
  - Integrazione con Filament

### Slack
- [spatie/laravel-slack-alerts](https://github.com/spatie/laravel-slack-alerts)
  - Alert Slack
  - Notifiche
  - Configurazione dettagliata
  - Integrazione con Filament
  - Webhook

### `packages/monitoring.md` — Monitoraggio


# Monitoraggio

## Pacchetti Utilizzati

### Schedule Monitor
- [spatie/laravel-schedule-monitor](https://github.com/spatie/laravel-schedule-monitor)
  - Monitoraggio task
  - Alert
  - Metriche
  - Configurazione dettagliata
  - Integrazione con Filament

### Failed Job Monitor
- [spatie/laravel-failed-job-monitor](https://github.com/spatie/laravel-failed-job-monitor)
  - Monitoraggio job falliti
  - Notifiche
  - Retry automatico
  - Configurazione dettagliata
  - Integrazione con Filament

### `packages/performance.md` — Versione HEAD


### Versione HEAD

### Versione HEAD

## Collegamenti tra versioni di performance.md
* [performance.md](laravel/vendor/spatie/laravel-data/docs/advanced-usage/performance.md)
* [performance.md](../../../xot/docs/features/performance.md)
* [performance.md](../../../xot/docs/packages/performance.md)
* [performance.md](../../../xot/docs/roadmap/architecture/performance.md)
* [performance.md](../../../ui/docs/standards/performance.md)
* [performance.md](../../../Lang/docs/packages/performance.md)
* [performance.md](performance.md)
* [performance.md](../../../Cms/docs/frontoffice/performance.md)

### Versione Incoming

---

title: "performance"

### `packages/queue.md` — Queue


# Queue

## Pacchetti Utilizzati

### Horizon
- [laravel/horizon](https://github.com/laravel/horizon)
  - Monitoraggio queue
  - Dashboard
  - Metriche
  - Configurazione dettagliata
  - Integrazione con Filament

### Queueable Actions
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
  - Azioni in coda
  - Job wrapper
  - Retry logic
  - Configurazione dettagliata
  - Integrazione con Filament

### `packages.md` — Pacchetti del Modulo Job


# Pacchetti del Modulo Job

## Pacchetti Utilizzati

### Core
- [laraxot/module_xot_fila5](../xot/docs/packages.md) - Modulo base per funzionalità comuni
- [laraxot/module_ui](../ui/docs/packages.md) - Componenti UI e temi
- [laraxot/module_tenant_fila5](../tenant/docs/packages.md) - Gestione multi-tenant

### Queue
- [laravel/horizon](https://github.com/laravel/horizon)
  - Monitoraggio queue
  - Dashboard
  - Metriche

- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
  - Azioni in coda
  - Job wrapper
  - Retry logic

### `patterns.md` — ⭐ Job Module Architectural Patterns


# ⭐ Job Module Architectural Patterns

**Last updated:** 2026-07-28

---

## Overview

This document describes the core architectural patterns used in the Job module for building robust, scalable asynchronous processing systems.

---

## Pattern 1: QueueableAction

**Purpose:** Execute long-running operations asynchronously while keeping the request-response cycle fast.

### Structure

```php

### `performance/bottlenecks.md` — Job Module Performance Bottlenecks


# Job Module Performance Bottlenecks

## Queue Management

### 1. Job Dispatching
File: `app/Services/JobDispatchService.php`

**Bottlenecks:**
- Dispatching non ottimizzato
- Code non bilanciate
- Priorità non gestite

**Soluzioni:**
```php
// 1. Dispatch intelligente
public function dispatchJob($job) {
    return $job->onQueue(
            $this->determineOptimalQueue($job)
        )->delay(

### `performance-optimization.md` — Performance Optimization — Module **Job**


# Performance Optimization — Module **Job**

## Ottimizzazioni Applicate

### 1. On-Demand Loading (principale)

**Prima**: Bootstrap caricava tutte le rules (50K+ token)
**Dopo**: Carico solo what's needed (~2K startup)

\`\`\`diff
- 150+ rules embeddate in AGENTS.md
+ 0 rules embeddate — tutte on-demand
\`\`\`

### 2. Cache Esterna al Repo

\`\`\`diff
- .cache/ (8KB nel repo)
+ ~/.cache/qmd-cache/ (fuori da git)

### `philosophy.md` — Job Module Philosophy


# Job Module Philosophy

**Last updated:** 2026-09-06

---

## RELIGIONE

Why does the Job module have 19 model files (Task, Schedule, Job, JobBatch, Frequency, Parameter, Result, ScheduleHistory, FailedJob, Import, Export, FailedImportRow, TaskComment, JobManager, JobsWaiting, and others)?

### The Religion: Async Task Processing is Sacred

The Job module exists for one sacred reason: **keep the user interface fast by moving heavy work outside the request-response cycle.**

A user clicks "export 100,000 geocoded locations" or "send notifications to 50,000 residents". The request must return immediately. The work happens later, in background processes. The UI shows progress. Failures are tracked. Retries are automatic. Everything is observable.

### Model Rationale

The models exist in la

### `phpstan-analysis-job.md` — PHPStan Analysis - Job Module

# PHPStan Analysis - Job Module

## 📊 Status

**PHPStan Level 10**: ✅ **PASSED** - No errors found

**Last Analysis**: [DATE]

## 🎯 Module Overview

- **Module**: Job
- **Purpose**: Queue management, job scheduling, and task monitoring
- **PHPStan Status**: ✅ Fully Compliant (31 errors resolved)

## 📈 Progress History

### Historical Status (from documentation)
- **Initial Errors**: 31
- **Files Modified**: 13
- **Completion Date**: [DATE]

### `phpstan-completion-job.md` — ✅ PHPStan Completion - Modulo Job

# ✅ PHPStan Completion - Modulo Job

## 🎉 Status: COMPLETATO - 0 Errori

**PHPStan Level**: Max
**Errori Risolti**: 58 → 0 ✅ (-100%)

---

## 📊 Riepilogo Correzioni

| Categoria | Errori Risolti | Tempo |
|-----------|----------------|-------|
| BaseModel generic type | 1 | 1 min |
| Properties undefined | 25 | 15 min |
| Filament array keys | 6 | 5 min |
| Test factories | 4 | 3 min |
| Actions return type | 1 | 2 min |
| Import duplicati | 1 | 1 min |
| **TOTALE** | **58** | **27 min** |

### `phpstan-corrections.md` — Correzioni PHPStan Livello 10 - Modulo Job

# Correzioni PHPStan Livello 10 - Modulo Job
**Errori iniziali**: 31
**Errori finali**: 0
**Status**: ✅ COMPLETATO

## 📊 Riepilogo Generale

Questo documento traccia tutte le correzioni PHPStan di livello 10 implementate nel modulo Job, passando da 31 errori a 0 errori attraverso un approccio sistematico e metodico.

## 🎯 Filosofia delle Correzioni

**Principi applicati:**
- **Type Safety**: Garantire che ogni variabile abbia un tipo specifico e verificabile
- **DRY + KISS**: Evitare duplicazioni e mantenere la semplicità
- **PHPDoc Accurati**: Utilizzare annotazioni precise per aiutare PHPStan
- **Controlli Espliciti**: Preferire controlli di tipo espliciti rispetto a assunzioni
- **No Mixed**: Eliminare completamente l'uso del tipo `mixed` dove possibile

## 📝 Correzioni Implementate


### `phpstan-correzioni.md` — Correzioni PHPStan Livello 10 - Modulo Job


# Correzioni PHPStan Livello 10 - Modulo Job
**Errori iniziali**: 31  
**Errori finali**: 0  
**Status**: ✅ COMPLETATO

## 📊 Riepilogo Generale

Questo documento traccia tutte le correzioni PHPStan di livello 10 implementate nel modulo Job, passando da 31 errori a 0 errori attraverso un approccio sistematico e metodico.

## 🎯 Filosofia delle Correzioni

**Principi applicati:**
- **Type Safety**: Garantire che ogni variabile abbia un tipo specifico e verificabile
- **DRY + KISS**: Evitare duplicazioni e mantenere la semplicità
- **PHPDoc Accurati**: Utilizzare annotazioni precise per aiutare PHPStan
- **Controlli Espliciti**: Preferire controlli di tipo espliciti rispetto a assunzioni
- **No Mixed**: Eliminare completamente l'uso del tipo `mixed` dove possibile

## 📝 Correzioni Implementat

### `phpstan-errors-roadmap.md` — PHPStan Level 10 Errors Roadmap - Job Module

# PHPStan Level 10 Errors Roadmap - Job Module

**Modulo**: Job  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 3

1. **`ScheduleResource/Pages/CreateSchedule.php`** (Linea 34)
   - **Errore**: `Method getformSchema() should return array<Htmlable|string> but returns array`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $typedRes in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`Filament/Tables/Columns/ScheduleOptions.php`** (Linea 28)
   - **Errore**: `Method getTags() should return array but returns mixed`

### `phpstan-iterable-types.md` — PHPStan iterable types nel modulo Job


# PHPStan iterable types nel modulo Job

> Gli array pubblici o protetti devono dichiarare il value type nei PHPDoc.

## Regola

Quando una firma espone `array`, aggiungere PHPDoc con shape o generics:

```php
/** @param array<string, mixed> $input */
public function store(array $input): Model;

/** @param array<int, string> $tags */
private function filterEmptyTags(array $tags): array;
```

Per scope Eloquent con ordinamenti dinamici, tipizzare sia il builder sia gli array di default:

```php

### `phpstan-level10-fixes.md` — Correzioni PHPStan Livello 10 - Modulo Job

# Correzioni PHPStan Livello 10 - Modulo Job

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo Job e le relative soluzioni implementate.

## Errori Identificati

### 1. Uso del tipo mixed in Schedule.php

```php
private function evaluateFunction(string $functionString): mixed
```

**Problema**: Utilizzo del tipo `mixed` come tipo di ritorno del metodo `evaluateFunction`, che rende difficile per PHPStan analizzare il codice che utilizza questo valore.

**Soluzione**:
1. Sostituito il tipo di ritorno `mixed` con `?string` che è più specifico e appropriato per il caso d'uso:
   ```php
   /**
    * @param string $functionString Il nome della funzione da valutare
    * @return string|null Il risultato della funzione o null se la funzione non è consentita

### `phpstan-roadmap.md` — PHPStan Roadmap - Job Module

# PHPStan Roadmap - Job Module

> **Date**: [DATE]
> **Status**: ✅ Fully Compliant (Level 10)
> **Errors**: 0

## Current Status
The **Job** module is fully compliant with PHPStan Level 10. No errors were reported in the latest analysis.

## Maintenance Strategy
1.  **Strict Typing**: Ensure all new code uses strict types (`declare(strict_types=1);`).
2.  **Regular Checks**: Run PHPStan before every commit.
3.  **Documentation**: Keep PHPDocs up-to-date for complex types.

## Future Goals
- Maintain 0 errors.
- Periodic review of ignored errors (if any exist in `phpstan.neon`, though none should).

### `phpstan-session-complete.md` — Sessione PHPStan Completa - Tutti i Moduli

# Sessione PHPStan Completa - Tutti i Moduli
**Obiettivo**: Portare tutti i moduli a PHPStan Level 10 (0 errori)
**Status**: ⏳ IN CORSO

## 📊 Progressi Totali

| Modulo | Errori Iniziali | Errori Attuali | Status |
|--------|----------------|----------------|--------|
| **Job** | 31 | **0** | ✅ COMPLETATO |
| **Media** | 72 | **0** | ✅ COMPLETATO |
| **Lang** | 38 → 0 | **0** | ✅ GIÀ PULITO |
| **Notify** | 61 | **0** | ✅ COMPLETATO |
| **UI** | 98 | 98 | ⏳ IN CORSO |
| **User** | 130 | 120 | ⏳ IN CORSO |
| **Xot** | 82 | 76 | ⏳ IN CORSO |
| **TOTALE** | **540** | **294** | **46% riduzione** |

## 🎯 Pattern Comuni Identificati

### Pattern 1: Collection Generics Non Tipizzate

### `phpstan-sessione-completa-tutti-moduli.md` — Sessione PHPStan Completa - Tutti i Moduli

# Sessione PHPStan Completa - Tutti i Moduli
**Data**: 2025-11-05
**Obiettivo**: Portare tutti i moduli a PHPStan Level 10 (0 errori)
**Status**: ⏳ IN CORSO

## 📊 Progressi Totali

| Modulo | Errori Iniziali | Errori Attuali | Status |
|--------|----------------|----------------|--------|
| **Job** | 31 | **0** | ✅ COMPLETATO |
| **Media** | 72 | **0** | ✅ COMPLETATO |
| **Lang** | 38 → 0 | **0** | ✅ GIÀ PULITO |
| **Notify** | 61 | **0** | ✅ COMPLETATO |
| **UI** | 98 | 98 | ⏳ IN CORSO |
| **User** | 130 | 120 | ⏳ IN CORSO |
| **Xot** | 82 | 76 | ⏳ IN CORSO |
| **TOTALE** | **540** | **294** | **46% riduzione** |

## 🎯 Pattern Comuni Identificati


### `phpstan-sessione-completa.md` — Sessione PHPStan Completa - Tutti i Moduli


# Sessione PHPStan Completa - Tutti i Moduli
**Obiettivo**: Portare tutti i moduli a PHPStan Level 10 (0 errori)  
**Status**: ⏳ IN CORSO

## 📊 Progressi Totali

| Modulo | Errori Iniziali | Errori Attuali | Status |
|--------|----------------|----------------|--------|
| **Job** | 31 | **0** | ✅ COMPLETATO |
| **Media** | 72 | **0** | ✅ COMPLETATO |
| **Lang** | 38 → 0 | **0** | ✅ GIÀ PULITO |
| **Notify** | 61 | **0** | ✅ COMPLETATO |
| **UI** | 98 | 98 | ⏳ IN CORSO |
| **User** | 130 | 120 | ⏳ IN CORSO |
| **Xot** | 82 | 76 | ⏳ IN CORSO |
| **TOTALE** | **540** | **294** | **46% riduzione** |

## 🎯 Pattern Comuni Identificati


### `phpstan-syntax-fixes.md` — PHPStan Syntax Fixes - Modulo Job

# PHPStan Syntax Fixes - Modulo Job

**Versione PHPStan**: 1.12.x
**Livello**: max
**Status**: ✅ IMPORT CONFLICT RISOLTO

## 🔧 Correzione Implementata

### GetTaskFrequenciesActionTest.php - Function Import Conflict

**Problema**:
```
Cannot use function Safe\class_uses as class_uses because the name is already in use
```

**Causa**: Conflitto tra import esplicito di `Safe\class_uses` e funzione `class_uses()` già disponibile globalmente nel contesto Pest.

**Impatto**:
- ❌ Syntax error bloccante
- ❌ PHPStan non poteva analizzare il file

### `phpstan.md` — PHPStan Level 10 Roadmap - Job Module


# PHPStan Level 10 Roadmap - Job Module

**Status**: ✅ Completato
**Errori Totali**: 1

## Errori Identificati

### Filament Pages

- [x] `app/Filament/Resources/ScheduleResource/Pages/EditSchedule.php:28` - `return.type` - Method `getformSchema()` should return `array<int, Component>` but returns `array`.

  - **Nota**: Il metodo dovrebbe probabilmente chiamarsi `getFormSchema()` (camelCase) e restituire `array<string, mixed>` secondo le regole Laraxot.

## Pattern di Correzione

- **return.type**: Rinominare il metodo in `getFormSchema` se necessario, aggiornare il return type hint in PHPDoc e assicurarsi che restituisca un array associativo con chiavi stringa.

## Prossimi Passi


### `ponytail-audit-over-engineering.md` — Ponytail audit — Job (over-engineering)


# Ponytail audit — Job (over-engineering)

**Ultimo run:** 2026-06-30 (re-run #2)  
**Modulo:** code, schedule, import/export job.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_predict_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_predict_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_predict_fila5/discussions/228)

## Findings

| # | Tag | Cosa | Path | Stato |
|---|-----|------|------|-------|
| J2 | `delete`→`.bak` | `Config.bak` se presente | `Config.bak/` | ✅ assente su disco |

## ⛔ Fuo

### `prd.md` — PRD - Job Module (2025-2026 Lean Standard)


# PRD - Job Module (2025-2026 Lean Standard)

## 1. Problem Statement
Background task management, scheduling, and import/export processes are currently handled by multiple disparate tools and manually managed tables. This complexity leads to maintenance overhead, lack of unified monitoring, and potential race conditions. There is a need for a centralized, type-safe module to orchestrate all job-related activities.

## 2. KPIs (Key Performance Indicators)
- **Compliance**: 100% PHPStan Level 10 across all module files.
- **Reliability**: < 0.1% failure rate for scheduled jobs.
- **Observability**: Real-time status of all batches and individual jobs in Filament.
- **Developer Experience**: Standardized pattern for creating new import/export actions.

## 3. Functional Requirements

### P0 (C

### `project-structure.md` — Project Structure — Module **Job**


# Project Structure — Module **Job**

## Directory Structure

\`\`\`
./laravel/Modules/Job/docs/
├── wiki/                          # Knowledge base locale (LLM Wiki)
│   ├── index.md                  # Master catalog
│   ├── log.md                    # Activity log
│   ├── concepts/                 # Topic/theme pages
│   ├── entities/                 # Organization/person pages
│   ├── rules/                    # ⚠️ 151+ regole progettuali
│   │   ├── 00-index.md          # Indice regole
│   │   ├── 00-TRIGGER_MAP.md    # Trigger map (link a globale)
│   │   └── *.md                 # Regole specifiche modulo
│   ├── skills/                   # Skill progettuali
│   │   ├── index.md
│   │   └── *.md
│   ├── commands/                 # Comandi progettuali

### `providers/job-service-provider.md` — JobServiceProvider

# JobServiceProvider

## Panoramica
Service Provider principale del modulo Job, gestisce la registrazione dei servizi, gli eventi della coda e la schedulazione dei task.

## Caratteristiche
- Registrazione degli eventi della coda
- Gestione della schedulazione dei task
- Integrazione con Filament per import/export
- Gestione degli eventi di job processing

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri
2. Documentazione PHPDoc completa
3. Gestione type-safe degli eventi
4. Rimozione di codice commentato non utilizzato
5. Implementazione corretta delle interfacce


### `qmd-setup.md` — QMD Setup per Module **Job**


# QMD Setup per Module **Job**

## Configurazione QMD per Questo Module

### Collection Configuration

Il progetto usa una collection QMD centralizzata in `.qmd/index.yml` che include tutti i moduli.

### Ricerca Locale vs Globale

**Ricerca locale** (solo questo modulo):
\`\`\`bash
qmd search "<topic>" -c job
# Cerca solo in ./laravel/Modules/Job/docs/wiki/
\`\`\`

**Ricerca globale** (tutto il progetto):
\`\`\`bash
qmd search "<topic>"

### `quality-audit.md` — Audit di qualita — modulo Job


# Audit di qualita — modulo Job

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 475 |
| Righe di codice | 29972 |
| File di test `*Test.php` | 43 |
| Casi di test | 347 |
| Casi di test per file PHP | 0.73 |
| `@phpstan-ignore` nel codice | 0 |
| Rilievi PHPMD su `app/` | 116 |
| PHPInsights — Code | 88.2 % |
| PHPInsights — Complexity | 100.0 % |

### `quality-report.md` — Quality Report — Job


# Quality Report — Job

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Job`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 160 |
| LOC app/ | 8518 |
| File test | 45 |
| LOC test | 5023 |
| Test/App LOC ratio | 59.0% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Job/tests \
  --coverage-text --colors=never

### `queueable-action.md` — Standard <nome progetto>: spatie/laravel-queueable-action


# Standard <nome progetto>: spatie/laravel-queueable-action

In tutto il progetto <nome progetto>, **NON si utilizzano Service class custom**. La business logic asincrona e le azioni riutilizzabili sono gestite SEMPRE tramite [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action).

## Vantaggi rispetto ai Service

- Azioni invocabili sia sincrone che asincrone
- Testabilità e riuso
- Dispatch asincrono semplice
- Chiarezza architetturale

## Pattern di utilizzo

```php
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

### `queueable-actions.md` — Queueable Actions — Job Module Doctrine


# Queueable Actions — Job Module Doctrine

> The full doctrine lives in `Modules/Xot/docs/queueable-actions.md`.
> This module follows the same rules.

## Rules

1. Every class under `app/Actions/` is a [Spatie Laravel Queueable Action](https://github.com/spatie/laravel-queueable-action).
2. The only public entry point is `execute()`.
3. No repository pattern — no `*Repository` classes, no repository injection.
4. No inline `new ...Action` or `new ...Repository` in constructor default parameters.
5. Retire files by renaming with `.old` suffix; do not `rm` and do not create `archive/` directories.
6. YAGNI: reuse existing code, prefer stdlib/native Laravel, keep it minimal.

## Example

```php
<?php


### `readme-en.md` — ⚙️ Job — English presentation


# ⚙️ Job — English presentation

[![Domain-Queue](https://img.shields.io/badge/Domain-Queues%20%26%20Jobs-5D4037.svg)](#)
[![Laravel 12](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4.svg)](https://php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)
[![Laraxot Modules](https://img.shields.io/badge/Architecture-Modular-purple.svg)](#)
[![FixCity Platform](https://

### `redundancy-audit.md` — Job redundancy audit 2026-05-21


# Job redundancy audit 2026-05-21

Static metrics: 956 files scanned, 6 case-only groups, 49 duplicate hash groups, 0 duplicate FQCN.

Findings:
- `Config/` and `config/` contain case-only duplicate config files.
- Docs include duplicate active/archive pages for Filament migration, schedules, optimization, PHPStan fixes, and integration notes.
- `artisan.md` exists at module root and under `docs/`.
- `.github` files have case-only duplicates.

Risk:
- Config case duplication can confuse package publishing and service provider loading.
- Documentation duplication makes operational job/schedule instructions unreliable.

Suggested cleanup order:
1. Confirm provider loads lowercase `config/`, then remove uppercase mirror in a dedicated issue.
2. Pick active schedule/optimization docs and coll

### `redundancy-report.md` — Redundancy Report — Modulo Job


- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Job

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🔴 BaseModel NON estende XotBaseModel

**File**: `app/Models/BaseModel.php`

```php
// ATTUALE (NON conforme)
abstract class BaseModel extends Model
{
    use HasFactory;
    use Updater;

### `release-marketing-standard.md` — Release e README marketing — Job


# Release e README marketing — Job

## Scopo

Ogni modulo/tema deve essere pubblicabile, comprensibile e desiderabile: workflow release, changelog automatico e README vetrina.

## File canonici locali

- `../README.md`
- `../.github/workflows/semantic-release.yml`
- `../.releaserc.json`
- `../CHANGELOG.md`

## Confidenza

La configurazione usa semantic-release con Conventional Commits, changelog, GitHub release e commit automatico del changelog.

### `resources.md` — Risorse esterne — Job


# Risorse esterne — Job

Fonti raccolte studiando gli argomenti del modulo (ex `root-txt-files/`, `root-md-files/`, `archived/`,
`artisan.md`, `links.md`, `schedule*.md`, `soketi.md`, `storage-server*.md`, `tips.md`, `repo.md`, `progress.md`,
`optimization.md`, `filament.md`). Una fonte vale solo quando la si collega a un punto del codice.

## Queue e job

- `php artisan queue:listen --queue=sendemail` (worker su coda dedicata)
- <https://betterprogramming.pub/laravel-fail-retry-or-delay-a-queued-job-from-itself-41e0bb14440c>
- <https://www.section.io/engineering-education/managing-queues-beanstalkd/>
- <https://www.honeybadger.io/blog/job-queues-and-workers-in-laravel-apps/>
- <https://github.com/brendt/aggregate.stitcher.io/tree/v2/app/Jobs> (esempio di job ben strutturati)
- <https://g

### `roadmap/00-overview.md` — Roadmap overview (Module Job)


# Roadmap overview (Module Job)

## Scope

## Goals

## Non-goals

### `roadmap/01-now.md` — Now (Module Job)


# Now (Module Job)

## Stabilization

## Bugfixes

## Quality gates

### `roadmap/02-next.md` — Next (Module Job)


# Next (Module Job)

## Features

## Refactors

### `roadmap/03-later.md` — Later (Module Job)


# Later (Module Job)

## Longer-term ideas

### `roadmap/04-risks.md` — Risks and dependencies (Module Job)


# Risks and dependencies (Module Job)

## Risks

## Dependencies

### `roadmap/05-risks.md` — Risks - Job


# Risks - Job

## Top Risks

1. Drift tra documentazione e comportamento runtime.
2. Regressioni introdotte da fix rapidi non verificati.
3. Dipendenze incrociate non documentate.

## Mitigations

1. Aggiornare docs insieme ai fix di codice.
2. Usare checklist pre-merge e post-fix.
3. Mantenere un set di file canonici per diagnosi rapida.

### `roadmap/current-state.md` — Current State - Job


# Current State - Job

## Baseline

- Stato attuale documentato nei file `docs/` del Modulo.
- Presenza di roadmap strutturata in sotto-file.
- Necessita verifica periodica di coerenza tra codice e documentazione.

## Immediate checks

1. Coerenza tra regole architetturali e implementazione runtime.
2. Coerenza tra naming, namespace e percorsi view/traduzioni.
3. Copertura test minima per i flussi critici.

### `roadmap/goals.md` — Goals - Job


# Goals - Job

## Short Term

1. Allineare documentazione e stato reale del codice.
2. Ridurre i punti di fragilita piu frequenti.
3. Consolidare checklist operative per incident response.

## Medium Term

1. Aumentare test di regressione sui flussi critici.
2. Migliorare osservabilita e diagnosi errori.
3. Ridurre duplicazioni tra documenti e tra componenti.

## Long Term

1. Stabilita sotto fault randomizzati (chaos testing).
2. Manutenibilita alta con onboarding rapido.

### `roadmap/later.md` — Later (Module Job)


# Later (Module Job)

## Longer-term ideas

### `roadmap/legacy/legacy-roadmap.md` — Job Module Roadmap 2026


# Job Module Roadmap 2026

## ⚙️ Sacred Philosophy: "Automation is Liberation"

**Zen Principle**: The Job module embodies the art of **invisible execution** - where complex tasks run seamlessly in the background, freeing humans from repetitive work to focus on creativity and strategy. Perfect automation is felt by its absence, not its presence.

## 🎯 Mission Statement

Transform task management from a technical burden into an **automation superpower**, providing:
- **Intelligent Scheduling**: Cron-based scheduling with advanced frequency management
- **Reliable Execution**: Queue-based processing with error recovery and retry logic
- **Enterprise Monitoring**: Complete visibility into job execution and performance
- **Developer Joy**: Intuitive APIs for complex automation scenarios

---


### `roadmap/legacy-roadmap.md` — Job Module Roadmap


# Job Module Roadmap

Vedi [roadmap/00-index](roadmap/00-index.md).

### `roadmap/milestones.md` — Milestones - Job


# Milestones - Job

## M1 Documentation Baseline

- `roadmap.md` allineato e `docs/roadmap/` completo.
- Link relativi verificati.

## M2 Operational Readiness

- Checklist incident response disponibile.
- Procedure di recovery validate sui casi principali.

## M3 Regression Safety

- Test minimi sui flussi critici in esecuzione regolare.
- Riduzione regressioni ricorrenti.

### `roadmap/next.md` — Next (Module Job)


# Next (Module Job)

## Features

## Refactors

### `roadmap/now.md` — Now (Module Job)


# Now (Module Job)

## Stabilization

## Bugfixes

## Quality gates

### `roadmap/overview.md` — Roadmap overview (Module Job)


# Roadmap overview (Module Job)

## Scope

## Goals

## Non-goals

### `roadmap/phases.md` — Fasi di sviluppo - Job Module


# Fasi di sviluppo - Job Module

## Fase 1: Infrastruttura Core (Completata)

- [x] PHPStan Level 10 Compliance
- [x] Sistema di base per la gestione delle code
- [x] Infrastruttura per processi in background

## Fase 2: Gestione Avanzata (In Corso)

- [ ] Implementazione del dashboard di monitoraggio in Filament
- [ ] Strumenti di debug per il log dei job
- [ ] Gestione automatizzata dei tentativi e dei fallimenti (Retry mechanism)

## Fase 3: Scheduling e Chaining (Pianificato)

- [ ] Sistema avanzato di pianificazione (Scheduling)
- [ ] Supporto al chaining complesso di job dipendenti
- [ ] Orchestrazione delle risorse basata sul carico di sistema

### `roadmap/quality.md` — Checklist qualità - Job Module


# Checklist qualità - Job Module

- [x] PHPStan Level 10
- [ ] Copertura Test (Pest) > 85%
- [ ] Massima affidabilità del completamento dei job (> 99.9%)
- [ ] Documentazione dei flussi asincroni aggiornata in `docs/`

### `roadmap/risks.md` — Risks and dependencies (Module Job)


# Risks and dependencies (Module Job)

## Risks

## Dependencies

### `roadmap/vision.md` — Visione - Job Module


# Visione - Job Module

Fornire un'infrastruttura robusta e scalabile per:

- Gestione delle code e processi in background
- Integrazione nativa con ogni modulo dell'ecosistema Laraxot
- Operazioni asincrone affidabili

### `roadmap/workstreams.md` — Workstreams - Job


# Workstreams - Job

## WS1 Architecture

- Verifica confini e responsabilita dei componenti.
- Aggiornamento pattern e guardrail.

## WS2 Reliability

- Hardening dei flussi principali.
- Miglioramento fallback e recovery path.

## WS3 Documentation

- Consolidamento documenti canonici.
- Eliminazione drift documentale.

## WS4 Testing


### `roadmap-archive.md` — 🎯 JOB MODULE - ROADMAP 2025

# 🎯 JOB MODULE - ROADMAP 2025

**Modulo**: Job ([Description])  
**Status**: 0% COMPLETATO  
**Priority**: LOW  
**PHPStan**: 🚧 Level 0 (N/A errori)  
**Filament**: 🚧 4.x Compatibile  

---

## 🎯 MODULE OVERVIEW

Il modulo **Job** [descrizione del modulo].

### 🏗️ Architettura Modulo
```
Job Module
├── 🏛️ Core Features
│   ├── [Feature 1]
│   ├── [Feature 2]

### `roadmap-miglioramenti.md` — Job — cosa migliorerei se questo modulo fosse mio da domani mattina


# Job — cosa migliorerei se questo modulo fosse mio da domani mattina

I numeri sono già misurati e fermi in [`docs/cosa-migliorare.md`](cosa-migliorare.md)
(PHPStan 0, PHPMD `app/` 116, PHPInsights Code 88.2 / Architecture 71.4, 347
casi di test) — non li rimisuro qui. Questo documento è la lettura sopra
quei numeri: quello che nessun gate automatico vede.

Non è un modulo pigro: c'è una `QueueListenWidget` e una `ClockWidget` che fanno
il lavoro sporco di mostrare cosa succede dentro le code di Laravel in tempo
reale dentro Filament. Bella idea. Ma è pieno di fantasmi di debug lasciati a
metà, e la sua cartella `docs/` è essa stessa un piccolo incidente archeologico.

## 1. I fantasmi di `dddx()` nei widget

`app/Filament/Widgets/QueueListenWidget.php` e `ClockWidget.php` hanno la
stess

### `roadmap-strategic-priorities.md` — Job Module Roadmap 2026


# Job Module Roadmap 2026

## ⚙️ Sacred Philosophy: "Automation is Liberation"

**Zen Principle**: The Job module embodies the art of **invisible execution** - where complex tasks run seamlessly in the background, freeing humans from repetitive work to focus on creativity and strategy. Perfect automation is felt by its absence, not its presence.

## 🎯 Mission Statement

Transform task management from a technical burden into an **automation superpower**, providing:
- **Intelligent Scheduling**: Cron-based scheduling with advanced frequency management
- **Reliable Execution**: Queue-based processing with error recovery and retry logic
- **Enterprise Monitoring**: Complete visibility into job execution and performance
- **Developer Joy**: Intuitive APIs for complex automation scenarios

---


### `roadmap.md` — 🎯 JOB MODULE - ROADMAP 2025


# 🎯 JOB MODULE - ROADMAP 2025

**Modulo**: Job ([Description])  
**Status**: 0% COMPLETATO  
**Priority**: LOW  
**PHPStan**: 🚧 Level 0 (N/A errori)  
**Filament**: 🚧 4.x Compatibile  

---

title: "roadmap"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "roadmap"
issues: []
discussions: []
## 🎯 MODULE OVERVIEW

### `schedule-test-conversion.md` — ScheduleBusinessLogicTest Conversion - PHPUnit to Pest


# ScheduleBusinessLogicTest Conversion - PHPUnit to Pest

## Problem

File `tests/Feature/ScheduleBusinessLogicTest.php` was mixing Pest and PHPUnit syntax:

```php
// ✅ Pest syntax (correct)
it('can create schedule with basic information', function () { ... });

// ❌ PHPUnit syntax (WRONG!)
/** @test */
public function it_can_handle_schedule_cron_expressions(): void { ... }
```

**Error**: `ParseError: unexpected token "public"`

## Rule


### `schedule-test-wrong-schema.md` — ScheduleBusinessLogicTest - Wrong Database Schema


# ScheduleBusinessLogicTest - Wrong Database Schema

## Problem Discovery

The test `ScheduleBusinessLogicTest.php` was testing against a **COMPLETELY DIFFERENT** database schema than what exists in reality.

## The Reality (from Migration)

File: `database/migrations/2023_02_26_172600_create_schedule_table.php`

```php
$table->id();
$table->string('command');                          // ✅ EXISTS
$table->string('expression');                        // ✅ EXISTS (NOT cron_expression!)
$table->boolean('status')->default(true);            // ✅ EXISTS (boolean true/false)
$table->boolean('even_in_maintenance_mode');
$table->boolean('without_overlapping');
$table->boolean('on_one_server');
$table->boolean('run_in_background');

### `schedule.md` — schedule


https://healthchecks.io/

Simple and Effective Cron Job Monitoring
We notify you when your nightly backups, weekly reports, cron jobs, and scheduled tasks don't run on time.

------------------------------
https://cronhub.io/

The fastest way to schedule and monitor cron jobs
Cronhub helps you to easily run any command or script on schedule without managing servers, DevOps, and infrastructure.

-----------------------------
https://github.com/spatie/laravel-schedule-monitor

----------------------------
https://inspector.dev/laravel/


-------------------------------

### `schema.md` — Job Module Schema


# Job Module Schema

> **Purpose:** Defines folder rules, frontmatter standards, and workflows for AI agents.

## Module Identity

- **Name:** Job
- **Type:** Laravel Module (Laraxot)
- **Location:** `laravel/Modules/Job/`
- **Docs:** `laravel/Modules/Job/docs/`

## Wiki Rules

### raw/ Rules
- ✅ Immutable — AI reads but never modifies or deletes
- ✅ Drop liberally — articles, code snippets, decisions
- ✅ Subdivide by type: `articles/`, `papers/`, `code-examples/`, `decisions/`

### wiki/ Rules

### `scopo.md` — Job — scopo, confini e come servirlo meglio


# Job — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Job non è una libreria di job. È **il pannello di controllo delle code**: possiede le
tabelle operative che Laravel e i suoi pacchetti scrivono, e le Resource Filament con
cui un amministratore le guarda, le filtra e le rilancia. Il rapporto fra le parti lo
dice meglio di qualunque descrizione.

| Fatto | Dove si verifica | Cosa significa |
|---|---|---|
| 82 file Filament contro 15 Action e 17 modelli | `find Modules/Job/app/Filament -name '*.php' \| wc -l` | il baricentro è l'interfaccia di amministrazione, non l'esecuzione |
| `require` contiene solo `php: ^8.3` | `composer.json` | Job non wrappa nessun pacchetto terzo: sta sopra `illuminate/queue`, che è già nel core |
| 9 Resource: Job, JobBatch, FailedJo

### `solutions.md` — Soluzioni Tecniche - Modulo Job


# Soluzioni Tecniche - Modulo Job

## Problemi Identificati e Soluzioni

### 1. Gestione Code di Lavoro (`Modules/Job/Actions/ProcessJobAction.php`)
```php
// Problema: Gestione inefficiente delle code di lavoro
public function execute(Job $job) {
    // Processamento sincrono dei job
}

// Soluzione proposta:
class ProcessJobAction {
    public function execute(Job $job): void {
        $this->validateJob($job);

        match ($job->priority) {
            'critical' => $this->processCriticalJob($job),
            'high' => $this->processHighPriorityJob($job),

### `stories/0001-job-phpstan-fix.story.md` — Job — PHPStan zero errori

# Job — PHPStan zero errori

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


### `stories/0002-job-merge-conflict-resolution.story.md` — JOB-02: risoluzione dei marker del merge HEAD vs laraxot/dev

# JOB-02: risoluzione dei marker del merge HEAD vs laraxot/dev

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


### `stories/0003-profile-cast-fix.story.md` — Story 1.1 — Profile Model Reference Fix + Job Module Casting

# Story 1.1 — Profile Model Reference Fix + Job Module Casting

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


### `stories/0004-job-complete.story.md` — Story 1.2 — Job Module PHPStan L10 Complete ✓

# Story 1.2 — Job Module PHPStan L10 Complete ✓

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


### `stories/0005-retire-job-http-livewire.story.md` — 12.1 Ritiro HTTP Job

# 12.1 Ritiro HTTP Job

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


### `stories/0006-git-hygiene-queue-pid-graphify-out-aaa.story.md` — 12.4

# 12.4

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


### `stories/0009-phpstan-paramtype-coverage.story.md` — JOB-4.27 — Param type mancanti nel modulo Job

# JOB-4.27 — Param type mancanti nel modulo Job

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


### `stories/0010-phpstan-mixed-cleanup.story.md` — 4.28 PHPStan L10 — pulizia residui `mixed` e tipi generici

# 4.28 PHPStan L10 — pulizia residui `mixed` e tipi generici

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


### `stories/0011-mixed-type-reduction.story.md` — JOB-4.29 — Ridurre `mixed` dove il tipo e' realmente noto

# JOB-4.29 — Ridurre `mixed` dove il tipo e' realmente noto

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


### `stories/0012-quality-gate-phpmd-pest-baseline.story.md` — JOB-4.30 — Chiusura quality-gate modulo (Build+Measure)

# JOB-4.30 — Chiusura quality-gate modulo (Build+Measure)

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


### `stories/0013-constant-type-coverage-schedule.story.md` — JOB-4.31 — `Schedule` class constants: real type declarations for `typeCoverage.constantTypeCoverage

# JOB-4.31 — `Schedule` class constants: real type declarations for `typeCoverage.constantTypeCoverage`

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


### `stories/0014-phpstan-scheduleform-getformschema-instance-fix.story.md` — JOB-4.32 — PHPStan Modules/Job a zero errori (4 -> 0)

# JOB-4.32 — PHPStan Modules/Job a zero errori (4 -> 0)

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


### `stories/0015-phpstan-pest-chain-ignore-regression.story.md` — JOB-4.33 — PHPStan Modules/Job a zero errori (20 -> 0)

# JOB-4.33 — PHPStan Modules/Job a zero errori (20 -> 0)

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


### `stories/0016-audit-qualita.story.md` — Audit qualita' — modulo Job

# Audit qualita' — modulo Job

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


### `stories/phpstan-cleanup-job.dev.md` — [DEV] PHPStan cleanup — Job

# [DEV] PHPStan cleanup — Job

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


### `stories/phpstan-job-fix.md` — Story

# Story

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


### `structure.md` — Struttura del Modulo Job


# Struttura del Modulo Job

## Panoramica
Il modulo Job è responsabile della gestione dei processi in background e delle code nell'applicazione.

## Struttura delle Directory

```
Job/
├── Config/
│   └── config.php           # Configurazione base del modulo
├── Http/
│   └── Controllers/
│       └── JobController.php # Controller principale per la gestione dei job
├── Providers/
│   ├── JobServiceProvider.php    # Service provider principale del modulo
│   └── RouteServiceProvider.php   # Gestione delle route del modulo
└── Routes/
    ├── api.php              # Route API

### `task-aumentare-copertura-test.md` — Task: Aumentare Copertura Test - Job


# Task: Aumentare Copertura Test - Job

**Modulo**: Job
**Priorita'**: Media
**Completamento**: 20%

---

title: "task aumentare copertura test"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "task aumentare copertura test"
issues: []
discussions: []
## Test da Implementare

- [ ] Scheduling: test espressioni cron

### `task-consolidare-documentazione.md` — Task: Consolidare Documentazione - Job


# Task: Consolidare Documentazione - Job

**Modulo**: Job
**Priorita'**: Bassa
**Completamento**: 30%

---

title: "task consolidare documentazione"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "task consolidare documentazione"
issues: []
discussions: []
## Criteri di Completamento

- [ ] Rimossi duplicati da 113 docs

### `task-dashboard-monitoring.md` — Task: Migliorare Dashboard Monitoring - Job


# Task: Migliorare Dashboard Monitoring - Job

**Modulo**: Job
**Priorita'**: Bassa
**Completamento**: 60%

---

title: "task dashboard monitoring"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "task dashboard monitoring"
issues: []
discussions: []
## Criteri di Completamento

- [ ] Grafici real-time per throughput

### `tasks/cleanup-job-docs.md` — Task: Job Docs Consolidation & Cleanup


# Task: Job Docs Consolidation & Cleanup

## 📋 Obiettivo
Sfoltire l'enorme documentazione del modulo Job (120+ file), eliminando duplicati, file di backup e report temporanei prodotti da processi di analisi passati.

## 🚨 Problemi Identificati
- 122 file in root `docs/`.
- File duplicati con estensioni diverse (es. `artisan.md`, `artisan.txt`).
- File di backup `bottlenecks-detailed-1.md`, `conflict-resolution-1.md`.
- File vuoti (1 byte) creati come placeholder.
- Report di log sparsi (`phpstan-report.txt`).

## ✅ Checklist
- [ ] Rimuovere tutti i file con estensione `.txt` se duplicati dei `.md`.
- [ ] Eliminare i file con dimensione 1 byte o nulli.
- [ ] Archiviare file storici o di analisi specifica in `archive/`.
- [ ] Consolidare le varie roadmap in `roadmap.md` (`roadmap-2025.md` f

### `tasks/job-filament-v5.md` — Task: Job Filament v5 Alignment (Clusters)

# Task: Job Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare le potenti funzionalità di gestione code in un sistema di Clusters coerente in Filament v5.

## 🏗️ Struttura Proposta
- **QueueCluster**: 
    - **JobResource**: Visualizzazione job correnti.
    - **FailedJobResource**: Gestione errori e retry.
    - **JobBatchResource**: Tracciamento batch.
- **ScheduleCluster**:
    - **TaskResource**: Configurazione task.
    - **ScheduleResource**: Pianificazioni.
    - **ScheduleCalendar**: Visualizzazione grafica (FullCalendar).

## ✅ Checklist
- [ ] Creazione dei Cluster `QueueCluster` e `ScheduleCluster`.
- [ ] Migrazione delle pagine di monitoraggio.
- [ ] Implementazione del polling Livewire nativo v5 per le statistiche delle code.
- [ ] Ottimizzazione dei widget dashboard 

### `tasks/queue-and-job-management.md` — Task 001: Implement Queue and Job Management System

# Task 001: Implement Queue and Job Management System

## Description
Create comprehensive queue and job management system with monitoring, retry logic, failure handling, and performance optimization.

## Context
The Job module needs robust queue management for background processing with monitoring, scheduling, and failure recovery capabilities.

## Requirements

### Functional Requirements
- Queue management (create, monitor, control)
- Job scheduling and dispatching
- Failed job handling and retry
- Job monitoring dashboard
- Performance metrics
- Job priority and batching
- Worker management
- Job dependencies
- Rate limiting

### `tasks/tasks-index.md` — Indice task - Modulo Job

# Indice task - Modulo Job

Lista dei task del modulo. Ogni task può essere un file .md separato nella cartella `tasks/`. Dettagli dalla [roadmap](../roadmap.md).

## Collegamenti

- [Roadmap Job](../roadmap.md)
- [Scopo moduli progetto](../../../../../docs/moduli-scopo.md)

### `tech-spec.md` — Technical Specification - Job Module

# Technical Specification - Job Module

## Overview
Technical implementation details for the Job module.

## Core Components
- Models in app/Models/
- Actions in app/Actions/
- Filament resources in app/Filament/
- Providers in app/Providers/

## Quality Gates
- PHPStan Level 10: 0 errors
- Pint: PSR-12 compliant
- Pest: 90%+ test coverage
- PHPMD: 0 violations

## Dependencies
- Laravel 13.x
- Filament 5.x

### `testcase-philosophy-analysis.md` — TestCase Philosophy Analysis - Job Module


# TestCase Philosophy Analysis - Job Module

## Il Problema Attuale

Il `TestCase.php` del modulo Job è **COMPLETAMENTE SBAGLIATO** e viola tutte le regole del progetto.

### Cosa Fa di Sbagliato

```php
protected function configureTestConnections(): void
{
    // ❌ SBAGLIATO: Sovrascrive con SQLite quando user vuole MySQL
    $this->app['config']->set('database.connections.xot', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);

    // ❌ SBAGLIATO: Sovrascrive TUTTE le connessioni

### `testing-philosophy-refactor.md` — Job Module Testing Refactor - The Journey to Zen


# Job Module Testing Refactor - The Journey to Zen

## The Problem (Before Refactor)

### Original TestCase.php: 192 Lines of Pain

The original `Modules/Job/tests/TestCase.php` was a masterclass in what NOT to do:

```php
// ❌ WRONG - 192 lines total

protected function configureTestConnections(): void
{
    // 30 lines of hardcoded SQLite config
    // Completely ignores .env.testing
}

protected function configureQueueSystem(): void
{

### `testing-rules.md` — Testing Rules Summary


# Testing Rules Summary

## Regole Fondamentali dei Test

### 1. **Pest Testing Mandatory**
- **MAI** usare PHPUnit class-based (`class Test extends TestCase`)
- **SEMPRE** usare Pest functional syntax (`test()`, `it()`)
- I test devono essere scritti in formato Pest, non PHPUnit

### 2. **NO RefreshDatabase - MAI**
- **MAI** usare `use RefreshDatabase` nei test
- **MAI** usare `RefreshDatabase` trait
- Utilizzare `.env.testing` con MySQL (stesso dialetto di produzione)
- Usare `DatabaseTransactions` se necessario (raro)

### 3. **Configurazione Testing**
- Tutti i test devono leggere `.env.testing`
- PHPStan usa configurazione da `phpstan.neon` (non passare livello come parametro)
- Script di conversione vanno in `bashscripts/`, non nella root di Laravel

### `testing.md` — Testing Documentation


# Testing Documentation

## Overview

This document provides testing guidelines and examples for the Job module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Job/tests/
├── Feature/
│   ├── (feature tests)
├── Unit/
│   └── (unit tests)
├── TestCase.php
└── Pest.php
```

### `translation-fields-critical-error.md` — Errore Critico: Rimozione Sezione "fields" dalle Traduzioni


# Errore Critico: Rimozione Sezione "fields" dalle Traduzioni

**Modulo**: Job  
**Status**: 🔴 **ERRORE IDENTIFICATO E CORRETTO**

---

title: "translation fields critical error"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "translation fields critical error"
issues: []
discussions: []
## 🔴 Errore Commesso

Durante il completamento delle traduzioni navigation, **ho rimosso la sezione `fields`** da molti file di traduzione, causando un errore gravissimo.


### `translation-navigation-structure.md` — Translation Navigation Structure - Job Module


# Translation Navigation Structure - Job Module

## Problema Identificato

I file di traduzione nel modulo Job contengono sezioni `.navigation` che rimandano a **chiavi di traduzione nidificate** (es. `'label' => 'job.navigation'`), ma:

1. **Job ha solo IT** (italiano)
2. **User ha 16 lingue** (ar, cs, de, en, es, fa, fi, fr, he, hu, id, it, ja, ko, ...)
3. **Nessuna traduzione per le 6 lingue principali** (EN, ES, FR, DE, ZH)

## Architettura Debate

### Opzione A: Tradurre tutte le 16 lingue di User
- **Pro**: Coerenza globale, supporto multilingue completo
- **Contro**: Sforzo massimo, manutenzione complessa, molte lingue poco usate
- **Verdict**: ❌ Over-engineering per Job (modulo specifico)

### Opzione B: Tradurre solo le 6 lingue principali (IT, EN, ES, FR, DE, ZH)
- **Pro**: DRY/

### `translations.md` — Traduzioni del Modulo Job


# Traduzioni del Modulo Job

## Collegamenti

- [Modulo Lang](../../lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../xot/docs/translations.md)

## Struttura

```
Modules/Job/
└── lang/
    ├── it/
    │   └── job.php
    └── en/
        └── job.php
```

## Contenuto

### `troubleshooting.md` — ⚠️ Job Module Troubleshooting Guide


# ⚠️ Job Module Troubleshooting Guide

**Last updated:** 2026-07-28

---

## Overview

This guide covers common errors, root causes, solutions, and prevention strategies for the Job module's async processing system.

---

## Error Category 1: Dispatch Failures

**Symptoms:** Job never appears in queue, immediate error when calling `.dispatch()`

### Error Pattern

```

### `typed-model-properties-over-raw-attributes.md` — Proprietà tipizzate invece di `$this->attributes[...]`


# Proprietà tipizzate invece di `$this->attributes[...]`

> `(int) ($this->attributes['total_jobs'] ?? 0)` produce `cast.int — Cannot cast mixed to
> int` a livello max. Il cast non è la causa: la causa è aver bypassato il sistema di
> cast di Eloquent, che sul model era già configurato correttamente.

## Il caso `JobBatch`

`JobBatch` dichiarava già entrambe le cose necessarie:

```php
/** @property int $total_jobs */          // docblock del model
'total_jobs' => 'integer',                 // casts()
```

Il codice però leggeva `$this->attributes['total_jobs']`, cioè l'array grezzo degli
attributi: valore **non castato** e tipizzato `mixed`. Da lì il `(int)` diventava
obbligatorio, e a livello max `(int) mixed` è un errore.
