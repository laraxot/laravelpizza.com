---
title: "coverage"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "coverage"
issues: []
discussions: []
status: draft
---

# AI module — coverage / quality log

## 2026-09-04 — mixed type reduction

**Scope**: reduce use of the PHP `mixed` type where a more specific type is actually knowable, per project convention ("cerchiamo di non usare mixed, quando lo troviamo cerchiamo di sostituirlo con qualcosa di adeguato"). Best-effort, not 100% coverage.

**Found**: 74 `\bmixed\b` occurrences across 33 `.php` files (one occurrence, in `tests/Unit/Actions/SentimentActionTest.php`, was a false positive — the word "mixed" inside test fixture prose "I have mixed feelings", not a type usage — so 73 real occurrences across 32 files).

**Changed**: 6 occurrences across 6 files, all docblock-only (no native `mixed` type-hints were touched — see "left as mixed" below for why the native ones stay). Replaced `array<string, mixed>` / `array<int, array<string, mixed>>` with a concrete shape once the returned/consumed structure was evidently stable:

- `Modules/AI/app/Contracts/SentimentAnalyzer.php` — `analyze()` return: `array{label: string, score: int|float, warning: string}`.
- `Modules/AI/app/Actions/Sentiment/BasicSentimentAnalyzer.php` — same shape (implements the contract).
- `Modules/AI/app/Actions/Sentiment/TransformersSentimentAnalyzer.php` — same shape.
- `Modules/AI/app/Actions/Sentiment/AnalyzeBasicSentimentAction.php` — same shape.
- `Modules/AI/app/Actions/Sentiment/AnalyzeTransformersSentimentAction.php` — same shape.
- `Modules/AI/app/Actions/Prediction/GetPredictionFallbackTemplatesAction.php` — `execute()` return tightened from `array<int, array<string, mixed>>` to `array<int, array{category: string, title: string, subtitle: string, description: string, analysis: string, tags: list<string>, options: list<string>}>` (hardcoded literal templates, shape evident and stable; this also benefits the one consumer, `GeneratePredictionDraftsAction::fallbackDrafts()`).

**Left as `mixed`, with reason** (~67 occurrences, ~26 files):

- `app/Actions/Cast/{CastScalarToStringAction,CastScalarToNullableStringAction,CastScalarToStringListAction,ScalarCasterAction}.php` (10 occurrences) — these are the module's own generic scalar-casting utilities; the whole point of `execute(mixed $value, ...)` is to accept any caller-provided value and normalize it. Native `mixed` here is intentional and correct, not a typing gap.
- `app/Models/{AiMessage,AiThread,AiActionProposal,AiToolLog}.php` (6 occurrences) — `@property array<string, mixed>|null` on JSON columns (`payload`, `meta`, `arguments`, `response`). Genuinely polymorphic JSON storage; no evidence of a stable schema to narrow to.
- `database/factories/{AiActionProposalFactory,AiMessageFactory,AiThreadFactory,AiToolLogFactory}.php` (4 occurrences) — standard Laravel `definition(): array<string, mixed>` convention; the returned array legitimately mixes string/int/bool/Carbon column values.
- `app/Actions/{GeneratePredictionsAction,GeneratePredictionDraftsAction,Prompt/BuildAIPromptAction,Support/MakeAIRequestAction,Support/RequestChatCompletionAction,AiJsonResponseDecoderAction,ClassifyTicketAction,SuggestSolutionsAction,ContextCompressorAction}.php`, `app/Datas/{PredictionData,OpenAiPredictionMapper}.php`, `app/Contracts/AiActionHandlerContract.php`, `app/Filament/Pages/{Completion,FineTuning}.php`, `tests/Support/OpenAiHttpFake.php`, `app/Actions/CreateAiActionProposalAction.php` — externally-sourced JSON (LLM responses, HTTP `Http::json()`/`json_decode()` results, Filament form state, caller-supplied `array<string, mixed> $options/$params/$context/$data`, HTTP request bodies). Values are read defensively via `is_string`/`is_scalar`/`is_numeric`/`is_array` checks before use; the shape is caller-defined and not stable enough to narrow honestly. Narrowing these would either be dishonest (an `@var` override not backed by the runtime) or would just move the `mixed` one level down (e.g. `array<array-key, mixed>`), so left as-is per "genuinely polymorphic JSON/config payloads" guidance.

**PHPStan**: `./vendor/bin/phpstan analyse Modules/AI --no-progress --error-format=table` → **0 errors before, 0 errors after** (baseline measured before any edit).

