---
title: "consolidation with aiassistant"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "consolidation with aiassistant"
issues: []
discussions: []
---

# Consolidation Strategy: AI + AiAssistant

**Conclusion:** Do NOT merge modules. Instead, extract handlers from AiAssistant into AI, making AiAssistant a thin consumer of AI's abstraction.

## Analysis

### Current State

**AI Module:**
- Infra-only: LLM bridge, handler registry, completion abstraction
- Dependencies: `openai-php/laravel`, Xot, Tenant
- **Zero coupling** to domain modules

**AiAssistant Module:**
- Domain orchestrator: quotation drafts, intervention reports, customer lookup
- Direct LLM calls to OpenAI and Groq (bypasses AI module)
- Dependencies: OpenAI, Groq, Quotation, Intervention, Customer, User, Xot
- **Parallel implementation** of LLM logic (duplication with AI)

### Why NOT Merge

1. **Separation of Concerns**
   - AI = mechanism (how to talk to LLM)
   - AiAssistant = domain policy (what to extract, when to approve)
   - Separate concerns = easier evolution

2. **Reusability**
   - AI can serve future domains (HR, Production, Catalog)
   - AiAssistant is specific to current business ops
   - Merging limits reuse

3. **Dependency Direction**
   - AiAssistant depends on domains (Quotation, Intervention)
   - AI depends on nothing domain-specific
   - Merging creates circular dependency risk

4. **Testing**
   - AI tests: mock LLM responses, test handlers in isolation
   - AiAssistant tests: mock domain models, test orchestration logic
   - Different test strategies = separate modules

### Why NOT Consolidate as-is

Current state has duplication and tight coupling to LLM providers:

```
AiAssistant imports:
├── openai-php/laravel (direct API calls) ← PROBLEM
├── Groq (direct API calls) ← PROBLEM
├── Quotation (extraction logic hardcoded)
├── Intervention (extraction logic hardcoded)
└── Customer (lookup logic hardcoded)

Should import:
├── AI (handler abstraction) ← use this
├── Quotation (interfaces only)
└── Intervention (interfaces only)
```

## Consolidation Roadmap

**Phase 1: Extract Handlers to AI (2-3 days)**

Move orchestration patterns from AiAssistant → AI:

```
AI/
├── Domain/
│   ├── QuotationDraftHandler.php      ← move from AiAssistant
│   ├── InterventionReportHandler.php  ← move from AiAssistant
│   ├── QuotationModificationHandler.php ← move from AiAssistant
│   └── SpeechTranscriptionHandler.php ← move from AiAssistant
└── Providers/
    └── AIServiceProvider.php (register all handlers)
```

**Phase 2: Refactor AiAssistant to Delegate (1-2 days)**

Update AiAssistant to call AI handlers instead of direct LLM:

```php
// OLD
class OpenAiQuotationDraftExtractor {
    public function extract($document) {
        return OpenAI::client()->chat()->create([...]);
    }
}

// NEW
class OpenAiQuotationDraftExtractor {
    public function __construct(AiActionHandlerRegistry $handlers) { }
    
    public function extract($document) {
        return $this->handlers->get('quotation-draft')->handle([
            'document' => $document,
        ]);
    }
}
```

**Phase 3: Remove Direct LLM Deps (1 day)**

Remove `openai-php/laravel` from AiAssistant, declare AI as dependency:

```json
// AiAssistant/composer.json
"require": {
    "laraxot/module_ai_fila5": "*",
    // remove: openai-php/laravel
}
```

**Phase 4: Update Tests (1 day)**

- AI tests: mock `AiActionHandlerRegistry`
- AiAssistant tests: mock `AI` module handlers

## Metrics & Acceptance Criteria

| Metric | Before | After | Goal |
|--------|--------|-------|------|
| AiAssistant LOC (app/) | ~1200 | ~600 | 50% reduction |
| Direct LLM imports in AiAssistant | 2 (OpenAI, Groq) | 0 | 0 |
| AI handler implementations | 4 | 10+ | reusable |
| Duplication (code coverage by both modules) | high | 0 | complete decoupling |
| AiAssistant import count | 15+ | 8 | simplified |

## Implementation Order

1. **AI handlers extraction** (highest impact, lowest risk)
   - Create `AI/Domain/QuotationDraftHandler`
   - Register in `AIServiceProvider`
   - Write handler tests

2. **AiAssistant refactoring** (medium risk, must coordinate)
   - Update extractors to use `AiActionHandlerRegistry`
   - Test with AI handlers
   - Remove direct LLM calls

3. **Dependency cleanup** (lowest risk, mechanical)
   - Remove `openai-php/laravel` from AiAssistant
   - Add AI as dependency
   - Run PHPStan L10

4. **Test suite update** (required for completion)
   - Mock `AiActionHandlerRegistry` in AI tests
   - Mock AI handlers in AiAssistant tests

## Risk Mitigation

| Risk | Mitigation |
|------|-----------|
| Breaking AiAssistant during refactor | Create handlers in AI first; test in isolation |
| Hidden LLM provider deps | `grep -r "OpenAI\|Groq" AiAssistant/` after cleanup |
| Handler interface instability | Lock handler contract in AI; version if needed |
| LLM response format changes | Handlers encapsulate parsing; single update point |

## Timeline

- **Phase 1 & 2:** 3-5 days (parallel work)
- **Phase 3:** 1 day (mechanical)
- **Phase 4:** 1 day (test rewrite)
- **Total:** ~1 week, high impact, zero breaking changes

## Success Criteria

✅ AiAssistant no longer imports OpenAI or Groq directly  
✅ All LLM calls in AiAssistant go through `AiActionHandlerRegistry`  
✅ AI module has 10+ reusable domain handlers  
✅ AiAssistant test suite passes with mocked AI handlers  
✅ PHPStan L10 passes on both modules  
✅ No circular dependencies  

## See Also

- `../ARCHITECTURE.md` — AI module's current design
- `../../AiAssistant/ARCHITECTURE.md` — AiAssistant's current design
- `handler-registry.md` — implementing custom handlers
- `../../../bmad-output/module-philosophy-audit.story.md` — full module audit
