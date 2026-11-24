---
title: "Parita' Forms/Components ↔ Tables/Columns"
type: rule
tags: [filament, forms, columns, parity, user]
created: 2026-09-01
updated: 2026-09-01
qmd: "user form column parity UserSection UserColumn"
related:
  - "./filament-table-architecture.md"
  - "./stories/form-column-parity.story.md"
  - "../../Ptv/docs/form-column-parity.md"
---

# Parita' Forms/Components ↔ Tables/Columns (User)

Regola piattaforma: vedi [Ptv/form-column-parity.md](../../Ptv/docs/form-column-parity.md).

## Mappa corrente

| Forms/Components | Tables/Columns |
|---|---|
| `UserSection` | `UserColumn` |
| `SingleRoleSelect` | `SingleRoleSelectColumn` |

## Verifica

`Modules/User/tests/Unit/Filament/Tables/Columns/FormColumnParityTest.php`