**PHPMD**: `./tools/phpmd.sh Modules/AI text ../docs/phpmd.ruleset.xml` ran cleanly (no crash). Findings are pre-existing debt unrelated to this diff (`CyclomaticComplexity` in `ContextCompressorAction`/`ChatDs4Action`/`GeneratePredictionDraftsAction`, `MissingImport` in `Ds4`/`Ollama` actions, `LongClassName`/`LongVariable`) — none of the touched files/lines are flagged except a pre-existing `LongVariable` on `AnalyzeTransformersSentimentAction.php:17` (constructor property name, untouched by this diff).

**Pest**: `Modules/AI/phpunit.xml` does not exist in this module, so the module-scoped Pest invocation (`./vendor/bin/pest Modules/AI/tests -c Modules/AI/phpunit.xml --no-coverage`) is not runnable as specified. Not attempted further (see task budget/instructions — one attempt only).

**Story**: `Modules/AI/docs/stories/ai-mixed-type-reduction.story.md`.

## 2026-09-04 — quality-gate closure (PHPMD + Pest + coverage)

**Scope**: chiudere il resto del quality gate per il modulo (PHPStan gia' verificato 0 errori in sessione precedente lo stesso giorno): PHPMD, Pest, coverage, git.

**PHPStan baseline**: `./vendor/bin/phpstan clear-result-cache && ./vendor/bin/phpstan analyse Modules/AI --memory-limit=-1` → **0 errori, 140 file** (era 139 prima dell'aggiunta del test nuovo; 140 dopo). Durante la sessione un run e' fallito con `Application bootstrap failed` per una race innocua di un'altra sessione concorrente su `Modules/Xot/app/Actions/File/GetComponentsAction.php` / `_components.json` (schema della cache dei componenti Blade in fase di refactor da un altro agente) — non e' un problema del modulo AI, risolto da solo pochi secondi dopo quando l'altra sessione ha completato il suo commit locale; riconfermato 0 errori dopo.

**PHPMD**: `./tools/phpmd.sh Modules/AI/app text ../docs/phpmd.ruleset.xml` — **9 finding trovati, 9 fixati, 0 rimasti** (`exit 0`):

- `ContextCompressorAction::extractCompressedText()` — CyclomaticComplexity 13/10: estratto in 3 metodi privati (`extractOutputItems`, `extractTextFromOutputItem`, `extractTextFromContentItem`), ciascuno complessita' 3-4.
- `Ds4/ChatDs4Action::execute()` — CyclomaticComplexity 10/10: estratto `buildPayload()` e `buildResult()`.
- `Ds4/ChatDs4Action.php:108`, `Ds4/GenerateDs4Action.php:95`, `Ollama/ChatOllamaAction.php:103`, `Ollama/GenerateOllamaAction.php:83` — MissingImport (`throw new \RuntimeException`): aggiunto `use RuntimeException;` in tutti e 4, tolto il backslash iniziale.
- `Predict/GeneratePredictionDraftsAction::parseDrafts()` — CyclomaticComplexity 10/10: estratto `parseDraftItem()` (parsing di un singolo item, ritorna `?array`).
- `Predict/GetPredictionDraftFallbackTemplatesAction` — LongClassName (41 caratteri, soglia 40): la classe era **codice morto** (0 chiamanti reali in tutto il monorepo, verificato con grep ricorsivo; menzionata solo in due doc che descrivevano un wiring mai avvenuto — `GeneratePredictionDraftsAction::fallbackDrafts()` usa in realta' `Actions/Prediction/GetPredictionFallbackTemplatesAction`, nome e namespace diversi). Ritirata a `.php.bak` (stesso pattern gia' in uso nel modulo per `PredictionDraftFallbackTemplates.php.bak`, `*.bak` e' in `.gitignore`). Doc aggiornate: `docs/wiki/concepts/ai-services-support-to-actions.md`, `docs/queueable-actions.md`.
- `Sentiment/AnalyzeTransformersSentimentAction.php:17` — LongVariable (`$analyzeBasicSentimentAction`, 28 caratteri, soglia 20): rinominata la proprieta' costruttore-promossa in `$basicSentiment` (14 caratteri), unico chiamante nello stesso file aggiornato.

**Bug reale trovato e fixato** (non un finding PHPMD/PHPStan, scoperto scrivendo un test per `ContextCompressorAction`, mai coperta da test prima d'ora): `tryOpenAiCompression()` faceva `use OpenAI\OpenAI;` e `class_exists('OpenAI\OpenAI')` — nome di classe sbagliato. Il pacchetto `openai-php/client` espone la classe di convenienza `OpenAI::client()` nel **namespace globale** (non `OpenAI\OpenAI`), caricata eagerly via Composer `files` autoload. Chiedere `class_exists('OpenAI\OpenAI')` fa si' che l'autoloader PSR-4 risolva `OpenAI\` + `OpenAI` allo stesso file gia' incluso, causando `PHP Fatal error: Cannot redeclare class OpenAI` — **non catchable** (verificato: nemmeno `catch (\Throwable)` lo intercetta, il processo PHP muore). Riprodotto isolatamente con `php -r 'require "vendor/autoload.php"; class_exists("OpenAI\OpenAI");'`, quindi confermato indipendente da Pest/Laravel. `ContextCompressorAction` non ha chiamanti in produzione al momento (altro codice morto/non ancora cablato), quindi il raggio d'impatto attuale e' zero, ma qualunque futuro utilizzo di `compress()` su testo piu' lungo di `targetChars` avrebbe fatto crashare il processo in modo garantito e non recuperabile. Fix: `use OpenAI;` + `class_exists('OpenAI')`; rimosso anche il conseguente `is_object($client)` ridondante (PHPStan lo segnalava `function.alreadyNarrowedType` una volta risolto il tipo reale `OpenAI\Client`).

**Pest**: `Modules/AI/phpunit.xml` non esiste — eseguito `./vendor/bin/pest Modules/AI/tests --no-coverage` (root `phpunit.xml`). Risultato: **64 test, 50 passati, 14 falliti, 252 assertion** (prima del mio intervento: 61 test, 47 passati, 14 falliti — stesso identico set di 14 fallimenti, verificato per nome). I 14 fallimenti sono **preesistenti e non correlati** ai file toccati in questa sessione (nessuno dei 14 e' in un file che ho modificato; verificato isolando singoli file e con grep incrociato classi-sotto-test):
  - `UserIdColumnsAcceptUuidTest` — `RuntimeException: A facade root has not been set.` (bootstrap Feature test).
  - `CompletionActionTest` (9 test) — `\OpenAI\Responses\Completions\CreateResponseChoice` e' `final`, Mockery non puo' crearne un mock parziale in questa versione del SDK/Mockery.
  - `QueueableActionContractTest` — `Modules\AI\Actions\Prompt\AIPromptTemplates` non usa il trait `QueueableAction` (file mai toccato in questa sessione).
  - `SentimentActionTest` (2 su 25) — bug di logica preesistenti in `Modules\AI\Actions\SentimentAction` (score `0.0` vs `0` atteso, label `POSITIVE` vs `NEGATIVE` atteso su un caso di negazione), classe diversa da `Sentiment\AnalyzeTransformersSentimentAction` toccata in questa sessione.
  - `AiActionProposalTest` — `BindingResolutionException` su `Spatie\EventSourcing\StoredEvents\EventSubscriber` (config event sourcing nell'ambiente di test).

**Coverage numerico**: non misurabile con i tool standard di questo repo. `Modules/AI/app` **non e'** nell'elenco `<source><include>` di `phpunit.xml` root (assente sia da li' sia dal classmap coverage-filter tentato via CLI). Tentativi: `XDEBUG_MODE=coverage` via env non applicato dal binario Xdebug installato (resta `xdebug.mode=develop` anche con env esportata — verificato con `ini_get`), `php -d xdebug.mode=coverage` applica il driver correttamente (verificato) ma senza `Modules/AI/app` in `<source>` il report resta vuoto anche con `--coverage-filter=Modules/AI/app --coverage-text`. Non ho modificato `phpunit.xml` (file condiviso da tutto il monorepo, fuori scope per questo task) ne' forzato altri workaround. Coverage **qualitativa** invece migliorata in modo verificabile: rimossi 34 righe di codice morto (file `.bak`), 3 nuovi test reali per `ContextCompressorAction` (prima **zero** test, ora 3, tutti passano, copertura del path `compress()` corto/passthrough + fallback estrattivo con troncamento a limite di frase + fallback a taglio duro), tutti i metodi privati estratti durante il refactor PHPMD restano esercitati indirettamente dai test esistenti che gia' passavano (`GeneratePredictionDraftsActionTest`, `PredictionDraftFallbackTemplatesActionTest`) senza nessuna regressione.

**File nuovi/modificati**: vedi `git log`/`git status` del modulo per l'elenco completo; riassunto in `docs/stories/ai-quality-gate.story.md`.
