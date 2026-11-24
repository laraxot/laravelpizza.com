---
title: "Contratto — RequestAssistantCompletionAction"
type: contract
action: "Modules\AI\Actions\Assistant\RequestAssistantCompletionAction"
tags: [contract, action]
created: 2026-11-18
updated: 2026-11-18
---

# RequestAssistantCompletionAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Assistant/RequestAssistantCompletionAction.php`.

## Input

- Prompt di sistema e prompt dell'utente.

## Output

- Il testo della risposta (JSON, come chiede il prompt) del primo fornitore che risponde.

## Invarianti

- Con `free_models_only` mai un modello a pagamento.
- Ogni richiesta chiede `response_format: json_object` e almeno un messaggio nomina JSON (JSON_INSTRUCTION), altrimenti Groq e OpenAI rispondono 400.

## Effetti collaterali

- Richieste HTTP ai fornitori in ordine (`assistant_providers`).
- Un avviso nel log per ogni fornitore saltato o in errore.

## Errori

- Un fornitore senza chiave, in errore o senza contenuto passa la mano al successivo.
- Alla fine prova OpenAI (MakeAIRequestAction), le cui eccezioni arrivano al chiamante.

## Non fa

- Non costruisce il prompt (BuildAssistantPromptAction).
- Non interpreta il JSON della risposta.
- Non salva la conversazione.
