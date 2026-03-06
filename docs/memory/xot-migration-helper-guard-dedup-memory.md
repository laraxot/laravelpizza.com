# Memory: Xot Migration Helper Guard De-dup (2026-03-06)

## Learning

In `XotBaseMigration`, `tableCreate()` already performs an internal `tableExists()` check.

## Consequence

An outer `if (! $this->tableExists())` wrapping `tableCreate()` is redundant and should be removed.

## Pattern to keep

1. Capture pre-existing table state only if needed for compatibility updates.
2. Always call `tableCreate(...)` directly.
3. Run `tableUpdate(...)` only for existing-table upgrade paths.

