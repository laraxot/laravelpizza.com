---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
title: "AI Module Philosophy"
description: "Design principles, architecture, cost control, and operational dogmas for FixCity AI integrations"
module: AI
status: active
last_updated: 2026-09-06
---

# AI Module Philosophy

**Why this module exists**: Augment FixCity administrators and operators with AI-powered capabilities—classification, routing, sentiment analysis, proposals—without replacing human judgment. AI assists, not substitutes.

This document is **visionary, eccentric, and honest about pitfalls**. It documents what we believe about LLMs and why 4 models, 32 actions, and zero service classes work.

---

## RELIGIONE — Sacred Dogmas

### Thou Shalt Not Hallucinate in Production

LLMs are probabilistic text completion engines. They generate plausible-sounding output whether or not it is factually true. The FixCity context: Italian public administration, citizen tickets, legal accountability.

**Guardrails**:
- Human-in-the-loop for **proposals**: AI suggests, humans confirm before execution (AiActionProposal lifecycle: pending → confirmed → executed).
- **Structured outputs only**: JSON schemas, not free text. Forces explicit reasoning.
- **Confidence thresholds**: Classification outputs include `confidence` field; below threshold triggers fallback.
- **Audit trails**: Every tool call logged (AiToolLog). Every proposal traced (AiActionProposal with full lifecycle).

### Tokens are Currency

Every API call costs. OpenAI's price model rewards frugality: pay per token, not per request.

**Dogma**:
- Default `max_tokens: 1500` is not a ceiling, it is a contract with the operator.
- Classifications must finish in <256 tokens. If you need more, your prompt is broken.
- Sentiment analysis in <128 tokens. If the model needs more, downgrade to regex fallback.
- Long-running tasks (pattern analysis, bulk predictions) use batch endpoints when available.
- Monitor `usage.prompt_tokens` and `usage.completion_tokens` per action. Log cost estimate (tokens × provider rate).

### APIs Have Opinions

OpenAI, DS4, Ollama each expect different message formats, header structures, response shapes. Don't fight it.

**Dogma**:
- Separate provider adapters (ChatDs4Action, ChatOllamaAction, CompletionAction).
- Normalize responses to a **canonical shape** (content, thinking, done, tokens, duration).
- Each adapter owns its defaults (DS4: max_tokens=256, temperature=0.3, top_p=0.7). Don't cross-pollinate.
- Retry logic lives in the caller (MakeAIRequestAction), not in the adapter.

### Locale Matters — Always Respond in Context

FixCity serves Italian municipalities. Prompts are in Italian. Responses must be in Italian. System prompts set tone (professional, empathetic, decisive).

**Dogma**:
- All prompts in `BuildAIPromptAction` are in Italian, tailored to public administration.
- System role message: "Sei un assistente AI specializzato nella gestione di ticket per amministrazioni pubbliche italiane. Rispondi sempre in formato JSON valido."
- Response tone adjusts per sentiment (frustrazione → empatico, rabbia → rassicurante).
- No hardcoded English error messages in user-facing output.

### Fail Gracefully, Log Verbosely

When an API call fails, the system does not crash. It logs, retries, falls back.

**Dogma**:
- Exponential backoff: `sleep((int) pow(2, $attempt))` on failure.
- Default retries: 3 attempts. Configurable per action.
- Fallback templates: if GeneratePredictionsAction fails, serve GetPredictionFallbackTemplatesAction output.
- All errors logged with context: action type, attempt number, response code/body, timestamp.

---

## FILOSOFIA — Why This Architecture

### Why 32 Actions for 4 Models?

Granularity, testability, reusability.

**Actions are not arbitrary**. They are separated by **responsibility**:

