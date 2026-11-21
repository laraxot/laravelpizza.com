---
qmd: "git multi org sync handoff"
title: "Handoff multi-org sync (STORY-003)"
type: handoff
tags: [git, multi-org, bmad, story-003]
created: 2026-07-21
updated: 2026-07-23
module: "Media"
issues:
  - "https://github.com/provtv/module_media_fila5/issues/13"
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
| Issue owner | https://github.com/provtv/module_media_fila5/issues/13 |
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

Sync multi-org verificato (dirty tree + env S3/Intervention v4 nella sessione).

## Stato sync 2026-07-23

- Remotes: `laraxot` + `provtv` (entrambi `git@github.com:.../module_media_fila5.git`), entrambi **reachable**.
- Working tree già pulito al check (nessun commit locale da fare in questo giro).
- `laraxot/dev`: **0 avanti / 0 dietro** — già allineato.
- `provtv/dev`: eravamo **3 commit avanti** (`688021b` merge da laraxot, `d0a6177`, `d7f0ecc` release 0.0.3-dev.10), merge-base presente (storia correlata, non unrelated) → `git push provtv dev` fast-forward `ee8c47f..688021b`, nessun conflitto.
- Nessun merge/rebase necessario, nessuna risoluzione di conflitti.
- Nota: una sessione precedente (2026-07-22 ~23:05, vedi `docs/chat/multi-agent-standing-coordination.md`) aveva segnalato Media come `DIVERGE`; al check odierno la situazione risultava già risolta/allineata (probabile fix di un'altra sessione nel frattempo).
- Finale `git status`: `On branch dev`, up to date con `provtv/dev` e `laraxot/dev`, working tree clean.
