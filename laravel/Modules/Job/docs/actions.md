---
qmd: "actions"
issues: []
discussions: []
title: "Job Module: QueueableActions Architecture (Consolidated)"
type: guide
tags: [actions, architecture, queueable]
created: 2026-07-21
updated: 2026-07-21
status: draft
---

# Job Module: QueueableActions Architecture

## Status

✅ **Consolidation Complete (2026-07-21)**

- Removed duplicate `app/actions/` (minuscolo) directory
- Centralized all actions in `app/Actions/` (maiuscolo)
- Standardized namespace: `Modules\Job\Actions\*`
- Updated all imports and dependencies

## Overview

The Job module uses **QueueableActions** to manage schedule operations, command execution, and task orchestration with built-in caching support.

## Action Structure

```
app/Actions/
├── Schedule/                       # Schedule-related actions
│   ├── ClearScheduleCacheAction.php
│   └── GetActiveSchedulesAction.php
├── Command/                        # Command discovery & execution
│   ├── GetCommandsAction.php
│   ├── GetCommandArgumentsActions.php
│   └── GetCommandOptionsActions.php
├── Console/                        # Console/artisan operations
│   ├── AssertAllowedArtisanCommandAction.php
│   ├── GetJobStatusCommandsAction.php
│   ├── GetQueueSubcommandsAction.php
│   └── GetScheduleStatusCommandsAction.php
├── ExecuteTaskAction.php           # Task execution
├── GetTaskCommandsAction.php       # Task command lookup
├── GetTaskFrequenciesAction.php    # Frequency options
└── DummyAction.php                 # Placeholder
```

### Schedule Actions

**Location:** `app/Actions/Schedule/`

#### GetActiveSchedulesAction

Retrieve active schedules with optional cache support.

```php
use Modules\Job\Actions\Schedule\GetActiveSchedulesAction;

$schedules = app(GetActiveSchedulesAction::class)->execute();
// Returns: Collection<int, Schedule>
```

**Behavior:**
- If `config('job::cache.enabled')` is true, returns cached result (persists forever until cleared)
- If caching disabled, queries database directly
- Uses `config('job::cache.store')` and `config('job::cache.key')` for cache configuration

**Signature:**
```php
public function execute(): Collection<int, Schedule>
```

#### ClearScheduleCacheAction

Clear the schedules cache.

```php
use Modules\Job\Actions\Schedule\ClearScheduleCacheAction;

app(ClearScheduleCacheAction::class)->execute();
// Clears cache using config('job::cache.store') and config('job::cache.key')
```

**Usage context:**
- Called by `ScheduleObserver` when a schedule is created/updated/deleted/saved
- Called by `ScheduleClearCacheCommand` console command
- Ensures cache consistency after mutations

**Signature:**
```php
public function execute(): void
```

## Configuration

Actions use config from `config/job.php`:

```php
'model' => \App\Models\Schedule::class,  // For GetActiveSchedulesAction
'cache' => [
    'enabled' => true,
    'store' => 'default',
    'key' => 'schedules.active',
],
```

## Integration Points

### ScheduleObserver

Automatically clears cache when schedules change:

```php
// app/Observers/ScheduleObserver.php
protected function clearCache(): void
{
    if (config('job::cache.enabled')) {
        app(ClearScheduleCacheAction::class)->execute();
    }
}
```

### ScheduleClearCacheCommand

Console command to manually clear schedule cache:

```bash
php artisan schedule:clear-cache
```

## Design Principles

1. **Separation of concerns**: Cache logic isolated from Observer/Command
2. **Reusability**: Use same action across multiple call sites
3. **Testability**: Call `execute()` directly without mocking container
4. **Queueability**: Inherit `dispatch()` for free via QueueableAction trait
5. **Composition**: Actions call other actions without constructor DI bloat

## Adding New Actions

1. Create action file in appropriate subdirectory: `app/Actions/<GroupName>/<WhatAction>.php`
2. Implement:
   ```php
   <?php
   declare(strict_types=1);
   
   namespace Modules\Job\Actions\<GroupName>;
   
   use Spatie\LaravelQueueableAction\QueueableAction;
   
   class MyAction
   {
       use QueueableAction;
       
       public function execute(/* params */): /* return_type */
       {
           // Implementation
       }
   }
   ```
3. Update `docs/ACTIONS.md` with new action documentation

## Related Documentation

- **Pattern docs:** `docs/wiki/patterns/services-support-to-actions-migration-pattern.md`
- **Coordinamento operativo:** [story owner del refactoring Actions](stories/job-services-to-actions.story.md).
  La story contiene scope, decisioni, handoff e verifiche; `docs/chat/` resta archivio
  storico e non è una fonte operativa.
- **Spatie library:** https://github.com/spatie/laravel-queueable-action

---

**Consolidation Date:** 2026-07-21  
**Status:** ✅ Complete  
**Namespace Standard:** `Modules\Job\Actions\*` (unified)
