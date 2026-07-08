# Context Compaction Strategy

## Problem Statement
Token budget exhaustion with "Compaction exhausted: context still exceeds model limits after 3 attempts" error when conversation exceeded 200K tokens.

## Root Cause Analysis
1. **Conversation growth:** Iterative development, multiple agent discussions, full file reads
2. **System compaction failed:** Automatic compression attempted 3 times without success
3. **No recovery path:** Error occurred with no free context available to create summary and reset
4. **Token accounting:** Each tool call, file read, and agent response added to context window

## Solution: Aggressive Context-Mode Configuration

Created `~/.config/context-mode/config.json` with token-optimized settings:
- **compressionLevel:** 11 (maximum Brotli compression)
- **compressionAlgorithm:** brotli (better than gzip for text)
- **cacheTTL:** 300 seconds (aggressive cache reuse)
- **enableAutoSandbox:** true (threshold 5120 chars)
- **deltaEncoding:** true (diff-based storage)
- **enableChunking:** true (4096 byte chunks)
- **aggressiveIndexing:** true (FTS5 full-text search)

## Operational Strategy

### Data Processing Pattern
```
ctx_batch_execute:
  - Run command
  - Auto-index output via FTS5
  - Keep raw data in subprocess sandbox
  - Return only matched sections (search result only)

ctx_search:
  - Retrieve indexed data on-demand
  - No full-file loads unless necessary
  - Use specific queries for targeted retrieval
```

### Token Budget Management
- **Hard limit:** 200K tokens
- **Trigger threshold:** 150K tokens → switch to ctx_batch_execute + ctx_search
- **Monitor:** ctx_stats after each major operation
- **Prevention:** Use token-optimizer cache_analytics for proactive monitoring

### Why This Works
1. **Sandbox isolation:** Raw output never enters context (stays in subprocess)
2. **FTS5 indexing:** Fast retrieval without re-execution
3. **Brotli 11 + delta:** ~85-95% compression ratio on repeated structures
4. **Chunking:** Smaller pieces compress better than large files
5. **Aggressive indexing:** Search for specific terms, not full content

## Prevention for Future Sessions

1. **Architectural decision:** Always use ctx_batch_execute for commands >20 lines output
2. **File operations:** Read/Edit/Write only for modifications, use ctx_execute_file for analysis
3. **Verbosity discipline:** Short responses, no unnecessary detail
4. **Parallel execution:** Use batch concurrency (4-8) for I/O-bound operations
5. **Memory utilization:** Store reasoning in docs/wiki/ and GitHub issues, not context

## References
- [[context_overflow_feedback]] - Context overflow prevention rules
- [[token_budget_constraint]] - Hard 200K limit enforcement
- ~/.config/context-mode/config.json - Active configuration
- docs/wiki/rules/00-TRIGGER_MAP.md - On-demand loading pattern
