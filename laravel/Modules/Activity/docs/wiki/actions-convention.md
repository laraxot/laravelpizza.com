---
title: Actions convention
module: Activity
type: note
updated: 2026-10-08
tags: [docs, activity, wiki]
qmd: "actions convention activity"
status: superseded
superseded_by: ../actions-convention.md
---

# Actions Convention

All classes under `app/Actions/` MUST use the **Spatie QueueableAction** trait
(`Spatie\QueueableAction\QueueableAction`) and expose a single **`execute()`**
method as the primary entry point.

## Rationale

- Consistent dispatch: any action can be queued with `dispatch()` without
  changing its signature.
- Uniform call site: `(new SomeAction)->execute(...)` across the entire
  module, making it easy to switch between sync and async execution.

## Enforcement

PHPStan rule `RequireQueueableAction` (see `phpstan.neon`) ensures every
concrete class in `app/Actions/` uses the trait and declares `execute()`.

## Creation checklist

When adding a new Action class:

```php
use Spatie\QueueableAction\QueueableAction;

class MyAction
{
    use QueueableAction;

    public function execute(/* … */): /* … */
    {
        // …
    }
}
```

## Dispatching

```php
// synchronous
(new MyAction)->execute($arg);

// queued
MyAction::dispatch($arg);
```