1. **Provider adapters** (ChatDs4Action, ChatOllamaAction): one action per (provider, endpoint) pair.
2. **Prompt builders** (BuildAIPromptAction, BuildTicketClassificationPromptAction): validate parameters, construct JSON-safe prompts.
3. **Business features** (ClassifyTicketAction, SuggestSolutionsAction): compose adapters + prompts + response parsing.
4. **Data casting** (CastScalarToStringAction): type coercion with validation.
5. **Support** (MakeAIRequestAction, AiJsonResponseDecoderAction): retry logic, response decoding.
6. **Sentiment analysis** (SentimentAction): polymorphic fallback (Transformers → Basic Regex).
7. **Proposals** (CreateAiActionProposalAction, ConfirmAiActionProposalAction): proposal lifecycle management.

**Why not a single AiService?**

- A service class would be 600+ lines, doing prompt building, API calling, parsing, logging, retrying.
- Actions are testable in isolation: mock one HTTP response, assert prompt structure.
- Actions are queueable (Spatie QueueableAction): defer heavy lifting to queue.
- Actions compose: ClassifyTicketAction uses BuildTicketClassificationPromptAction + ChatDs4Action + AiJsonResponseDecoderAction. Each dependency is swappable.

### Why Zero Service Classes?

The old Laravel pattern: Service classes as business logic buckets. This module **rejects it entirely**.

**Why**:
- Services are bags of state. Actions are functions with explicit dependencies.
- Actions are laravel-agnostic; services are tied to Laravel's DI container.
- Services hide composition; actions make it explicit (use/new statements).
- Spatie's QueueableAction is the better abstraction for async work than queued jobs.

**The trade-off**: You must understand action composition to navigate the code. This is intentional—clarity over convenience.

### Why Models, Not DTOs?

Eloquent models (AiThread, AiMessage, AiActionProposal, AiToolLog) are the source of truth. They persist, relate, query.

**Why**:
- Audit trails require database storage: every proposal, every message, every tool call.
- Eloquent relationships model the domain: a Thread owns Messages, Proposals, ToolLogs.
- Queries like `$thread->proposals()->where('status', 'pending')->get()` are clear and efficient.
- Laravel's timestamp casting, JSON serialization, and mass assignment protection are free.

**DTOs** (CompletionData, SentimentData) **are ephemeral**—returned from actions, not persisted. They normalize API responses.

### Why Prompt Engineering is Centralized

All prompts live in `Prompt/BuildAIPromptAction.php` and referenced templates (AIPromptTemplates). This is intentional.

**Why**:
- Versioning: if a prompt stops working, you can see the history (git blame, commit message).
- Testing: unit tests can assert prompt structure without calling APIs.
- Locale: all Italian text in one place; updates don't scatter.
- Reuse: routing prompt is complex and shared; don't duplicate it in multiple feature branches.

**Anti-pattern**: Prompts embedded in views or config files are invisible to developers.

---

## POLITICA — Operational Decisions

### Model Selection

| Task | Primary | Fallback | Rationale |
|------|---------|----------|-----------|
| Classification | DS4 Flash | OpenAI GPT-4o-mini | Fast (256 tok), deterministic (temp 0.3), Italian strong |
| Sentiment | Transformers (local) | Basic regex | Zero cost, offline, fast |
| Routing | DS4 Flash | OpenAI GPT-4o-mini | Contextual reasoning, cost-efficient |
| Solutions | DS4 Flash | OpenAI GPT-4o-mini | Longer output (512 tok), creative (temp 0.7) |
| Predictions | DS4 Flash | Fallback templates | Bulk operations, structured JSON |
| Auto-response | DS4 Flash | Fallback template | Tone & locale matter; fallback is generic |

**Why DS4 Flash first?**
- Deployed locally (no API key leakage, no latency to US).
- 8B parameters on single GPU, competitive with GPT-3.5-turbo.
- Deep reasoning ("thinking" mode) for complex tasks.
- Cost: zero operational cost if GPU budget already allocated.

**Why Ollama as a third option?**
- Qwen2.5-Coder 7B for fallback tasks.
- Local, no rate limits, can handle abuse gracefully.

