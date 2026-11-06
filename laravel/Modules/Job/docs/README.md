---
title: "Job - documentazione del modulo (docs)"
type: documentation
module: Job
tags: [module, documentation]
created: 2026-06-05
updated: 2026-10-23
qmd: "job docs README ownership code map limiti scheduler code"
issues: []
discussions: []
related:
  - "../README.md"
  - "./00-index.md"
  - "./stories/02.Job-merge-conflict-resolution.story.md"
  - "./stories/docs-ingressi-job.story.md"
  - "./stories/job-admin-authorization.story.md"
status: active
---

# Job docs

Cartella `docs/` del modulo Job: documentazione a livello modulo. Per la panoramica
del modulo vedi il [README del modulo](../README.md); per la navigazione vedi
l'[indice](./00-index.md).

## Panoramica

Il modulo **Job** gestisce i job asincroni, le code di elaborazione e lo scheduler
di task persistiti su database (connessione dedicata `job`).

Ownership: pacchetto `laraxot/module_job_fila5` (`composer.json`), repo git separato in
`laravel/Modules/Job`; provider `Modules\Job\Providers\JobServiceProvider` e
`Providers\Filament\AdminPanelProvider` (`module.json`), entrambi su base `Xot`.

## Funzionalita'

- Gestione code e job (tabella `jobs`), job in attesa
- Retry e gestione dei job falliti (`failed_jobs`)
- Batch (`job_batches`) e monitoraggio esecuzioni (`JobManager`)
- Archivio di schedule su DB (`Schedule`, `ScheduleHistory`, `Task`) con esecuzione manuale
  dal widget; la registrazione automatica nello scheduler di Laravel NON e' attiva (vedi Limiti)
- Import/Export Filament (`Import`, `Export`, `FailedImportRow`)

## Modelli principali

Namespace `Modules\Job\Models`:

```php
Job::class          // tabella jobs
JobsWaiting::class  // sottoclasse vuota di Job (stessa tabella jobs), per la Resource dei job in attesa
FailedJob::class
JobBatch::class
JobManager::class   // tracciamento esecuzioni
Schedule::class     // + ScheduleHistory, Task, Result, Frequency
Import::class       // + Export, FailedImportRow
```

## Servizi e Actions

La logica di business nuova vive in Spatie Queueable Actions (`app/Actions/**`,
metodo `execute()`). Non esiste piu' nessun service: `ScheduleService` e' stato eliminato
(story [2026-10-08 services-to-actions](./stories/services-to-actions-job.story.md));
`ScheduleObserver` e `ScheduleClearCacheCommand` usano direttamente
`ClearScheduleCacheAction`. Le classi `JobDispatcher`, `QueueManager`, `JobService`, `JobScheduler`,
`JobMonitor` (come classe di servizio) e `FailureHandler`, citate in versioni precedenti di
questi docs (in particolare [index.md](./index.md)), non esistono nel modulo.

## Mappa del codice (verificata il 2026-10-14)

| Area | Contenuto reale |
|---|---|
| `app/Actions` | 13 classi: `ClearScheduleCacheAction`, `GetActiveSchedulesAction`, `ExecuteTaskAction`, `GetTaskCommandsAction`, `GetTaskFrequenciesAction`, `DummyAction`, `Command/` (3), `Console/` (4) |
| `app/Filament/Resources` | 9 Resource: `Job`, `JobsWaiting`, `FailedJob`, `JobBatch`, `JobManager`, `Schedule`, `Import`, `Export`, `FailedImportRow` (pagina `BoardJobs` in `JobResource`) |
| `app/Filament/Pages` | `Dashboard`, `JobMonitor`, `JobStatus` |
| `app/Filament/Widgets` | `ClockWidget`, `JobStatusWidget`, `QueueListenWidget`, `ScheduleCrudWidget`, `ScheduleStatusWidget` |
| `app/Console/Commands` | `schedule:clear-cache`, `schedule:test-job`, `worker:check`, `phpunit:test` |
| `app/Http/Livewire` | 4 file ancora presenti (`Broad`, `Job/Status`, `Schedule/Crud`, `Schedule/Status`) |
| `database/migrations` | 14 migrazioni (dai nomi dei file: jobs, job_batches, failed_jobs, job_manager, schedule, schedule_histories, tasks, frequencies, parameters, results, imports, exports, failed_import_rows, task_comments) |
| `routes/` | `web.php` vuoto, `api.php` interamente commentato: il modulo non espone rotte HTTP proprie |
| `tests/` | 47 file PHP, 43 `*Test.php` (Feature 10, Unit il resto) |
| `lang/` | `it`, `en`, `de`, `es`, `fr`, `nb_NO` e una sotto-cartella annidata `lang/lang/` |

