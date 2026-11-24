---
title: "Sincronizzazione multi-organizzazione (laraxot + provtv)"
type: concept
tags: [git, sync, multi-org, laraxot, provtv, quality-gates]
created: "2026-07-21"
updated: "2026-07-23"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
status: draft
qmd: "sincronizzazione multi-organizzazione (laraxot + provtv) activity"
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

## Regola per il futuro

Prima di un merge/rebase su questo repo, controllare sempre `git remote -v` e
sincronizzare **tutti** i remote elencati, non solo `origin`/`provtv`. Mai forzare
push distruttivi su storie scollegate: preferire `--allow-unrelated-histories` e
revisione manuale dei conflitti reali.

### Playbook push dual-remote (2026-07-22, canon UI)

Se `unpack failed` / `did not receive expected object` → `git push --no-thin`.
Se `GH008` / LFS missing su un org e l’altro ha già accettato il tip →
`git lfs fetch <sibling> --all` poi `git lfs push <target> --all`, poi push.
Dettaglio (SSoT): [../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md](../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md).
Niente reset/squash/force per aggirare LFS.

### Push Activity 2026-07-22 — divergenza (non LFS)

`laraxot` e `provtv` divergevano (commit paralleli omonimi, SHA diversi).  
Fix: deepen/unshallow se serve → merge forward-only → tip `25ac1e70` su **entrambi** (`0 0`).  
Canon: [wiki/troubleshooting/git-push-dual-remote.md](./wiki/troubleshooting/git-push-dual-remote.md).

### Caso User 2026-07-23 (unrelated)

`module_user_fila5`: `laraxot` tip `3ea7273a` (`0 0`); `provtv` **merge-base vuoto** → STOP (no merge/force).
Canon: [../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md](../../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md).

### Caso Activity 2026-07-23 (allineato)

Working tree dirty: 2 file docs (`git-multi-org-sync-handoff.md`,
`multi-org-sync-laraxot-provtv.md`, entrambi aggiornamenti sezione "Caso User" di
un'altra sessione) → committati (`94e99d77`). Storie correlate, nessuna divergenza:
solo 1 commit locale non ancora pushato su entrambi i remote. Push riuscito senza
conflitti: `laraxot dev` e `provtv dev` (`29d5363a..94e99d77`). Stato finale: `0 0`
su entrambi i remote, working tree pulito.