### Token Budgets

Enforce **hard limits per action**:

```php
// Minimal (sentiment, quick decisions)
max_tokens: 128
temperature: 0.1
top_p: 0.5

// Optimized (classifications, routing)
max_tokens: 256
temperature: 0.3
top_p: 0.7

// Full (solutions, analysis, responses)
max_tokens: 512–2000
temperature: 0.5–0.7
top_p: 0.9
```

**Monitoring**: Log every response with prompt_tokens + completion_tokens. Query logs monthly for cost analysis. Alert if a single request exceeds budget.

### Retry Logic

Default: **3 exponential backoff attempts** (2^n seconds).

```php
// Attempt 1: immediate
// Attempt 2: sleep 2 seconds
// Attempt 3: sleep 4 seconds
// After: throw exception
```

**Special cases**:
- Rate limit (HTTP 429): retry with longer backoff (60s).
- Timeout (>30s): consider request ill-formed; fail fast.
- Invalid JSON response: log warning, return empty string, let caller decide.

### Caching & Context Reuse

DS4's KV cache (`~/.ds4/kvcache/`) persists between requests. This is good—don't disable it.

**Not implemented yet**: prompt caching (OpenAI, Anthropic). When budget allows, cache system prompts and ticket categories for 24h.

---

## SCOPO — What AI Does in FixCity

### Ticket Classification

**Goal**: Categorize citizen tickets into 6 buckets (infrastructure, environment, transport, security, services, other).

**Flow**:
1. User submits ticket.
2. ClassifyTicketAction called with (title, description).
3. BuildTicketClassificationPromptAction generates prompt.
4. ChatDs4Action (or fallback) returns JSON with category, confidence, tags.
5. AiJsonResponseDecoderAction validates schema.
6. If confidence < 0.6, human review flag set.
7. Result stored in Ticket model metadata.

**Cost**: ~80–120 tokens per ticket. 1000 tickets/day = ~100K tokens = ~$0.30 (OpenAI pricing).

### Solution Suggestions

**Goal**: Propose 3–5 concrete solutions for a ticket.

**Flow**:
1. Ticket opened by operator.
2. SuggestSolutionsAction called with (title, description, category).
3. BuildTicketSolutionsPromptAction generates rich prompt with context.
4. ChatDs4Action returns JSON with solutions array (title, steps, estimated_time, priority).
5. Operator reviews, edits, or accepts.
6. If accepted, solutions logged as ActionProposal with status=pending.

**Cost**: ~200–400 tokens. Less frequent than classification.

### Sentiment Analysis

**Goal**: Gauge citizen satisfaction, urgency, emotional state.

**Flow**:
1. Message received (ticket description, comment, etc.).
2. SentimentAction tries Transformers (local, free).
3. If Transformers unavailable, uses regex-based BasicSentimentAnalyzer.
4. Returns JSON: sentiment (pos/neg/neutral), emotion, confidence, urgency_level, recommended_tone.
5. Operator sees urgency flag; high/critical triggers escalation.

**Cost**: Zero (local) or ~50 tokens (LLM fallback).

### Ticket Routing

**Goal**: Assign tickets to available agents by skill + workload + specialty.

**Flow**:
1. Batch of unassigned tickets + list of available agents.
2. BuildAIPromptAction with 'routing' type.
3. ChatDs4Action considers agent skills, load, performance history.
4. Returns JSON: array of (ticket_id, agent_id, confidence, reasoning).
5. Each assignment is an AiActionProposal (type='ticket_assignment', status=pending).
6. Supervisor reviews, confirms or reassigns.

**Cost**: ~300–600 tokens per batch of 10 tickets.

---

## ZEN — Essence

Practical AI without hallucination.

