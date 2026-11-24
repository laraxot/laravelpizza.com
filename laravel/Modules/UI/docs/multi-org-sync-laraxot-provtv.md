---
qmd: "ui multi org sync laraxot provtv md"
title: "Sincronizzazione multi-organizzazione (laraxot + provtv)"
type: concept
tags: [git, sync, multi-org, laraxot, provtv, quality-gates]
created: "2026-07-21"
updated: "2026-07-29"
updated: "2026-07-29"
updated: "2026-07-29"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
updated: "2026-07-29"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
updated: "2026-07-23"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
updated: "2026-07-23"
  - "./wiki/troubleshooting/git-push-lfs-missing-objects.md"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
updated: "2026-07-29"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
  - "./git-multi-org-sync-handoff.md"
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
- **Storie scollegate ("unrelated histories")**: alcuni repo avevano un branch `dev`
  remoto rigenerato senza antenato comune con la storia locale. Risolto con
  `git merge --allow-unrelated-histories`, verificando caso per caso i conflitti
  "add/add" (nella maggior parte dei casi contenuto identico, differenze reali
  risolte a mano confrontando i diff).

- **Blocco LFS lato server (provtv)** (storico): in una sessione precedente si era
  riscritta la storia senza tracking LFS. **Non ripetere** rewrite se evitabile.
- **Blocco LFS lato server (provtv)** (storico): in una sessione precedente si era
  riscritta la storia senza tracking LFS. **Non ripetere** rewrite se evitabile.
- **Blocco LFS lato server (provtv)** (storico): in una sessione precedente si era
  riscritta la storia senza tracking LFS. **Non ripetere** rewrite se evitabile.
- **Blocco LFS lato server (provtv)** (storico): in una sessione precedente si era
  riscritta la storia senza tracking LFS. **Non ripetere** rewrite se evitabile.
- **Blocco LFS lato server (provtv)** (storico): in una sessione precedente si era
  riscritta la storia senza tracking LFS. **Non ripetere** rewrite se evitabile.
- **Violazione di dipendenza Geo→UI**: `app/Livewire/Components/Map/InteractiveMap.php`
  importava `Modules\\Geo\\Services\\{Geocoding,Map}Service`, un modulo che non fa
  parte di questo progetto e che comunque UI non dovrebbe mai importare
  (regola: la dipendenza corretta è Geo → UI, mai il contrario). Il file era già
  stato archiviato in passato (vedi `docs/geo-dependency-violation-interactive-map.md`)
  ma reintrodotto da un merge upstream da `laraxot/dev`; rimosso di nuovo.

### Push dual-remote 2026-07-22 (tip `b874935`)

| Sintomo | Causa | Fix |
|---------|-------|-----|
| `unpack failed` / `did not receive expected object` | pack thin + storia merge laraxot↔provtv | `git push --no-thin` |
| `GH008` / LFS missing su `provtv` | OID LFS non presenti su quel remote | `git lfs fetch laraxot --all` → `git lfs push provtv --all` → push |

Playbook completo: [wiki/troubleshooting/git-push-lfs-missing-objects.md](./wiki/troubleshooting/git-push-lfs-missing-objects.md).
| `GH008` / LFS missing su `provtv` | OID LFS non presenti su quel remote | `git lfs fetch laraxot --all` → `git lfs push provtv --all` → push |

Playbook completo: [wiki/troubleshooting/git-push-lfs-missing-objects.md](./wiki/troubleshooting/git-push-lfs-missing-objects.md).

| `GH008` / LFS missing su `provtv` | OID LFS non presenti su quel remote | `git lfs fetch laraxot --all` → `git lfs push provtv --all` → push |

Playbook completo: [wiki/troubleshooting/git-push-lfs-missing-objects.md](./wiki/troubleshooting/git-push-lfs-missing-objects.md).
| `GH008` / LFS missing su `provtv` | OID LFS non presenti su quel remote | `git lfs fetch laraxot --all` → `git lfs push provtv --all` → push |

Playbook completo: [wiki/troubleshooting/git-push-lfs-missing-objects.md](./wiki/troubleshooting/git-push-lfs-missing-objects.md).

| `GH008` / LFS missing su `provtv` | OID LFS non presenti su quel remote | `git lfs fetch laraxot --all` → `git lfs push provtv --all` → push |

Playbook completo: [wiki/troubleshooting/git-push-lfs-missing-objects.md](./wiki/troubleshooting/git-push-lfs-missing-objects.md).


## Regola per il futuro

Prima di un merge/rebase su questo repo, controllare sempre `git remote -v` e
sincronizzare **tutti** i remote elencati, non solo `origin`/`provtv`. Mai forzare
push distruttivi su storie scollegate: preferire `--allow-unrelated-histories` e
revisione manuale dei conflitti reali. In push: **FF + `--no-thin`**; LFS da sibling sano, non squash/reset.
revisione manuale dei conflitti reali. In push: **FF + `--no-thin`**; LFS da sibling sano, non squash/reset.
revisione manuale dei conflitti reali. In push: **FF + `--no-thin`**; LFS da sibling sano, non squash/reset.
revisione manuale dei conflitti reali. In push: **FF + `--no-thin`**; LFS da sibling sano, non squash/reset.

### Caso User 2026-07-23 (unrelated)

`module_user_fila5`: `laraxot` tip `3ea7273a` (`0 0`); `provtv` **merge-base vuoto** → STOP (no merge/force).
Canon: [../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md](wiki/troubleshooting/git-push-dual-remote-unrelated.md).

