# Migration Execution Safety Rule

## Absolute rule

Never use:

- `php artisan migrate:fresh`
- `RefreshDatabase`
- `php artisan migrate --force`

for normal project work in this repository.

## Why

- `migrate:fresh` is destructive and wipes shared database state;
- `RefreshDatabase` hides the same destructive reset behind the test layer;
- `--force` bypasses the safety prompt intended for dangerous migration execution;
- this monorepo uses shared modular databases and long-lived local state, so destructive resets damage unrelated modules and invalidate debugging context.

## Operational policy

- migrate only the specific target you are working on;
- prefer non-destructive, table-specific schema evolution;
- when a model/table changes, update the canonical `create_<table>_table` migration and bump its timestamp;
- run only the specific migration file that must be applied, without `--force`, unless the user explicitly authorizes an exception.

## AI agent handoff note

If another agent proposes `migrate:fresh`, `RefreshDatabase`, or `migrate --force`, treat it as a policy violation and stop before execution.