**Principles**:
1. **Humans decide, AI informs.** Proposals are suggestions until confirmed.
2. **Tokens are finite.** Every action has a budget; exceed it and fail gracefully.
3. **Logs are sacred.** Every API call, retry, and fallback is audited.
4. **Locale is identity.** Prompts, responses, errors all in Italian for Italian citizens.
5. **Composition over inheritance.** Small, testable actions over god-class services.
6. **Explicit > implicit.** Action dependencies visible; config values typed (Config::string).
7. **Defaults are safe.** temperature=0.3 (deterministic), max_tokens=256 (cheap), retry=3 (resilient).

---

## LIBRERIE DA INSTALLARE

### Already Included

- `openai/php-client` or `laravel/openai`: OpenAI SDK (Completions, ChatCompletions).
- `spatie/laravel-queueable-action`: Queueable actions framework.
- `webmozart/assert`: Runtime type validation.
- `thecodingmachine/safe`: Safe wrapper around error-throwing PHP functions.

### Optional (In Progress)

- `codewithkyrian/transformers`: Local transformers for sentiment analysis (JS bridge via wasm).
- `anthropic-sdk/anthropic-sdk-php`: Anthropic Claude API (future).
- `laravel/pulse`: Performance monitoring (queued actions).

### Recommended (Not Yet Installed)

- `prometheus/client`: Metrics export (token usage, latency, error rates).
- `doctrine/dbal`: Advanced migrations (JSON columns, native enum support).

---

## FUTURE IMPLEMENTAZIONI

### Fine-Tuning (Months 4–6)

If classification accuracy plateaus below 90%, create a fine-tuning dataset:
- 500+ manually labeled tickets (title, description, correct category).
- Export as JSONL: `{"prompt": "...", "completion": "correct_category"}`
- OpenAI API: create fine-tuned model (24h turnaround).
- Route classifications through fine-tuned model, fallback to base model if rate-limited.

### Retrieval-Augmented Generation (RAG) (Months 6–9)

Link historical tickets + solutions to a vector store (Pinecone, Weaviate, or Milvus).

**Flow**:
1. Operator opens ticket.
2. SuggestSolutionsAction retrieves top-3 similar tickets (cosine similarity on embeddings).
3. Constructs prompt: "Similar cases: [context]. Now solve this: [current ticket]."
4. Model responds informed by precedent, not hallucinating from thin air.

**Cost**: Embedding generation (~$0.02 per 1K tokens, cached). Query < 50 tokens.

### Streaming Responses (Months 9–12)

For long operations (bulk predictions, report generation), use OpenAI's streaming API.

**Current**: Single blocking HTTP call, waits for full response.
**Future**: Stream chunks back to browser (WebSocket or Server-Sent Events), show partial results.

**Impact**: Perceived latency halves; user sees progress; can cancel mid-stream.

### Tool Use / Function Calling (Months 12+)

Models like GPT-4, Claude, DS4 (with extended reasoning) can call tools.

**Example**:
1. Model reads ticket.
2. Model decides it needs current agent availability (calls `get_agents_status` tool).
3. System responds with live data.
4. Model incorporates answer into reasoning.
5. Final proposal is informed by real-time data, not stale prompt context.

**Framework**: Spatie action calling another action. Structured tool definitions in config.

---

## COMPETITORS & INSPIRATIONS

### Anthropic Claude

**Strengths**: Extended thinking (100K+ token reasoning), native tool use, superior Italian understanding (Multilingual 3.5B base).
**Weakness**: ~3x cost vs. OpenAI base models.
**Inspiration**: Use Claude for high-stakes decisions (citizen complaint escalation, legal risk assessment).

### OpenAI GPT-4o

**Strengths**: Vision (parse handwritten forms), strong reasoning, mature ecosystem, cost-effective.
**Weakness**: API-only (no self-hosting), US-based (compliance concerns for EU public data).
**Inspiration**: Vision fine-tuning for photo-based tickets (road damage, vandalism).

### Mistral

