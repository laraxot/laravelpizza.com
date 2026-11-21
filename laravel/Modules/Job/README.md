---
id: module-job-readme
title: "Job - monitor e scheduler delle code"
type: module-readme
category: module-documentation
module: Job
status: active
created: 2026-09-14
updated: 2026-10-07
tags: [module, laraxot, job, queue, async, retries, scheduler]
qmd: "job queue async actions retries scheduler module documentation"
issues:
  - "https://github.com/laraxot/module_job_fila5/issues/54"
  - "https://github.com/laraxot/module_job_fila5/issues/59"
discussions:
  - "https://github.com/laraxot/module_job_fila5/discussions/55"
related:
  - "./docs/"
  - "./docs/architecture.md"
  - "./docs/bmad/livewire-inventory.md"
  - "./docs/stories/12.1.retire-job-http-livewire.story.md"
  - "./docs/stories/02.Job-merge-conflict-resolution.story.md"
sources: []
---

# Job

Gestione dei lavori asincroni: monitor delle code Laravel e scheduler di task
persistiti su database, con UI Filament.

## Cosa offre

- **Monitor delle code**: viste Filament sulle tabelle `jobs`, `failed_jobs`,
  `job_batches`, job in attesa e `JobManager` (tracciamento delle esecuzioni).
- **Scheduler su DB**: `Schedule`, `ScheduleHistory` e `Task` (cron, comando,
  opzioni, stato) con azioni accodabili (Spatie Queueable Actions, metodo `execute()`).
- **Import/Export**: risorse Filament su `imports`, `exports` e `failed_import_rows`.
- **Retry e stato**: gestione dei fallimenti e dello stato dei job.
- **Widget**: `JobStatusWidget`, `ScheduleStatusWidget`, `ScheduleCrudWidget`,
  `QueueListenWidget`, `ClockWidget` e pagina `JobMonitor`.
- **Integrazione** con Activity e Notify per log di esecuzione e notifiche di fallimento.

## Confini architetturali

- Connessione database dedicata `job` (`Modules\Job\Models\BaseModel::$connection`).
- Tabella e form di una Resource vivono nelle classi `Tables/<Plurale>Table` e
  `Schemas/<Model>Form` risolte da `XotBaseResource`; i vecchi componenti
  `Http/Livewire` sono sostituiti dai widget Filament (vedi
  [livewire inventory](./docs/bmad/livewire-inventory.md)).
- Architettura: [docs/architecture.md](./docs/architecture.md).

## Scheda tecnica verificata (2026-10-07)

| Voce | Valore |
|---|---|
| Nome dichiarato | `Job` (alias `job`, vedi `module.json`) |
| Namespace | `Modules\Job\` |
| File PHP (escluso vendor e node_modules) | 484 |
| File PHP in `tests/` | 49 (45 `*Test.php`) |
| File PHP in `database/` | 45 (di cui 14 migrazioni) |
| Aree `app/` | Actions, Console, Contracts, Datas, Entities, Enums, Events, Filament, Http, Models, Notifications, Observers, Phpstan, Providers, Rules, Services, Traits, View |
| SSoT locale | [`docs/`](docs/) e [`docs/bmad/`](docs/bmad/) |

Questa scheda e' un inventario statico, non una dichiarazione di qualita'. I numeri
vanno rigenerati quando il modulo cambia; non copiarli in badge non verificati.
Il precedente inventario (2026-09-28) riportava 506 file PHP, 76 di test e
"45 migrazioni": il 45 contava tutti i file di `database/`, le migrazioni sono 14.

## Gate di qualita'

Dal progetto Laravel:

```bash
cd laravel
php artisan module:list
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Job
./vendor/bin/pest Modules/Job
```

Ultimo esito noto: PHPStan su `Modules/Job` exit 0 dopo la risoluzione dei marker
di merge (story [02.Job-merge-conflict-resolution](./docs/stories/02.Job-merge-conflict-resolution.story.md)).

## Storico

- 2026-09-28: aggiunta la scheda tecnica e il README (docs 0 a 60, auto-valutazione
  73/100 grado C); ridotta la nidificazione in `GetTaskCommandsAction`; QA gate superato.
- 2026-10-07: risolti i marker di conflitto committati in `e7e667b11` (questo file incluso).

**Modulo** `job` | **Laraxot** | PHPStan max | Filament 5
