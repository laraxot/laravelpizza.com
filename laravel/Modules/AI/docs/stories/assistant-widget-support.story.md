---
title: "Thread e messaggi per chat pubbliche: CreateAiThreadAction, AppendAiMessageAction"
type: story
module: AI
slug: assistant-widget-support
status: review
owner: AI
created: 2026-11-17
updated: 2026-11-17
requested_by: "Passaparola story 1.4 (widget chat)"
issues: []
discussions: []
related:
  - ../assistant.md
---

# Story: thread e messaggi per chat pubbliche

Due Action agnostiche usate dal widget di Passaparola, utili a ogni progetto con una chat.

- [x] `Actions\CreateAiThreadAction::execute(?int $userId, string $panelId, array $meta = [])`:
  crea un `AiThread` (uuid pubblico, `panel_id` deciso dal chiamante, `userId` null = anonimo).
- [x] `Actions\AppendAiMessageAction::execute(AiThread, AiMessageRoleEnum, string, ?int, ?array)`:
  aggiunge un messaggio senza passare dal modello e aggiorna `last_message_at`.
  Usi: domanda arrivata quando la conversazione è già in mano a una persona, risposta di un operatore.
- [x] `Assistant\AnswerQuestionAction` usa `AppendAiMessageAction` (prima aveva una propria copia privata).
- [ ] `pest` e `phpstan` nell'app host.
