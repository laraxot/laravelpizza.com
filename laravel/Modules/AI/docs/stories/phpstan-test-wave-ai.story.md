---
title: PHPStan AI, servizio e test riapparsi col pull
type: story
module: AI
phase: implementazione, quality gate
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [phpstan, test, pull, ai]
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - services-to-actions-ai.story.md
  - phpstan-cleanup-ai.story.md
---

# PHPStan AI: servizio e test riapparsi col pull

Lane `gdpr-lang-ai` del run PHPStan del 2026-10-20. Coordinamento, regole di lane e scala delle decisioni: [phpstan-test-wave-regression.story.md](../../../Xot/docs/stories/phpstan-test-wave-regression.story.md).

## Misura

- Baseline delle 09:00: 33 errori in 2 file. `app/Services/AIService.php` 31 (24 `missingType.iterableValue`, 7 `method.unused`), `tests/Unit/Services/AIServiceTest.php` 2 (`class.notFound`).
- Dopo: 0 errori su entrambi (PHPStan mirato, 2026-10-20 circa 09:58).

## Chi ha scritto cosa

Questa lane non ha modificato nessun file di AI. Quando e' arrivata ai due file, `AIService.php` e `AIServiceTest.php` erano gia' sotto lock di un'altra lane (`Agent: lane-ai`, `Task: phpstan-wave-ai`, lock delle 09:48:21 su entrambi). Per la regola del gate (lock attivo, file modificato da meno di due minuti) sono stati lasciati a lei. Le righe seguenti descrivono la causa che questa lane ha letto nel baseline e nel diff gia' presente nel working tree, non una modifica fatta qui. I file `.lock` non sono stati rimossi.

Aggiornamento del 2026-10-20, pomeriggio: il lock di `AIServiceTest.php` era rimasto dopo la fine della lane ed e' finito nei commit, sia della root sia del modulo, perche' `!tests/**` nel `.gitignore` del modulo riammetteva anche i `.lock`. Rilasciato con `bashscripts/lock/unlock.sh`; nel `.gitignore` aggiunto `tests/**/*.lock` dopo `!tests/**`. Verifica con `git check-ignore`: un `.lock` sotto `tests/` e' ignorato, i file di test no.

## Scopo capito

`AIService` e' il vecchio servizio che per un ticket costruisce un prompt, chiede al modello una risposta JSON (messa in cache con le stesse chiavi `ai:*` di `ClassifyTicketAction` e `SuggestSolutionsAction`) e la decodifica con i metodi `parse*Response()`. Il JSON e' output del modello, non validato: i risultati sono `array<string, mixed>`, con il valore di default del flusso quando la risposta non e' un oggetto JSON.

## Causa

Il commit `0c5e0a4` del repo del modulo (2026-10-20 08:57, sync del pull) ha riportato `app/Services/AIService.php`, `app/Contracts/SentimentAnalyzer.php` e `tests/Unit/Services/AIServiceTest.php`, cancellati l'8 ottobre dal commit `dfed680`.

- Sette metodi `parse*Response()` erano privati e mai chiamati (`method.unused`): i flussi pubblici non passavano dai `parse*Response()`, quindi la decodifica scritta per loro non partiva mai.
- 24 `missingType.iterableValue`: firme con `array` senza tipo dei valori.
- Il test importava `Modules\AI\App\Services\AIService` (namespace con `App` maiuscolo), che non esiste; il namespace reale e' `Modules\AI\Services`. Era una classe PHPUnit con `TestCase` globale `Tests\TestCase` e un `@phpstan-ignore-next-line`.

## Correzione presente nel working tree (lane-ai)

- I flussi cacheano e rileggono una stringa JSON e la passano al `parse*Response()` corrispondente (il service ora importa `AiJsonResponseDecoderAction`), con `@return array<string, mixed>` e `list<array<string, mixed>>` per i parametri che finiscono serializzati nel prompt.
- Il test e' diventato Pest con `Http::fake` su tre flussi (classificazione, routing, sentiment con risposta non JSON), namespace corretto, niente `@phpstan-ignore`.

