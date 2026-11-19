# Story 7.5: Assistente AI nel sito (AG-UI, A2UI) e WebMCP

Status: review

## Story

As a Visitatore o Partecipante,
I want chiedere in una chat del sito "che meetup ci sono a Milano a dicembre?" e iscrivermi da lì,
so that trovo l'evento giusto parlando, senza filtri e pagine.

Fonte: passaggi 2–5 del talk LaravelDay 2026 (https://github.com/datomatic/laravelday-2026). Prerequisito: story 7.4.

## Acceptance Criteria

1. La chat riusa i tool MCP della story 7.4 in-process (nessuna logica nuova): nella demo lo fa l'adattatore `McpTool`.
2. Il modello passa dal modulo condiviso `AI` (agnostico), con fornitori OpenRouter o Groq e **solo modelli gratuiti**;
   il modulo Meetup chiama il modulo AI, non il contrario.
3. `join_event` e `leave_event` chiedono conferma all'utente nella chat prima di essere eseguiti (approvazione lato
   server, come `withApprovalPolicy` nella demo); il modulo AI ha già `AiActionProposal` (proposta → conferma).
4. La cronologia sta sul server e un thread appartiene a un solo utente (403 altrimenti).
5. Gli eventi in chat sono schede (A2UI o componenti Blade del tema), con il pulsante che chiama direttamente
   l'iscrizione, senza ripassare dal modello.
6. Pagina profilo "Collega un assistente AI": l'utente crea e revoca da solo il token personale per i client MCP.
7. WebMCP (facoltativo): sulle pagine eventi `search_events` dichiarato con `document.modelContext.registerTool`, attivo
   solo se il browser lo supporta (origin trial Chrome 149–156).

## Note di analisi

- Demo: neuron-ai 4.1 + OpenAI; qui va valutato se il modulo AI deve offrire un "agent runner" con tool calling o se
  conviene neuron-ai dentro il modulo AI. Decisione da prendere con Marco prima dello sviluppo.
- Rate limit, costi zero (modelli gratuiti) e testo di avviso privacy nella chat.

## Dev Agent Record (2026-11-19, Claude)

- Decisione: neuron-ai dentro il modulo condiviso `AI` (base agnostica `XotBaseAgent` + `StreamAgentRunAction`,
  upstream laraxot/module_ai_fila5); Meetup scrive solo l'agente e la rotta. Doc: `Modules/Meetup/docs/assistant.md`.
- AC1 ✅ tool MCP riusati con `McpToolAdapter`. AC2 ✅ Groq/OpenRouter, nessuna chiave → pulsante nascosto.
  AC3 ✅ approvazione lato server con il titolo dell'evento. AC4 ✅ thread creato dal server, 403 sui thread altrui.
  AC5 ⚠️ schede costruite dai risultati dei tool, con link alla pagina evento (lì il pulsante Livewire); l'iscrizione
  dalla scheda passa dalla conferma in chat. AC6 ✅ pagina `/{lingua}/profile/assistants` (crea, mostra una volta, revoca; 5 test). AC7 ⏳ facoltativo, rimandato.
- Correzioni al modulo AI condiviso (da riportare upstream): `StreamAgentRunAction` perdeva `role`/`content` dei
  messaggi con `validate()` (ogni turno → 422); tipi Safe/PHPStan in `StreamAgentRunAction` e `McpToolAdapter`.
- Verifiche: 8 test feature, suite Project verde, PHPStan 10 OK, Pint, audit FO senza problemi, e2e nel browser con
  axe (0 violazioni) e conferma.
