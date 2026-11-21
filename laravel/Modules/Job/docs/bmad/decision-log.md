---
title: "Decision log — Job"
type: decision-log
status: active
updated: 2026-11-16
module: Job
qmd: "decision log Job ADR scheduler monitor policy Team boilerplate Livewire legacy story 12.1 riaperta"
related:
  - ./audits/job-audit.md
  - ./epics.md
  - ../decision-log.md
---

# Decision log — Job

Append-only, più recente in alto. Il registro precedente (`../decision-log.md`) contiene la decisione sull'enum `Status` di `Schedule` (2026-10-08) e un'entry template; resta come storico.

| ID | Data | Stato | Decisione | Perché | Evidenza |
|---|---|---|---|---|---|
| D-5 | 2026-11-16 | **APPROVATA** | Le tre policy Team (`Job`, `FailedJob`, `JobBatch`) passano a `JobBasePolicy` | Deny-by-default e bypass `job::admin`; oggi `create()` = true | `JobPolicy.php:11,32` |
| D-4 | 2026-11-16 | **APPROVATA** | Riaprire la story 12.1 (ritiro `Http/Livewire`) | Era `done`, il codice dice il contrario (`Broad.php:41` con `dd()`) | `docs/stories/12.1.retire-job-http-livewire.story.md`, `Http/Livewire/_components.json` |
| D-3 | 2026-11-16 | **APPROVATA** | `JobResource` senza `CreateJob`/`EditJob`/`JobForm` | La tabella `jobs` è scritta dalla coda, non da una persona | `JobResource.php:31`, `JobForm.php:26` |
| D-2 | 2026-11-16 | **APERTA** | Scheduler su DB: cablare o ritirare dalla UI | Promette esecuzioni che non avvengono; "esegui ora" fallisce | `JobServiceProvider.php:38,48-66`, `ExecuteTaskAction.php:18` |
| D-1 | 2026-11-16 | PROPOSTA | Pattern unico per i comandi Artisan da UI: `SuperAdminOnlyTrait` + allowlist a match esatto | È già lo standard di `JobStatus`; gli altri 4 widget e il legacy lo ignorano | `JobStatusWidget.php`, `ScheduleStatusWidget.php:24-43` |
| D-0 | 2026-10-08 | APPROVATA (storica) | `Schedule` usa l'enum `Status` al posto delle costanti | Ultima versione buona, ripristinata dal blob `788ff149` | `../decision-log.md` |

## D-2 — opzioni

- **A. Cablare:** riattivare `registerSchedule`, hook `Queue::before/after/failing`, implementare `ExecuteTaskAction`, popolare `ScheduleHistory`/`Result`. Realizza lo scopo ([purpose § 4](./purpose.md)); costo: Pest su un `Schedule` fittizio e attenzione a `schedule:run` doppio (cron + DB).
- **B. Ritirare:** modulo "solo monitor"; togliere `ScheduleResource`, widget Schedule, "esegui ora". Meno codice, scopo ridotto.
- Raccomandazione dell'audit: **B** finché non c'è un consumatore reale (YAGNI); A solo con story e committente.

## Regole

Una decisione `PROPOSTA` diventa `APPROVATA` con story BMAD e Pest verde. Non riscrivere le voci passate: superarle.
