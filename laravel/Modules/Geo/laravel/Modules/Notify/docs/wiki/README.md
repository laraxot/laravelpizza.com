# FixCity LLM Wiki

This directory is the canonical compiled wiki layer for the Karpathy-style workflow in this repository.

## Canonical Mapping

- Raw corpus: `docs/` excluding `docs/wiki/**`
- Compiled wiki: `docs/wiki/`
- Schema layer: `AGENTS.md`, `CLAUDE.md`, `QWEN.md`, `GEMINI.md`, `docs/project/docs-governance.md`

## Operations

1. Ingest: read sources from `docs/`, then update one or more pages in `docs/wiki/`.
2. Query: start from [index.md](./index.md), then open the relevant wiki pages before dropping back to raw docs.
3. Lint: check broken links, stale summaries, duplicate knowledge, orphan pages, and contradictions.

## Structure

- [index.md](./index.md): content index for the compiled wiki
- [log.md](./log.md): append-only operational history
- `concepts/`: reusable cross-module knowledge pages
- `modules/`: module-level synthesis pages
- `themes/`: theme-level synthesis pages
- `queries/`: archived answers worth keeping
- `lint/`: health-check reports and follow-up notes

## Rules

- `docs/wiki/` is synthesis, not raw dumping.
- Raw files stay in their canonical locations under `docs/`, module docs, theme docs, or other approved sources.
- Prefer linking to canonical source documents instead of copying large passages.
- Create a wiki page only when the knowledge is likely to be reused across sessions.

## Related Docs

- [Karpathy adoption](../project/karpathy-llm-wiki-adoption.md)
- [QMD local docs search](../project/qmd-local-docs-search.md)
- [Project docs index](../README.md)
