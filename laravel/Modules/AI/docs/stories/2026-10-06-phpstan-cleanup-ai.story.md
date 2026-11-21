---
title: "[STORY] PHPStan cleanup — AI"
type: story
module: AI
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, ai]
---

# [STORY] PHPStan cleanup — AI

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo AI. Errori di partenza: 15 `typeCoverage.constantTypeCoverage` (AiToolLog 2, AiMessage 4, AIPromptTemplates x3 copie).

## Analysis

**Scopo del codice.** Il modulo AI registra conversazioni (`AiThread` -> `AiMessage`), le chiamate a tool dell'assistente (`AiToolLog`, audit trail)
e le azioni che l'AI propone ma che un umano deve confermare (`AiActionProposal`: pending -> confirmed -> executed | cancelled | failed).

Le costanti segnalate erano **insiemi di valori persistiti** e non configurazione:

| Costanti | Dominio | Soluzione |
| --- | --- | --- |
| `AiActionProposal::STATUS_*` (5) | stato della proposta | `AiActionProposalStatusEnum` (gia' presente, esteso) |
| `AiToolLog::STATUS_OK/ERROR` | esito della chiamata al tool | nuovo `AiToolLogStatusEnum` |
| `AiMessage::ROLE_*` (4) | autore del messaggio (valori del campo `role` delle chat-completion) | nuovo `AiMessageRoleEnum` |
| `ROUTING_JSON`, `PATTERN_JSON`, `IMPROVEMENTS_JSON` | testo dei prompt (configurazione) | restano costanti, ora `public const string` |

Gli enum implementano `HasLabel/HasColor/HasIcon` con `EnumTrait`: etichetta, colore e icona arrivano dai file lang
`ai::<snake(NomeEnum)>.values.<valore>.*` (it + en), nessuna stringa hardcoded. I model usano `casts()` verso l'enum, quindi
`$proposal->status` e' un enum (metodi `canBeConfirmed()`, `canBeCancelled()`, `isFinal()`), il badge Filament e la `Select` leggono l'enum
(`->options(AiActionProposalStatusEnum::class)`), i colori non sono piu' duplicati nella tabella.

**Stato trovato nel working tree.** Un passaggio precedente aveva gia' tolto le costanti da `AiActionProposal` e sostituito gli usi con
`\Modules\AI\Enums\AiActionProposalStatusEnum::X->value` (FQCN inline, senza cast ne' metodi sull'enum), e aveva sostituito le altre
costanti tipizzate con docblock `@var` (che per PHPStan non conta come tipo nativo). Qui il lavoro e' stato completato e ripulito.

## Acceptance Criteria

- [x] Nessuna costante `STATUS_*`/`ROLE_*` residua in `AiActionProposal`, `AiToolLog`, `AiMessage` (consumatori verificati con grep su `Modules` e `Themes`: solo il modulo AI)
- [x] Enum con label/colore/icona tradotti (it, en) e metodi di dominio; nessuna stringa hardcoded
- [x] `casts()` verso gli enum e `@property` aggiornati; factory, Filament (form, tabella), Action e test usano gli enum
- [x] Costanti dei prompt tipizzate (`public const string`)
- [x] PHPStan: 0 errori sul modulo AI (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [2026-10-06-phpstan-cleanup-ai.dev.md](./2026-10-06-phpstan-cleanup-ai.dev.md)
