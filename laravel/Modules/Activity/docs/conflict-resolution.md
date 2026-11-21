---
title: "Conflict resolution — Activity PHP markers"
type: troubleshooting
module: Activity
status: active
qmd: "Activity git conflict markers resolution PHPStan bootstrap QueueableAction Filament"
related:
  - ./bmad/stories/phpstan-conflict-markers-bootstrap.story.md
  - ./wiki/concepts/queueable-action-execute-entrypoint.md
  - ./wiki/concepts/schemas-tables-pattern.md
---

# Conflict resolution — Activity (PHP)

## Scopo

I marker `<<<<<<<` / `=======` / `>>>>>>>` nei PHP del modulo Activity
rompevano il bootstrap PHPStan. Risoluzione manuale per preservare audit log,
Actions Spatie Queueable e Filament XotBase.

## Esito

- Marker PHP: **0** in `app/` + `tests/` + `lang` PHP.
- `php -l` verde sui file toccati.
- PHPStan `Modules/Activity`: **0 errori su `app/`**; residui solo in test
  (typing Pest / harness, ~112) documentati nella story.

## Decisioni (perché)

| Area | Scelta |
|------|--------|
| LogModel*/LogUser* | Nullable + `execute(?T)` con fallback a proprietà |
| Activity model | Un body, `ActivityScopes` + `@method` + `typedQuery`/`typedGet` |
| Statistics | `typedQuery`/`typedGet` + normalize + cache `match` |
| Resources | Solo `$model` (Schemas/Tables discovery) |
| List pages | Thin (no getTable*) |
| Tables | Colonne complete + IDColumn; no filtri Restaurant |
| Adapter | `UserContract` (non `User` relativo al namespace Adapter) |

## Backlink

- Story: [phpstan-conflict-markers-bootstrap](./bmad/stories/phpstan-conflict-markers-bootstrap.story.md)
