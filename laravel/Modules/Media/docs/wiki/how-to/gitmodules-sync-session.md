---
title: "Gitmodules sync session — note modulo/tema"
type: how-to
tags: [git, gitmodules, sync, quality-gates, merge-conflict]
created: 2026-07-21
updated: 2026-07-21
qmd: "gitmodules sync session module theme note story-003"
issues:
  - "https://github.com/provtv/base_ptv_fila5/issues/201"
discussions: []
related:
  - "../../../../../../docs/stories/STORY-003-gitmodules-sync-conflict-sweep.md"
  - "../../../../../../docs/chat/gitmodules-sync.md"
---

# Gitmodules sync session

Sessione orchestrata dal prompt `bashscripts/tools/prompts/02-gitmodules-sync.md` (v5.1) e da **STORY-003**.

## Cosa fare su questo owner

1. `git remote -v` — sync **tutte** le organizzazioni (`fetch` + `pull --ff-only` + `push`, mai `--force`).
2. Quality gates da `laravel/`: phpstan → phpmd → phpinsights (`--composer=composer.lock`).
3. Marker Git: risoluzione manuale forward-only (no `git restore`).

## Canon

- Story: [../../../../../../docs/stories/STORY-003-gitmodules-sync-conflict-sweep.md](../../../../../../docs/stories/STORY-003-gitmodules-sync-conflict-sweep.md)
- Report: [../../../../../../docs/chat/gitmodules-sync.md](../../../../../../docs/chat/gitmodules-sync.md)
- Issue base: https://github.com/provtv/base_ptv_fila5/issues/201
