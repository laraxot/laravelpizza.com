---
title: "AI: un solo punto di config e Action di richiesta senza difetti latenti"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: AI
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on:
  - ../../../Xot/docs/stories/test-database-guard.story.md
  - ./services-to-actions-ai.story.md
  - ./phpstan-test-wave-ai.story.md
tags: [bmad, ai, config, openai, queueable-action, cache, tests, filament-blueprint, w1, w2, w3]
---

# AI: un solo punto di config e Action di richiesta senza difetti latenti

Fase BMAD: Create Story (wave W1 dell'epic, lane AI, riga n. 4). Solo documentazione: nessun PHP toccato per scriverla.

## Richiesta

Ordine permanente dell'utente (2026-10-20): "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint". Qui: capire perche' le Action AI non trovano la chiave OpenAI e correggere la causa, non il sintomo. Epic: [epic-code-quality-ratchet](../../../Xot/docs/bmad/epic-code-quality-ratchet.md). La cancellazione di `AIService` e la parita' con le Action successore sono in [services-to-actions-ai](./services-to-actions-ai.story.md) (nota di verifica del 2026-10-20): questa story tiene solo il lavoro rimasto.

## Scopo

- `Actions/Support/MakeAIRequestAction.php` e' il client HTTP di chat completions con retry e backoff esponenziale, ereditato da `AIService::makeAIRequest()`. Serve a `ClassifyTicketAction` (categoria del ticket di un cittadino) e `SuggestSolutionsAction` (soluzioni proposte). Se la chiave e' vuota ogni chiamata da' 401 e dopo 3 tentativi lancia.
- `config/ai.php` doveva essere l'unico punto dove si leggono modello, temperatura, token e timeout; le Action leggono `ai.*`.
- `GeneratePredictionsAction` e `GeneratePredictionDraftsAction` generano bozze di previsione; la seconda ha un ripiego su modelli fissi se manca la chiave.

## Stato misurato

Misura del 2026-10-20 tra le 13:35 e le 14:05 UTC. Cifre volatili.

- Tre sorgenti per la stessa chiave. `MakeAIRequestAction.php:27-30` legge `ai.openai_api_key`, `ai.openai_base_url`, `ai.timeout`, `ai.retry_attempts`: assenti da `AI/config/ai.php` (`rg -n 'openai_api_key|retry_attempts' laravel/Modules/AI/config` stampa 0; controprova: `rg -c 'openai' laravel/Modules/AI/config/ai.php` stampa 11). `GeneratePredictionsAction.php:167` legge `services.openai.api_key`: `rg -n -i 'openai' laravel/config/services.php` stampa 0 (controprova: `rg -n "'ollama'|'netfun'" laravel/config/services.php` stampa 2 righe). Solo `openai.api_key` si risolve (`laravel/config/openai.php:17`, `env('OPENAI_API_KEY')`) ed e' letta solo da `Predict/GeneratePredictionDraftsAction.php:43`.
- Causa piu' profonda, da leggere nel codice: `Xot/app/Providers/XotBaseServiceProvider.php:199` registra ogni file di config di modulo come `<modulo>.<file>`, quindi `AI/config/ai.php` vive in `ai.ai.*` e `config.php` in `ai.config.*`. `AIServiceProvider` non ridefinisce `registerConfig` (`rg -n 'registerConfig' laravel/Modules/AI/app/Providers` stampa 0). Quindi anche `config('ai.model')`, `ai.temperature`, `ai.max_tokens` (`GeneratePredictionsAction.php:170-176`) e `ai.chat_model`, `ai.temperature` (`GeneratePredictionDraftsAction.php:179,186`) non leggono `ai.php` e cadono sui default inline. Non riprodotto a runtime in questa sessione; stesso meccanismo gia' osservato in Lang (`Lang/docs/stories/docs-lang-studio.story.md`: `config('lang.save_missing_translations')` e' `NULL` con tinker). I test mascherano il difetto: `AI/tests/TestCase.php` imposta `ai.model`, `ai.temperature`, `ai.max_tokens` a mano nel `setUp`.
- Regressione rispetto al test: `tests/Unit/Actions/MakeAIRequestActionTest.php:17-45` (commit `0c5e0a4`, 08:57) pretende `ai.openai_api_key` che vince su `services.openai.api_key`. La versione precedente dell'Action aveva quella catena; il commit `e0c8ec4` (12:14) l'ha riscritta e ha tolto il ripiego (`git -C laravel/Modules/AI diff e0c8ec4^ e0c8ec4 -- app/Actions/Support/MakeAIRequestAction.php`).
- Modello fisso: `MakeAIRequestAction.php:49` `'gpt-4'`, `:60-61` temperatura 0.3 e 2000 token, mentre `config/ai.php` dichiara `gpt-3.5-turbo`.
- Risposta vuota in cache: `MakeAIRequestAction.php:78` ritorna `''` se la risposta 200 non ha `choices[0].message.content`; `ClassifyTicketAction.php:56` e `SuggestSolutionsAction.php:54` la mettono in `Cache::remember` per 3600 s, cioe' un'ora di categoria `altro` (`DEFAULTS`).
- Zero consumatori: `rg -n 'ClassifyTicketAction|SuggestSolutionsAction|GeneratePredictionsAction|GeneratePredictionDraftsAction' laravel/Modules/*/app laravel/app laravel/routes -g '*.php'` trova solo le classi stesse e docblock. Solo `SentimentAction` ha un consumatore (`Filament/Pages/Completion.php:16`). Il difetto e' latente, non in produzione oggi.
- `@var` inline contro la regola: `GeneratePredictionDraftsAction.php:42,127,146` e `GeneratePredictionsAction.php:226`.
- `Actions/Prompt/AIPromptTemplates.php:19,47`: due metodi statici di sola stringa, un solo consumatore (`BuildAIPromptAction.php:37,41`); non e' un caso d'uso.
- Test: `tests/Unit/Actions/GeneratePredictionsActionTest.pest.php` (162 righe, 10 test) non gira mai: il suffisso non e' `Test.php` (`laravel/phpunit.xml:11-12`). Pest non parte nel modulo: un run di questa mattina (scratchpad `ai-pest-5.out`, 09:57) registra `MakeAIRequestActionTest` 4 falliti, 0 asserzioni, `Target class [config] does not exist`, lo stesso sintomo della story Notify del 2026-09-15. Non riprodotto ora (Pest vietato).
- Filament: `Filament/AdminPanelProvider.php:11` estende `PanelProvider` ed e' un doppione non registrato di `Providers/Filament/AdminPanelProvider.php:9` (`rg -n 'AI.{1,2}Filament.{1,2}AdminPanelProvider' laravel --glob '!**/vendor/**' -g '*.php'` stampa 0). 14 stringhe primarie (+2 `body`) in `Pages/FineTuning.php` (59-138) e `Pages/Completion.php:99,104`. Il blueprint (`AI/docs/bmad/filament-blueprint.md`) elenca solo `AiActionProposalResource`.

## Lavoro

1. Config, un solo percorso: chiave e base URL da `config('openai.*')` (gia' presente, `OPENAI_API_KEY`); timeout, retry, modelli in `AI/config/ai.php` letti come `ai.ai.*` (o la decisione 1). Aggiornare le 3 Action e il `TestCase`. Rischio basso (zero consumatori), medio per i test.
2. `MakeAIRequestAction.php:49,60-61`: leggere modello, temperatura e token da config con default espliciti, oppure dichiarare in un commento perche' il ticket vuole `gpt-4` a 0.3. Decisione 2.
3. `MakeAIRequestAction.php:78`: contenuto assente deve lanciare (o ritornare `null`) e `ClassifyTicketAction.php:56`, `SuggestSolutionsAction.php:54` non devono mettere `''` in cache (calcolare fuori da `remember`, `put` solo se non vuoto). Rischio basso.
4. Allineare `MakeAIRequestActionTest` alla catena decisa al punto 1 (oggi pretende il ripiego su `services.openai.*` che l'Action non ha piu').
5. Decidere gli ingressi: collegare `ClassifyTicketAction` e `SuggestSolutionsAction` al flusso ticket o ritirarle (regola 25) insieme a `GeneratePredictionsAction` e `GeneratePredictionDraftsAction`. Decisione 3: senza chiamanti il punto 1 e' igiene, non correzione.
6. `AIPromptTemplates`: assorbirlo in `BuildAIPromptAction` come `private const` (stesso esito gia' scelto in `services-to-actions-ai`) o spostarlo fuori da `Actions/`. Nessun `execute()` finto. Togliere i 4 `@var` del punto sopra.
7. Test: leggere `GeneratePredictionsActionTest.pest.php`, portarne il corpo in `GeneratePredictionsActionTest.php` (o stub `->skip` se manca il SUT, scala di `bashscripts/docs/prompts/10-test.md`), poi rimuovere il file e il `.php.bak` in `Actions/Predict`.
8. Filament: cancellare `Filament/AdminPanelProvider.php`; 14 stringhe verso `ai/lang/<locale>/`; aggiungere al blueprint le pagine `Completion` e `FineTuning` (il `docs/` e' di un'altra sessione: segnalare).

## Acceptance criteria

- [ ] `rg -n "config\('(ai|services\.openai|openai)\.[a-z_]+" laravel/Modules/AI/app` mostra una sola famiglia di chiavi per la chiave API (`openai.api_key`) e nessuna chiave `ai.*` assente dal config.
- [ ] Controllo a runtime (non eseguito qui): `php artisan tinker --execute="var_dump(config('ai.model'), config('ai.ai.model'));"` conferma quale dei due nomi e' valorizzato; il codice legge solo quello.
- [ ] `rg -n "return ''" laravel/Modules/AI/app/Actions/Support/MakeAIRequestAction.php` stampa 0 e nessuna `Cache::remember` salva una stringa vuota.
- [ ] `rg -n '@var' laravel/Modules/AI/app/Actions` stampa 0 righe nei file toccati.
- [ ] `/usr/bin/find laravel/Modules/AI/tests -name '*.pest.php'` stampa 0 file; `find laravel/Modules/AI/app -name '*.bak'` stampa 0.
- [ ] `rg -nP '^class \w+ extends (PanelProvider)\b' laravel/Modules/AI/app` stampa 0.
- [ ] `phpstan analyse` mirato sui file toccati: `[OK] No errors`, nessun ignore, nessun `mixed` nuovo.

## Verifica

Da `laravel/`, solo lettura. Ogni zero va controprovato con il comando gemello (vedi "Stato misurato"). Prova storica dell'Action: `git -C Modules/AI show e0c8ec4^:app/Actions/Support/MakeAIRequestAction.php | rg -n "configString|services\.openai"`.

## Vincoli

Nessun Pest/PHPUnit finche' la guardia DB (`Xot/tests/Support/TestDatabaseGuard.php`) non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta. PHPStan solo mirato, in coda `flock` di `bashscripts/docs/prompts/11-phpstan.md`; un solo run completo, a swarm fermo e a RAM libera. Un solo agente per modulo che edita PHP (oggi `AI/app/Actions/AiJsonResponseDecoderAction.php` e `PredictionDraftFallbackTemplatesAction.php` sono modificati e non committati da un'altra sessione). `laravel/phpstan.neon` immutabile. Forward-only. Pest resta Pest. Niente nuovi `*Service`. Niente `mixed`, `@var` o ignore di comodo. Nessuna chiamata reale a OpenAI da test: `Http::fake`.

## Decisioni aperte

1. Nome della chiave: accettare `ai.ai.*` o cambiare `registerConfig` di Xot (tocca tutti i moduli, decide l'utente)?
2. Il ticket deve restare su `gpt-4` a temperatura 0.3?
3. Il flusso ticket AI serve davvero, o si ritirano le Action senza chiamanti?

## Come ripartire

1. Leggere `XotBaseServiceProvider.php:187-203` e `AI/tests/TestCase.php`, poi chiedere all'utente la decisione 1; senza risposta, applicare il punto 3 (cache vuota), che non dipende dal nome.
2. Scrivere (senza eseguire) il test che verifica che una risposta vuota non finisca in cache, poi il fix con il gate lock+mtime.
3. Rilanciare i comandi di "Stato misurato", annotare l'output in coda a questa story e aggiornare second brain (memoria e wiki del modulo).
