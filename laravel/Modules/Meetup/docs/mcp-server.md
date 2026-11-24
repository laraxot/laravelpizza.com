---
title: Server MCP di Laravel Pizza Meetups
updated: 2026-11-18
---

# Server MCP

Con il server MCP (Model Context Protocol), Claude, Cursor e gli altri client compatibili usano Laravel Pizza Meetups
per conto di un utente: cercano gli eventi, ne leggono il dettaglio, iscrivono e cancellano l'iscrizione.

L'idea viene dal talk *"Apri la tua app agli agenti: MCP, AG-UI e A2UI"* del LaravelDay 2026
([datomatic/laravelday-2026](https://github.com/datomatic/laravelday-2026)): la logica resta nelle Action del modulo
e ogni nuova "porta" (sito, MCP, in futuro una chat) la chiama a modo suo. Nessuna regola è duplicata nei tool.

## Endpoint e autenticazione

- `POST /api/mcp` (trasporto HTTP "streamable" di `laravel/mcp`), definito in `Modules/Meetup/routes/api.php`.
- Middleware `auth:api` (Passport) e `throttle:60,1`: senza token risponde **401**.
- L'utente è quello del token: `$request->user()` nei tool. I messaggi e i link usano la sua lingua (`users.lang`).

## Tool, resource e prompt

| Nome | Tipo | Cosa fa | Action usata |
|---|---|---|---|
| `search_events` | tool, sola lettura | eventi futuri o passati, filtri città e date, posti liberi, URL | `SearchPublicEventsAction` |
| `show_event` | tool, sola lettura | dettaglio pubblico: descrizione, sede, relatori, sponsor, "sei iscritto?" | `BuildEventSummaryAction` |
| `my_events` | tool, sola lettura | eventi a cui l'utente è iscritto | `GetUserRegisteredEventsAction` |
| `join_event` | tool, idempotente | iscrive e manda l'email di conferma; una seconda chiamata risponde "già iscritto" | `JoinEventAction` |
| `leave_event` | tool, distruttivo | annulla l'iscrizione, il posto torna libero | `UnregisterAttendeeFromEventAction` |
| `laravelpizza://events/upcoming` | resource | tutti gli eventi futuri (JSON) | `SearchPublicEventsAction` |
| `find_meetup` | prompt | propone fino a 3 eventi per città e interessi, iscrive dopo conferma | (orchestra i tool) |

Solo dati pubblici: niente email dell'organizzatore né elenco degli iscritti (test dedicato).
Le istruzioni del server chiedono all'agente di **chiedere conferma** prima di `join_event` e `leave_event`; le
annotazioni MCP (`IsDestructive`, `IsIdempotent`) permettono ai client di chiederla da soli.

## Collegare un client

1. Il server deve avere le chiavi Passport (una volta per ambiente, vedi runbook §9): `php artisan passport:keys`.
   Il client "personal access" lo crea da solo la prima richiesta di token (`CreateOwnAssistantTokenAction`);
   a mano: `php artisan passport:client --personal --name="Laravel Pizza MCP" --provider=users`.
2. Token: l'utente lo crea e lo revoca da solo in **Modifica il profilo → Collega un assistente AI**
   (`/{lingua}/profile/assistants`, CMS `pages/profile/assistants.json`, Livewire `AssistantTokens`). Il token si vede
   una volta sola, dura 6 mesi (default Passport), la revoca vale subito. Test: `tests/Feature/ProfileAssistantTokensTest.php`.
3. Nel client, per esempio Claude Code:
   `claude mcp add --transport http laravelpizza https://<dominio>/api/mcp --header "Authorization: Bearer <token>"`

## Verifica

- Test: `Modules/Meetup/tests/Feature/Mcp/MeetupServerTest.php` (tool, resource, prompt, 401 senza token, token Passport).
- Prova reale (18/11/2026, in locale): `initialize`, `tools/list` (5 tool) e `tools/call search_events` con un token
  Passport vero via curl.

## Cosa non c'è ancora (story 7-5)

- **Chat nel sito (AG-UI) e schede generate (A2UI)**: richiedono un modello AI e vanno costruite sul modulo condiviso
  `AI` (fornitori OpenRouter/Groq con modelli gratuiti), riusando questi stessi tool, con approvazione umana per
  `join_event`/`leave_event`.
- **WebMCP**: tool dichiarati dalla pagina all'agente del browser; API in origin trial su Chrome, non verificabile ora.
