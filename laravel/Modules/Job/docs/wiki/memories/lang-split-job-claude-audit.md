---
title: "lang split job — claude-audit large file"
type: memory
module: Job
tags: [job, i18n, claude-audit, lang-split]
created: 2026-07-09
updated: 2026-07-09
qmd: "Job lang it split job_core job_fields claude-audit 500 righe"
issues:
  - "https://github.com/laraxot/module_job_fila5/issues/1"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/304"
related:
  - ../../Xot/docs/wiki/concepts/claude-audit-static-all-modules.md
---

# Split `lang/it/job.php` (claude-audit)

## Problema

`lang/it/job.php` >500 righe → finding «Large File» (score quality 65).

## Soluzione

```text
lang/it/job.php          → array_merge loader (~11 righe)
lang/it/job_meta.php     → pages, widgets, navigation
lang/it/job_fields.php   → fields
lang/it/job_actions.php  → actions, messages, validation, …
```

Chiavi invariate: `job::` namespace Laravel invariato via merge.

## Altri fix Job 80/0

- Rimosso codice commentato con nesting in `GetTaskCommandsAction`, `Schedule/Crud`
- Doc-ratio su lang split + blade `create.blade.php`
