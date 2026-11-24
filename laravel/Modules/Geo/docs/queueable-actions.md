---
qmd: "queueable actions"
issues: []
discussions: []
title: "Queueable Actions — Geo Module"
type: concept
created: 2026-07-12
updated: 2026-07-12
confidence: high
tags: [queueable-action, spatie, architecture, laraxot, geo]
related:
  - Modules/Xot/docs/queueable-actions.md
---

# Queueable Actions — Geo Module Doctrine

> The full doctrine lives in `Modules/Xot/docs/queueable-actions.md`.
> This module follows the same rules.

## Rules

1. Every class under `app/Actions/` is a [Spatie Laravel Queueable Action](https://github.com/spatie/laravel-queueable-action).
2. The only public entry point is `execute()`.
3. No repository pattern — no `*Repository` classes, no repository injection.
4. No inline `new ...Action` or `new ...Repository` in constructor default parameters.
5. Retire files by renaming with `.old` suffix; do not `rm` and do not create `archive/` directories.
6. YAGNI: reuse existing code, prefer stdlib/native Laravel, keep it minimal.

## Example

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Spatie\QueueableAction\QueueableAction;

class DoSomethingAction
{
    use QueueableAction;

    public function execute(): void
    {
        // business logic
    }
}
```

## Calling Convention

```php
app(DoSomethingAction::class)->execute();
```

## Verification

After every change:

```bash
cd laravel
php -d memory_limit=2048M vendor/bin/phpstan analyse Modules/Geo --no-progress
vendor/bin/pint Modules/Geo/app/Actions
```
