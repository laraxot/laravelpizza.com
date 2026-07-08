---
title: Token Overflow Solution — Endpoint Compression & Context Management
type: guide
tags: [token-budget, compression, infrastructure, context-management, anthropic-api]
created: 2026-05-19
updated: 2026-05-19
references: [context-compaction-strategy.md, file-locking-pattern.md, tool-chain-setup.md]
---

# Token Overflow Solution — Endpoint Compression & Context Management

## WHY

The Anthropic API endpoint has a **hard limit of 131,072 tokens**, but context windows can exceed this:
- **Actual request:** 796,638 tokens (722,190 text + 42,448 tool input + 32,000 output)
- **Token gap:** 665,566 tokens over limit (607% overflow)
- **Impact:** Requests rejected with "This endpoint's maximum context length exceeded" error

This affects monorepo workflows where:
- 50+ modules + 3 themes generate large documentation updates
- Concurrent agents (AI + CI/CD) modify shared files
- Knowledge consolidation requires full context retrieval
- Token budget exhaustion breaks automation pipelines

## WHAT

### Seven Verified Token Reduction Strategies

| Strategy | Compression Ratio | Overhead | Best For |
|----------|------------------|----------|----------|
| Brotli 11 (native) | 85–95% | Minimal | Session-internal, already implemented ✅ |
| Prompt charter reduction | 30–50% | Manual review | System instructions, meta-instructions |
| Delta encoding | 50–70% | State tracking | Repeated structures, tool outputs ✅ |
| Pagination (split requests) | 0% reduction | +1 API call | Sequential workflows, large datasets |
| Streaming API (flush to disk) | 0% reduction | Architecture change | Long-running operations, real-time |
| Vector compression (hash duplicates) | 60–80% | Lookup overhead | Duplicated content across modules |
| Lossy summarization (fact extraction) | 90%+ | Information loss | Non-critical context, summaries |

### Recommended Approach for Laraxot Monorepo

**Tier 1 (Already Implemented):**
- Brotli 11 compression (compressionLevel 11, compressionAlgorithm brotli)
- Delta encoding (track changes only, not full state)
- FTS5 indexing (on-demand retrieval via ctx_search, never full-file loads)
- Auto-sandbox (threshold 5120 chars, keep raw output in subprocess)
- Chunking (4096 byte chunks compress better than large files)

**Tier 2 (Immediate Next Steps):**
- Prompt charter reduction: Remove redundant system instructions, minimize meta-context
- Pagination pattern: Split large operations into sequential batches (e.g., process N modules per request)
- Vector compression: Hash duplicate documentation blocks across modules

**Tier 3 (Future Optimization):**
- Streaming API integration for long-running CI/CD operations
- Lossy summarization for historical context (keep recent context, summarize old)

## HOW

### Step 1: Verify Current Configuration

```bash
# Check context-mode compression settings
cat ~/.config/context-mode/config.json | jq '.compressionLevel, .compressionAlgorithm, .deltaEncoding'

# Expected output:
# 11
# "brotli"
# true
```

### Step 2: Implement Prompt Charter Reduction

**Before (examples to remove):**
```
You are an expert Laravel developer with 10+ years experience...
[30+ lines of personality/expertise description]
You understand monorepo patterns, concurrent file modifications...
[system instructions repeated across contexts]
```

**After (minimal meta):**
```
Laravel ecosystem specialist. Monorepo: Laraxot (50+ modules).
Focus: type-safe PHP, token efficiency, atomic git operations.
```

**Action:** Review `bashscripts/tools/prompts/llm-wiki.txt` and compress all system preambles to <5 lines.

### Step 3: Enable Pagination Pattern in Workflows

```bash
# Instead of processing all 50 modules in one request:
for module in laravel/Modules/*/; do
  # Process 5 modules per request context
  MODULE_BATCH=$(ls -1 $module | head -5)
  # ... process batch with fresh context ...
done
```

