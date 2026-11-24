---
title: Base agnostica per agenti neuron-ai con AG-UI
status: done
date: 2026-11-19
epic: integrazione laravelday-2026 (Passaparola epic 2)
---

# Story: base agnostica per agenti neuron-ai con AG-UI

## Contesto

Passaparola integra la demo datomatic/laravelday-2026 (issue #11 di base_passaparola_fila5).
L'assistente operatore (story 2.3 di Passaparola) è un agente neuron-ai che usa gli stessi tool del
server MCP. Il modulo AI è condiviso fra i progetti: qui va solo la parte agnostica.

## Criteri di accettazione

- [x] `neuron-core/neuron-ai ^4.1` e `laravel/mcp ^1.1` nelle dipendenze del modulo.
- [x] `XotBaseAgent`: fornitore dalla cascata dell'assistente, memoria e persistenza nel database.
- [x] `ResolveAgentProviderAction`: Groq, poi OpenRouter; errore chiaro senza chiavi.
- [x] `StreamAgentRunAction`: RunAgentInput validato, thread legato all'utente, resume, SSE.
- [x] `McpToolAdapter`: tool MCP riusati come tool dell'agente, errori come risultato del tool.
- [x] Tabelle `ai_agent_messages` e `ai_agent_runs` con i modelli.
<<<<<<< HEAD
- [x] Documentazione in `docs/AGENTS.md`, test in `tests/Unit/Agent`.
=======
- [x] Documentazione in `docs/agents.md`, test in `tests/Unit/Agent`.
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))

## Note

- Composer non raggiungibile nell'ambiente: test eseguibili nel progetto ospite (issue #7).
<<<<<<< HEAD

## Aggiornamento: PHPStan a zero e agenti di nuovo funzionanti

Cosa non andava, e perché:

- **Dipendenze e binding persi.** I commit di sync `.` del modulo (f4c9ab1, 3a87af7) hanno risolto i
  conflitti togliendo sia i marker sia il lato `laraxot/dev`. Sono spariti `neuron-core/neuron-ai` e
  `laravel/mcp` da `composer.json` (rimessi dall'orchestratore) e i binding `MessageStoreInterface` e
  `PersistenceInterface` da `AIServiceProvider`. Senza binding `XotBaseAgent` non si costruisce:
  falliva ogni test di `StreamAgentRunActionTest`. Binding ripristinati.
- **Strict mode MySQL.** `EloquentPersistence` di neuron 4.1 esige lo strict mode sulla sessione, ma
  la connessione `mysql` del tenant ha `strict => false`, sia in produzione sia nel runner dei test.
  Ogni run in pausa sarebbe fallito con `PersistenceException`. Nuova
  `Neuron\Persistence\StrictModeEloquentPersistence`: accende `STRICT_TRANS_TABLES` solo durante le
  scritture del run e poi rimette la modalità di prima. La garanzia di neuron resta valida.
- **PHPStan (28 errori → 0).** `Safe\json_encode`/`Safe\json_decode` in `BuildA2uiSurfaceAction` e
  `RenderSurfaceTool`. L'errore di parsing ora arriva da `Safe\Exceptions\JsonException`, non più da
  `json_last_error_msg()`. Il tipo del componente è letto senza cast da `mixed`. Nei test: `data_get`
  al posto di offset su `mixed`, tipi di ritorno degli helper, `providerBaseUri()` che accetta
  `AIProviderInterface`.
- `tests/Unit/Models/AiActionProposalTest.php` non aveva `uses(TestCase::class)`, quindi girava
  senza applicazione.

Aperto: `QueueableActionContractTest` fallisce su `Actions\Sentiment\BasicSentimentAnalyzer`. È
un'implementazione di `Contracts\SentimentAnalyzer` spostata in `app/Actions` dal sync f4c9ab1, non
un'Action: va decisa la collocazione. Il sync 3a87af7 ha perso anche altro contenuto `laraxot/dev`
(provider `Local` di `AiProviderEnum`, prompt di Vision, test di Vision, docs MCP): va fatto un
recupero a parte.

Recupero fatto: i 48 file toccati dal sync 3a87af7 (`.gitignore`, `module.json`, `vite.config.js`,
Vision con `systemPrompt`/`jsonMode`, modelli, `docs/mcp/*`, test di Assistant e Vision) e
`testbench.yaml` (cancellato dal sync 5b0bd7c) sono tornati alla versione di f079210, l'ultimo commit
buono prima dei sync. In ogni file f079210 era la versione più recente. Restano diversi da f079210
solo il binding strict mode in `AIServiceProvider`, il guard `runningInConsole` di
`StreamAgentRunAction` (6d2b8c9) e le correzioni PHPStan di questa story. `BasicSentimentAnalyzer`
c'era già in f079210: non è una perdita del sync.
=======
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))
