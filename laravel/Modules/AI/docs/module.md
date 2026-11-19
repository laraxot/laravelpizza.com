---
issues: []
discussions: []
title: "AI Module — Doctrine"
type: doctrine
tags: [ai, artificial-intelligence, module-doctrine]
created: 2026-09-05
updated: 2026-09-05
qmd: "AI module doctrine BMAD analysis purpose religion philosophy policy why zen gap enhancements split merge"
related:
  - "../../Xot/docs/module.md"
  - "../AiAssistant/docs/module.md"
---

# AI Module — Doctrine

## Scope (Scopo)

AI è l'infrastruttura di integrazione AI generale. Gestisce provider LLM (OpenAI, Groq, Ollama), configurazione modelli, e fornisce azioni AI riutilizzabili. È il gateway AI del monorepo.

## Religion (Religione)

**"AI come utility, non come mistero."** L'AI è un servizio come un altro: configurabile, testabile, sostituibile. Nessun vendor lock-in.

## Philosophy (Filosofia)

- **Adapter pattern**: provider come adapter intercambiabili
- **Configuration-driven**: modelli configurati via env, non codice
- **Actions-first**: ogni operazione è una QueueableAction
- **Streaming-ready**: supporto per streaming
- **Tool-calling**: structure per function calling

## Policy (Politica)

- Ogni provider è un adapter
- Configurazione via env
- Nessun hardcoding di modelli o prezzi
- Streaming per tutti i provider
- Token counting e cost tracking

## Why (Perché)

L'integrazione AI richiede configurazione complessa di provider, modelli, pricing. Inline sarebbe ingestibile e impossibile da testare.

## Zen

*"Un gateway, infiniti modelli. AI come servizio, non come magia."*

## Gap

- OperatorAssistantAgent deferred a AiAssistant
- Documentazione provider incompleta
- Test di integrazione con provider reali limitati
- Cost tracking non completamente implementato

## Add

- Provider adapter per più LLM (Claude, Gemini)
- Cost dashboard con breakdown per modulo
- Prompt templates system
- AI response caching
- Fallback chains

## Split/Merge

**Mantenere come-is, NON fondere con AiAssistant.**

La distinzione è architetturale: AI è infra generica, AiAssistant è applicazione specifica.

## Future Enhancements

1. **Multi-model routing**: instradamento automatico
2. **Prompt versioning**: versionamento con rollback
3. **AI playground**: UI per testare prompt
4. **Cost optimization AI**: suggerimenti per ridurre costi
5. **Response caching**: cache intelligente risposte
6. **Fine-tuning pipeline**: pipeline per modelli custom
