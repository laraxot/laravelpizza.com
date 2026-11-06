---
title: "AI provider support and documentation ownership"
type: concept
module: AI
tags: [ai, providers, openai, gpt, ollama, claude, gemini, second-brain]
created: 2026-09-25
updated: 2026-09-25
qmd: "AI provider runtime support OpenAI GPT Ollama DS4 DeepSeek Claude Anthropic Gemini documentation ownership"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./second-brain-local-discipline.md
  - ../../../../Xot/docs/wiki/concepts/module-dashboard-page-mandatory.md
  - ../../../../../Themes/docs/wiki/concepts/ai-harness-theme-discipline.md
status: draft
---

# AI provider support and documentation ownership

This page records what the AI module's source currently implements. Provider
names are not a promise of full feature parity; status applies only to the code
paths listed here and was checked on 2026-09-25.

| Provider / family | Status in `Modules/AI` | Evidence |
|---|---|---|
| OpenAI / GPT | Implemented in several actions | `CompletionAction`, `GeneratePredictionsAction`, `Predict/GeneratePredictionDraftsAction`, `Support/MakeAIRequestAction` |
| Ollama | Implemented local HTTP actions | `Actions/Ollama/ChatOllamaAction` and `GenerateOllamaAction` |
| DS4 / DeepSeek-compatible endpoint | Implemented as an OpenAI-compatible chat-completions request | `Actions/Ds4/ChatDs4Action` and `GenerateDs4Action`; endpoint comes from `services.ds4` config |
| Anthropic / Claude | No direct provider adapter found in `Modules/AI/app` | Do not describe the module as having a Claude integration without a new code-backed audit |
| Google / Gemini | No direct provider adapter found in `Modules/AI/app` | The theme's Gemini note is a routing/reference page, not a setup guide |

“No direct adapter found” is deliberately scoped to this module's `app/` source;
it does not claim that no other package or module in the application can call a
vendor API. Recheck the implementation before changing this status.

## Ownership rules

- Provider clients, credentials/configuration, request/response mapping and
  provider-specific runtime behavior belong to the owning module, currently
  `Modules/AI` for the actions above.
- Claude, GPT, Gemini and similar coding assistants are agent clients, not UI
  themes. Their local instruction files may explain client-specific setup but
  must link to the canonical project/module wiki instead of copying rules.
- `Themes/<Name>` owns presentation, Folio/Volt, CSS and accessibility. A theme
  may document user-facing AI presentation, but must not claim ownership of a
  provider adapter or create a provider-named theme.
- Record provider status with code paths and a verification date. Keep secrets
  in server-side configuration; documentation must never include live keys.

## Related sources

- [AI agent and second-brain discipline](./second-brain-local-discipline.md)
- [Theme and module boundary](../../../../../Themes/docs/wiki/concepts/ai-harness-theme-discipline.md)
- [Themes wiki index](../../../../../Themes/docs/wiki/index.md)
- [Gemini theme reference](../../../../../Themes/docs/shared-components/google-gemini.md)
