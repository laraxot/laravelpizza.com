---
title: "[STORY] PHPStan zero errors — AI"
type: story
module: AI
status: in-progress
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, bmad, ai, rebase, ai-thread]
related:
  - ../../../../docs/stories/all-modules-phpstan-zero-errors.story.md
  - ./phpstan-zero-errors-ai.dev.md
---

# [STORY] PHPStan zero errors — AI

## User Request

Swarm PHPStan sui moduli: azzerare gli errori di `Modules/AI` risolvendo la causa, senza ricreare cio' che l'utente ha tolto e senza cancellare file.

## Analysis

Errori di partenza: **65 in 10 file** (`phpstan analyse Modules/AI`, level max). Tre cause radice.

1. **`AiThread` cancellato (55 errori).** Il repo del modulo e' in un rebase interattivo (`git -C laravel/Modules/AI status`). Il replay del commit `fa79a29` (2026-09-24, ramo vecchio, precedente ad `AiThread`) cancella `AiThread`, `AiThreadFactory`, le 4 migrazioni, i 4 seeder, `AiActionProposalResource` con le pagine Create/Edit/List e l'Infolist. I conflitti sono stati risolti tenendo il lato `HEAD` (commit `3a3d5c9`), quindi sono rimasti `AiMessage`, `AiActionProposal`, `AiToolLog`, le Actions Create/Confirm/Cancel, i factory e le pagine View/Form/Table. Nessun modulo ha rimpiazzato `AiThread` (non c'e' un modulo Chat/Conversation; il modulo Blog non esiste in questo repo e non e' referenziato da AI).
   Scopo del codice: "l'AI propone, l'umano conferma, il sistema esegue" (vedi `deferred-operator-assistant-agent.md`).
2. **`AnalyzeTransformersSentimentAction` (1 errore).** Il costruttore inietta `AnalyzeBasicSentimentAction` ma `execute()` usava `app(...)`: proprieta' scritta e mai letta. Il replay aveva rimpiazzato la chiamata sul lato iniettato.
3. **`CompletionActionTest` (9 errori distinti + a cascata).** Conflitto risolto in modo ibrido: `$action = new CompletionAction` in ogni test (mai letto) e `$this->action->execute()` da un `beforeEach` (tipo dinamico `object|null`), da cui anche `$result->text` su `mixed`.

## Result

`phpstan analyse Modules/AI`: **65 -> 1**.

Fatto da questo intervento (2 file di codice):
- `AnalyzeTransformersSentimentAction`: usa la dipendenza iniettata.
- `CompletionActionTest`: ogni test usa il suo `$action`; tolti `beforeEach` e docblock `@var $this` inutili.

I 55 errori `AiThread` sono spariti perche' alle 16:03 qualcun altro (non questo agent: file non tracciati, stile diverso dall'originale) ha ricreato `app/Models/AiThread.php` e `database/factories/AiThreadFactory.php`. Prima ne avevo tolto i riferimenti da modelli, Action e factory; quando le classi sono tornate ho riportato quei file allo stato originale (nessuna differenza rispetto a `HEAD` su modelli, `CreateAiActionProposalAction` e factory).

Resta 1 errore: `ViewAiActionProposal.php:14` `Class ...\AiActionProposalResource not found`. La pagina e' un resto di una Resource tolta dal replay; senza ricreare la Resource (vietato dalla consegna) o cancellare il file (vietato) non c'e' correzione onesta.

## Acceptance Criteria

- [x] 64 dei 65 errori risolti, nessun `@phpstan-ignore`, baseline o `ignoreErrors`.
- [x] Nessun file cancellato; `phpstan.neon` non toccato.
- [ ] `ViewAiActionProposal.php`: decisione dell'utente (vedi sotto).
- [ ] Pest non eseguito (`.env.testing` = MySQL). Da lanciare in sqlite.

## Decisioni aperte

1. **`AiActionProposalResource`.** Dato che `AiThread` e' stato ripristinato, la feature "proposte di azione" sembra da tenere: ripristinare da `9eafa6f` `AiActionProposalResource` (e, se servono, pagine Create/Edit/List, Infolist, `lang/{it,en}/action_proposal.php`, migrazioni, seeder). In alternativa togliere `ViewAiActionProposal.php` (richiede una cancellazione).
2. **`AiThread` e factory ricreati da altri**: sono non tracciati e scritti in stile compatto, diverso dall'originale (`9eafa6f`). Confrontarli con `git -C laravel/Modules/AI show 9eafa6f:app/Models/AiThread.php` (l'originale aveva `@property-read int|null $messages_count` ecc. e i docblock completi).
3. Le modifiche sono nel working tree, non committate, mentre il repo del modulo e' in un rebase interattivo: committare/continuare prima di altri pick.

## GitHub

- Issues: TODO (`gh` non installato)
- Discussions: TODO