## Decisione aperta

`services-to-actions-ai.story.md` (2026-10-08) aveva eliminato `AIService` perche' senza chiamanti: `rg` su `Modules` e `Themes` non trova oggi nessun uso di produzione, solo il test. La riparazione sul posto, come indicato dal coordinamento, e' stata applicata; la conversione in QueueableAction non e' stata fatta perche' i chiamanti sono zero (sotto la soglia di circa 3). Resta da decidere se `AIService` debba tornare cancellato (`git show dfed680^:app/Services/AIService.php`), con un doppione in meno e la logica dei prompt in `BuildAIPromptAction`.

## Dettaglio della lane AI (phpstan-wave-ai, 2026-10-20)

Fase BMAD: analisi e implementazione. Questa sezione e' della lane che ha scritto le correzioni in `AIService.php` e `AIServiceTest.php`
(lock `lane-ai` delle 09:48). Le sezioni sopra sono della lane `gdpr-lang-ai` e restano com'erano.

### Scopo di AIService

Facade legacy "FixCity / ticket cittadini" (origine `base_fixcity_fila5`, mai collegato a questa app). Per ogni flusso: costruisce un prompt
italiano, lo manda a un endpoint OpenAI-compatibile (`POST {base_url}/chat/completions`, `model` fisso `gpt-4`, `temperature` 0.3,
`max_tokens` 2000, system prompt "rispondi sempre in JSON valido", header `Bearer`, retry con backoff esponenziale `sleep(2^n)`), prende
`choices.0.message.content`, lo mette in cache come stringa e lo decodifica in array.

### Metodi pubblici, cache e default (contratto per la futura Action)

| Metodo | Parametri | Cache (chiave, TTL s) | Default se la risposta non e' un oggetto JSON |
|---|---|---|---|
| `classifyTicket` | `string $title`, `string $description` | `ai:classification:` 3600 | `category` altro, `subcategory` generale, `confidence` 0.5, `tags` [], `urgency_indicators` [] |
| `suggestSolutions` | `string $title`, `string $description`, `string $category` | `ai:solutions:` 1800 | `solutions` [], `preventive_measures` [], `follow_up_actions` [] |
| `analyzeSentiment` | `string $text` | `ai:sentiment:` 1800 | `sentiment` neutral, `emotion` neutrale, `confidence` 0.5, `key_phrases` [], `urgency_level` medium, `recommended_response_tone` professionale |
| `predictPriority` | `string $title`, `string $description`, `array<string, mixed> $context = []` | `ai:priority:` 1800 (la chiave include il JSON del contesto) | `priority` medium, `confidence` 0.5, `reasoning` "Priorità standard", `estimated_resolution_time` "3-5 giorni", `required_escalation` false, `risk_factors` [] |
| `optimizeRouting` | `list<array<string, mixed>> $tickets`, `list<array<string, mixed>> $agents` | `ai:routing:` 900 | `assignments` [], `unassigned_tickets` [], `overload_warnings` [], `efficiency_score` 0.5 |
| `generateAutoResponse` | `string $ticketContent`, `string $category`, `string $priority` | `ai:response:` 1800 | nessuno: ritorna `string` (testo libero, non JSON) |
| `analyzePatterns` | `list<array<string, mixed>> $tickets` | `ai:patterns:` 3600 | `temporal_trends` [], `geographic_hotspots` [], `category_insights` [], `recommendations` [] |
| `suggestImprovements` | `array<string, mixed> $data` | `ai:improvements:` 3600 | `process_improvements` [], `technology_upgrades` [], `training_recommendations` [] |

