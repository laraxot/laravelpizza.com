---
title: "Assistente: fornitori in cascata (Groq, OpenRouter, OpenAI)"
type: story
module: AI
slug: assistant-provider-cascade
status: review
owner: AI
created: 2026-11-17
updated: 2026-11-17
requested_by: "Marco: usare anche Groq e OpenRouter"
issues: []
discussions: []
related:
  - ../assistant.md
  - ../vision-openrouter.md
---

# Story: fornitori in cascata per l'assistente

- [x] `Assistant\RequestAssistantCompletionAction`: Groq → OpenRouter → OpenAI, con `response_format: json_object`
- [x] Riusa `AiProviderEnum` e `Vision\OpenAiCompatibleRequestAction` (già usati per le immagini): nessun client duplicato
- [x] `AIConfigData`: `assistant_providers`, `assistant_models` (Groq `openai/gpt-oss-120b`, OpenRouter `google/gemini-2.5-flash`), `assistant_timeout`
- [x] `AnswerQuestionAction` usa la cascata; se tutto fallisce la domanda passa a una persona
- [x] Test con risposte HTTP finte: ordine, modello, modalità JSON, passaggio al fornitore successivo, chiavi mancanti
- [ ] Prova reale con le chiavi nel `.env` dell'app host (da questo ambiente i fornitori non sono raggiungibili)
- [ ] Spostare `AiProviderEnum` e `OpenAiCompatibleRequestAction` fuori dal namespace `Vision`, ora che servono anche al testo
