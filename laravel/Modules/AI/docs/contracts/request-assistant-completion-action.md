---
title: "Contratto — RequestAssistantCompletionAction"
type: contract
action: "Modules\AI\Actions\Assistant\RequestAssistantCompletionAction"
<<<<<<< HEAD
tags: [contract, action, ai, assistente, llm]
created: 2026-11-18
updated: 2026-11-24
=======
tags: [contract, action]
created: 2026-11-18
updated: 2026-11-18
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))
---

# RequestAssistantCompletionAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
<<<<<<< HEAD
Sorgente: `app/Actions/Assistant/RequestAssistantCompletionAction.php`. Perché una cascata di fornitori:
[ADR](../adr/assistant-provider-cascade.md).

## Input

- Prompt di sistema e prompt dell'utente (stringhe).
- Implicito, da `AIConfigData::make()` (file `ai` del tenant): `assistant_providers` (default `groq`, `openrouter`),
  `assistant_models`, `assistant_timeout` (30 s), `free_models_only` (default `true`). Le chiavi API da `config('services.*')`.

## Output

- Il testo della prima risposta non vuota (`choices.0.message.content`), di norma un oggetto JSON come chiede il prompt.
- Se nessun fornitore della cascata risponde: il risultato di `MakeAIRequestAction` (OpenAI).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| AI-ASSIST-INV-1 | I fornitori si provano nell'ordine di `assistant_providers`, ciascuno con il proprio modello di `assistant_models`. | `AI-ASSIST-INV-1` |
| AI-ASSIST-INV-2 | Con `free_models_only` un modello a pagamento della cascata non viene mai chiamato (`AiProviderEnum::isFreeModel`). | `AI-ASSIST-INV-2` |
| AI-ASSIST-INV-3 | Si chiede `response_format: json_object` (salvo fornitori con `jsonMode() === 'none'`) e almeno un messaggio contiene «json»: se manca, al prompt di sistema si aggiunge `JSON_INSTRUCTION` (senza, Groq e OpenAI rispondono 400). | `AI-ASSIST-INV-3` |
| AI-ASSIST-INV-4 | Un fornitore senza chiave, in errore (`AiRequestException`) o senza contenuto passa la mano al successivo. | `AI-ASSIST-INV-4` |
| AI-ASSIST-INV-5 | Esaurita la cascata, l'ultima parola è di `MakeAIRequestAction` (OpenAI). | `AI-ASSIST-INV-5` |

Test: `tests/Unit/Assistant/RequestAssistantCompletionActionTest.php` (risposte HTTP finte, nessuna rete).

## Effetti collaterali

- Richieste HTTP `POST /chat/completions` ai fornitori (`Vision\OpenAiCompatibleRequestAction`), `temperature` 0.2, `max_tokens` 1000.
- Un `Log::warning` per ogni fornitore in errore o senza contenuto.

## Errori

- Gli errori dei fornitori della cascata non escono.
- Le eccezioni di `MakeAIRequestAction` (ultimo tentativo) arrivano al chiamante.

## Non fa

- Non applica `free_models_only` all'ultimo tentativo: `MakeAIRequestAction` chiama OpenAI, a pagamento (debito noto).
- Non costruisce il prompt (`BuildAssistantPromptAction`) e non interpreta il JSON (`AnswerQuestionAction` con `AssistantAnswerData::fromModelResponse`).
- Non salva la conversazione (`CreateAiThreadAction`, `AppendAiMessageAction`).
- Non mette in cache le risposte e non ripete la stessa richiesta allo stesso fornitore.
=======
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
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))
