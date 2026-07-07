# AI Module

> Updated: 2026-04-15
> Sources: [../../../laravel/Modules/AI/docs/README.md](../../../laravel/Modules/AI/docs/README.md), [../../../laravel/Modules/AI/docs/structure.md](../../../laravel/Modules/AI/docs/structure.md)
> Raw: [../../../laravel/Modules/AI/docs/mcp.md](../../../laravel/Modules/AI/docs/mcp.md), [../../../laravel/Modules/AI/docs/mcp/mcp-integration-overview.md](../../../laravel/Modules/AI/docs/mcp/mcp-integration-overview.md), [../../../laravel/Modules/AI/docs/ollama-strategy.md](../../../laravel/Modules/AI/docs/ollama-strategy.md)

## Summary

The AI module is the project-level hub for MCP guidance, local-first AI runtime strategy, and reusable operator patterns for agent tooling.

## Why It Matters

- it centralizes MCP patterns that other modules can inherit instead of duplicating;
- it contains the strongest current documentation on local AI workflow policy;
- it is now one of the first modules with an actual compiled local wiki.

## Canonical Local Wiki

The module-level compiled wiki lives in `laravel/Modules/AI/docs/wiki/`.

Start with:

- [AI Module Overview](../../../laravel/Modules/AI/docs/wiki/overviews/ai-module.md)
- [AI MCP Governance](../../../laravel/Modules/AI/docs/wiki/concepts/ai-mcp-governance.md)
- [Local-First Ollama Strategy](../../../laravel/Modules/AI/docs/wiki/concepts/local-first-ollama-strategy.md)

## Project-Level Takeaways

- treat `laravel/Modules/AI/docs/` as the raw module corpus;
- keep durable syntheses in `laravel/Modules/AI/docs/wiki/`;
- use this root page only as a project-wide routing summary.

## Related

- [LLM Wiki Governance](../concepts/llm-wiki-governance.md)
