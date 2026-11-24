---
title: "Analisi del sentiment: le Action e basta"
type: guideline
module: AI
tags: [documentation, sentiment, queueable-action, actions-over-services]
created: 2026-11-19
updated: 2026-11-19
qmd: "SentimentAction AnalyzeBasicSentimentAction AnalyzeTransformersSentimentAction BasicSentimentAnalyzer TransformersSentimentAnalyzer SentimentAnalyzer contratto eliminato QueueableActionContractTest"
issues: []
discussions: []
related:
  - ./stories/services-to-actions-ai.story.md
  - ./PHILOSOPHY.md
---

# Analisi del sentiment: le Action e basta

## Il percorso

```
SentimentAction::execute($prompt)            // punto d'ingresso, restituisce SentimentData
  ├─ Transformers installato → app(Sentiment\AnalyzeTransformersSentimentAction)->execute()
  └─ altrimenti              → app(Sentiment\AnalyzeBasicSentimentAction)->execute()
```

Tutte e tre sono Spatie QueueableAction (`use QueueableAction`, `execute()` pubblico), come vuole la
regola del progetto: la logica sta in `app/Actions`, non in `app/Services` ne' in classi con un
metodo diverso da `execute()`. Lo verifica `tests/Unit/Actions/QueueableActionContractTest.php`,
che percorre **ogni** file sotto `app/Actions`.

- `AnalyzeBasicSentimentAction`: liste di parole positive/negative; una parola preceduta entro tre
  parole da una negazione (`not`, `never`, `don't`...) inverte la polarita'.
- `AnalyzeTransformersSentimentAction`: oggi la pipeline Transformers e' disattivata e delega
  sempre alla basic (scrive una riga in `error_log` se la libreria e' presente).

## Cosa e' stato eliminato, e perche' (2026-11-19)

`Actions/Sentiment/BasicSentimentAnalyzer`, `Actions/Sentiment/TransformersSentimentAnalyzer` e il
contratto `Contracts/SentimentAnalyzer` (`analyze(string): array`).

- **Zero chiamanti**: `grep -rn` su `laravel/Modules` e `laravel/Themes` trovava solo le classi
  stesse; nessun binding nel container (`AIServiceProvider` non li registra), nessun test.
- **Duplicati, e vecchi**: stessa logica delle due Action, ma la basic non gestiva le negazioni
  («not a good product» contava come positivo). `SentimentAction` usa gia' le Action dal passaggio
  services→actions (story `services-to-actions-ai`, sezione «Aperto»).
- **Non adattatori**: un adattatore serve se qualcuno dipende dal contratto. Nessuno ne dipendeva,
  quindi spostarli fuori da `Actions/` avrebbe conservato codice morto in un posto diverso.
- Il contratto, rimasto senza implementazioni ne' consumatori, e' stato tolto con loro.

Se un giorno servira' scegliere l'analizzatore da configurazione, il punto e' `SentimentAction`
(una `match` sulle due Action), non un'interfaccia parallela.
