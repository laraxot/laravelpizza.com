# Rule: No migrate:fresh

## Critical Mandate
The command `php artisan migrate:fresh` is **strictly forbidden** in all environments, including local development and automated CI/CD pipelines.

## Why?
1. **Destructive**: It drops all tables in the database, which is catastrophic in shared or persistent environments.
2. **Schema Integrity**: In a modular or multi-tenant system (Laraxot), some tables might not be managed by the current set of migrations or might belong to different schemas. `migrate:fresh` would wipe them out blindly.
3. **Seed Data Loss**: It destroys all existing data, which might be difficult or impossible to reconstruct without full backups.
4. **Coherence**: It forces a "wipe and start over" mentality that discourages proper migration versioning and incremental updates.

## Correct Approach
1. **Incremental Migrations**: Use `php artisan migrate` to apply new changes.
2. **Transactional Tests**: Use `DatabaseTransactions` in your Pest tests to ensure a clean state without destroying the schema.
3. **Manual Cleanup**: If you need to reset a specific table, do it explicitly via a migration or a dedicated action, never wipe the whole DB.
4. **CI/CD**: The CI/CD pipeline is configured to run `migrate` on a dedicated test database (`_test`). It must never use `fresh`.

## Exception
There are no exceptions to this rule. Trust the migration history.
