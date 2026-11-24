---
title: Base agnostica per agenti neuron-ai con AG-UI
status: done
date: 2026-11-19
epic: integrazione laravelday-2026 (Passaparola epic 2)
---

# Story: base agnostica per agenti neuron-ai con AG-UI

## Contesto

Passaparola integra la demo datomatic/laravelday-2026 (issue #11 di base_passaparola_fila5).
L'assistente operatore (story 2.3 di Passaparola) è un agente neuron-ai che usa gli stessi tool del
server MCP. Il modulo AI è condiviso fra i progetti: qui va solo la parte agnostica.

## Criteri di accettazione

- [x] `neuron-core/neuron-ai ^4.1` e `laravel/mcp ^1.1` nelle dipendenze del modulo.
- [x] `XotBaseAgent`: fornitore dalla cascata dell'assistente, memoria e persistenza nel database.
- [x] `ResolveAgentProviderAction`: Groq, poi OpenRouter; errore chiaro senza chiavi.
- [x] `StreamAgentRunAction`: RunAgentInput validato, thread legato all'utente, resume, SSE.
- [x] `McpToolAdapter`: tool MCP riusati come tool dell'agente, errori come risultato del tool.
- [x] Tabelle `ai_agent_messages` e `ai_agent_runs` con i modelli.
- [x] Documentazione in `docs/agents.md`, test in `tests/Unit/Agent`.

## Note

- Composer non raggiungibile nell'ambiente: test eseguibili nel progetto ospite (issue #7).
