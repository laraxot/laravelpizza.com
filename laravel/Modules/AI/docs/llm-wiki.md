# AI Module LLM Wiki

This module is the best first adopter of the Karpathy pattern because it already contains MCP, Ollama, agent, and workflow documentation that is repeatedly queried and extended.

## Mapping

- Source umbrella: `laravel/Modules/AI/docs/`
- Optional imported sources: `laravel/Modules/AI/docs/sources/`
- Compiled wiki: `laravel/Modules/AI/docs/wiki/`
- Schema: `laravel/Modules/AI/docs/wiki/schema.md`

## What Belongs In The AI Wiki

- stable synthesis about local AI runtime choices;
- MCP integration patterns reused across modules;
- comparisons between agent workflows and tool stacks;
- resolved implementation decisions that are otherwise rediscovered in chat.

## What Stays Outside The AI Wiki

- raw vendor docs copied verbatim;
- long generated logs;
- one-shot troubleshooting transcripts;
- duplicated notes that already exist as source documents.

## Suggested First Uses

1. Archive the current MCP guidance into a smaller set of durable wiki pages.
2. Keep an AI operations log in `docs/wiki/log.md`.
3. Use `qmd` against the AI docs collection when a user asks cross-cutting questions such as:
   `Which MCP pattern did we standardize on?`

## Commands

```bash
bashscripts/docs/llm-wiki-qmd.sh collection add laravel/Modules/AI/docs --name module-ai-docs
bashscripts/docs/llm-wiki-qmd.sh search "mcp integration"
bashscripts/docs/llm-wiki-qmd.sh query "how should AI docs distinguish source notes from compiled guidance" --no-rerank
```
