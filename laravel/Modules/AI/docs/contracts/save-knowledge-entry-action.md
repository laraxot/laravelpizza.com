---
title: "Contratto — SaveKnowledgeEntryAction"
type: contract
action: "Modules\AI\Actions\Assistant\SaveKnowledgeEntryAction"
tags: [contract, action, ai, assistente, knowledge-base]
created: 2026-11-24
updated: 2026-11-24
---

# SaveKnowledgeEntryAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Assistant/SaveKnowledgeEntryAction.php`.

## Input

- `collection` (la base di conoscenza di un progetto o cliente), `question`, `answer`.
- Facoltativi: `tags` (lista), `id` della voce da aggiornare, `isActive` (default `true`).

## Output

- La voce `AiKnowledgeEntry` salvata.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| AI-KNOWLEDGE-INV-1 | Domanda o risposta vuote (dopo `trim`) → `ValidationException` prima di toccare il database. | `AI-KNOWLEDGE-INV-1` |
| AI-KNOWLEDGE-INV-2 | Con `id`, la voce si aggiorna solo se appartiene alla stessa `collection`; altrimenti `ValidationException` su `id`. | — |
| AI-KNOWLEDGE-INV-3 | Senza `id`, una voce con la stessa domanda nella `collection` si aggiorna invece di duplicarsi. | — |
| AI-KNOWLEDGE-INV-4 | `tags` nullo conserva i tag esistenti; una lista li sostituisce, senza voci vuote. | — |

Test: `tests/Unit/Assistant/SaveKnowledgeEntryActionTest.php` (solo INV-1; le altre richiedono la tabella `ai_knowledge_entries`).

## Effetti collaterali

- Un INSERT o UPDATE su `ai_knowledge_entries`.

## Errori

- `ValidationException` (INV-1, INV-2); errori del database al chiamante.

## Non fa

- Non verifica chi chiama: l'autorizzazione è del chiamante.
- Non calcola embedding né indicizza: la ricerca (`SearchKnowledgeEntriesAction` → `RankKnowledgeEntriesAction`) legge le voci attive della `collection` a ogni domanda.
- Non cancella voci (per spegnerne una: `isActive = false`).
