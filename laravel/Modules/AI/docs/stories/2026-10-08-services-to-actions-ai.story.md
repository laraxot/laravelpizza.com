---
title: "[STORY] AI: Services eliminati, const ripristinate a enum"
type: story
module: AI
status: done
priority: high
created: 2026-10-08
updated: 2026-10-08
tags: [bmad, services, queueable-actions, enum, const, dead-code, merge-regression]
qmd: "ai services eliminati queueable actions enum const merge laraxot dev regressione AIService BuildAIPromptAction"
related:
  - ./2026-10-06-phpstan-cleanup-ai.story.md
  - ../wiki/concepts/ai-services-support-to-actions.md
  - ../bmad/domain-status-enum.md
  - ../../../../../bmad-output/epic-code-standards-services-mixed-const.md
---

# [STORY] AI: Services eliminati, const ripristinate a enum

## Richiesta

Epic standard di codice (2026-10-08): niente `app/Services`, `mixed` ultima spiaggia, `const` di classe in tipi adatti.
Perimetro: i 5 Services di AI (`AIService`, `AIChatCompletionClient`, `AIServiceJsonDecoder`, `AIServicePromptBuilder`,
`AIServicePromptTemplates`) e le 20 `const` di classe del modulo.

## Analisi: lo scopo, non il messaggio

### Causa comune: un merge ha riesumato lavoro gia' fatto

Il modulo era gia' in regola due volte: il 2026-07-16 i Services erano stati ritirati (vedi
[ai-services-support-to-actions](../wiki/concepts/ai-services-support-to-actions.md)) e il 2026-10-06/07 le `const` di stato erano
diventate enum (commit `9c9bfdc`, [story](./2026-10-06-phpstan-cleanup-ai.story.md)). Nel working tree trovato oggi erano tornati
entrambi: gli enum, i file lang e le doc erano rimasti, ma model, Action, risorsa Filament, factory e test avevano di nuovo le
`const` (il merge `laraxot/dev` di `f7b2107` ha preso il lato vecchio di quei file), e i 5 Services erano rientrati con `9b0682a`.
Quindi gli enum esistevano ma non li usava nessuno: una conversione a meta' che avrebbe fatto riaprire gli errori
`constantTypeCoverage`. Non c'era nulla da progettare, c'era da ripristinare e consolidare.

### Services: tutti codice morto (prove)

| Service | Chiamanti | Equivalente vivo |
|---|---|---|
| `AIService` (8 metodi) | 0 in `laravel/Modules`, `laravel/Themes`, config, provider, route, Filament, test | `ClassifyTicketAction`, `SuggestSolutionsAction` (con cache `ai:classification:*` / `ai:solutions:*` identica) |
| `AIChatCompletionClient` | solo `AIService` | `Actions/Support/MakeAIRequestAction` (copia con config `ai.*`) |
| `AIServiceJsonDecoder` | solo `AIService` | `Actions/AiJsonResponseDecoderAction` (con test) |
| `AIServicePromptBuilder` | solo `AIService` | `Actions/Prompt/BuildAIPromptAction` (stessi 8 prompt) |
| `AIServicePromptTemplates` | solo `AIServicePromptBuilder` | consts ora private in `BuildAIPromptAction` |

`rg` su `Modules`, `Themes`, `bashscripts` (esclusi docs/vendor/.bak) non trova altro che `AIServiceProvider` (classe diversa).
I cinque flussi di `AIService` senza Action (`predictPriority`, `optimizeRouting`, `generateAutoResponse`, `analyzePatterns`,
`suggestImprovements`) non sono raggiunti da nessuno: non ricreati come Action (stessa decisione del 2026-07-16, evitare codice
morto nuovo). I prompt corrispondenti restano in `BuildAIPromptAction` se un giorno servono.

Conversione corretta = eliminazione, non nuove Action.

### const (20)