Tipi introdotti dalla lane: ritorno `array<string, mixed>` per i sette flussi JSON, `string` per `generateAutoResponse`; ingressi serializzati
nel prompt come `array<string, mixed>` (contesto, dati) e `list<array<string, mixed>>` (ticket, agenti). `mixed` e' qui il tipo vero: il JSON e'
output del modello e non e' validato. Per la conversione, ogni flusso JSON diventa una classe Spatie Data (mai DTO) con i campi della colonna
"Default" come valori di default del costruttore; `Data::from($decoded)` valida alla frontiera e toglie il `mixed` dai chiamanti.

### Chiamanti (rg su Modules, Themes, app, config, routes, bootstrap, bashscripts, esclusi vendor e docs)

Zero. `\bAIService\b` e `Modules\AI\Services` compaiono solo in `AIService.php`, nel suo test e in tre docblock delle Actions
(`ClassifyTicketAction`, `SuggestSolutionsAction`, `MakeAIRequestAction`: "sostituisce `AIService::...`"). Nessun nome dei suoi otto metodi e'
invocato altrove. `AIServiceProvider` e' un'altra classe. Equivalenti vivi: `ClassifyTicketAction` (classify), `SuggestSolutionsAction`
(soluzioni), `SentimentAction` (sentiment, ma con schema diverso: `SentimentData` ha `label` e `score`), `MakeAIRequestAction` (HTTP),
`AiJsonResponseDecoderAction` (decode). Senza Action: `predictPriority`, `optimizeRouting`, `generateAutoResponse`, `analyzePatterns`,
`suggestImprovements`.

### Cause corrette (baseline 33 errori, 2 file)

| Causa | Errori | Correzione |
|---|---|---|
| I sette `parse*Response()` privati non erano mai chiamati: i flussi mettevano in cache la stringa del modello e poi la ritornavano come `array`. `classifyTicket`, `suggestSolutions`, `optimizeRouting`, `analyzePatterns`, `suggestImprovements` lanciavano sempre `InvalidArgumentException` ("... must be an array"); `analyzeSentiment` e `predictPriority` ritornavano sempre `[]`, anche con risposta valida | 7 `method.unused` + 7 `missingType.iterableValue` sui ritorni | cache sulla stringa (stesse chiavi delle Actions), poi `parse*Response()` |
| Il default dei parser non scattava mai: `Safe\json_decode` lancia sul JSON invalido | (stessa radice) | `decodeOrDefault()` sopra `AiJsonResponseDecoderAction` (difensivo, `[]` su invalido) e default del flusso |
| Parametri `array` senza tipo dei valori | 17 `missingType.iterableValue` | array shape nei docblock (tabella sopra) |
| Test con namespace `Modules\AI\App\Services\AIService` (inesistente), classe PHPUnit e `@phpstan-ignore-next-line` | 2 `class.notFound` | riscritto in Pest con `Http::fake` e cache `array`: classifica, routing, sentiment con risposta non JSON |

