---
title: remotes campagna ridondanza ptv sigma
type: handoff
tags: [git, remotes, ptv, sigma, themes, github]
created: "2026-05-27"
updated: "2026-05-27"
related:
  - ../wiki/how-to/module-theme-github-issues.md
  - ../../laravel/Modules/Ptv/docs/wiki/redundancy-audit.md
---

# Remotes — campagna ridondanza Ptv / Sigma

Issue aperte su remote **`origin`** (provtv). Verificare sempre con `git remote -v`.

| Path workspace | `origin` |
|----------------|----------|
| monorepo root | `provtv/base_ptv_fila5_mono` |
| `laravel/Modules/Ptv` | `provtv/module_ptv_fila5` |
| `laravel/Modules/Sigma` | `provtv/module_sigma_fila5` |
| `laravel/Themes/One` | `provtv/theme_one_fila5` |
| `laravel/Themes/Zero` | `provtv/theme_zero_fila5` |
| `laravel/Themes/Three` | `laraxot/theme_three_fila5` (issue campagna → mono **#162**) |

## Issue esistenti (2026-05-27)

| Repo | # | Titolo |
|------|---|--------|
| mono | 162 | Consolidamento logica Scheda / de-coupling Ptv-Sigma-Progressioni |
| module_ptv_fila5 | 4 | Ridondanza e dipendenza da Sigma |
| module_sigma_fila5 | 4 | SchedaTrait God Trait |
| theme_one_fila5 | 5 | Ridondanza temi e blade |
| theme_zero_fila5 | — | usare **#3** Discussione ridondanza |
