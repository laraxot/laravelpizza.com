---
title: "censimento omonimi metodi — modulo Job"
type: analysis
module: Job
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Job

> **61** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Job)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 26 |
| `E_scheda_stack` | 8 |
| `G_module_local` | 7 |
| `H_cross_module_homonym` | 20 |

## Dettaglio

### `A_filament_framework` (26 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `Job` · `JobBasePolicy` · `Modules/Job/app/Models/Policies/JobBasePolicy.php`

#### `via` — 14 classi

- `Job` · `TaskCompleted` · `Modules/Job/app/Notifications/TaskCompleted.php`

#### `getHeaderWidgets` — 13 classi

- `Job` · `JobStatus` · `Modules/Job/app/Filament/Pages/JobStatus.php`
- `Job` · `ListJobsWaiting` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaiting.php`
- `Job` · `ListJobsWaitings` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaitings.php`

#### `toMail` — 10 classi

- `Job` · `TaskCompleted` · `Modules/Job/app/Notifications/TaskCompleted.php`

#### `validate` — 8 classi

- `Job` · `Corn` · `Modules/Job/app/Rules/Corn.php`

#### `getActions` — 6 classi

- `Job` · `ActionGroup` · `Modules/Job/app/Filament/Columns/ActionGroup.php`
- `Job` · `ActionGroup` · `Modules/Job/app/Filament/Tables/Columns/ActionGroup.php`

#### `rules` — 6 classi

- `Job` · `ScheduleRequest` · `Modules/Job/app/Http/Requests/ScheduleRequest.php`

#### `updated` — 4 classi

- `Job` · `ScheduleObserver` · `Modules/Job/app/Observers/ScheduleObserver.php`

### `G_module_local`

#### `task` — 4 classi

- `Job` · `Frequency` · `Modules/Job/app/Models/Frequency.php`
- `Job` · `Parameter` · `Modules/Job/app/Models/Parameter.php`
- `Job` · `Result` · `Modules/Job/app/Models/Result.php`
- `Job` · `TaskComment` · `Modules/Job/app/Models/TaskComment.php`

#### `artisan` — 2 classi

- `Job` · `JobStatus` · `Modules/Job/app/Filament/Pages/JobStatus.php`
- `Job` · `Status` · `Modules/Job/app/Http/Livewire/Job/Status.php`
- `Job` · `Status` · `Modules/Job/app/Http/Livewire/Schedule/Status.php`

#### `beginProcess` — 2 classi

- `Job` · `ClockWidget` · `Modules/Job/app/Filament/Widgets/ClockWidget.php`
- `Job` · `QueueListenWidget` · `Modules/Job/app/Filament/Widgets/QueueListenWidget.php`

#### `beginStream` — 2 classi

- `Job` · `ClockWidget` · `Modules/Job/app/Filament/Widgets/ClockWidget.php`
- `Job` · `QueueListenWidget` · `Modules/Job/app/Filament/Widgets/QueueListenWidget.php`

#### `getTags` — 2 classi

- `Job` · `ScheduleArguments` · `Modules/Job/app/Filament/Columns/ScheduleArguments.php`
- `Job` · `ScheduleOptions` · `Modules/Job/app/Filament/Columns/ScheduleOptions.php`
- `Job` · `ScheduleArguments` · `Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php`
- `Job` · `ScheduleOptions` · `Modules/Job/app/Filament/Tables/Columns/ScheduleOptions.php`

#### `onValidationError` — 2 classi

- `Job` · `CreateSchedule` · `Modules/Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php`
- `Job` · `EditSchedule` · `Modules/Job/app/Filament/Resources/ScheduleResource/Pages/EditSchedule.php`

#### `withValue` — 2 classi

- `Job` · `ScheduleArguments` · `Modules/Job/app/Filament/Columns/ScheduleArguments.php`
- `Job` · `ScheduleOptions` · `Modules/Job/app/Filament/Columns/ScheduleOptions.php`
- `Job` · `ScheduleArguments` · `Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php`
- `Job` · `ScheduleOptions` · `Modules/Job/app/Filament/Tables/Columns/ScheduleOptions.php`

### `H_cross_module_homonym`

#### `getWidgets` — 10 classi

- `Job` · `JobManagerResource` · `Modules/Job/app/Filament/Resources/JobManagerResource.php`
- `Job` · `JobResource` · `Modules/Job/app/Filament/Resources/JobResource.php`
- `Job` · `JobsWaitingResource` · `Modules/Job/app/Filament/Resources/JobsWaitingResource.php`

#### `user` — 9 classi

- `Job` · `TaskComment` · `Modules/Job/app/Models/TaskComment.php`

#### `failed` — 8 classi

- `Job` · `JobBatch` · `Modules/Job/app/Models/JobBatch.php`

#### `addTeamMember` — 6 classi

- `Job` · `FailedJobPolicy` · `Modules/Job/app/Models/Policies/FailedJobPolicy.php`
- `Job` · `JobBatchPolicy` · `Modules/Job/app/Models/Policies/JobBatchPolicy.php`
- `Job` · `JobPolicy` · `Modules/Job/app/Models/Policies/JobPolicy.php`

#### `broadcastOn` — 6 classi

- `Job` · `BroadcastingEvent` · `Modules/Job/app/Events/BroadcastingEvent.php`
- `Job` · `PrivateEvent` · `Modules/Job/app/Events/PrivateEvent.php`
- `Job` · `PublicEvent` · `Modules/Job/app/Events/PublicEvent.php`

#### `removeTeamMember` — 6 classi

- `Job` · `FailedJobPolicy` · `Modules/Job/app/Models/Policies/FailedJobPolicy.php`
- `Job` · `JobBatchPolicy` · `Modules/Job/app/Models/Policies/JobBatchPolicy.php`
- `Job` · `JobPolicy` · `Modules/Job/app/Models/Policies/JobPolicy.php`

#### `messages` — 5 classi

- `Job` · `ScheduleRequest` · `Modules/Job/app/Http/Requests/ScheduleRequest.php`

#### `status` — 5 classi

- `Job` · `Job` · `Modules/Job/app/Models/Job.php`
- `Job` · `JobManager` · `Modules/Job/app/Models/JobManager.php`

#### `updateTeamMember` — 5 classi

- `Job` · `FailedJobPolicy` · `Modules/Job/app/Models/Policies/FailedJobPolicy.php`
- `Job` · `JobBatchPolicy` · `Modules/Job/app/Models/Policies/JobBatchPolicy.php`
- `Job` · `JobPolicy` · `Modules/Job/app/Models/Policies/JobPolicy.php`

#### `begin` — 4 classi

- `Job` · `ClockWidget` · `Modules/Job/app/Filament/Widgets/ClockWidget.php`
- `Job` · `QueueListenWidget` · `Modules/Job/app/Filament/Widgets/QueueListenWidget.php`

#### `getCards` — 4 classi

- `Job` · `JobStatsOverview` · `Modules/Job/app/Filament/Resources/JobManagerResource/Widgets/JobStatsOverview.php`
- `Job` · `JobStatsOverview` · `Modules/Job/app/Filament/Resources/JobResource/Widgets/JobStatsOverview.php`
- `Job` · `JobsWaitingOverview` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Widgets/JobsWaitingOverview.php`

#### `getOptions` — 4 classi

- `Job` · `Schedule` · `Modules/Job/app/Models/Schedule.php`

_… +8 metodi in questa categoria_




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
