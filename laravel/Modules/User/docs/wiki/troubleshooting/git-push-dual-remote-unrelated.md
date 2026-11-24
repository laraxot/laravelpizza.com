---
title: "Git push User — history unrelated laraxot vs provtv"
type: rule
module: User
tags: [git, push, dual-remote, unrelated, multi-org, user, forward-only]
created: 2026-07-23
updated: 2026-07-23
qmd: "User module_user_fila5 push unrelated histories laraxot provtv no merge force"
issues:
  - https://github.com/provtv/module_user_fila5/issues/16
discussions:
  - https://github.com/provtv/base_ptv_fila5/discussions/204
related:
  - "./git-push-lfs-missing-objects.md"
  - "../../multi-org-sync-laraxot-provtv.md"
  - "../../git-multi-org-sync-handoff.md"
  - "../../../../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md"
  - "../../../../Activity/docs/wiki/troubleshooting/git-push-dual-remote.md"
---

# Git push User — history unrelated (laraxot ↔ provtv)

## Perché

`Modules/User` ha due remote:

- `laraxot` → `laraxot/module_user_fila5`
- `provtv` → `provtv/module_user_fila5`

Scopo: tip `dev` allineati senza force. Se i root commit divergono (`git merge-base` vuoto), un merge/rebase cieco produce centinaia di conflitti add/add — **vietato** in automatico.

## Come è stato sistemato (2026-07-23)

| Remote | Stato | Azione |
|--------|-------|--------|
| `laraxot/dev` | tip `3ea7273a` · **0 0** | `git push --no-thin` → **Everything up-to-date** |
| `provtv/dev` | tip `d2b107e0` · ahead 3 / behind 57 | **STOP** — `merge-base` vuoto (unrelated); push non-FF rifiutato |

### Diagnosi

```bash
cd laravel/Modules/User
git fetch laraxot dev && git fetch provtv dev
git rev-list --left-right --count HEAD...laraxot/dev   # 0 0
git rev-list --left-right --count HEAD...provtv/dev    # 3 57
git merge-base HEAD provtv/dev                         # exit 1 = unrelated
git rev-list --max-parents=0 HEAD
git rev-list --max-parents=0 provtv/dev                # root diversi
```

Diff tip↔tip: **centinaia di file** (non un semplice gap di commit). Tip locale include squash LFS (`3ea7273a` — SVG non più puntatori LFS orfani).

### Cosa fare / non fare

| Scenario | Azione |
|----------|--------|
| Solo `laraxot` da pubblicare | `git -c pack.useSparse=false push --no-thin laraxot HEAD:dev` |
| `provtv` unrelated | **Niente** merge/rebase/force finché un umano non sceglie la storia autoritativa |
| Serve unificare | Decisione umana: (A) `provtv` adotta tip `laraxot` con force esplicito, oppure (B) cherry-pick selettivo commit utili da `provtv` su tip `laraxot` (forward-only) |
| GH008 / LFS | [git-push-lfs-missing-objects.md](./git-push-lfs-missing-objects.md) · playbook UI sibling |

**Vietato agenti:** `push --force`, `merge --allow-unrelated-histories` cieco, `reset`/`restore` per “aggiustare”.

## Relazione con altri playbook

- Divergenza **con** merge-base (Activity): [Activity git-push-dual-remote](../../../../Activity/docs/wiki/troubleshooting/git-push-dual-remote.md)
- LFS / `--no-thin` (UI): [UI git-push-lfs-missing-objects](../../../../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md)
