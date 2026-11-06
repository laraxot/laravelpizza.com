---
title: "Actions Convention"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "actions convention activity"
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
