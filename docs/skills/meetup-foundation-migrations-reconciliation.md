# Skill: Meetup Foundation Migrations Reconciliation

## Use when

- Executing foundation schema work for Meetup module.
- Resolving duplicate migration histories for `events`, `profiles`, and pivot tables.

## Workflow

1. Read plan + module docs + migration directory inventory.
2. Align authoritative migration files (`2025_01_01_000001..000008`) with `XotBaseMigration`.
3. Reconcile legacy duplicates by making them guarded and non-conflicting.
4. Validate with syntax checks and migration status registry query.
5. Commit each logical task atomically.

## Guardrails

- Never introduce unguarded second creators for the same table.
- Keep pivot FK column names consistent with related model intent.
- Avoid destructive resets; preserve existing history while preventing runtime conflicts.
