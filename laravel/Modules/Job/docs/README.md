---
title: "Job - documentazione del modulo (docs)"
type: documentation
module: Job
tags: [module, documentation]
created: 2026-06-05
updated: 2026-10-07
qmd: "README"
issues: []
discussions: []
related:
  - "../README.md"
  - "./00-index.md"
  - "./stories/02.Job-merge-conflict-resolution.story.md"
---

# Job docs

Cartella `docs/` del modulo Job: documentazione a livello modulo. Per la panoramica
del modulo vedi il [README del modulo](../README.md); per la navigazione vedi
<<<<<<< .merge_file_QWWeV9
l'[indice](00-index.md).
=======
<<<<<<< .merge_file_OsEwtW
l'[indice](00-index.md).
=======
l'[indice](./00-index.md).
>>>>>>> .merge_file_x37Z3p
>>>>>>> .merge_file_JnbJW6

## Panoramica

Il modulo **Job** gestisce i job asincroni, le code di elaborazione e lo scheduler
di task persistiti su database (connessione dedicata `job`).

## Funzionalita'

- Gestione code e job (tabella `jobs`), job in attesa
- Retry e gestione dei job falliti (`failed_jobs`)
- Batch (`job_batches`) e monitoraggio esecuzioni (`JobManager`)
- Scheduler su DB (`Schedule`, `ScheduleHistory`, `Task`)
- Import/Export Filament (`Import`, `Export`, `FailedImportRow`)

## Modelli principali

Namespace `Modules\Job\Models`:

```php
Job::class          // tabella jobs
JobsWaiting::class  // vista sulla stessa tabella jobs (job in attesa)
FailedJob::class
JobBatch::class
JobManager::class   // tracciamento esecuzioni
Schedule::class     // + ScheduleHistory, Task, Result, Frequency
Import::class       // + Export, FailedImportRow
```

## Servizi e Actions

La logica di business nuova vive in Spatie Queueable Actions (`app/Actions/**`,
metodo `execute()`). L'unico service rimasto e' `Modules\Job\Services\ScheduleService`
(vedi story [job-services-to-actions](./stories/job-services-to-actions.story.md)).
Le classi `JobDispatcher` e `QueueManager`, citate in una versione precedente di
questo file, non esistono nel modulo.

## Collegamenti

- [Architettura](./architecture.md)
- [Inventario Livewire e widget Filament](./bmad/livewire-inventory.md)
- [Xot base](../../Xot/docs/README.md)
- [Notify](../../Notify/docs/readme.md) per le notifiche di fallimento job
- [Activity](../../Activity/docs/README.md) per il log di esecuzione

## Stories

- [02 Job - risoluzione marker di merge (2026-10)](./stories/02.Job-merge-conflict-resolution.story.md)
- [2026-10-06 PHPStan cleanup - Job](./stories/2026-10-06-phpstan-cleanup-job.story.md) | [dev](./stories/2026-10-06-phpstan-cleanup-job.dev.md)

## Stato dell'organizzazione della cartella

Upstream (`laraxot/dev`) dichiara che `docs/wiki/` e `build_local/` sono stati
rimossi e che il contenuto di `_archive` e' in `docs-archive-2026/` alla radice del
modulo. Verificato il 2026-10-07: `docs/wiki/` e `docs/build_local/` esistono ancora,
`docs-archive-2026/` non esiste nel modulo. La pulizia non e' stata applicata in
questo repo e non e' oggetto della story di merge.
