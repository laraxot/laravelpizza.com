---
title: "Contratto — ConfirmAiActionProposalAction"
type: contract
action: "Modules\AI\Actions\ConfirmAiActionProposalAction"
tags: [contract, action, ai, proposta, human-in-the-loop]
created: 2026-11-24
updated: 2026-11-24
---

# ConfirmAiActionProposalAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/ConfirmAiActionProposalAction.php`. Perché l'AI propone e una persona conferma:
[ADR](../adr/ai-proposes-human-confirms.md).

## Input

- La proposta (`AiActionProposal`, con `type` e `payload`).
- L'id di chi conferma (`int|string`: gli utenti sono UUID).
- Implicito: gli handler registrati in `Adapters\AiActionHandlerRegistry` (singleton).

Chiamata dall'azione «Conferma» di `Filament/Resources/AiActionProposalResource/Tables/AiActionProposalsTable.php`, visibile solo
se `status->canBeConfirmed()`.

## Output

- La stessa proposta, salvata, con lo stato finale: `executed` o `failed`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| AI-CONFIRM-INV-1 | Prima di eseguire si salvano `confirmed`, `confirmed_by_user_id` (stringa) e `confirmed_at`: chi ha confermato resta anche se l'handler fallisce. | `AI-CONFIRM-INV-1` |
| AI-CONFIRM-INV-2 | Esito positivo → `executed`, `executed_at`, `result` = ritorno dell'handler. | `AI-CONFIRM-INV-2` |
| AI-CONFIRM-INV-3 | Nessun handler per il `type`, o handler che lancia → `failed` con il messaggio in `error`. | `AI-CONFIRM-INV-3` |
| AI-CONFIRM-INV-4 | Nessuna eccezione dell'handler arriva al chiamante (`catch (\Throwable)`). | `AI-CONFIRM-INV-4` |

Test: `tests/Unit/Actions/ConfirmAiActionProposalActionTest.php` (salvataggio bloccato dall'evento `saving`, si prova la macchina a stati).

## Effetti collaterali

- Due `save()` della proposta (conferma, esito).
- Quello che fa l'handler del dominio registrato per il `type` (fuori dal modulo AI).

## Errori

- Solo errori del database al salvataggio della proposta.

## Non fa

- Non controlla lo stato di partenza: confermare una proposta già eseguita la riesegue. Il controllo sta solo nella UI
  (`canBeConfirmed()`); un chiamante nuovo deve farlo da sé.
- Non verifica permessi di chi conferma.
- Non apre una transazione intorno all'handler e non ritenta.
- Non crea né annulla proposte (`CreateAiActionProposalAction`, `CancelAiActionProposalAction`).
