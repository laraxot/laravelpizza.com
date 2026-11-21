---
qmd: "git multi org sync handoff"
title: "Handoff multi-org sync (STORY-003)"
type: handoff
tags: [git, multi-org, bmad, story-003]
created: 2026-07-21
updated: 2026-07-23
module: "Job"
issues:
  - "https://github.com/provtv/module_job_fila5/issues/16"
discussions:
  - "https://github.com/provtv/base_ptv_fila5/discussions/204"
---

# Handoff — multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_job_fila5/issues/16 |
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

## Stato sync 2026-07-23

- Remotes: `laraxot` + `provtv` (entrambi `git@github.com:.../module_job_fila5.git`), entrambi **reachable**.
- Working tree già pulito al check, nessun merge/rebase in corso.
- `laraxot/dev` e `provtv/dev`: entrambi già al tip locale (`4e91cf6`), **0 avanti / 0 dietro** su entrambi.
- Nessuna azione necessaria: nessun commit, nessun merge, nessun push (già allineato).
- Finale `git status`: `On branch dev`, up to date con `laraxot/dev` (e `provtv/dev`), working tree clean.
