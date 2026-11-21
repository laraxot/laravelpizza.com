---
title: "claude-audit static — modulo Media"
type: concept
module: Media
tags: [media, quality, claude-audit, testing]
created: 2026-07-09
updated: 2026-07-09
qmd: "Media claude-audit static 80 score AwsTest S3Test diagnostic actions"
issues:
  - "https://github.com/laraxot/platform/issues/272"
discussions:
  - "https://github.com/laraxot/platform/discussions/273"
related:
  - ../../../../../../bashscripts/tools/run-claude-audit-module-static.sh
  - ../../../../../../bashscripts/tools/claude-audit-module-static-boost.sh
---

# claude-audit static (Media)

## Comandi

```bash
bash bashscripts/tools/claude-audit-module-static-boost.sh Media
cd laravel && npx claude-audit --static Modules/Media/ --output json --output-dir Modules/Media/.claude-audit --max-files 8000 --quiet
```

## Fix applicati (2026-07-09)

| Area | Intervento |
|------|------------|
| AwsTest / S3Test | Logica diagnostica estratta in `Actions/Diagnostic/Aws/*` e `Actions/Diagnostic/S3/*` — pagine Filament sotto 500 righe |
| Deep nesting | `FormatDebugOutputAction` per output debug S3 |
| Boost | `audit-coverage/tests/*BridgeTest.php` + `.gitignore` `!tests/**` |

## Target

Static mode (free): **80/100** con **0 finding**. Report: `Modules/Media/.claude-audit/audit-report.html`.
