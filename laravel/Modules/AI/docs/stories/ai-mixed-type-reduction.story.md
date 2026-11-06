---
tags: [documentation]
updated: 2026-09-26
qmd: "ai mixed type reduction.story"
issues: []
discussions: []
title: "Reduce mixed type usage - AI module"
status: done
type: story
created: 2026-09-04
---

# Reduce mixed type usage - AI module

**Trovato**: 74 occorrenze di `mixed` in 33 file `.php` del modulo (73 reali: una era un falso positivo, la parola "mixed" dentro una stringa di fixture di test, non un tipo). La maggior parte erano gia' l'uso corretto — cast scalari generici, colonne JSON Eloquent, `definition()` di factory, payload JSON/HTTP esterni con shape non stabile — ma due cluster avevano una shape evidente e stabile mai dichiarata: gli analyzer di sentiment (4 implementazioni + 1 contract, tutti con lo stesso `return ['label' => ..., 'score' => ..., 'warning' => ...]`) e i template di fallback delle prediction (array letterale hardcoded con chiavi fisse).

**Fatto**: sostituito `array<string, mixed>` con `array{label: string, score: int|float, warning: string}` in `app/Contracts/SentimentAnalyzer.php`, `app/Actions/Sentiment/BasicSentimentAnalyzer.php`, `app/Actions/Sentiment/TransformersSentimentAnalyzer.php`, `app/Actions/Sentiment/AnalyzeBasicSentimentAction.php`, `app/Actions/Sentiment/AnalyzeTransformersSentimentAction.php`. Sostituito `array<int, array<string, mixed>>` con una shape a 7 campi in `app/Actions/Prediction/GetPredictionFallbackTemplatesAction.php`. PHPStan: 0 errori prima, 0 errori dopo (`./vendor/bin/phpstan analyse Modules/AI --no-progress --error-format=table`).

**Resta da fare**: le rimanenti ~67 occorrenze sono state lasciate `mixed` con motivazione documentata in `docs/coverage.md` (sezione 2026-09-04) — cast utility, colonne JSON Eloquent, factory, payload JSON/HTTP/form esterni a shape non stabile. Nessuna e' stata giudicata un typing gap reale; restringerle avrebbe richiesto un `@var`/cast non supportato dal codice runtime (vietato) o avrebbe solo spostato `mixed` di un livello (es. `array<array-key, mixed>`). Se in futuro emerge uno schema stabile per uno di questi payload (es. contratto OpenAI fissato), rivalutare.

Dettaglio completo: `Modules/AI/docs/coverage.md`.
