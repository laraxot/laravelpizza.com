---
title: "Migration: Support → Actions"
type: note
status: done
updated: 2026-10-22
tags: [docs, activity]
qmd: "migration: support → actions activity"
---
# Migration: Support → Actions

**Module:** Activity  
**Date:** 2026-07-13  
**Scope:** convert `app/Support/ActivityLogSchema.php` to a QueueableAction.

## Why

The project architecture forbids a Service/Support layer. Business logic must live in `app/Actions/*` as single-purpose, queueable actions.

## What changed

### Removed
- `app/Support/ActivityLogSchema.php`
- `tests/Unit/Support/ActivityLogSchemaTest.php`
- `app/Actions/IsActivityLogSchemaWritableAction.php` (moved to sub-folder)

### Created / moved
- `app/Actions/Schema/IsActivityLogSchemaWritableAction.php`
  - Uses `Spatie\QueueableAction\QueueableAction`.
  - Single public method: `execute(): bool`.
  - Called via `app(IsActivityLogSchemaWritableAction::class)->execute()`.

### Updated
- `tests/Unit/Actions/IsActivityLogSchemaWritableActionTest.php` — namespace updated.
- `Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php` — `use` statement updated to `Modules\Activity\Actions\Schema\IsActivityLogSchemaWritableAction`.

## Verification

```bash
# PHPStan (all Modules)
cd /var/www/_bases/base_fixcity_fila5/laravel
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules --no-progress
# [OK] No errors

# Pest (specific test)
php vendor/bin/pest Modules/Activity/tests/Unit/Actions/IsActivityLogSchemaWritableActionTest.php
# Tests: 1 passed
```

## Pattern for future conversions

1. Move the static helper method into an Action class under `app/Actions/<Context>/`.
2. Add `use QueueableAction;`.
3. Rename the entry method to `execute(...)`.
4. Replace static calls with `app(<Action>::class)->execute(...)`.
5. Delete the old Support file and its test.
6. Update every `use` statement and call site.
