---
title: "Job: audit, decisioni ed epiche"
type: audit
module: Job
status: active
qmd: "audit Job finding policy create scheduler registerSchedule ExecuteTaskAction Livewire legacy widget guard decisioni D-0..D-5 epiche E1..E7 ECC"
related:
  - ./README.md
  - ./architecture.md
  - ./stories/0005-e1-job-policy-create-deny.story.md
  - ./bmad/stories/0006-module-bmad-audit.story.md
---

# Job: audit, decisioni ed epiche

Sintesi dell'audit source-first del 2026-11-16 (inventario filesystem, `rg` con `path:line`, lettura dei file
critici), **ri-verificata sul codice il 2026-11-25**: ogni finding riporta lo stato di oggi. Dove codice e docs
divergevano, ha vinto il codice. L'esposizione runtime dei finding sull'autorizzazione non e' stata provata in un
browser: e' dedotta dal codice e va chiusa con Pest.

## Stato dei finding

| ID | Finding | Stato 2026-11-25 |
|---|---|---|
| P0-1 | `create()` = true su `Job`/`FailedJob`/`JobBatch`: chiunque entri nel pannello puo' scrivere un `payload` nella tabella che il worker consuma | **chiuso** (E1): le tre policy estendono `JobBasePolicy`, `create()` = false; `JobResource` senza `CreateJob`/`EditJob` |
| P0-2 | Scheduler su DB non cablato: `registerSchedule` e gli hook `Queue::before/after/failing` sono commentati in `JobServiceProvider`; `ExecuteTaskAction` lancia `BadMethodCallException` | **aperto** (D-2): confermato, il pulsante "esegui ora" di `ScheduleCrudWidget` produce un errore |
| P1-1 | `app/Http/Livewire/` legacy (`Broad`, `Job/Status`, `Schedule/Status`, `Schedule/Crud`) ancora presente e registrato: `Artisan::call($cmd)` senza allowlist ne' auth, `saveEnv()` riscrive `.env` senza controllo, `dd('fine')` in `Broad` | **aperto** (E3): le 4 classi e i 4 alias in `_components.json` esistono; la story 12.1 era data per "done" a torto |
| P1-2 | Widget con effetti operativi senza guard: solo `JobStatus` e `JobStatusWidget` usano `SuperAdminOnlyTrait`; `ScheduleStatusWidget` ammette `schedule:run` e `schedule:clear-cache` a chiunque lo veda; `ClockWidget` e `QueueListenWidget` avviano `queue:listen` in un loop `sleep(3)` dentro la richiesta Livewire | **aperto** (E4) |
| P1-3 | `ScheduleStatusWidgetTest` invocava `migrate:fresh` su un widget reale | **chiuso** (E5): ora il kernel Artisan e' mockato con `->never()` |
| P1-4 | Documentazione che contraddice il codice (architettura circolare, purpose troncato, inventario Livewire obsoleto) | **chiuso** con la riscrittura di [README.md](README.md) e [architecture.md](architecture.md) |
| P2 | `ScheduleService` ancora presente (solo un test lo usa) e in `tests/Arch/debt.php`; 2 coppie di Action duplicate (le piatte sono marcate SUPERSEDED); `DummyAction` con `echo`; `app/Console/Commands/queue.pid`, `app/Services/ScheduleService.php.bak` e `.gitignore.bak` nell'albero; `tests/Unit/ScratchA9TmpTest.php` temporaneo; `TaskComment` e `TaskCommentRelations` importano `Modules\User\Models\User` concreto invece di `XotData`/`UserContract`; titoli letterali in `FailedJobsTable`, `JobBatchesTable`, `ListJobBatches`; `exec()` in `WorkerCheck` (la riga viene da `BuildQueueWorkerCommandAction` con soli interi, vedi ADR 0003) | **aperto** |

### Cosa e' stato verificato e non e' un finding

- `JobStatus` (pagina) e `JobStatusWidget`: super-admin, allowlist a match esatto
  (`AssertAllowedArtisanCommandAction`), `QUEUE_CONNECTION` validato contro `config('queue.connections')`,
  `old_value` `#[Locked]`; coperti da `JobStatusAuthorizationTest` e `JobStatusWidgetEnvWriteTest`.
- Le 13 policy di sola ereditarieta' da `JobBasePolicy`: deny-by-default con bypass `super-admin`/`job::admin`.
- `DB::raw` in `Result`, `JobsWaitingOverview`, `JobStatsOverview`: espressioni costanti, nessun input.
- `strict_types` ovunque, nessun `RefreshDatabase`, nessuna baseline PHPStan.

