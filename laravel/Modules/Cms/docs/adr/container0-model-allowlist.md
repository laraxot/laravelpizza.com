---
title: "ADR — Le rotte /{container0}/{slug0} caricano un modello solo da un elenco esplicito e con la policy view"
type: decision
module: Cms
tags: [adr, cms, sicurezza, folio, routing, policy, dcp-283]
created: 2026-11-24
updated: 2026-11-24
status: accepted
related:
  - ../../app/Actions/ResolvePageAction.php
  - ../../config/config.php
  - ../contracts/page-resolution-action.md
---

# ADR: le rotte `/{container0}/{slug0}` caricano un modello solo da un elenco esplicito e con la policy `view`

## Contesto

- La pagina Folio del tema `[container0]/[slug0]` chiede a `ResolvePageAction` cosa mostrare. In origine l'Action ricavava
  un modello Eloquent dal primo segmento (ramo `profile`, euristica del singolare: `users` -> `User`).
- Misurato (DCP-283, C-04): `/it/profile/<uuid>` e `/it/user/<uuid>` rispondevano 200 per un utente reale, anche a un ospite,
  e 404 per uno inesistente (oracolo di esistenza); lo snapshot Livewire portava classe e chiave del modello.

Domanda: quali modelli puo' raggiungere un URL pubblico, e a quali condizioni?

## Decisione

In `app/Actions/ResolvePageAction.php`:

- `blog` ed `events` passano solo dai finder dei contenuti pubblicati del modulo Blog (`findPublishedPostBySlug`,
  `findPublishedEventBySlug`), se il modulo e' installato: un post non si legge come evento e viceversa.
- Ogni altro contenitore carica un modello solo se elencato in `cms.config.container0_models` (alias storico
  `xra.container0_model_map`) e la classe e' un `Model`. Default: mappa vuota, nessun modello.
- Il record si legge con `resolveRouteBinding()` (chiave di rotta e scope globali) ed e' esposto solo se
  `Gate::allows('view', $item)` per chi guarda, ospite compreso. Negato, assente o senza policy = `null`, come non trovato.

## Alternative scartate

- Euristica sul nome del contenitore: ogni modello dell'applicazione diventa raggiungibile da un URL.
- Denylist dei modelli sensibili (User, ...): un modello nuovo e' esposto per default.
- 403 per un record negato: distingue "esiste ma non puoi" da "non esiste", cioe' l'oracolo che si voleva chiudere.

## Conseguenze

- Pro: superficie esplicita; gli scope dei modelli valgono; nessun oracolo di esistenza.
- Contro: un progetto che voleva pagine-modello deve elencarle in config e scrivere la policy `view`.
- Chi aggiunge un contenitore non scrive codice in `ResolvePageAction`: aggiunge la voce di config e la policy.

## Verifica

- `Modules/Cms/tests/Feature/ResolvePageModelExposureTest.php` (group `CMS-RESOLVE-PAGE-INV-1` ... `-INV-5`): contenitore non
  elencato, `profile`/`user`/`users` senza modello, policy che nega o assente, scope globale, voce non-modello ignorata,
  finder Blog. I casi con utenti reali richiedono il DB del modulo User.
