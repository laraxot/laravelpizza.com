---
title: "no app/Support — AI QueueableAction"
type: concept
tags: [ai, actions, queueable-action, support, sentiment]
created: 2026-07-12
updated: 2026-07-12
qmd: "AI module no Support sentiment ScalarCaster PredictionDraft templates"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md
---

# AI — `app/Support/` eliminato

| Legacy | Action |
|--------|--------|
| `Sentiment/BasicSentimentAnalyzer` | `AnalyzeBasicSentimentAction` |
| `Sentiment/TransformersSentimentAnalyzer` | `AnalyzeTransformersSentimentAction` |
| `ScalarCaster` | `CastScalarToStringAction`, `CastScalarToNullableStringAction`, `CastScalarToStringListAction` |
| `PredictionDraftFallbackTemplates` | `GetPredictionFallbackTemplatesAction` |

`SentimentAction` orchestra le action sentiment; `OpenAiPredictionMapper` usa le cast action.
