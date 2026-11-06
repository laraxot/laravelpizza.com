---
title: "[DEV] PHPStan zero errors — AI"
type: dev-story
module: AI
status: in-progress
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, ai, lessons-learned]
---

# Dev Story — AI PHPStan 65 -> 1

## Technical Plan

Raggruppare per causa radice, capire lo scopo con `git -C laravel/Modules/AI log/show` (sola lettura), correggere dove nasce l'errore.

## Implementation Steps

1. [x] Ricostruita la storia di `AiThread`: aggiunto in `9b0682a` (2026-09-26), tolto dal replay di `fa79a29` (2026-09-24, ramo vecchio) nel commit `dfa39fa`; i conflitti sono stati risolti tenendo il lato `HEAD`, quindi i modelli e le Actions sono rimasti.
2. [x] `AnalyzeTransformersSentimentAction` torna alla dipendenza iniettata.
3. [x] `CompletionActionTest` torna a un `$action` locale per test.
4. [x] Riferimenti ad `AiThread`: tolti, poi riportati allo stato originale quando `AiThread` e `AiThreadFactory` sono stati ricreati da altri (16:03).
5. [ ] `ViewAiActionProposal.php` (1 errore): in attesa della decisione sulla Resource.

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/AI --memory-limit=-1 --no-progress --error-format=raw
```

Risultato: 1 errore (`ViewAiActionProposal.php:14`). `php -l` pulito sui file toccati. Pest non eseguito.

## Lessons Learned

- Un file mancante in un repo con `rebase in progress` non e' una scelta dell'utente: `git status` del modulo e `git show <commit> --stat` dicono se la cancellazione viene da un replay.
- Un conflitto risolto tenendo un solo lato lascia a meta' le feature: modelli senza il modello padre, pagine senza Resource. Il segnale e' un errore `class.notFound` su una classe che i docs descrivono ancora.
- Dipendenza iniettata e mai letta: ricondurre la chiamata alla proprieta' (`$this->dep->execute()`), non a `app()`.
- Nei test Pest, `$this->action` impostato in `beforeEach` e' dinamico per PHPStan: meglio una variabile locale per test.
