# Meetup Foundation Migrations Reconciliation Rule

## Scope

Applies to `laravel/Modules/Meetup/database/migrations` when working on foundation schema for events, entities, and registration pivots.

## Mandatory constraints

1. Keep one authoritative `create_*_table` migration per table path for the new foundation set (`2025_01_01_000001..000008`).
2. Legacy duplicate migrations must remain non-conflicting:
   - either no-op when schema is already present;
   - or only perform guarded idempotent `tableUpdate` changes.
3. Use `XotBaseMigration` with `tableCreate()` + `tableUpdate()` patterns.
4. Registration and relation pivots must use explicit FK pairs:
   - `event_user`: `event_id`, `user_id`
   - `event_performer`: `event_id`, `performer_id`
   - `event_sponsor`: `event_id`, `sponsor_id`
5. Event schema for REGS-03 readiness must expose capacity + temporal lock columns:
   - `start_at`, `end_at`
   - `attendees_current`, `attendees_max`
   - `venue_id`

## Verification minimum

- `php -l` on touched migration files.
- `php artisan migrate:status` must list a coherent set with no conflicting duplicate creators.
