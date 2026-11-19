---
title: Assistente AI nel sito
updated: 2026-11-19
story: 7-5
---

# Assistente AI nel sito

Un utente loggato apre "Chiedi all'assistente" (in basso a destra in tutte le pagine pubbliche) e scrive, per esempio,
"Che meetup ci sono a Bologna?". L'assistente cerca gli eventi, li mostra come schede e, se l'utente lo chiede, lo
iscrive o cancella l'iscrizione **dopo una conferma esplicita** nella chat.

Il pattern viene dal talk del LaravelDay 2026 ([datomatic/laravelday-2026](https://github.com/datomatic/laravelday-2026), MIT):
la logica sta nelle Action, il server MCP (story 7-4, [mcp-server.md](mcp-server.md)) e la chat usano gli stessi tool.

## Pezzi

| Dove | Cosa |
|---|---|
| `Modules/AI` (condiviso, agnostico) | `XotBaseAgent`, `StreamAgentRunAction` (endpoint AG-UI in SSE), `McpToolAdapter`, `ResolveAgentProviderAction`, tabelle `ai_agent_messages` e `ai_agent_runs` — vedi `Modules/AI/docs/agents.md` |
| `Modules/Meetup/app/Neuron/Agents/MeetupAssistant.php` | istruzioni e tool: `search_events`, `show_event`, `my_events` liberi; `join_event` e `leave_event` con approvazione |
| `Modules/Meetup/app/Actions/Assistant/` | `RunMeetupAssistantAction` (rotta), `GetAssistantThreadIdAction` (thread in sessione), `IsAssistantAvailableAction` (mostra il pulsante solo se c'è un fornitore) |
| `POST /meetup/assistant` | `web` + `auth` + `throttle:20,1`; 401 da ospite, 403 su un thread di un altro utente, 422 senza messaggio, 503 se il fornitore non risponde |
| `Themes/Meetup/resources/views/components/ui/assistant.blade.php` | pannello (dialog accessibile, `aria-live`), suggerimenti, avviso privacy |
| `Themes/Meetup/resources/js/assistant.js` | client `@ag-ui/client`, caricato solo se il pannello è nella pagina (chunk separato) |

## Regole

- **Fornitori gratuiti**: Groq (`GROQ_API_KEY`), poi OpenRouter (`OPENROUTER_API_KEY`). Senza chiavi il pulsante non
  compare e la rotta risponde 503. Le chiavi stanno in `config/local/laravelpizza/services.php` lette dall'env.
- **Thread dell'utente**: l'id è creato dal server (`meetup-{userId}-{uuid}`) e salvato in sessione; il modulo AI
  rifiuta un thread con un altro prefisso. La cronologia sta in `ai_agent_messages`.
- **Conferma**: `join_event`/`leave_event` mettono in pausa il run (interrupt AG-UI) con il titolo dell'evento; la
  chat mostra "Conferma"/"Annulla" e riprende il run con `resume`. Finché la conferma è in sospeso non si scrive.
- **Nessun HTML dal modello**: il testo passa da un Markdown minimo (grassetto, corsivo, link http/https o relativi,
  elenchi) applicato dopo l'escape; le schede evento si costruiscono con `textContent` dai risultati dei tool.
- Dopo un'iscrizione o una cancellazione i componenti Livewire della pagina si aggiornano (posti, pulsante).

## Test

`Modules/Meetup/tests/Feature/Assistant/MeetupAssistantTest.php` con `FakeAIProvider` di neuron-ai: ospite, thread
altrui, input vuoto, streaming e salvataggio, ricerca senza conferma, iscrizione solo dopo l'approvazione, rifiuto,
creazione del thread. Nessuna chiamata a un modello vero.

## Non ancora fatto

- Pagina profilo "Collega un assistente AI" per creare e revocare da soli il token MCP (oggi lo crea l'amministratore).
- WebMCP (`document.modelContext.registerTool`), facoltativo e solo per browser in origin trial.
