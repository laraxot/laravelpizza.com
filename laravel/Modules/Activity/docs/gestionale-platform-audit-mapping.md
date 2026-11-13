---
title: "Platform AuditLog (SRC) vs Activity"
type: concept
tags: [activity, platform, audit, gestionale-commesse]
created: 2026-07-23
updated: 2026-07-23
qmd: "Platform AuditLog Activity gestionale_commesse"
issues:
  - "https://github.com/laraxot/base_workorder_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_workorder_fila5/discussions/8"
related:
  - "./00-index.md"
  - "../../../../docs/gestionale-commesse-comparison/module-mapping.md"
<<<<<<< .merge_file_C4vuDt
=======
status: draft
>>>>>>> .merge_file_jVIIfE
---

# Platform AuditLog (SRC) vs Activity

> **Perché:** SRC `Platform` espone `AuditLog` + `AuditLogger`. Da noi l’owner naturale è **Activity** (event/snapshot store).

## Mapping

| SRC | Nostro |
|---|---|
| `AuditLog` model + Filament resource | Activity / StoredEvent / Snapshot |
| `AuditLogger` service | pattern activitylog già in Laraxot |

## Gap

- Allineare UI audit business alle resource SRC solo se manca vista operativa
- Settings di Platform → vedi Tenant (`gestionale-platform-mapping.md`)
