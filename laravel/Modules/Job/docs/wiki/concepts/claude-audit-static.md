---
title: "claude-audit static — modulo Job"
type: concept
module: Job
tags: [job, quality, claude-audit, testing]
created: 2026-07-09
updated: 2026-07-09
qmd: "Job claude-audit static 80 score lang split job_meta"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../../bashscripts/tools/run-claude-audit-module-static.sh
  - ../../../../../../bashscripts/tools/claude-audit-module-static-boost.sh
---

# claude-audit static (Job)

## Comandi

```bash
bash bashscripts/tools/claude-audit-module-static-boost.sh Job
cd laravel && npx claude-audit --static Modules/Job/ --output json --output-dir Modules/Job/.claude-audit --max-files 8000 --quiet
```

## Fix applicati (2026-07-09)

| Area | Intervento |
|------|------------|
| `lang/it/job.php` | Merge sottofile: `job_core.php`, `job_fields.php`, `job_actions.php` |
| `lang/it/job_meta.php` | Solo pages/widgets/navigation; rimosso duplicato corrotto |
| Livewire | Rimosso codice commentato con nesting profondo in `GetTaskCommandsAction` / `Schedule/Crud` |
| Boost | bridge `audit-coverage/tests/` + comment ratio su lang |

## Target

**80/100**, **0 finding**. Report: `Modules/Job/.claude-audit/audit-report.html`.
