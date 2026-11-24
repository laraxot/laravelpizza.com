---
title: "ai services support to actions"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ai services support to actions"
issues: []
discussions: []
---

# AI module: Services/Support -> Queueable Actions

Data: 2026-07-16

Applica la golden rule del repo (2026-07-13): in nessun modulo devono esistere
`app/Services/` o `app/Support/`. La logica di dominio vive in
`app/Actions/{Context}/FooAction.php` con il trait `Spatie\QueueableAction\QueueableAction`
e un singolo metodo pubblico `execute(...)`.

## Situazione di partenza

| File | Cartella | Stato |
|---|---|---|
| `AIService.php` | `app/Services` | Codice morto: 0 chiamanti nel monorepo. Boilerplate "FixCity / ticket cittadini" mai collegato a questa app (prediction market). |
| `AiJsonResponseDecoder.php` | `app/Support` | Codice morto: 0 chiamanti. Duplicava il decode JSON gia inline in `AIService`. |
| `PredictionDraftFallbackTemplates.php` | `app/Support` | Codice morto: 0 chiamanti. I template erano duplicati inline in `GeneratePredictionDraftsAction::fallbackDrafts()`. |
| `ScalarCaster.php` | `app/Support` | Vivo: usato solo da `Datas/OpenAiPredictionMapper`. |

## Decisioni

- **`AIService`**: nessun chiamante e funzionalita gia coperta da
  `Actions/CompletionAction` e `Actions/Predict/GeneratePredictionDraftsAction`.
  Non ricreato come Action (evitare di generare codice morto in una nuova cartella —
  regola ponytail). Ritirato a `.bak`.
- **`AiJsonResponseDecoder`**: codice morto, ritirato a `.bak`.
- **`PredictionDraftFallbackTemplates`**: convertito in Action
  `Actions/Predict/GetPredictionDraftFallbackTemplatesAction` (QueueableAction,
  `execute(): array`) e **cablato** in `GeneratePredictionDraftsAction::fallbackDrafts()`
  via `app(GetPredictionDraftFallbackTemplatesAction::class)->execute()`, rimuovendo la
  duplicazione dei template. Originale ritirato a `.bak`.
- **`ScalarCaster`**: 3 helper statici (`string`, `nullableString`, `stringList`) non
  riconducibili a un singolo `execute()`. Essendo usati solo da `OpenAiPredictionMapper`,
  sono stati inlineati come metodi privati statici (`toString`, `toNullableString`,
  `toStringList`) nel mapper. Originale ritirato a `.bak`.

## Effetto

- `app/Services/` e `app/Support/` non contengono piu file `.php` (solo `.bak`), quindi
  `bashscripts/tools/check-no-app-support.sh` non segnala piu il modulo AI.
- Aggiunto il trait `QueueableAction` a `GeneratePredictionDraftsAction`,
  `BasicSentimentAnalyzer`, `TransformersSentimentAnalyzer` per rispettare
  `audit-queueable-action-trait.sh`.
- PHPStan `Modules/AI`: da 13 a 2 "errori" (i 2 residui sono soltanto pattern di ignore
  globali non matchati nello scope del singolo modulo — `phpstan.neon` e immutabile).

## Aggiornamento 2026-10-08

Un merge (`laraxot/dev`, commit `9b0682a`) aveva riportato in `app/Services/` i 5 file (`AIService`, `AIChatCompletionClient`,
`AIServiceJsonDecoder`, `AIServicePromptBuilder`, `AIServicePromptTemplates`) e il `.bak`. Erano ancora codice morto (0 chiamanti):
eliminati, nessuna nuova Action. Equivalenti vivi: `ClassifyTicketAction`, `SuggestSolutionsAction`, `MakeAIRequestAction`,
`AiJsonResponseDecoderAction`, `BuildAIPromptAction`. Dettagli: [story](../../stories/2026-10-08-services-to-actions-ai.story.md).