| Const | Esito |
|---|---|
| `AiActionProposal::STATUS_*` (5) | enum `AiActionProposalStatusEnum` (gia' presente): cast, Action, Select/badge Filament, factory, test |
| `AiToolLog::STATUS_OK/ERROR` (2) | enum `AiToolLogStatusEnum`: cast + factory |
| `AiMessage::ROLE_*` (4) | enum `AiMessageRoleEnum`: cast + factory (`isUser()`) |
| `AIPromptTemplates::ROUTING_JSON/PATTERN_JSON/IMPROVEMENTS_JSON` (3 x 3 copie = 9) | restano `private const string` dentro `BuildAIPromptAction` (unico consumatore): testo di prompt statico, non configurazione ne' insieme di stati. Le 3 classi erano copie identiche (una in `app/Services`, una in `app/Datas` mai usata, una in `app/Actions/Prompt` che violava `QueueableActionContractTest`): sparite tutte |

I valori backed sono i literal gia' persistiti (`pending`, `ok`, `user`...): colonne `string` invariate, nessuna migrazione di dati.

## Modifiche

- Eliminati (recuperabili da `HEAD` del repo `Modules/AI`): `app/Services/*` (5 `.php` + `AIService.php.bak`),
  `app/Datas/AIPromptTemplates.php`, `app/Actions/Prompt/AIPromptTemplates.php`, `tests/Unit/Services/AIServiceTest.php`
  (testava solo `new CompletionAction()`, gia' coperto da `CompletionActionTest`, con nome e namespace "Services" fuorvianti).
- `app/Actions/Prompt/BuildAIPromptAction.php`: 3 `private const string`; prompt byte-identici (verificato con reflection contro
  la classe vecchia).
- Models `AiActionProposal`, `AiMessage`, `AiToolLog`: tolte le const, aggiunti i cast agli enum e `@property` tipizzate.
- Action `Create/Confirm/CancelAiActionProposalAction`, `AiActionProposalForm` (`->options(Enum::class)`),
  `AiActionProposalsTable` (`canBeConfirmed()/canBeCancelled()`, badge da enum: tolte la mappa colori con `secondary`, non
  standard in Filament, e la `formatStateUsing` ridondante), tre factory, `AiActionProposalTest`.
- Chiavi lang `ai::action_proposal.statuses.*` ora orfane (l'etichetta arriva da `ai_action_proposal_status_enum.php`): lasciate.

## Verifica

- PHPStan sui file toccati (models, 3 Action, `BuildAIPromptAction`, risorsa Filament, factory, test, `AiActionHandlerRegistry`):
  `[OK] No errors` (output in scratchpad `svc-ai-phpstan.out`).
- `php -l` sui file modificati: puliti.
- Pest (non richiede DB): `AiActionProposalTest` 2 passed. `QueueableActionContractTest` FAIL, preesistente e fuori perimetro:
  `Actions\Sentiment\BasicSentimentAnalyzer` e `TransformersSentimentAnalyzer` non usano `QueueableAction` (vedi Aperto).
- Probe senza MySQL (sqlite in memoria, app bootstrappata): 15/15 OK. Cast da literal DB a enum, `Create` -> `PENDING` con
  colonna `pending`, `Cancel` -> `cancelled`, `Confirm` senza handler -> `failed`, le 3 factory producono enum, etichetta
  enum risolta ("In attesa", colore `warning`), i prompt `routing`, `pattern_analysis`, `improvements` contengono i JSON.

## Decisioni

- Nessuna nuova Action: i casi d'uso vivi esistono gia'; ricrearne per flussi senza chiamanti sarebbe codice morto.
- Template dei prompt dentro `BuildAIPromptAction` (non in `config/`): non variano per ambiente e hanno un solo consumatore.
- `mixed`: nei file toccati restano solo `array<string, mixed>` per payload/risultati JSON di terze parti
  (`payload`, `result`, `$params`), senza `mixed` nudo.

## Aperto

- `Actions/Sentiment/BasicSentimentAnalyzer` e `TransformersSentimentAnalyzer` (+ `.bak`): zero chiamanti, implementano
  `Contracts/SentimentAnalyzer`, duplicano `AnalyzeBasicSentimentAction`/`AnalyzeTransformersSentimentAction` e fanno fallire
  `QueueableActionContractTest`. Candidati a eliminazione con il contratto (fuori perimetro: non Service, non const).
- Le risposte JSON di `ClassifyTicketAction`/`SuggestSolutionsAction` restano `array<string, mixed>`: tipizzarle con Data a shape
  (`category`, `confidence`, `tags`...) e' un lavoro a parte sui flussi vivi.
- `BuildAIPromptAction` e' una Action "contenitore" con `$type` stringa; 6 dei suoi 8 rami non hanno chiamanti. Da spezzare per caso
  d'uso quando serviranno.
- `RequestChatCompletionAction` (zero chiamanti) duplica `MakeAIRequestAction`.
- Rischio ricorrente: un nuovo merge da `laraxot/dev` puo' riesumare Services e const. Le modifiche sono nel working tree: vanno
  committate forward-only dal proprietario del repo del modulo.
