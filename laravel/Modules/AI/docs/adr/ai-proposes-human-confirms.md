---
title: "ADR — L'AI propone, una persona conferma, un handler del dominio esegue"
type: decision
status: accepted
module: AI
tags: [adr, ai, proposte, human-in-the-loop, registry]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../contracts/confirm-ai-action-proposal-action.md
  - ../deferred-operator-assistant-agent.md
  - ../agents.md
---

# ADR: l'AI propone, una persona conferma, un handler del dominio esegue

## Contesto

- Un agente AI che agisce sui dati (timbrature, stati di ordini) può sbagliare: un'azione eseguita non si annulla con un prompt.
- Il modulo AI è condiviso tra progetti con domini diversi; l'agente operatore portato da un altro gestionale (~1575 righe,
  tool-calling verso `WorkOrder`, `Bom`, `Product`, …) dipendeva direttamente da moduli che qui non esistono o hanno altro schema
  (`docs/deferred-operator-assistant-agent.md`).
- Domanda: come lasciare che l'AI faccia cose, senza che agisca da sola e senza che il modulo AI conosca i domini?

## Decisione

- L'AI non esegue: crea una `AiActionProposal` (`CreateAiActionProposalAction`, stato `pending`, `type` + `payload` + `preview`).
- Una persona la conferma o la annulla dal back office (`AiActionProposalResource`, azioni visibili solo se `canBeConfirmed()` /
  `canBeCancelled()`).
- `ConfirmAiActionProposalAction` cerca l'handler del `type` in `Adapters\AiActionHandlerRegistry` (singleton in `AIServiceProvider`) e lo
  esegue; esito e errore restano sulla proposta (`executed`/`failed`, `result`/`error`).
- Gli handler (`Contracts\AiActionHandlerContract`) li registra il modulo di dominio del progetto: il modulo AI non importa nessun modulo
  di dominio.

## Alternative scartate

- Tool-calling che scrive direttamente (come l'agente originale): nessun punto in cui una persona possa fermare un errore del modello.
- Portare l'agente 1:1: tool contro modelli che qui non esistono, accoppiamento AI → domini.
- Eventi Laravel al posto del registry: più handler potrebbero eseguire la stessa proposta; con il registry il `type` ha un solo handler.

## Conseguenze

- Pro: traccia completa (chi ha proposto, chi ha confermato, quando, esito); il modulo AI resta agnostico.
- Contro: ogni azione chiede un clic; serve un handler per ogni `type`.
- Debito: `ConfirmAiActionProposalAction` non controlla lo stato di partenza (lo fa solo la UI) e non apre una transazione intorno
  all'handler.

## Verifica

- `vendor/bin/pest Modules/AI/tests --group=AI-CONFIRM-INV-3`: fallisce se una proposta senza handler o con handler in errore non finisce
  `failed`. Registry: `tests/Unit/Support/AiActionHandlerRegistryTest.php`.
- Solo revisione: nessun `use Modules\<Dominio>\…` in `Modules/AI/app` per eseguire azioni di dominio (oggi assente).
