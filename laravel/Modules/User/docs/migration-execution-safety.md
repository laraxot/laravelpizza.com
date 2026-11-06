---
title: "Migration Execution Safety Rule"
type: concept
tags: [migration, execution, safety]
created: 2026-07-14
updated: 2026-07-14
qmd: "migration-execution-safety migration execution safety rule"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

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