Quick start (da `laravel/`): `php artisan module:list`, poi `./vendor/bin/pest Modules/Job`
e `./vendor/bin/phpstan analyse Modules/Job` (config unica `laravel/phpstan.neon`). L'esito di
questi due comandi non e' stato rieseguito per questa revisione dei docs.

## Limiti verificati

- `config/config.php` contiene solo `name` e `icon`; `config/Config/config.php` e' un array vuoto.
  Il codice legge pero' `job::model`, `job::cache.enabled|store|key`, `job::history_collapsed`
  (`GetActiveSchedulesAction`, `ClearScheduleCacheAction`, `ScheduleObserver`, `ViewSchedule`) e
  `jobs.pruning.activate|retention_days` (`JobManager`): nessuna di queste chiavi e' definita nel modulo.
- Lo scheduler su DB non e' collegato: in `JobServiceProvider::registerSchedule()` e `registerQueue()`
  tutto il corpo e' commentato, `Executing::dispatch` ed `Executed::dispatch` compaiono solo li', e
  `ScheduleObserver` non e' registrato in nessun punto di `app/`. `GetActiveSchedulesAction` non ha
  chiamanti di produzione.
- `ExecuteTaskAction` e' invocata solo da `ScheduleCrudWidget` e dal vecchio `Http/Livewire/Schedule/Crud`.
- Il README del modulo (`../README.md`) elenca ancora `Services` e `Phpstan` fra le aree di `app/`:
  non esistono piu' (fuori dal perimetro `docs/`, non modificato).

## Collegamenti

- [Architettura](./ARCHITECTURE.md)
- [Inventario Livewire e widget Filament](./bmad/livewire-inventory.md)
- [Xot base](../../Xot/docs/README.md)
- [Notify](../../Notify/docs/README.md) per le notifiche di fallimento job
- [Activity](../../Activity/docs/README.md) per il log di esecuzione

## Stories

- [02 Job - risoluzione marker di merge (2026-10)](./stories/02.Job-merge-conflict-resolution.story.md)
- [2026-10-06 PHPStan cleanup - Job](./stories/phpstan-cleanup-job.story.md) | [dev](./stories/phpstan-cleanup-job.dev.md)
- [2026-10-08 Services -> Actions (ScheduleService eliminato)](./stories/services-to-actions-job.story.md)
- [2026-10-14 Ingressi docs rivisti sul codice](./stories/docs-ingressi-job.story.md)
- [2026-10-29 Autorizzazione pagina e widget operativi (super-admin, allowlist, .env)](./stories/job-admin-authorization.story.md)
- [2026-10-30 Niente testi fissi nelle Blade (it, en, de, es)](./stories/blade-i18n-no-hardcoded-text.story.md)
- [Impostazioni: opzioni del worker avviato da worker:check (`JobConfigData`)](./bmad/stories/setting-page-campi-reali.story.md)

## Stato dell'organizzazione della cartella

Upstream (`laraxot/dev`) dichiara che `docs/wiki/` e `build_local/` sono stati
rimossi e che il contenuto di `_archive` e' in `docs-archive-2026/` alla radice del
modulo. Verificato il 2026-10-07: `docs/wiki/` e `docs/build_local/` esistono ancora,
`docs-archive-2026/` non esiste nel modulo. La pulizia non e' stata applicata in
questo repo e non e' oggetto della story di merge.