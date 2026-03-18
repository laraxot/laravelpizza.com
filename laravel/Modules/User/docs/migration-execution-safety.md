# Migration Execution Safety Rule

For this repository, migration execution must be non-destructive.

Never use:

- `migrate:fresh`
- `RefreshDatabase`
- `migrate --force`

The correct approach is:

1. identify the canonical `create_<table>_table` migration;
2. modify that file if the schema contract changes;
3. bump the timestamp in the filename;
4. run only the specific migration needed for the target table/database.

This preserves local state, avoids collateral damage across modules, and keeps debugging reproducible.
