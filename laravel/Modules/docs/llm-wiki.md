# LLM Wiki For Modules

This note explains how modules participate in the repository-wide Karpathy-style LLM wiki.

## Canonical Rule

- Raw corpus: `docs/` excluding `docs/wiki/**`
- Compiled wiki: `docs/wiki/`
- Module docs: `laravel/Modules/<Module>/docs/` remain canonical source material, not a second wiki root

## What Changes For Modules

Module documentation is part of the raw corpus. When new module knowledge is worth preserving across sessions:

1. keep the source material in `laravel/Modules/<Module>/docs/`;
2. compile the reusable synthesis into `docs/wiki/`;
3. link back to the source module docs;
4. update `docs/wiki/index.md` and `docs/wiki/log.md`.

## Why

A separate `laravel/Modules/<Module>/docs/wiki/` convention would create competing wiki roots. The project now standardizes on one compiled layer under `docs/wiki/`.

## Entry Points

- Canonical workflow: [../../../docs/wiki/README.md](../../../docs/wiki/README.md)
- Canonical index: [../../../docs/wiki/index.md](../../../docs/wiki/index.md)
- Adoption notes: [../../../docs/project/karpathy-llm-wiki-adoption.md](../../../docs/project/karpathy-llm-wiki-adoption.md)