**Strengths**: Open-source 7B–72B models, EU-based, LGPL licensing, fast inference.
**Weakness**: Smaller model size means weaker Italian understanding.
**Inspiration**: Fallback for cost-critical, low-complexity tasks (sentiment only, no reasoning).

### Local Models (Ollama, vLLM)

**Strengths**: Zero cost, offline, privacy (no data to OpenAI), instant throughput scaling.
**Weakness**: Require GPU/CPU, slower inference than API, tuning burden.
**Inspiration**: Use Qwen2.5-Coder 7B for fallback sentiment, auto-response generation. Larger models (Llama 70B) for complex reasoning if GPU budget allows.

### Google PaLM / Gemini

**Strengths**: Multimodal (text, image, code), integrated with Google Workspace.
**Weakness**: Pricing opaque; indexing concerns.
**Inspiration**: Not recommended unless FixCity adopts Google Workspace; too many integrations already.

---

## BEST PRACTICES

### Prompt Design

1. **Be Specific**: "Classifica il ticket in una di queste 6 categorie: …" not "Che cosa è?".
2. **Define Format**: "Rispondi in formato JSON con campi: category, confidence, tags." not "Rispondi naturalmente."
3. **Give Examples**: Include 1–2 sample (ticket, expected_output) pairs in prompt.
4. **Constrain Output**: Use JSON schema or enum values, not free text.
5. **Iterate**: A/B test two prompts on 100 tickets, measure accuracy, keep better one.

### Action Composition

1. **Dependency Injection**: Pass adapters to actions in constructor.
   ```php
   new ClassifyTicketAction(
       prompt: new BuildTicketClassificationPromptAction(),
       api: new ChatDs4Action(),
       fallback: new ChatOllamaAction(),
   )
   ```
2. **Single Responsibility**: Each action does one thing. Classify is not also parsing response.
3. **Handle Failures**: Actions throw exceptions; caller decides retry/fallback.

### Cost Control

1. **Monitor Usage**: Query logs monthly for prompt_tokens + completion_tokens by action.
   ```sql
   SELECT action_name, SUM(prompt_tokens) as total, AVG(completion_tokens) as avg
   FROM ai_logs GROUP BY action_name ORDER BY total DESC;
   ```
2. **Set Budgets**: Allocate quarterly token budget per feature.
3. **Cache Results**: Store classification results; don't re-classify same ticket.
4. **Batch Operations**: For bulk predictions, use batch API (48h turnaround, 50% cheaper).

### Testing

1. **Mock HTTP**: Use `Http::fake()` to avoid live API calls in tests.
   ```php
   Http::fake([
       'api.openai.com/*' => Http::response(['choices' => [...]], 200),
   ]);
   ```
2. **Assert Prompt Structure**: Test that prompts are valid JSON, contain required context.
3. **Test Fallbacks**: Ensure action degrades gracefully when API fails.
4. **Use Factories**: Create test fixtures (TestTicket, TestAgent) with realistic data.

### Logging & Observability

1. **Log Every Call**: action name, model, prompt tokens, completion tokens, latency, cost estimate.
2. **Structured Logging**: Use Laravel's `Log::info()` with context array, not string interpolation.
   ```php
   Log::info('Classification completed', [
       'ticket_id' => $ticket->id,
       'action' => 'ClassifyTicketAction',
       'model' => 'deepseek-v4-flash',
       'tokens' => ['prompt' => 120, 'completion' => 45],
       'cost' => 0.00123,
       'latency_ms' => 1850,
   ]);
   ```
3. **Alert on Anomalies**: If single request >2000 tokens, alert ops.
4. **Retention**: Keep logs 90 days; archive to S3 for compliance.

---

## BAD PRACTICES

### Hardcoded Prompts in Views

```php
// BAD
{{ openai('Classifica: ' . $ticket->title) }}
```

**Why**: Versioning lost; locale scattered; impossible to test.

**Better**: Pass to BuildAIPromptAction; test independently.

### No Error Handling

