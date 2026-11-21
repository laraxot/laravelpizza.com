---
title: "claude-audit static — modulo AI"
type: concept
module: AI
tags: [ai, quality, claude-audit, testing]
created: 2026-07-09
updated: 2026-07-09
qmd: "AI claude-audit static 80 AIService AIChatCompletionClient prompt builder"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../../bashscripts/tools/run-claude-audit-module-static.sh
  - ../../../../../../bashscripts/tools/claude-audit-module-static-boost.sh
---

# claude-audit static (AI)

## Comandi

```bash
bash bashscripts/tools/claude-audit-module-static-boost.sh AI
cd laravel && npx claude-audit --static Modules/AI/ --output json --output-dir Modules/AI/.claude-audit --max-files 8000 --quiet
```

## Fix applicati (2026-07-09)

| Area | Intervento |
|------|------------|
| `AIService` | Delega a `AIChatCompletionClient` + `AIServicePromptBuilder` + `AIServiceJsonDecoder` — file <500 righe, no nesting profondo |
| `ClassifyTicketAction` | Usa `MakeAIRequestAction` + prompt builder (DRY) |
| `MakeAIRequestAction` | HTTP/retry centralizzato in `AIChatCompletionClient` |

## Target

**80/100**, **0 finding**. Report: `Modules/AI/.claude-audit/audit-report.html`.
