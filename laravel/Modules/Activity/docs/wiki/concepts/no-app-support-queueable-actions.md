---
title: "no app/Support — Activity QueueableAction"
type: concept
tags: [activity, actions, queueable-action, support]
created: 2026-07-12
updated: 2026-10-22
qmd: "Activity module no Support RedactModelAttributes IsActivityLogSchemaWritable ActivityLogger adapter"
related:
  - ../../../../../../docs/second-brain/process/no-app-support-queueable-actions.md
  - ../../../../../../bashscripts/ai/wiki/concepts/no-app-support-monorepo-migration.md
status: draft
---

# Activity — `app/Support/` eliminato

| Legacy | Destinazione |
|--------|--------------|
| `RedactModelAttributes` | `RedactModelAttributesAction` |
| `ActivityLogSchema` | `Actions/Schema/IsActivityLogSchemaWritableAction` |
| `ActivityLogger` (coordinator) | `Adapters/ActivityLogger` — delega alle Action |

Wave 2026-10-22: rimosso `app/Support/ActivityLogSchema.php`; test solo sotto `tests/Unit/Actions/`.

Zen: coordinator multi-metodo → `Adapters/`; use-case → `execute()`.
