---
title: "Handoff multi-org sync (STORY-003)"
type: handoff
tags: [git, multi-org, bmad, story-003]
created: 2026-07-21
updated: 2026-07-23
module: "User"
issues:
  - "https://github.com/provtv/module_user_fila5/issues/16"
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
| Issue owner | https://github.com/provtv/module_user_fila5/issues/16 |
| Discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Hub base issue | https://github.com/provtv/base_ptv_fila5/issues/203 |
| Hub base discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Story monorepo | `docs/stories/STORY-003-multi-org-sync-geo-boundary-bashscripts.md` |

## Regole rapide

1. `cd` owner → `git remote -v` → fetch tutti → merge senza force → push tutti
2. Dopo edit PHP: phpstan/phpmd/phpinsights scoped (prompt `02-gitmodules-sync.md`)
3. Mai `git restore` — forward-only
4. UI: non reintrodurre `InteractiveMap` (dominio Geo)
5. Se `merge-base` vuoto vs un org → STOP (unrelated); sync solo l’org allineabile

## Note owner

Seguire sync multi-org e mantenere docs allineate alla story.

### Sessione push 2026-07-23

- `laraxot/dev` = `3ea7273a` (**0 0**, push OK)
- `provtv/dev` = unrelated — [wiki/troubleshooting/git-push-dual-remote-unrelated.md](./wiki/troubleshooting/git-push-dual-remote-unrelated.md)

### Sync 2026-07-23 (batch 5-item, seguito)

- Working tree dirty (docs handoff aggiornati da sessione precedente, non miei) → committato (`f1f1295`, "chore(User): sync locale").
- `laraxot/dev`: eravamo 1 ahead / 0 behind. Push iniziale respinto per race (`cannot lock ref`, remoto avanzato nel frattempo), rifetch → remoto già allineato a `f1f1295` (altra sessione concorrente ha completato il push) → **0 0**, nessuna azione ulteriore necessaria.
- `provtv/dev`: **confermato UNRELATED HISTORIES** (`git merge-base HEAD provtv/dev` vuoto, root commit diversi: locale `cd6af2aa`, provtv `516161d9`/`d2b107e0` come tip). Non tentato merge/force, lasciato per decisione utente come da regola.
- Nessuna rottura di codice trovata in questo giro.
