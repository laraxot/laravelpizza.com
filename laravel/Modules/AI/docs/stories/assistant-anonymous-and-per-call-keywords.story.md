---
title: "Assistente: visitatori anonimi e parole sensibili per chiamata"
type: story
module: AI
slug: assistant-anonymous-and-per-call-keywords
status: review
owner: AI
created: 2026-11-17
updated: 2026-11-17
requested_by: "Passaparola story 1.2 (laraxot/module_passaparola_fila5)"
issues: []
discussions: []
related:
  - ./assistant-knowledge-base.story.md
  - ../assistant.md
---

# Story: visitatori anonimi e parole sensibili per chiamata

Richiesta dal progetto Passaparola (widget pubblico, un'attività = parole sensibili diverse).
Modifiche agnostiche e retrocompatibili.

## Criteri di accettazione

- [x] `ai_threads.created_by_user_id` nullable (blocco `tableUpdate` nella migrazione esistente)
- [x] `ai_action_proposals.proposed_by_user_id` nullable; `CreateAiActionProposalAction` accetta `?int`
- [x] `AnswerQuestionAction` accetta `?array $handoffKeywords` (null = config)
- [x] `DetectHandoffTriggerAction::execute(string, ?array)`
- [x] Test Pest per le parole per chiamata
- [ ] `php artisan migrate` + `pest` + `phpstan` nell'app host
- [ ] Lettura dello storico di un thread per il widget (rimandata alla story 1.4 di Passaparola)
