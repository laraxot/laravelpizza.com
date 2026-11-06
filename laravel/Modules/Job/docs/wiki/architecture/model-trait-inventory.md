---
title: "Struttura dei metodi dei modelli Job"
type: architecture
module: Job
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [job, eloquent, model, traits, architecture]
qmd: "Job Task Schedule relations accessors mutators model traits methods inventory"
related:
  - ../index.md
---

# Struttura dei metodi dei modelli Job

Le classi modello compongono accessor, helper e relazioni tramite trait specifici
per modello. I nomi pubblici restano invariati, perciò le query Eloquent e i
consumatori esistenti mantengono lo stesso contratto.

| Trait | Metodi |
|---|---|
| [JobMutators](../../../app/Models/Traits/JobMutators.php) | `Job`: `getDisplayNameAttribute`/`getDisplayName` |
| [TaskMutators](../../../app/Models/Traits/TaskMutators.php) | `Task`: accessor/helper `activated`, `upcoming`, `last_result`, `average_runtime` |
| [TaskRelations](../../../app/Models/Traits/TaskRelations.php) | `Task`: `frequencies`, `results` |
| [TaskCommentRelations](../../../app/Models/Traits/TaskCommentRelations.php) | `TaskComment`: `task`, `user` |
| [FrequencyRelations](../../../app/Models/Traits/FrequencyRelations.php) | `Frequency`: `task`, `parameters` |
| [ScheduleHistoryRelations](../../../app/Models/Traits/ScheduleHistoryRelations.php) | `ScheduleHistory`: `command` |
| [ParameterRelations](../../../app/Models/Traits/ParameterRelations.php) | `Parameter`: `task` |
| [ResultRelations](../../../app/Models/Traits/ResultRelations.php) | `Result`: `task` |
| [ScheduleRelations](../../../app/Models/Traits/ScheduleRelations.php) | `Schedule`: `histories` |

Le relazioni mantengono i foreign key espliciti già usati da Eloquent e dagli
consumer. Le coppie accessor/helper sono conservate insieme nello stesso trait.
