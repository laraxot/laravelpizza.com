---
title: "Context Compression and Retrieval"
module: "One"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-05-12T10:32:00Z"
related:
  - "[[Theme One Operating Focus]]"
---

# Context Compression and Retrieval

> Theme One-facing summary of the shared context-compression setup.

## Main Signals

- the project now uses a dedicated MCP token optimizer
- QMD remains the preferred first pass for wiki retrieval
- theme docs should avoid broad raw-doc loading when a wiki or source summary already exists
- Kilo large-project guidance recommends keeping only root `AGENTS.md`, using `.kilocodeignore`, and compacting before switching between unrelated theme tasks
- managed indexing remains disabled by repo policy until a deliberate indexing rollout exists
- local prerequisites are now present if Theme One later needs indexing-backed retrieval
- final Kilo-side activation is still a client-verified step
- OpenCode now has a git-root `opencode.json` with explicit compaction and watcher ignores for noisy runtime trees
- the global OpenCode config also loads `@tarquinen/opencode-dcp@latest`, reducing repeated long-session payloads before they reach 262K-class endpoints

## Theme Guidance

Theme One work often touches strategy, roadmap, charts, PDF, and UX docs. Use the theme wiki first, then rely on the shared compression setup and OpenCode pruning to reduce repeated tool payloads.

## References

- [[Theme One Operating Focus]]
- `../../../../../docs/ai/claude/context-compression-mcp.md`
