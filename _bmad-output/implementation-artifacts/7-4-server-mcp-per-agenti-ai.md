# Story 7.4: Server MCP per agenti AI

Status: review

## Story

As a Partecipante che usa un assistente AI (Claude, Cursor…),
I want che l'assistente trovi i meetup e mi iscriva per conto mio,
so that posso organizzarmi senza aprire il sito, con le stesse regole del sito (posti, conferma via email).

Fonte: talk "Apri la tua app agli agenti: MCP, AG-UI e A2UI", LaravelDay 2026 — https://github.com/datomatic/laravelday-2026

## Acceptance Criteria

1. `POST /api/mcp` espone i tool `search_events`, `show_event`, `my_events`, `join_event`, `leave_event`, la resource
   `laravelpizza://events/upcoming` e il prompt `find_meetup`.
2. Senza token Passport valido la risposta è 401; con il token i tool agiscono per quell'utente.
3. I tool chiamano le Action esistenti (nessuna regola duplicata): capienza, iscrizione doppia, eventi non pubblicati,
   email di conferma sono identici al sito.
4. Nessun dato privato (email dell'organizzatore, elenco iscritti) esce dal server.
5. `join_event` è idempotente; `leave_event` è marcato distruttivo; messaggi nella lingua dell'utente.
6. Rate limit 60 chiamate/minuto per utente.

## Tasks / Subtasks

- [x] `laravel/mcp` tra le dipendenze di produzione (dichiarato in `Modules/Meetup/composer.json`; prima solo come dipendenza dev di `laravel/boost`)
- [x] `Modules/Meetup/app/Mcp/*`: server, 5 tool, resource, prompt; `BuildEventSummaryAction`
- [x] Rotta in `Modules/Meetup/routes/api.php` con `auth:api` e `throttle:60,1`
- [x] Traduzioni `meetup::mcp` it/en
- [x] Test `Tests/Feature/Mcp/MeetupServerTest.php` (9) + prova reale con curl e token Passport
- [x] Runbook: chiavi Passport e client personale (mancavano: ogni `auth:api` dava 500)
- [x] Docs `Modules/Meetup/docs/mcp-server.md`

## Dev Notes

- Lezione: con Composer come root i plugin sono disattivati, compreso il merge dei `composer.json` dei moduli; un
  `composer update` senza `COMPOSER_ALLOW_SUPERUSER=1` crede superflui 138 pacchetti e comincia a rimuoverli.
