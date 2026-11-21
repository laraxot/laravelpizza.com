---
title: team-permissions-sqlite-migration.story
module: User
---

# Story: team_permissions migration on SQLite

## Context

The `2026_08_06_150000_create_team_permissions_table` migration queried
MySQL's `information_schema.table_constraints` while running against the
project's SQLite test/development database. SQLite consequently aborted the
migration before the schema could be completed.

## Acceptance criteria

- [x] Foreign-key existence checks use Laravel's connection-independent schema
      builder API.
- [x] No migration code queries `information_schema` for this check.
- [x] The migration passes PHP syntax validation.
- [x] The configured database reports the migration as applied and `migrate`
      has no pending migrations.

## Implementation

Replaced the local `information_schema` helper with
`SchemaBuilder::hasForeignKey()`, which delegates foreign-key introspection to
the active database grammar, including SQLite.

## Verification

- `php -l Modules/User/database/migrations/2026_08_06_150000_create_team_permissions_table.php`
- `php artisan migrate --no-interaction`
- `php artisan migrate:status --no-interaction`

PHPStan was attempted for `Modules/User`, but the current local environment
cannot bootstrap Laravel because its configured MySQL database `trade_data`
does not exist; this is unrelated to the migration change.
