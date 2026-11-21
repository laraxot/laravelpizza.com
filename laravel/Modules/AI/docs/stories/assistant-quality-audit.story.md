---
title: "Assistente: audit di qualità (report nel database, duplicato rimosso)"
type: story
module: AI
slug: assistant-quality-audit
status: review
owner: AI
created: 2026-11-17
updated: 2026-11-17
issues: [26]
discussions: []
related:
  - ./assistant-knowledge-base.story.md
  - ./assistant-anonymous-and-per-call-keywords.story.md
  - ../assistant.md
---

# Story: audit di qualità dell'assistente

Fatto durante l'audit del progetto Passaparola, primo progetto che usa l'assistente.

## Modifiche

- [x] `BuildAssistantReportAction` filtra nel database (`where('payload->kind')`, `where('payload->collection')`):
  prima leggeva i messaggi dell'assistente di **tutte** le collection del periodo e filtrava in PHP.
  Con molte attività clienti il report di una sola attività leggeva i dati di tutte.
- [x] Rimosso `Actions/Support/MakeAIRequestAction`: copia non usata da nessun modulo né test di
  `Actions/MakeAIRequestAction` (verificato in tutti i moduli e temi del progetto Passaparola).
  Aggiornati `docs/queueable-actions.md`, `docs/coverage.md`, `docs/wiki/concepts/provider-support-and-doc-ownership.md`.

## Decisioni lasciate aperte (issue #26)

- `MakeAIRequestAction` usa `gpt-4` quando non c'è un'impostazione salvata: un test lo fissa di
  proposito (`_keeps_gpt_4_with_temperature_0_3_and_2000_tokens_when_no_setting_is_saved`), quindi non
  è stato cambiato. `AIConfigData::chat_model` esiste già se si vuole renderlo configurabile.
- Il prompt di sistema predefinito di `MakeAIRequestAction` parla di ticket della PA: l'assistente
  passa il proprio, gli altri chiamanti usano ancora quello.

## Verifica

- [ ] `pest Modules/AI/tests` e `phpstan` nell'app host