```php
// BAD
$response = Http::post($url, $data);
return $response->json()['content'];
```

**Why**: Silent failures; no retry; operator sees blank classification.

**Better**: Try-catch, exponential backoff, log, fallback.

### Unbounded Token Generation

```php
// BAD
'max_tokens' => 10000, // or not set (default 4096)
```

**Why**: Cost explodes; slow latency; truncated mid-sentence.

**Better**: Budget per action (128–512 typical, 2000 max).

### Mixing Providers in Single Action

```php
// BAD
if (env('USE_OPENAI')) { $api = new OpenAIAdapter(); }
else { $api = new OllamaAdapter(); }
$response = $api->chat($prompt);
```

**Why**: Tangled logic; hard to test; response shapes differ.

**Better**: Separate actions (ChatOpenAiAction, ChatOllamaAction), compose in higher-level action.

### Ignoring Confidence / Validation

```php
// BAD
$result = json_decode($response->content());
$ticket->category = $result->category; // trust blindly
```

**Why**: Hallucination accepted. If model confidence=0.2, don't use it.

**Better**: Check `$result->confidence`; if <0.6, require human review.

### No Audit Trail

```php
// BAD
// No record of which AI proposed this solution
$solution = $aiService->suggestSolution($ticket);
$ticket->update(['solution' => $solution]);
```

**Why**: Operator cannot audit, cannot contest, cannot debug.

**Better**: Create AiActionProposal, log tool calls, persist all API requests/responses.

---

## FALSE FRIENDS — Gotchas

| Gotcha | Why Dangerous | Solution |
|--------|---------------|----------|
| **Context window ≠ output window** | Model can read 100K tokens but only generate 2K. You fill prompt with context, lose output space. | Reserve 30% of context for output. If prompt >70% full, summarize or chunk. |
| **Temperature 0 ≠ Deterministic** | LLMs still sample; setting T=0 just concentrates probability mass. Same prompt ≠ same response. | For true determinism, use hardcoded rules (regex). For reproducibility, log seed. |
| **Max tokens mid-sentence** | If output token limit reached mid-word, JSON truncated, decoder fails. | Set max_tokens 50 tokens higher than expected, validate output after decoding. |
| **Prompt injection** | User input in prompt without escaping. Attacker changes ticket title to include JSON block; confuses parser. | Always JSON-encode user input in prompts. Use `json_encode($user_input)`. Validate JSON schema after decode. |
| **Model drift** | OpenAI updates base models monthly. Yesterday's prompt works, today it returns different JSON. | Pin model versions (use `gpt-4-turbo-2025-04-09`, not `gpt-4-turbo`). Test on each update. |
| **Rate limits are silent** | OpenAI returns HTTP 429 but doesn't tell you why. Quota exhausted? Wrong API key? | Implement strict exponential backoff. Log all 429s. Query usage dashboard weekly. |
| **Token counting off-by-one** | OpenAI token counter is an estimate; actual tokens differ by ~1–5%. | Don't rely on `estimate_tokens()` for budget. Use `actual_tokens` from response. |
| **Async timeout** | Queued action takes 2 minutes but queue timeout is 1 minute. Job fails silently. | Set action timeout higher than LLM response time (180s typical). Monitor job queue health. |
| **Embedding dimension mismatch** | Store embeddings with dim=1536 (OpenAI), query with dim=768 (local model). Vector distance meaningless. | Use same model for generation and search. Retrain embeddings if switching models. |
| **Cached system prompt stale** | Implement prompt caching; update system message but cache not invalidated. Old rules still applied. | Version system prompts in config. Invalidate cache on each minor version bump. |

---

## COME USARLO — Usage Patterns

### Classify a Ticket

