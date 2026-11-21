---
title: "no app/Support — Activity QueueableAction"
type: concept
tags: [activity, actions, queueable-action, support]
created: 2026-07-12
updated: 2026-07-12
qmd: "Activity module no Support RedactModelAttributes IsActivityLogSchemaWritable ActivityLogger adapter"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md
---

# Activity — `app/Support/` eliminato

| Legacy | Destinazione |
|--------|--------------|
| `RedactModelAttributes` | `RedactModelAttributesAction` |
| `ActivityLogSchema` | `IsActivityLogSchemaWritableAction` |
| `ActivityLogger` (coordinator) | `Adapters/ActivityLogger` — delega alle Action esistenti |

Zen: il coordinator multi-metodo non è una Action; vive in `Adapters/` e chiama solo `execute()` sulle Action.
