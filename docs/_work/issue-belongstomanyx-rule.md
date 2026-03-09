## Context
Project rule update: in LaravelPizza application models, many-to-many relations must use `belongsToManyX(...)` (not `belongsToMany(...)`).

## Why
- keep consistency with project RelationX conventions
- avoid documentation/code divergence
- enforce one relationship style across modules

## Documentation updates completed
- docs/rules/laravel-relationships-fundamental.md
- docs/rules/laravel-relationships-critical.md
- docs/rules/critical-relationships-memory.md
- docs/memory/belongstomanyx-mandatory-memory.md
- docs/skills/belongs-to-manyx-relationship-skill.md

## Next steps
- scan modules for `belongsToMany(` occurrences and classify
- migrate applicable relations to `belongsToManyX(...)`
- update Pest tests per touched relation

## Definition of done
- no new app-level many-to-many uses `belongsToMany(...)`
- all touched relations tested
- docs + issue/discussion updated