```php
// Controller
$action = app(ClassifyTicketAction::class);
$result = $action->execute(
    title: $ticket->title,
    description: $ticket->description,
);

// Result: CompletionData with parsed JSON
// {
//   "category": "infrastruttura",
//   "confidence": 0.92,
//   "tags": ["strada", "illuminazione"],
//   "urgency_indicators": ["... strada pericolosa ..."]
// }

$ticket->update([
    'category' => $result->category,
    'ai_confidence' => $result->confidence,
    'ai_tags' => $result->tags,
    'needs_human_review' => $result->confidence < 0.6,
]);
```

### Suggest Solutions with Async Queueing

```php
// Queue for background processing
dispatch(
    new SuggestSolutionsJob(
        ticketId: $ticket->id,
        title: $ticket->title,
        description: $ticket->description,
        category: $ticket->category,
    )
);

// In Job class
public function handle()
{
    $action = app(SuggestSolutionsAction::class);
    $result = $action->execute(...);
    
    // Create proposal (not yet executed)
    AiActionProposal::create([
        'ai_thread_id' => $thread->id,
        'type' => 'suggest_solutions',
        'payload' => $result->toArray(),
        'status' => 'pending',
    ]);
    
    // Notify operator
    Notification::send($operators, new ProposalReady($proposal));
}
```

### Handle Sentiment Analysis with Fallback

```php
// Sentiment tries Transformers, falls back to regex
$action = app(SentimentAction::class);
$sentiment = $action->execute($message);

// Always returns SentimentData, even if error
if ($sentiment->status === 'error') {
    Log::warning('Sentiment analysis failed', ['error' => $sentiment->error]);
    // Use fallback: neutral sentiment, request human review
    $ticket->flagged_for_review = true;
} else {
    $ticket->sentiment = $sentiment->sentiment;
    $ticket->emotion = $sentiment->emotion;
    $ticket->urgency = $sentiment->urgency_level;
}
$ticket->save();
```

### Confirm and Execute a Proposal

```php
// Operator confirms proposal
$proposal = AiActionProposal::findOrFail($id);
$proposal->update([
    'status' => 'confirmed',
    'confirmed_by_user_id' => auth()->id(),
    'confirmed_at' => now(),
]);

// Execute via handler registry
$handler = app(AiActionHandlerRegistry::class)->get($proposal->type);
try {
    $result = $handler->handle($proposal);
    $proposal->update([
        'status' => 'executed',
        'executed_at' => now(),
        'result' => $result,
    ]);
} catch (Exception $e) {
    $proposal->update([
        'status' => 'failed',
        'error' => $e->getMessage(),
    ]);
    Log::error('Proposal execution failed', [
        'proposal_id' => $proposal->id,
        'type' => $proposal->type,
        'error' => $e->getMessage(),
    ]);
}
```

---

## COME INSTALLARLO — Setup

### Environment Variables

```bash
# .env

# OpenAI (fallback)
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini

# DS4 (primary, local)
DS4_URL=http://127.0.0.1:8000
DS4_TOKEN=dsv4-local
DS4_MODEL=deepseek-v4-flash

# Ollama (fallback, local)
OLLAMA_URL=http://localhost:11434
OLLAMA_MODEL=qwen2.5-coder:7b

# Anthropic Claude (future)
ANTHROPIC_API_KEY=sk-ant-...
```

### Config Publish

```bash
php artisan vendor:publish --tag=ai-config
```

### Migrations

```bash
php artisan migrate --path=modules/ai/database/migrations
```

Creates tables: `ai_threads`, `ai_messages`, `ai_action_proposals`, `ai_tool_logs`.

### Queueing

Ensure queue driver configured (Redis recommended for production):

```php
// config/queue.php
'default' => env('QUEUE_CONNECTION', 'redis'),

'redis' => [
    'driver' => 'redis',
    'connection' => 'default',
    'queue' => env('QUEUE_NAME', 'default'),
    'retry_after' => 180, // actions need time
    'block_for' => null,
],
```

### Startup Checklist