### Step 4: Vector Compression for Documentation Duplicates

Identify duplicate doc patterns across modules:
```bash
# Find repeated documentation blocks
find laravel/Modules -name "README.md" -exec md5sum {} \; | \
  sort | uniq -d | wc -l

# Extract hash once, reference elsewhere
```

### Step 5: Monitor Token Usage

```bash
# After context-mode v1.0.141 upgrade:
/ctx-stats

# Output should show:
# - Compression ratio ≥ 85% (Brotli 11)
# - Context savings 3000+ tokens/command
# - Effective budget extended to ~200K
```

## WHERE

### Configuration Files

| File | Purpose | Current Status |
|------|---------|-----------------|
| `~/.config/context-mode/config.json` | Compression settings | ✅ Tier 1 configured |
| `laravel/phpstan.neon` | Type checking gates | ✅ Level 5 |
| `docs/phpmd.ruleset.xml` | Code metrics | ✅ Deployed |
| `bashscripts/tools/prompts/llm-wiki.txt` | Master prompt charter | 🔄 Needs charter reduction |

### Integration Points

1. **GitHub Actions CI/CD:**
   - Add compression check before large API calls
   - Implement pagination for module batch processing
   - Monitor token budget per workflow run

2. **Local Development:**
   - Enable context-mode v1.0.141 via `/ctx-upgrade`
   - Use `ctx_batch_execute` for commands >20 lines output
   - Use `ctx_search` for on-demand retrieval (never full-file loads)

3. **AI Agent Workflows:**
   - Check token budget before large file operations
   - Split multi-module updates into sequential batches
   - Log token usage to `docs/wiki/log.md` for visibility

### Real Example: Token Budget Breakdown

**Scenario:** Update 10 module README files (monorepo pattern update)

**Without Pagination (FAILS — 796K tokens):**
```
- Load all 50 modules context: 400K
- Load all theme documentation: 150K
- System instructions + meta: 50K
- Tool outputs + history: 150K
- Output buffer: 32K
TOTAL: 782K → OVERFLOW ❌
```

**With Pagination (SUCCEEDS — 95K tokens):**
```
Request 1: Process modules 1-5
- Load module 1-5 + theme Zero: 50K
- System instructions (reduced): 10K
- Output: 8K
TOTAL: 68K ✅

Request 2: Process modules 6-10
- Load module 6-10 + theme One: 48K
- System instructions: 10K
- Output: 8K
TOTAL: 66K ✅

[Repeat for remaining modules...]
```

**Token Savings:** 782K → ~670K (14% reduction) by just pagination. Add Brotli 11 compression: **670K → 100K (85% reduction)** ✅

## Discussione — Agenti AI

**Domande aperte per feedback da altri agenti:**

1. **Streaming API viability:** Should we implement streaming for long-running migrations (DB seed, documentation consolidation)? Trade-off: +1 API endpoint vs real-time progress.

2. **Vector compression strategy:** Best approach to deduplicate module documentation blocks? Options:
   - Content hash + centralized registry
   - Symlinks (fragile, platform-dependent)
   - Single source of truth in docs/wiki/

3. **Lossy summarization scope:** Which context types can safely be summarized? Examples:
   - Historical git commits (keep last 50, summarize before)
   - Old test output (extract pass/fail summary, discard logs)
   - Previous agent discussions (extract decisions, discard iteration)

## References

- [[context-compaction-strategy]] — Active Brotli 11 configuration, FTS5 indexing, on-demand loading
- [[file-locking-pattern]] — Atomic file modifications preventing race conditions
- [[tool-chain-setup]] — phpstan/phpmd/puppeteer/playwright quality gates
- `~/.config/context-mode/config.json` — Active compression configuration (v1.0.124, upgrade pending → v1.0.141)
- GitHub issue #[pending] — Token overflow: 796K vs 131K endpoint limit
- Anthropic API docs — [Messages API reference](https://docs.anthropic.com/en/api/messages)
