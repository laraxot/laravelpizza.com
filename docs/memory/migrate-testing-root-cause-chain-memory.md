# Memory: `migrate --env=testing` Root Cause Chain (2026-03-06)

## Command

`cd laravel && php artisan migrate --env=testing -vvv`

## Ordered findings

1. Sandbox run raised `SQLSTATE[HY000] [2002]` (connection ambiguity).
2. Elevated run reached PHP parsing stage and briefly reported unmatched brace in Meetup migration 2026 (transient file-state signal).
3. Re-run after parse stage exposed stable schema blocker:
   - `SQLSTATE[42S21] Duplicate column name 'user_id'`
   - file: `Modules/Meetup/database/migrations/2025_01_01_000008_create_event_user_table.php`

## Stable root cause

`create_event_user_table` defines `user_id` explicitly, then calls `XotBaseMigration::timestamps()` which defines `user_id` again for audit metadata.

## Implementation direction

For tables with domain `user_id`, avoid `timestamps()` and use a variant that does not auto-add `user_id` (e.g. `updateTimestamps()`) to prevent column collisions.

## Process learning

Connection errors in sandbox are not sufficient evidence. Always re-run with elevated permissions before concluding infra root cause.