## Decisioni

Append-only, la piu' recente in alto. Una decisione `PROPOSTA` diventa `APPROVATA` con story BMAD e Pest verde.

| ID | Stato | Decisione e perche' |
|---|---|---|
| D-5 | approvata | Le tre policy Team (`Job`, `FailedJob`, `JobBatch`) passano a `JobBasePolicy`: deny-by-default e bypass `job::admin`; prima `create()` era true. |
| D-4 | approvata | Riaprire la story 12.1 (ritiro `Http/Livewire`): era `done` ma `Broad.php` conteneva ancora `dd()`. |
| D-3 | approvata | `JobResource` senza `CreateJob`/`EditJob`/`JobForm`: la tabella `jobs` e' scritta dalla coda, non da una persona. |
| D-2 | **aperta** | Scheduler su DB: cablare o ritirare dalla UI. Opzione A: riattivare `registerSchedule` e gli hook di coda, implementare `ExecuteTaskAction`, popolare `ScheduleHistory`/`Result`, con Pest su un `Schedule` fittizio e senza doppio `schedule:run` (cron piu' DB). Opzione B: modulo "solo monitor", togliere `ScheduleResource`, widget Schedule e "esegui ora". L'audit raccomanda B finche' non c'e' un consumatore reale (YAGNI). |
| D-1 | proposta | Pattern unico per i comandi Artisan da UI: `SuperAdminOnlyTrait` + allowlist a match esatto (e' gia' lo standard di `JobStatus`). |
| D-0 | approvata (storica, 2026-10-08) | `Schedule` usa l'enum `Status` al posto delle costanti. |

Decisioni formali di architettura: [adr/index.md](adr/index.md) (allowlist a match esatto, `jobs` in sola lettura
nell'admin, flag del worker dal tenant).

## Epiche e piano

Ogni epica diventa una story BMAD prima di toccare il codice. Gate: PHPStan = 0 sul modulo, Pest mirato su DB di
test (mai `migrate:fresh`, `RefreshDatabase`, `--force`), poi docs.

| Epica | Contenuto | Stato |
|---|---|---|
| E1 | Autorizzazione di `Job`/`FailedJob`/`JobBatch` (P0-1): 3 policy su `JobBasePolicy`, `JobResource` senza create/edit, Pest deny-default ([story 0005](stories/0005-e1-job-policy-create-deny.story.md)) | fatta |
| E2 | Scheduler: decidere D-2 con un committente e allineare codice, UI e docs | aperta |
| E3 | Ritiro `Http/Livewire`: cancellare le 4 classi, le viste e `_components.json`; Pest che fallisce se `app/Http/Livewire/*.php` esiste; `rg 'dd\('` = 0 | aperta |
| E4 | `SuperAdminOnlyTrait` su `ScheduleStatusWidget`, `ScheduleCrudWidget`, `ClockWidget`, `QueueListenWidget`; via il loop `sleep` + `queue:listen`; Pest `Livewire::test` 403 per non super-admin | aperta |
| E5 | Test onesti: kernel mockato in `ScheduleStatusWidgetTest` (fatto); resta da togliere `ScratchA9TmpTest.php` e da scrivere almeno un `Livewire::test` per pagina/widget operativo (oggi 0 file con `Livewire::test`, 25 file che usano `ReflectionClass`) | parziale |
| E6 | Notificare il fallimento a chi ha chiesto il lavoro (dipende da E2: stesso punto d'aggancio sugli hook di coda) | da definire |
| E7 | Debito P2: `ScheduleService` in Action o cancellazione, unificare le 2 coppie di Action, via il junk, i18n dei titoli, modello utente via `XotData` | aperta |

## Stato dei controlli ECC

| Controllo | Esito |
|---|---|
| Inventario statico | verificato (sezione sopra e [architecture.md](architecture.md)) |
| PHPStan `Modules/Job` | 0 errori all'audit (2026-11-16), anche sul tree `Modules` |
| Pest | parziale all'audit: `JobStatusAuthorizationTest` 17 pass; suite completa non eseguita per carico macchina. Pest non si esegue in produzione e richiede DB di test raggiungibile |
| Security review | P0-1 chiuso; restano P0-2 e i P1 |
| Anti-pattern vietati | baseline o `@phpstan-ignore` senza motivazione; test svuotati per silenziare errori; `migrate:fresh`/`RefreshDatabase`/`--force`; docs con date nel nome; comportamento o screenshot inventati |

Storico dell'audit: [bmad/stories/0006-module-bmad-audit.story.md](bmad/stories/0006-module-bmad-audit.story.md).