1. **OpenAI API key valid**: `curl https://api.openai.com/v1/models -H "Authorization: Bearer $OPENAI_API_KEY"` → 200 OK.
2. **DS4 running**: `curl http://127.0.0.1:8000/health` → {"status": "ok"}.
3. **Ollama running**: `curl http://localhost:11434/api/tags` → list of models.
4. **Queue worker running**: `php artisan queue:work redis --queue=default` in separate terminal.
5. **Database migrations applied**: `php artisan migrate:status` → no pending migrations.
6. **Test action**: `php artisan tinker` → `app(ClassifyTicketAction::class)->execute("Strada danneggiata", "Buca grande")` → JSON classification.

---

## COVERAGE ANALYSIS

### Actions Coverage

| Category | Count | Tested? | Notes |
|----------|-------|---------|-------|
| Provider adapters | 4 | Partial | Http::fake in tests; no live API calls |
| Prompt builders | 3 | Yes | Unit tests for parameter validation |
| Business features | 4 | Yes | Integration tests with mock HTTP |
| Sentiment | 4 | Yes | Both Transformers and Basic paths tested |
| Proposals | 3 | Partial | Handler registry tested; fallback templates need test coverage |
| Data casting | 4 | Yes | Type coercion tests |
| Support | 2 | Yes | Retry logic, response parsing |
| **Total** | **32** | **90%+** | High coverage; minimal untested paths are error cases |

### Database Models Coverage

| Model | Relationships | Tests | Notes |
|-------|---------------|-------|-------|
| AiThread | hasMany(AiMessage, AiActionProposal, AiToolLog) | Yes | All relationships tested; queries optimized with eager loading |
| AiMessage | belongsTo(AiThread) | Yes | Role casting validated |
| AiActionProposal | belongsTo(AiThread) | Yes | Status lifecycle (pending→confirmed→executed) tested |
| AiToolLog | belongsTo(AiThread, AiActionProposal) | Partial | Audit trail functional but integration tests sparse |

### Feature Coverage

| Feature | Implementation | Tested? | Readiness |
|---------|-----------------|---------|-----------|
| Ticket classification | ClassifyTicketAction | Yes | 95% ready, needs production feedback |
| Solution suggestions | SuggestSolutionsAction | Yes | 90% ready, UX refinement pending |
| Sentiment analysis | SentimentAction | Yes | 85% ready, Transformers performance unknown in production |
| Ticket routing | BuildAIPromptAction (routing type) | Partial | 70% ready, needs agent availability API integration |
| Auto-response generation | auto_response prompt type | Partial | 60% ready, template selection incomplete |
| Pattern analysis | pattern_analysis prompt type | No | Research phase only |
| Improvements suggestions | improvements prompt type | No | Research phase only |

### Gaps & Debt

1. **No batch API integration**: Manual chunking of bulk operations; not using OpenAI Batch API.
2. **No fine-tuning pipeline**: Manual retraining when accuracy dips; no automated dataset creation.
3. **No observability**: Logs exist; Prometheus metrics not yet exported.
4. **No caching**: Prompt caching (OpenAI) not implemented; every request fresh.
5. **No RAG layer**: Similarity search over historical tickets not integrated.
6. **No tool use**: Models cannot call functions; all reasoning is contextual.
7. **Pattern analysis & improvements untested**: Research-phase actions lack production test coverage.

---

## Epilogue: Trust, But Verify

This module is **pragmatic**. It does not aspire to AGI or general reasoning. It solves three concrete problems for FixCity:

1. **Classify** tickets fast and consistently.
2. **Suggest** solutions informed by domain knowledge.
3. **Route** work to the right person.

All proposals are human-reviewed before execution. Logs are exhaustive. Fallbacks are graceful.

**The philosophy is simple**: _Use AI to augment administrators, not replace them. Respect tokens and budgets. Log everything. Test before pushing. Trust the model enough to be useful, but verify before committing._

---

**Module**: AI · **Version**: 0.1.0 · **Maintainer**: Marco Sottana · **License**: MIT
