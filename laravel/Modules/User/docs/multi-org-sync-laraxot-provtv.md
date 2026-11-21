---
title: "Sincronizzazione multi-organizzazione (laraxot + provtv)"
type: concept
tags: [git, sync, multi-org, laraxot, provtv, quality-gates]
created: "2026-07-21"
updated: "2026-07-23"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
  - "./wiki/troubleshooting/git-push-dual-remote-unrelated.md"
  - "./wiki/troubleshooting/git-push-lfs-missing-objects.md"
---

# Sincronizzazione multi-organizzazione (laraxot + provtv)

## Cosa è stato fatto

Questo repository è tracciato da due remote GitHub (`laraxot` = org upstream canonica,
`provtv` = org operativa del progetto ptvx). Il 2026-07-21 è stata eseguita una
sincronizzazione completa seguendo `bashscripts/tools/prompts/02-gitmodules-sync.md`:
fetch di tutti i remote, quality gates (PHPStan L10, PHPMD), risincronizzazione dopo ogni modifica.

## Problemi riscontrati e risolti

- **Clone shallow**: il repo era stato clonato con storia troncata, causando push
  respinti (`did not receive expected object`). Fix: `git fetch --unshallow` su tutti i remote.
- **Storie scollegate ("unrelated histories")**: root commit diversi tra org.
  **2026-07-23:** `laraxot` = tip `3ea7273a` (`0 0`); `provtv` = unrelated (ahead 3 / behind 57).
  **Non** si fa merge/force automatico — decisione umana su storia autoritativa.
  Canon: [wiki/troubleshooting/git-push-dual-remote-unrelated.md](./wiki/troubleshooting/git-push-dual-remote-unrelated.md).

## Regola per il futuro

Prima di un merge/rebase su questo repo, controllare sempre `git remote -v` e
sincronizzare **tutti** i remote elencati, non solo `origin`/`provtv`. Mai forzare
push distruttivi. Se `merge-base` è vuoto → STOP. Se merge-base esiste e c’è divergenza →
merge forward-only manuale. LFS: sibling o playbook UI.

### Playbook push dual-remote (2026-07-22, canon UI)

Se `unpack failed` / `did not receive expected object` → `git push --no-thin`.
Se `GH008` / LFS missing su un org e l’altro ha già accettato il tip →
`git lfs fetch <sibling> --all` poi `git lfs push <target> --all`, poi push.
Dettaglio (SSoT): [../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md](../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md).
Niente reset/squash/force per aggirare LFS.

### Push User 2026-07-23

| Remote | Esito |
|--------|-------|
| `laraxot` | OK `3ea7273a` |
| `provtv` | bloccato unrelated — [git-push-dual-remote-unrelated.md](./wiki/troubleshooting/git-push-dual-remote-unrelated.md) |

