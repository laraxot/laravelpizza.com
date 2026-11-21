---
qmd: "multi org sync laraxot provtv"
issues: []
discussions: []
title: "Sincronizzazione multi-organizzazione (laraxot + provtv)"
type: concept
tags: [git, sync, multi-org, laraxot, provtv, quality-gates]
created: "2026-07-21"
updated: "2026-07-29"
related:
  - "../../../bashscripts/tools/prompts/02-gitmodules-sync.md"
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

- **Lavoro concorrente**: durante la sync un altro agente stava attivamente
  rifattorizzando test e Action in questo modulo; la sync ha rispettato quel
  lavoro senza sovrascriverlo.

## Regola per il futuro

Prima di un merge/rebase su questo repo, controllare sempre `git remote -v` e
sincronizzare **tutti** i remote elencati, non solo `origin`/`provtv`. Mai forzare
push distruttivi su storie scollegate: preferire `--allow-unrelated-histories` e
revisione manuale dei conflitti reali.

### Playbook push dual-remote (2026-07-22, canon UI)

Se `unpack failed` / `did not receive expected object` → `git push --no-thin`.
Se `unpack failed` / `did not receive expected object` → `git push --no-thin`.
Niente reset/squash/force: sempre forward-only.


### Caso User 2026-07-23 (unrelated)

`module_user_fila5`: `laraxot` tip `3ea7273a` (`0 0`); `provtv` **merge-base vuoto** → STOP (no merge/force).
Canon: [../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md](../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md).

### Caso Tenant 2026-07-23 (allineato)

Working tree dirty: 1 file (`docs/multi-org-sync-laraxot-provtv.md`, aggiornamento
sezione "Caso User" di un'altra sessione) → committato (`2136445`). Storie
correlate, nessuna divergenza: solo 1 commit locale non ancora pushato su entrambi
i remote. Push riuscito senza conflitti: `laraxot dev` e `provtv dev`
(`8ff7642..2136445`). Stato finale: `0 0` su entrambi i remote, working tree pulito.

