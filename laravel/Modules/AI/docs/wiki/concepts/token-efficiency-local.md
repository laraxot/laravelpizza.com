---
issues: []
discussions: []
title: "Token efficiency — disciplina locale AI"
type: concept
module: AI
tags: [tokens, qmd, ollama, second-brain, context]
created: 2026-07-24
updated: 2026-07-24
qmd: "ai module token efficiency ollama actions qmd query context compression"
related:
  - ./second-brain-local-discipline.md
  - ./context-compression-plugin.md
  - ./ollama-actions-ownership.md
  - ../../../../../../docs/wiki/concepts/token-efficiency-2026.md
  - ../../../../../../docs/wiki/rules/token-optimization-discipline.md
---

# Token efficiency — modulo AI

## Perché

Le Actions Ollama (`Chat`/`Generate`) e i plugin di compressione vivono qui: un contesto gonfio spreca **token modello locale** e tempo embed/rerank QMD.

## Pratica owner

| Fare | Non fare |
|------|----------|
| Canon globale `token-efficiency-2026` + `query` wrapper | Preload wiki AI intera |
| Compressione contesto via plugin/action AI owner | Mettere Actions AI in Xot |
| Write-back decisioni AI in `docs/wiki/` | Dump log Ollama interi in chat |

```bash
bashscripts/docs/llm-wiki-qmd.sh query "ollama actions AI"
```

Canon ownership: [ollama-actions-ownership.md](./ollama-actions-ownership.md).
