---
title: "claude-audit static — modulo Lang"
type: concept
module: Lang
tags: [lang, quality, claude-audit, testing]
created: 2026-07-09
updated: 2026-07-09
qmd: "Lang claude-audit static 80 score LangServiceProvider nesting"
issues:
  - "https://github.com/laraxot/platform/issues/272"
discussions:
  - "https://github.com/laraxot/platform/discussions/273"
related:
  - ../../../../../../bashscripts/tools/run-claude-audit-module-static.sh
  - ../../../../../../bashscripts/tools/claude-audit-module-static-boost.sh
---

# claude-audit static (Lang)

## Comandi

```bash
bash bashscripts/tools/claude-audit-module-static-boost.sh Lang
cd laravel && npx claude-audit --static Modules/Lang/ --output json --output-dir Modules/Lang/.claude-audit --max-files 8000 --quiet
```

## Fix applicati (2026-07-09)

| Area | Intervento |
|------|------------|
| `LangServiceProvider` | `applyUserValidationMessages()` + `configureActionAsButtonWhenNoRecord()` — nesting ≤3 |
| `docs/*.php` script legacy | Spostati/rimossi dalla scan (es. `italian-text-validation-refined.php`) |
| Boost | bridge test + doc ratio |

## Target

**80/100**, **0 finding**. Report: `Modules/Lang/.claude-audit/audit-report.html`.
