Progress update on belongsToManyX convention alignment:

- Updated rules/docs to remove contradictory guidance and enforce `belongsToManyX(...)` as canonical for app many-to-many relations.
- Added/updated files:
  - docs/rules/laravel-relationships-fundamental.md
  - docs/rules/laravel-relationships-critical.md
  - docs/rules/critical-relationships-memory.md
  - docs/memory/belongstomanyx-mandatory-memory.md
  - docs/skills/belongs-to-manyx-relationship-skill.md
- Tracking issue opened: #549

Next: scan module-by-module for `belongsToMany(` occurrences and migrate where project-convention applies, with Pest updates per touched relation.