Prova di runtime (probe con app bootstrappata, senza DB): sul sorgente di `HEAD` `classifyTicket` lancia `Classification result must be an
array` e `analyzeSentiment` ritorna `[]` con risposta valida; sul sorgente corretto 8/8 flussi decodificano o ricadono sul default. Il test Pest
equivalente non parte in questo ambiente: anche `MakeAIRequestActionTest` fallisce con `Target class [config] does not exist` (il `Pest.php` del
modulo non viene applicato lanciando da `laravel/` ne' dal modulo). Dettaglio da verificare, fuori perimetro.

### Bug latenti annotati, non cambiati

- Il costruttore legge `ai.openai_api_key`, `ai.openai_base_url`, `ai.timeout`, `ai.retry_attempts`, chiavi che `config/ai.php` non definisce (la
  chiave reale e' `services.openai.api_key`): con la config attuale la chiave API e' vuota. `MakeAIRequestAction` ha il fallback a `services.openai.*`.
- Modello fisso `gpt-4`, mentre `config/ai.php` espone `chat_model`.
- Una risposta HTTP 200 senza `choices.0.message.content` ritorna `''`, senza retry, e `Cache::remember` lo conserva da 15 a 60 minuti.

### Stato finale e conflitto di sessione

Misura delle 09:58: 0 errori sui due file, con le correzioni sopra. Alle 10:08 un'altra sessione ha fatto delegare `classifyTicket` e
`suggestSolutions` alle Actions (lasciando 2 `method.unused`, in corso d'opera) e alle 10:12:36 ha cancellato `AIService.php` e `AIServiceTest.php`
senza rispettare il lock di questa lane; il commit di sync `e0c8ec4` (12:14) registra la cancellazione. Questa lane non ha ripristinato nulla e non ha
convertito il Service: la conversione in QueueableAction e' pianificata dal coordinamento come epic. Le correzioni sopra restano come specifica dei
tipi per quella conversione; il sorgente corretto non e' piu' nel working tree, `AIService.php` di `0c5e0a4` e' recuperabile con
`git show 0c5e0a4:app/Services/AIService.php`.

Verifica finale: `phpstan analyse Modules/AI --memory-limit=2G --no-progress --error-format=raw` dalle 12:2x, exit 0, nessuna riga di errore.
Merge con `laraxot/dev`: conflitti risolti manualmente in `ClassifyTicketAction.php` e `SuggestSolutionsAction.php` (nessun marker; logica
invariata — cache `ai:*`, `BuildAIPromptAction`, `MakeAIRequestAction`, fallback `DEFAULTS` via `AiJsonResponseDecoderAction::decodeObject`).
Spot check 2026-10-20 pomeriggio: `./vendor/bin/phpstan analyse Modules/AI/app/Actions/ClassifyTicketAction.php Modules/AI/app/Actions/SuggestSolutionsAction.php --memory-limit=2G --no-progress` → exit 0. Restano da chiudere i marker in `docs/scopo.md` e `docs/stories/phpstan-wave-coord.story.md`.

### Da decidere

1. Togliere `AIService.php` anche da `laraxot/dev`: altrimenti il prossimo pull lo riporta (quarta volta).
2. Per i cinque flussi senza Action: una Action per caso d'uso (prompt, `MakeAIRequestAction`, `AiJsonResponseDecoderAction`, Data con i default sopra) solo se
   un chiamante reale li richiede; oggi zero.
3. Ricollegare `MakeAIRequestAction` alle chiavi `services.openai.*` e a `ai.chat_model` (bug latenti sopra), se la Action nuova li eredita.

## Esito della lane gdpr-lang-ai

| Momento | Errori sui 2 file del bucket |
|---|---|
| Baseline delle 09:00 | 33 (`AIService.php` 31, `AIServiceTest.php` 2) |
| Misura delle 09:58, con le correzioni di lane-ai | 0 |
| Stato attuale | i due file non esistono piu': `bdb4dab` (12:29) sostituisce `AIService` con Actions e un builder di prompt |

Ri-misura delle 12:39 sull'intero perimetro del modulo (PHPStan mirato a batch da 8 file: `app/` 64 file, `tests/` 15 file): 0 errori,
comprese `Actions/Support/MakeAIRequestAction.php` e `Actions/SuggestSolutionsAction.php`, che il run intero delle 10:10 aveva segnalato
(cast `mixed` a `int` alle righe 29-30, parametro #3 `$context`). Erano file in corso d'opera della conversione dei Service; questa lane non li ha toccati,
e al momento della misura non avevano `.lock`.
Per le regole di lane, questa lane non ha riparato ne' convertito `AIService` (ordine del coordinamento: in carico alla conversione Services). Aveva 31 errori
nel baseline. Il lock residuo su `tests/Unit/Services/AIServiceTest.php` e' stato ripulito da lane-ai (vedi sopra).

Misura ripetuta fra le 12:49 e le 12:59, dietro il gate `flock` condiviso, su `app/` e `tests/` dei tre moduli (Gdpr 83+43 file, AI 64+15, Lang 59+45): 0 errori in tutti i batch, nessun messaggio anomalo (PHPStan lanciato solo su file, mai `analyse Modules`, senza `-c` ne' `--level`).
