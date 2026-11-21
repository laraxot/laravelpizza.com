---
title: "Id utente come stringa (UUID) in tutte le tabelle del modulo AI"
type: story
module: AI
slug: user-ids-as-strings
status: review
owner: AI
created: 2026-11-17
updated: 2026-11-17
issues: []
discussions: []
related:
  - ../assistant.md
---

# Story: id utente come stringa

## Problema

Gli utenti Laraxot (`Modules\User\Models\BaseUser`) hanno id **UUID** (`HasUuids`, `$keyType = 'string'`).
Le colonne utente del modulo AI erano `unsignedBigInteger` e le Action accettavano `int`:
`ConfirmAiActionProposalAction` riceveva `(int) Auth::id()`, cioè `0` o un numero sbagliato, e la
riga restava legata a nessuno o all'utente sbagliato. Il test `tests/Feature/UserIdColumnsAcceptUuidTest.php`
descriveva già il comportamento giusto, ma le migrazioni non lo rispettavano.

## Modifiche

- [x] Colonne `ai_threads.created_by_user_id`, `ai_messages.user_id`, `ai_action_proposals.proposed_by_user_id`,
  `ai_action_proposals.confirmed_by_user_id`, `ai_tool_logs.user_id`: `string(36)` nullable
  (creazione + blocco `tableUpdate` per i database esistenti; i valori numerici restano validi come stringa)
- [x] `CreateAiThreadAction`, `AppendAiMessageAction`, `CreateAiActionProposalAction`, `ConfirmAiActionProposalAction`,
  `Assistant\AnswerQuestionAction`: accettano `int|string` (o `null` dove l'utente può mancare) e salvano stringhe
- [x] `AiActionProposalsTable`: conferma con `(string) Auth::id()`
- [x] `@property` dei modelli: `string|null`
- [ ] `php artisan migrate` e `pest tests/Feature/UserIdColumnsAcceptUuidTest.php` nell'app host
