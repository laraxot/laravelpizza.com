---
title: "AI domain enums (status, tool log, message role)"
module: AI
type: decision
tags: [ai, enum, filament, phpstan]
created: 2026-10-06
updated: 2026-10-06
---

# AI domain enums

I valori finiti persistiti dai model AI sono **backed enum** in `app/Enums/` (namespace `Modules\AI\Enums`), non costanti di classe.
Le colonne restano `string` (le migration non cambiano): la conversione avviene nei `casts()` del model.

| Enum | Model / colonna | Valori | Metodi |
| --- | --- | --- | --- |
| `AiActionProposalStatusEnum` | `AiActionProposal.status` | `pending`, `cancelled`, `confirmed`, `executed`, `failed` | `isPending()`, `isFinal()`, `canBeConfirmed()`, `canBeCancelled()` |
| `AiToolLogStatusEnum` | `AiToolLog.status` | `ok`, `error` | `isError()` |
| `AiMessageRoleEnum` | `AiMessage.role` | `user`, `assistant`, `tool`, `system` | `isUser()` |

## Regole

- Gli enum implementano `HasLabel`, `HasColor`, `HasIcon` con `Modules\Xot\Traits\EnumTrait`: etichetta, colore e icona stanno in
  `lang/<locale>/<snake(NomeEnum)>.php` alla chiave `values.<valore>.{label,color,icon,description}` (nome file = nome classe in snake case, **compreso** il suffisso `_enum`).
- Filament: `TextColumn::badge()` e `Select::options(Enum::class)` leggono l'enum; non ripetere mappe colore/etichetta nelle tabelle.
- Codice: `$proposal->status` e' un enum (`canBeConfirmed()`...), non confrontare con stringhe. Per scrivere: `forceFill(['status' => AiActionProposalStatusEnum::CONFIRMED])`.
- Le costanti di **configurazione** (testi dei prompt `ROUTING_JSON`, `PATTERN_JSON`, `IMPROVEMENTS_JSON`) restano costanti tipizzate, ora `private const string` in `Actions/Prompt/BuildAIPromptAction` (le tre copie di `AIPromptTemplates` sono state eliminate il 2026-10-08).
- Non esistono piu' `AiActionProposal::STATUS_*`, `AiToolLog::STATUS_*`, `AiMessage::ROLE_*` (nessun consumatore fuori dal modulo AI).

## Note

- `lang/*/action_proposal.php` conserva le chiavi `statuses.*` (non piu' lette dal codice del modulo): rimuovibili dopo aver verificato che nessun tema le usi.
- La cartella `Modules/AI/Enums/` (fuori da `app/`, quindi fuori da PSR-4) contiene un `AiActionProposalStatus` orfano e mai referenziato: non e' l'enum in uso.

Storia: [2026-10-06-phpstan-cleanup-ai](../stories/2026-10-06-phpstan-cleanup-ai.story.md).
