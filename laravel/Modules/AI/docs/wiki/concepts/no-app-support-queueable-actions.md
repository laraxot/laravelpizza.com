---
title: "no app/Support — AI QueueableAction"
type: concept
tags: [ai, actions, queueable-action, support, adapters]
created: 2026-07-12
updated: 2026-10-22
qmd: "AI module no Support AiActionHandlerRegistry JsonDecoder ScalarCaster PredictionDraft"
related:
  - ../../../../../../docs/second-brain/process/no-app-support-queueable-actions.md
status: draft
---

# AI — `app/Support/` eliminato

| Legacy Support | Destinazione |
|----------------|--------------|
| `AiActionHandlerRegistry` | `Adapters/AiActionHandlerRegistry` (singleton binding, **non** Action) |
| `AiJsonResponseDecoder` | `Actions/AiJsonResponseDecoderAction` |
| `ScalarCaster` | `Actions/Cast/ScalarCasterAction` |
| `PredictionDraftFallbackTemplates` | `Actions/PredictionDraftFallbackTemplatesAction` (+ Predict variant) |

Wave 2026-10-22: registry spostato da faux-Action ad Adapter (religione: multi-metodo ≠ use-case).
