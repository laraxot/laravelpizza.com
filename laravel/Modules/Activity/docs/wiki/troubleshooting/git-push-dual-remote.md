---
title: "Git push dual-remote Activity (shallow + divergenza laraxot/provtv)"
type: rule
module: Activity
tags: [git, push, shallow, dual-remote, multi-org, activity, forward-only]
created: 2026-07-22
updated: 2026-07-22
qmd: "Activity module_activity_fila5 push deepen no-thin merge provtv laraxot"
issues:
  - https://github.com/provtv/module_activity_fila5/issues/15
discussions:
  - https://github.com/provtv/base_ptv_fila5/discussions/204
related:
  - "../../multi-org-sync-laraxot-provtv.md"
  - "../../git-multi-org-sync-handoff.md"
  - "../../second-brain.md"
  - "../../../../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md"
status: draft
---

# Git push dual-remote: modulo Activity

## Perché

`Modules/Activity` è un repo git indipendente con due remote:

- `laraxot` → `laraxot/module_activity_fila5`
- `provtv` → `provtv/module_activity_fila5`

Scopo: tip `dev` **identico** su entrambi (ahead/behind `0 0`), senza force e senza rewrite.

## Come è stato corretto (2026-07-22)

Tip finale: **`25ac1e70`** (`merge: allinea provtv/dev in Activity (dual-remote, forward-only)`).

### Sintomi

1. Clone **shallow** → conteggi ahead/behind falsi (es. “ahead 1177”) e rischio `did not receive expected object`.
2. `laraxot/dev` e `provtv/dev` **divergenti** (commit paralleli con stesso messaggio, SHA diversi) → `non-fast-forward`.
3. Push FF su un solo remote lasciava l’altro dietro.
4. Race multi-agente: i tip cambiano in corsa: sempre re-fetch prima di agire.

### Fix (ordine)

```bash
cd laravel/Modules/Activity

# 1) Storia completa
git fetch laraxot --deepen=2000
git fetch provtv --deepen=2000
# oppure: git fetch --unshallow

# 2) Allinea locale a un remote (qui: laraxot già a posto)
git fetch laraxot && git status -sb
# vs laraxot: 0 0

# 3) Integra l’altro org (forward-only: NO rebase cieco, NO force)
git merge provtv/dev -m "merge: allinea provtv/dev in Activity (dual-remote, forward-only)"
# conflitti: risolvere a mano; tip↔tip aveva solo fix quality-gate minori

# 4) Push pack completo su entrambi
git -c pack.useSparse=false push --no-thin laraxot HEAD:dev
git -c pack.useSparse=false push --no-thin provtv HEAD:dev

# 5) Verifica
git fetch laraxot && git fetch provtv
git rev-list --left-right --count laraxot/dev...HEAD   # 0 0
git rev-list --left-right --count provtv/dev...HEAD    # 0 0
```

### Esito

| Remote | Dopo |
|--------|------|
| `laraxot/dev` | `25ac1e70` |
| `provtv/dev` | `25ac1e70` |

Verifica sessione: entrambi **Everything up-to-date**. Niente LFS in questo modulo (`git lfs ls-files` = 0). Per LFS vedi playbook UI.

### Cosa non fare

- `git push --force` / `reset --soft` / `git restore` per “aggiustare”
- Push su un solo remote lasciando tip divergenti
- Fidarsi dei conteggi “ahead N” su clone shallow senza deepen
- Rebase cieco tra org quando ci sono commit paralleli omonimi

## Cross-reference

- Multi-org: [../../multi-org-sync-laraxot-provtv.md](../../multi-org-sync-laraxot-provtv.md)
- Handoff: [../../git-multi-org-sync-handoff.md](../../git-multi-org-sync-handoff.md)
- LFS / `--no-thin` (UI SSoT): [../../../../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md](../../../../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md)
