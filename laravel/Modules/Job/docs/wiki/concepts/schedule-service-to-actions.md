---
issues: []
discussions: []
title: "Job — ScheduleService → Actions"
type: concept
tags: [job, actions, queueable-action, schedule, migration]
created: 2026-07-13
updated: 2026-07-13
qmd: "Job module ScheduleService to QueueableAction schedule cache active schedules"
related:
  - ../../../Xot/docs/wiki/concepts/queueable-action-trait-mandatory.md
  - ../../../User/docs/wiki/concepts/no-app-support-queueable-actions.md
---

# Job — `ScheduleService` → Actions

## Mapping

| Legacy `app/Services/ScheduleService.php` | Action | Pattern |
|---|---|---|
| `getActives()` (+ private `getFromCache()`) | `Modules\Job\Actions\GetActiveSchedulesAction::execute()` | `QueueableAction`, cache read via `Cache::store()->rememberForever()` |
| `clearCache()` | `Modules\Job\Actions\ClearScheduleCacheAction::execute()` | `QueueableAction`, `Cache::store()->forget()` |

Both actions use `Spatie\QueueableAction\QueueableAction` and expose a single public `execute()`.

## Callers updated

- `Modules\Job\Observers\ScheduleObserver::clearCache()` → `app(ClearScheduleCacheAction::class)->execute()`
- `Modules\Job\Console\Commands\ScheduleClearCacheCommand::handle()` → `app(ClearScheduleCacheAction::class)->execute()` (previously dead/commented-out code)

No caller of `getActives()` existed outside the service itself; `GetActiveSchedulesAction` is available for future use (e.g. schedule listing/dashboard widgets).

## Tests

- `Modules/Job/tests/Unit/Actions/ClearScheduleCacheActionTest.php`
- `Modules/Job/tests/Unit/Actions/GetActiveSchedulesActionTest.php`

Legacy `app/Services/ScheduleService.php` and its test were removed once no code referenced them.
