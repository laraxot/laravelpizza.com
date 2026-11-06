---
title: "AI — Core Actions complete + PHPStan zero"
id: "ai.002-core-actions"
module: AI
type: story
status: todo
priority: high
created: 2026-11-04
---

# AI.002 — Core Actions complete

## Contesto

Le Actions AI esistono e hanno test ma alcune sono parziali.
`AiActionHandlerRegistry`, `CompletionAction`, `ContextCompressorAction`,
`GeneratePredictionDraftsAction` devono essere completate e PHPStan-clean.

## Obiettivo

Portare tutte le Actions AI a completamento: PHPStan zero errori, coverage ≥ 70%,
contratti espliciti tra azioni.

## Acceptance criteria

- [ ] PHPStan zero errori su `Modules/AI`
- [ ] `CompletionAction` con retry policy e fallback template
- [ ] `ContextCompressorAction` con limite token configurabile
- [ ] `AiActionHandlerRegistry` con tutti gli handler registrati
- [ ] `GeneratePredictionDraftsAction` con Http::fake() nei test
- [ ] Coverage Pest ≥ 70%
- [ ] Nessun segreto OpenAI nei log o nelle response

## Note tecniche

- `OPENAI_API_KEY` solo da config, mai hardcoded
- Timeout e retry configurabili da `config/openai.php`
- Tutti i test usano `OpenAiHttpFake` già presente in `tests/Support/`
