---
title: "ADR — L'assistente chiede la risposta a più fornitori in cascata, solo modelli gratuiti"
type: decision
status: accepted
module: AI
tags: [adr, ai, assistente, groq, openrouter, openai, costi]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../contracts/request-assistant-completion-action.md
  - ../stories/assistant-provider-cascade.story.md
---

# ADR: l'assistente chiede la risposta a più fornitori in cascata

## Contesto

- L'assistente risponde a un visitatore in chat: la risposta deve arrivare in pochi secondi (`assistant_timeout` = 30 s).
- Prima della story `assistant-provider-cascade` (2026-11-17) l'unico fornitore era OpenAI (`MakeAIRequestAction`), a pagamento.
- Groq e OpenRouter offrono modelli gratuiti con API compatibile OpenAI; i piani gratuiti hanno limiti di frequenza (429).
- Groq e OpenAI rispondono 400 a `response_format: json_object` se nessun messaggio contiene «json» (osservato il 2026-11-17).
- Domanda: come avere una risposta veloce, senza costi imprevisti, anche quando un fornitore è giù o limitato?

## Driver della decisione

- Latenza: la risposta arriva a un visitatore in chat, quindi ogni fornitore ha un tempo massimo (`assistant_timeout` = 30 s) e un
  errore deve passare la mano senza far attendere ancora.
- Costo: OpenAI era l'unico fornitore ed è a pagamento; Groq e OpenRouter offrono modelli gratuiti con la stessa API compatibile
  OpenAI, quindi non serve un client nuovo.
- Disponibilità: i piani gratuiti rispondono 429 oltre i limiti di frequenza, quindi un solo fornitore gratuito non basta.
- Vincolo tecnico: con `response_format: json_object` Groq e OpenAI rispondono 400 se nessun messaggio nomina «json»; senza
  accorgimento il fornitore verrebbe saltato a ogni chiamata.

## Decisione

- `Assistant\RequestAssistantCompletionAction` prova i fornitori di `AIConfigData::$assistant_providers` in ordine (default Groq, poi
  OpenRouter), con il modello di `assistant_models` (`openai/gpt-oss-120b`, `openrouter/free`).
- Un fornitore senza chiave, in errore o senza contenuto passa la mano al successivo; alla fine resta OpenAI (`MakeAIRequestAction`).
- Con `free_models_only` (default `true`) un modello a pagamento della cascata si salta prima della chiamata (`AiProviderEnum::isFreeModel`).
- Riuso di `AiProviderEnum` e `Vision\OpenAiCompatibleRequestAction`, già usati per le immagini: nessun client HTTP nuovo.
- `JSON_INSTRUCTION` si aggiunge al prompt di sistema se nessun messaggio nomina JSON.

## Alternative scartate

- Solo OpenAI: costo a ogni domanda e un solo punto di guasto.
- Un SDK per fornitore (es. client Groq dedicato): tre client per la stessa API compatibile OpenAI.
- Scegliere il fornitore a caso o per carico: l'ordine fisso rende prevedibili costi e qualità, e si cambia da configurazione del tenant.

## Conseguenze

- Pro: risposta anche con un fornitore giù; nessun costo finché risponde un modello gratuito; ordine e modelli per tenant senza deploy.
- Contro: con tutti i gratuiti giù si paga OpenAI, e l'ultimo tentativo **non** rispetta `free_models_only` (debito).
- Debito: `AiProviderEnum` e `OpenAiCompatibleRequestAction` stanno ancora nel namespace `Vision` (story, punto aperto); la prova con
  chiavi reali dall'app ospite non è fatta.

## Conferma

La decisione è rispettata finché `RequestAssistantCompletionActionTest` resta verde: ordine Groq → OpenRouter → OpenAI, passaggio al
successivo su errore o assenza di chiave, nessuna chiamata a un modello a pagamento con `free_models_only` attivo, istruzione JSON
aggiunta quando manca. I default (`assistant_providers`, `assistant_models`, `assistant_timeout`, `free_models_only`) stanno in
`Modules/AI/app/Datas/AIConfigData.php` e si cambiano da configurazione del tenant, non nel codice.

## Verifica

`vendor/bin/pest Modules/AI/tests/Unit/Assistant/RequestAssistantCompletionActionTest.php` (5 test, HTTP finto, verdi il 2026-11-24;
group `AI-ASSIST-INV-1`…`AI-ASSIST-INV-5`): fallisce se cambia l'ordine, se un errore non passa al successivo, se si chiama un modello a
pagamento con `free_models_only` o se manca la parola «json».
