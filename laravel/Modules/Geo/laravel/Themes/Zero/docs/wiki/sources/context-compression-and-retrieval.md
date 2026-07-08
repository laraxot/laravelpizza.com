---
title: "Context Compression and Retrieval"
module: "Zero"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-05-12T10:32:00Z"
related:
  - "[[Theme Zero Operating Focus]]"
---

# Context Compression and Retrieval

> Theme Zero-facing summary of the shared context-compression setup.

## Main Signals

- the project now exposes a shared MCP token optimizer
- QMD remains the preferred retrieval layer before raw docs
- baseline-theme work should stay wiki-first to avoid loading unnecessary historical docs
- Kilo large-project guidance recommends minimal MCP, concise `AGENTS.md`, and aggressive exclusion of runtime metadata from file access
- managed indexing remains disabled by repo policy until a deliberate indexing rollout exists
- local prerequisites are now present if Theme Zero later needs indexing-backed retrieval
- final Kilo-side activation is still a client-verified step
- OpenCode now has a git-root `opencode.json` with explicit compaction and watcher ignores for noisy runtime trees
- the global OpenCode config also loads `@tarquinen/opencode-dcp@latest`, reducing repeated long-session payloads before they reach 262K-class endpoints

## Theme Guidance

Theme Zero carries large frontend, chart, and quality-guideline docs. Use the local wiki first, then let the shared optimizer and OpenCode pruning reduce repeated tool output during theme work.

## References

- [[Theme Zero Operating Focus]]
- `../../../../../docs/ai/claude/context-compression-mcp.md`
