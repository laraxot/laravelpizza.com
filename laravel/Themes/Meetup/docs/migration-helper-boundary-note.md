# Migration Helper Boundary Note

The theme has no direct database migration layer.  
When editing module migrations used by this theme ecosystem (for example `Modules/Meetup`), prefer `XotBaseMigration` helper methods without redundant outer guards.

## Practical rule

- Use `tableCreate()` directly.
- Do not add an extra `if (! $this->tableExists())` around `tableCreate()`.
- Keep update logic in a separate guarded block for existing tables only.

