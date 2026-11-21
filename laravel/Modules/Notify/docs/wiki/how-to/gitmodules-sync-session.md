---
title: "Gitmodules sync session — note modulo/tema"
type: how-to
tags: [git, gitmodules, sync, quality-gates, merge-conflict]
created: 2026-07-21
updated: 2026-09-21
qmd: "gitmodules sync session module theme git-C nested repo not submodule"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/115"
discussions: []
related:
  - "../../../../../../docs/wiki/memories/no-git-submodules-module-repos.md"
  - "../../../../../../docs/wiki/rules/gitmodules-ini-paths-only.md"
  - "../../../../../../docs/wiki/how-to/per-module-git-sync-verification.md"
---

# Gitmodules sync session

Notify è una **repository Git autonoma** (`path` in `gitmodules.ini`), non un submodule.
Isolamento: `git -C laravel/Modules/Notify` + `rev-parse --show-toplevel` uguale al path.
Mai Shell `working_directory`. Git solo avanti: fetch + merge (no rebase, no restore).

## Cosa fare su questo owner

1. `git -C laravel/Modules/Notify remote -v` — verità runtime (`laraxot/module_notify_fila5`).
2. `git -C laravel/Modules/Notify fetch laraxot` poi merge `laraxot/dev` se behind; push se ahead.
3. Quality gates da `laravel/`: phpstan → phpmd → phpinsights. Mai `phpunit.xml` in root modulo.
4. Marker Git: risoluzione manuale forward-only.

## Canon

- [no-git-submodules-module-repos.md](../../../../../../docs/wiki/memories/no-git-submodules-module-repos.md)
- Prompt: [17-gitmodules-path-iteration.md](../../../../../../bashscripts/docs/prompts/17-gitmodules-path-iteration.md)
