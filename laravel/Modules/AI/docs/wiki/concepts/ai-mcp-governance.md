# AI MCP Governance

> Updated: 2026-04-15
> Sources: [../../mcp.md](../../mcp.md), [../../mcp/mcp-integration-overview.md](../../mcp/mcp-integration-overview.md), [../../README.md](../../README.md)
> Raw: [../../installazione-mcp-servers.md](../../installazione-mcp-servers.md), [../../cursor-mcp.md](../../cursor-mcp.md)

## Summary

The AI module is the canonical documentation hub for repository-wide MCP patterns, server selection, and reading order.

## Stable Rules

- keep shared MCP guidance in the AI module first;
- add module-specific MCP docs only when they truly diverge from the shared baseline;
- prefer repository-local conventions and wrappers over user-home or machine-specific paths;
- treat stale absolute-path examples as raw historical material, not as live policy.

## Reading Order

1. `README.md`
2. `mcp.md`
3. `mcp/mcp-integration-overview.md`
4. deeper setup and troubleshooting files only when needed

## Current Gaps

- some raw files mix stable guidance with environment-specific setup;
- older docs still reference legacy repositories and absolute filesystem paths;
- the wiki does not yet record per-server decision notes.

## Related

- [AI Module Overview](../overviews/ai-module.md)
- [Local-First Ollama Strategy](./local-first-ollama-strategy.md)
- [Project AI Module Page](../../../../../../docs/wiki/modules/ai-module.md)
