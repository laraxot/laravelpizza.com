# AI Module Overview

> Updated: 2026-06-13

## Completamento (2026-06-13)

| Gate | Stato |
|------|-------|
| PHPStan `Modules/AI` | ✅ |
| Pest Actions | 🔄 allineare worktree Sentiment/Completion |
| Coverage | [#12](https://github.com/laraxot/module_ai_fila5/issues/12) |

- Testing: [concepts/testing.md](../concepts/testing.md)
- Hub: [platform-completion-roadmap](../../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md)

## Summary

The AI module is the documentation hub for MCP integration, local-first AI runtime policy, and reusable operator guidance for agent tooling in this repository.

## Role

- centralizes shared MCP guidance before module-specific variants appear elsewhere;
- documents the local-first posture around Ollama and escalation to cloud models;
- acts as a pilot area for compiling noisy raw docs into a smaller reusable wiki.

## Stable Knowledge

- MCP is the main interoperability layer for tools, memory, filesystem access, browser automation, and external services.
- Local-first AI is the preferred default for trivial and repetitive tasks.
- Cloud escalation is still required for harder reasoning, architecture, and complex debugging.

## Entry Points

- [AI MCP Governance](../concepts/ai-mcp-governance.md)
- [Local-First Ollama Strategy](../concepts/local-first-ollama-strategy.md)

## Risks

- some MCP raw docs still embed legacy environment-specific paths;
- several AI docs exist in duplicated naming variants, so ingest must remain selective;
- the raw corpus is larger than the compiled layer, so future work should prefer high-reuse summaries.

## Related

- [Project AI Module Page](../../../../../../docs/wiki/modules/ai-module.md)
- [Project LLM Wiki Governance](../../../../../../docs/wiki/concepts/llm-wiki-governance.md)
