# Local-First Ollama Strategy

> Updated: 2026-04-15
> Sources: [../../ollama-strategy.md](../../ollama-strategy.md), [../../tools.md](../../tools.md)
> Raw: [../../ollama.md](../../ollama.md), [../../ollama-mcp-setup.md](../../ollama-mcp-setup.md), [../../ollama-mcp-usage-guide.md](../../ollama-mcp-usage-guide.md)

## Summary

The AI module promotes a local-first model policy: run trivial or repetitive AI tasks locally with Ollama, then escalate to cloud models only for tasks that need stronger reasoning.

## Why It Exists

- reduce token cost for routine work;
- keep sensitive project logic local when possible;
- lower latency for boilerplate, transformations, and summaries;
- preserve continuity when external APIs are unavailable.

## Decision Model

- Level 1: trivial boilerplate and routine transformations should use local models first.
- Level 2: logic and debugging can start local and escalate if quality is insufficient.
- Level 3: architecture and deep reasoning go directly to stronger cloud models.

## Operational Implications

- model lifecycle matters: inventory, pull, switch, and inspect the active model;
- command-level tooling is part of the operating model, not optional decoration;
- documentation is the shared bus when local model policy changes.

## Caveats

- local-first is a policy, not a quality guarantee;
- repeated local failure should trigger escalation, not stubborn adherence;
- the policy needs review when hardware or local model quality changes.

## Related

- [AI Module Overview](../overviews/ai-module.md)
- [AI MCP Governance](./ai-mcp-governance.md)
