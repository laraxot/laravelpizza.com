# LLM Wiki Governance

> Updated: 2026-04-15
> Sources: [Karpathy adoption](../../project/karpathy-llm-wiki-adoption.md); [QMD local docs search](../../project/qmd-local-docs-search.md)
> Raw: [Project docs README](../../README.md); [Modules index](../../../laravel/Modules/docs/README.md); [Themes index](../../../laravel/Themes/docs/README.md)

## Purpose

This page defines how the Karpathy-style LLM wiki maps onto the FixCity repository.

## Mapping

- Raw corpus: `docs/` excluding `docs/wiki/**`
- Compiled wiki: `docs/wiki/`
- Schema: `AGENTS.md`, `CLAUDE.md`, `QWEN.md`, `GEMINI.md`, and project docs governance

## Ingest

When a new source is important enough to preserve:

1. Keep the source in its canonical raw location.
2. Update or create a reusable synthesis page under `docs/wiki/`.
3. Add or refresh the entry in `docs/wiki/index.md`.
4. Append the operation to `docs/wiki/log.md`.

## Query

For repository-grounded questions:

1. Start from `docs/wiki/index.md`.
2. Read the relevant wiki pages.
3. Drop back to the raw corpus only to verify details or inspect edge cases.
4. Archive the answer in `docs/wiki/queries/` only if it is likely to be reused.

## Lint

Periodic wiki maintenance should check:

- broken links
- orphan pages
- duplicate knowledge pages
- stale claims superseded by newer docs
- missing cross-links between module and theme knowledge

## QMD

QMD is optional acceleration, not the wiki itself. Use it to search the markdown corpus faster. Keep durable synthesis in `docs/wiki/`.
