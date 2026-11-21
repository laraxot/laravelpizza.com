---
issues: []
discussions: []
title: "Context Overflow Prevention"
module: "Tenant"
type: concept
tags: [context, overflow, prevention]
created: 2026-07-14
updated: 2026-07-14
qmd: "context overflow prevention"
related:
  - "./phpstan-corrections-january.md"
---
## Context Overflow Prevention

context-mode MCP v1.0.121 comprime il 98% del contesto automaticamente.

- Canonical doc: `docs/wiki/concepts/context-overflow-prevention.md`
- Rule: `bashscripts/ai/rules/context-compression-discipline.md`
- Comandi: `ctx doctor`, `ctx stats`, `ctx purge`, `ctx upgrade`
- Install: `npm install -g context-mode@latest`
- AGENTS.md deve essere ≤50 righe stub (mai 200KB!)

*Riferimento: contesto >262K tokens causa API Error 400 durante compaction.*
