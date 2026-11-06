---
title: "Case-Insensitive File Conflicts"
module: "Job"
type: concept
tags: [case, conflicts]
created: 2026-07-14
updated: 2026-07-14
qmd: "case conflicts"
related:
  - "./phpstan-fixes-archive-2.md"
status: superseded
superseded_by: ../case-conflicts.md
---
# Case-Insensitive File Conflicts

File duplicati nel modulo `Job` che differiscono solo per la capitalizzazione:

- `Modules/Job/.github`: `CONTRIBUTING.md`, `contributing.md`
- `Modules/Job/.github`: `SECURITY.md`, `security.md`

Uniformare i nomi (preferibilmente tutto maiuscolo come nello standard GitHub) e aggiornare eventuali riferimenti.
