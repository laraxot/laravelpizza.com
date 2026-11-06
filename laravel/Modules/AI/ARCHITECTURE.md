---
title: "ARCHITECTURE"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ARCHITECTURE"
issues: []
discussions: []
---

# Architettura Modulo AI

Ponte verso LLM: inferenza agnostica dal provider, prompt versionati, completamenti strutturati. Fondazione per tutte le capacità AI.

## Scopo

Standardizzare l'accesso agli LLM senza accoppiamento al provider (OpenAI, DeepSeek, Ollama).

**Contratti:**
- `AiActionHandlerContract` — esegui azione AI
- `SentimentAnalyzer` — classifica sentiment

**Dati:**
- `CompletionData` — risposta LLM con metadati
- `PredictionData` — risultato previsione
- `AIPromptTemplates` — registro prompt versionati

**Azioni:**
- `CompletionAction` — inferenza grezza
- `AiJsonResponseDecoderAction` — parsing output strutturato
- `ContextCompressorAction` — compressione budget token

## Dipendenze

```
AI (questo modulo)
├── openai-php/laravel (esterno)
├── Xot (classi base)
└── Tenant (contesto multi-tenant)
```

**Zero accoppiamento a moduli dominio.** AI è solo infrastruttura.

## Integrazione: Pattern Consigliato

I moduli **NON importano AI direttamente**. Invece:

1. **Via Contratto:** `AiActionHandlerContract` per handler custom
2. **Via Evento:** Moduli dominio emettono eventi; AI/AiAssistant ascoltano
3. **Via Service Provider:** Registra handler in `AIServiceProvider::register()`

```php
// ❌ SBAGLIATO: import diretto
use Modules\AI\Actions\CompletionAction;

// ✅ CORRETTO: usa contratto handler
$handler = app(AiActionHandlerRegistry::class)->get('quotation-draft');
$handler->handle($request);
```

## Best Practices

- **Astrazione handler:** Non usare OpenAI/Groq direttamente; delegare via registry
- **Versionamento prompt:** Tutti i prompt in `AIPromptTemplates` con fallback
- **Token budget:** Enforza limite context window con `ContextCompressorAction`
- **Logging:** Registra ogni inferenza (costo, token, errori) per audit
- **Retry:** Retry automatico su transient errors (timeout, rate limit)
- **Testing:** Mock risposte LLM via `AiActionHandlerContract`, non API reale

## ⚠️ Bad Practices

- **Import diretto OpenAI** — causa tight coupling, impossibile swappare provider
- **env() per API key** — accoppiamento a config; usa `config('ai.openai_key')`
- **Hardcoded prompt** — prompt dovrebbe essere versionato in `AIPromptTemplates`
- **Nessun budget token** — input illimitato causa crash o costi altissimi
- **Service class wrapper** — usa Actions + QueueableAction, non Services
- **Nessun logging** — impossibile debuggare fallimenti o anomalie

## 🚨 False Friends

- **"Uso Config al posto di env()"** — `config()` legge ENV al boot; se ENV cambia runtime, config non si aggiorna. Usa `config()` solo in ApplicationServiceProvider, non in logica business
- **"AiAssistant è modulo AI"** — NO: AiAssistant è orchestratore dominio, AI è infra. Confonderli causa duplication
- **"Retry automatico significa affidabilità"** — NO: retry su 5xx; su 4xx (auth, rate limit) spesso fallisce. Distingui errori
- **"Token compression è sempre sicuro"** — NO: comprimere contesto perde informazioni. Documenta cosa viene scartato
- **"Una risposta JSON = output strutturato"** — NO: JSON malformato non fa errore; valida sempre con schema

## Problemi Noti & Debito Tecnico

1. **Handler registry incompleto:** Pochi handler pronti. Espandere per pattern comuni (summarize, extract, classify, translate)

2. **Nessuna astrazione provider LLM:** Usa OpenAI diretto. Dovrebbe astrarre a `LlmProviderContract` (OpenAI, DeepSeek, Ollama compatibile)

3. **Prompt non versionati:** Prompts hardcoded. Dovrebbero essere in `AIPromptTemplates` con fallback

4. **Token budget non enforced:** `ContextCompressorAction` esiste ma non usato ovunque. Auto-comprimere se input > context window

5. **Duplication con AiAssistant:** AiAssistant implementa orchestrazione LLM parallela (Groq, OpenAI diretto). Consolidare in handler system

## Refactoring: Consolidare Accesso LLM

**Problema:** AiAssistant parla direttamente a OpenAI/Groq, bypassa astrazione handler AI.

**Soluzione:**

1. Estrai handler dominio da AiAssistant in AI come `Domain\*Handler`
   - `Domain\QuotationDraftHandler` (in AI)
   - `Domain\InterventionReportHandler` (in AI)
   - `Domain\SpeechTranscriptionHandler` (in AI)

2. Refactor AiAssistant per usare `AiActionHandlerContract` invece import diretto LLM

3. Registra handler in `AIServiceProvider`

**Impatto:**
- AiAssistant si rimpicciolisce (solo orchestrazione thin)
- AI diventa single source of truth per pattern LLM
- Nuovi moduli dominio riusano handler senza reimplementare

## Decisioni Architetturali

| Decisione | Razionale |
|-----------|-----------|
| Contratti over classi | Handler interface stabile; implementazione swappabile |
| Scope solo infra | AI non dipende da Quotation, Intervention, etc. |
| Event-driven integration | Domini emettono; AI ascolta; zero import circolare |
| Agnostico provider | Supporta OpenAI, DeepSeek, Ollama via single handler |
| Handler, non Action | Handler è sincrono request→response, non queueable |

## Vedi Anche

- `PHILOSOPHY.md` — principi AI e vincoli
- `TESTING.md` — mock completamenti, test isolati
- `docs/consolidation-with-aiassistant.md` — roadmap consolidamento
- `docs/stories/01.consolidate-aiassistant-handlers.story.md` — story BMAD Phase 1
