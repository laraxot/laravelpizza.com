---
tags: [documentation]
updated: 2026-09-26
qmd: "ai quality gate 2026 09 04.story"
issues: []
discussions: []
title: "Quality gate closure - AI module (PHPMD + Pest + coverage + git)"
status: done
type: story
created: 2026-09-04
---

# Quality gate closure - AI module (PHPMD + Pest + coverage + git)

**Fase BMAD**: Build + Measure.

## Build

- **PHPMD** (`./tools/phpmd.sh Modules/AI/app text ../docs/phpmd.ruleset.xml`): 9 finding → 9 fixati.
  - `ContextCompressorAction::extractCompressedText()` (CyclomaticComplexity 13/10): estratto in 3 metodi privati piccoli.
  - `Ds4/ChatDs4Action::execute()` (CyclomaticComplexity 10/10): estratto `buildPayload()` + `buildResult()`.
  - `Predict/GeneratePredictionDraftsAction::parseDrafts()` (CyclomaticComplexity 10/10): estratto `parseDraftItem()`.
  - `Ds4/ChatDs4Action.php`, `Ds4/GenerateDs4Action.php`, `Ollama/ChatOllamaAction.php`, `Ollama/GenerateOllamaAction.php` (MissingImport su `\RuntimeException`): aggiunto `use RuntimeException;` in tutti e 4.
  - `Predict/GetPredictionDraftFallbackTemplatesAction` (LongClassName 41/40): era codice morto (0 chiamanti reali, verificato con grep sull'intero monorepo), ritirata a `.bak` come da convenzione gia' in uso nel modulo. Doc di riferimento aggiornate.
  - `Sentiment/AnalyzeTransformersSentimentAction.php:17` (LongVariable 28/20): proprieta' costruttore rinominata `$analyzeBasicSentimentAction` → `$basicSentiment`.
- **Bug reale trovato mentre si scriveva un test per `ContextCompressorAction`** (mai testata prima): `tryOpenAiCompression()` usava `class_exists('OpenAI\OpenAI')` — nome classe inesistente. `openai-php/client` espone la classe di convenienza `\OpenAI` nel namespace globale (Composer `files` autoload). Chiedere l'esistenza di `OpenAI\OpenAI` fa risolvere all'autoloader PSR-4 lo stesso file gia' incluso → `PHP Fatal error: Cannot redeclare class OpenAI`, **non catchable neanche con `catch (\Throwable)`** (verificato). Riprodotto isolatamente fuori da Pest/Laravel con `php -r 'require "vendor/autoload.php"; class_exists("OpenAI\OpenAI");'`. Fix: `use OpenAI;` + `class_exists('OpenAI')`, rimosso anche un `is_object()` diventato ridondante (confermato da PHPStan `function.alreadyNarrowedType` una volta risolto il tipo reale). `ContextCompressorAction` non ha ancora chiamanti in produzione, quindi impatto attuale zero, ma qualunque wiring futuro su testo lungo avrebbe fatto crashare il processo in modo garantito.
- **Test nuovi**: `Modules/AI/tests/Unit/Actions/ContextCompressorActionTest.php` — 3 test reali (passthrough su testo corto, fallback estrattivo che rispetta il limite e i confini di frase, fallback a taglio duro senza confini di frase). Prima: zero test per questa classe.

## Measure

- **PHPStan**: `./vendor/bin/phpstan clear-result-cache && ./vendor/bin/phpstan analyse Modules/AI --memory-limit=-1` → **0 errori / 140 file** (baseline gia' verificata 0 in sessione precedente lo stesso giorno; riconfermata dopo tutti i fix, incluso il nuovo test). Una race innocua di un'altra sessione concorrente su `Modules/Xot` (cache `_components.json` dei componenti Blade in refactor) ha fatto fallire temporaneamente il bootstrap di PHPStan durante la sessione — non e' un problema del modulo AI, si e' risolto da solo.
- **PHPMD**: 0 finding rimasti (`exit 0`).
- **Pest**: `./vendor/bin/pest Modules/AI/tests --no-coverage` → **64 test, 50 passati, 14 falliti, 252 assertion**. I 14 fallimenti sono preesistenti, verificati come non correlati a nessun file toccato in questa sessione (dettaglio completo in `docs/coverage.md`, sezione 2026-09-04). Prima del mio intervento: 61 test, 47 passati, stesso identico set di 14 fallimenti.
- **Coverage numerica**: non misurabile con i tool standard — `Modules/AI/app` non e' incluso in `<source>` di `phpunit.xml` root, e questo file e' condiviso da tutto il monorepo (fuori scope modificarlo per questo task). Dettaglio tentativi in `docs/coverage.md`.
- **phpinsights**: non installato in questo repo (rimosso, incompatibile con Pest 5 — vedi memoria second-brain `pest5-incompatibile-con-phpinsights`), step saltato.

## File toccati

- `app/Actions/ContextCompressorAction.php` — refactor complessita' + fix bug reale `OpenAI\OpenAI` → `OpenAI`.
- `app/Actions/Ds4/ChatDs4Action.php` — refactor complessita' + import mancante.
- `app/Actions/Ds4/GenerateDs4Action.php` — import mancante.
- `app/Actions/Ollama/ChatOllamaAction.php` — import mancante.
- `app/Actions/Ollama/GenerateOllamaAction.php` — import mancante.
- `app/Actions/Predict/GeneratePredictionDraftsAction.php` — refactor complessita'.
- `app/Actions/Predict/GetPredictionDraftFallbackTemplatesAction.php` — rimosso (codice morto), ritirato a `.php.bak`.
- `app/Actions/Sentiment/AnalyzeTransformersSentimentAction.php` — rinomina variabile lunga.
- `tests/Unit/Actions/ContextCompressorActionTest.php` — nuovo.
- `docs/coverage.md`, `docs/queueable-actions.md`, `docs/wiki/concepts/ai-services-support-to-actions.md` — aggiornati.

Dettaglio numeri completi: `Modules/AI/docs/coverage.md`.
