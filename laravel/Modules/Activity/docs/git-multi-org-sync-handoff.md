---
title: "Handoff multi-org sync (STORY-003)"
type: handoff
tags: [git, multi-org, bmad, story-003]
created: 2026-07-21
updated: 2026-07-23
module: "Activity"
issues:
  - "https://github.com/provtv/module_activity_fila5/issues/15"
discussions:
  - "https://github.com/provtv/base_ptv_fila5/discussions/204"
status: draft
qmd: "handoff   multi-org sync (story-003) activity"
---

# Handoff — multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_activity_fila5/issues/15 |
| Discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Hub base issue | https://github.com/provtv/base_ptv_fila5/issues/203 |
| Hub base discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Story monorepo | `docs/stories/STORY-003-multi-org-sync-geo-boundary-bashscripts.md` |

## Regole rapide

1. `cd` owner → `git remote -v` → fetch tutti → merge senza force → push tutti
2. Dopo edit PHP: phpstan/phpmd/phpinsights scoped (prompt `02-gitmodules-sync.md`)
3. Mai `git restore` — forward-only
4. UI: non reintrodurre `InteractiveMap` (dominio Geo)

## Note owner

Seguire sync multi-org e mantenere docs allineate alla story.

### Sessione push 2026-07-22

Tip `25ac1e70` su `laraxot` + `provtv` (`0 0`). Blocco = **non-fast-forward** / shallow fuorviante, non LFS.  
Playbook: [wiki/troubleshooting/git-push-dual-remote.md](./wiki/troubleshooting/git-push-dual-remote.md).

### Caso User 2026-07-23 (unrelated)

`merge-base` vuoto vs un org → STOP. User: laraxot `3ea7273a` OK; provtv unrelated.
[../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md](../../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md).
