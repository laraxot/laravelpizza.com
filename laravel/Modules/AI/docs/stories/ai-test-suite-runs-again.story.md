---
title: "AI: la suite di test torna a girare"
type: story
status: done
created: 2026-10-26
updated: 2026-10-26
module: AI
related:
  - ../../../Xot/docs/stories/xot-action-containers-and-zombie-traits.story.md
tags: [ai, pest, openai, phpstan, sentiment]
---

# AI: la suite di test torna a girare

Fase BMAD: Dev, poi Verify.

## Problema

La suite AI si fermava con `Cannot redeclare class OpenAI`. `ContextCompressorAction` usava `OpenAI\OpenAI`, una classe che non esiste. L'autoloader cercava quel nome in `vendor/openai-php/client/src/OpenAI.php`, il file della classe globale `\OpenAI`, e lo includeva una seconda volta. Il client poi leggeva una proprietà `responses` che `OpenAI\Client` non ha, quindi la compressione via OpenAI non partiva mai.

## Correzioni

- `ContextCompressorAction`: `\OpenAI::client($key)->responses()->create()` e `$response->outputText`. Rimosso `extractCompressedText(mixed)`: niente più `mixed`.
- Rimossa la copia `Modules/Xot/app/Actions/ContextCompressorAction.php` (zero chiamanti; voce 1 e decisione 1 della story Xot collegata). L'Action di dominio resta in AI.
- `MakeAIRequestAction`: se manca `ai.openai_api_key` usa `services.openai.api_key`. `ai.openai_api_key` non è definita in nessun file di config, quindi prima la chiave era sempre vuota.
- `AnalyzeBasicSentimentAction`: una negazione nelle tre parole precedenti inverte la polarità ("not a good product" è negativo).
- `CompletionActionTest`: niente mock di classi `final`. Si usano `CreateResponse::fake()`, `OpenAI::fake()` e `assertSent()`, con controllo dei parametri.

## Verifica

Dalla root: `PEST_OUT=<file> bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/AI/tests Modules/AI/tests`.
Prima: errore fatale (0 test completati). Dopo: 65 superati, 2 falliti. PHPStan sui file toccati: 0 errori.

## Aperto

- `UserIdColumnsAcceptUuidTest`: colonna `ai_threads.created_by_user_id` mancante. È deriva di schema nel DB di origine dello scratch (migration pendenti), non codice.
- `QueueableActionContractTest`: `Actions/Prompt/AIPromptTemplates` non è un'Action (template statici). Va spostata fuori da `Actions/`. Serve decidere la cartella: nessuna cartella esistente è adatta e una nuova cartella base richiede approvazione.
