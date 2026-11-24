---
title: "ADR — Gli id utente nelle tabelle AI sono stringhe da 36 caratteri"
type: decision
status: accepted
module: AI
tags: [adr, ai, uuid, migrazioni]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../stories/user-ids-as-strings.story.md
---

# ADR: gli id utente nelle tabelle AI sono stringhe

## Contesto

- Gli utenti (`Modules\User\Models\BaseUser`) hanno id UUID (`HasUuids`, `$keyType = 'string'`).
- Le colonne utente del modulo erano `unsignedBigInteger` e le Action accettavano `int`: `ConfirmAiActionProposalAction` riceveva
  `(int) Auth::id()`, cioè `0` o un numero sbagliato, e la proposta restava legata a nessuno o all'utente sbagliato (story
  `user-ids-as-strings`, 2026-11-17).
- Domanda: che tipo hanno le colonne utente e i parametri delle Action?

## Decisione

- `ai_threads.created_by_user_id`, `ai_messages.user_id`, `ai_action_proposals.proposed_by_user_id`,
  `ai_action_proposals.confirmed_by_user_id`, `ai_tool_logs.user_id`: `string(36)` nullable, in creazione e nel blocco `tableUpdate`
  per i database esistenti (es. `database/migrations/2026_07_24_000001_create_ai_threads_table.php`).
- `CreateAiThreadAction`, `AppendAiMessageAction`, `CreateAiActionProposalAction`, `ConfirmAiActionProposalAction`,
  `Assistant\AnswerQuestionAction` accettano `int|string` e salvano stringhe; la tabella Filament conferma con `(string) Auth::id()`.

## Alternative scartate

- Colonne `uuid`: i valori numerici già salvati non sarebbero più validi; con `string(36)` restano validi come stringa (story).
- Cast a `int` nel chiamante: è esattamente il difetto da cui si parte.

## Conseguenze

- Pro: funziona con utenti UUID e numerici.
- Contro: nessuna chiave esterna verso `users`, che sta su un'altra connessione (le tabelle AI sono su `xot`, vedi il commento della
  migrazione di `ai_threads`).

## Verifica

`vendor/bin/pest Modules/AI/tests/Feature/UserIdColumnsAcceptUuidTest.php` controlla lo schema delle cinque colonne. Oggi è rosso nel DB
di prova condiviso (le tabelle AI non hanno le colonne attese: migrazioni non applicate lì); finché non torna verde, solo revisione: nessun
`(int)` su un id utente nelle Action del modulo. `AI-CONFIRM-INV-1` prova che la conferma salva l'UUID come stringa.
