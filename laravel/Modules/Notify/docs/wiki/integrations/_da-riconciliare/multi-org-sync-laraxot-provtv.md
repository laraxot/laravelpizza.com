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

- **Storia scollegata risolta**: `dev` locale e `laraxot/dev` non avevano
  antenato comune (root commit diversa). Merge con `--allow-unrelated-histories`,
  conflitti "add/add" risolti (contenuto quasi identico, differenze minime tipo
  docblock).

## Regola per il futuro

Prima di un merge/rebase su questo repo, controllare sempre `git remote -v` e
sincronizzare **tutti** i remote elencati, non solo `origin`/`provtv`. Mai forzare
push distruttivi su storie scollegate: preferire `--allow-unrelated-histories` e
revisione manuale dei conflitti reali.

### Playbook push dual-remote (2026-07-22, canon UI)

Se `unpack failed` / `did not receive expected object` → `git push --no-thin`.
Niente reset/squash/force: sempre forward-only.


### Caso User 2026-07-23 (unrelated)

`module_user_fila5`: `laraxot` tip `3ea7273a` (`0 0`); `provtv` **merge-base vuoto** → STOP (no merge/force).
Canon: [../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md](../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md).

### Caso Notify 2026-07-23 (già allineato, nessuna azione)

Working tree pulito, nessun merge/rebase in corso. Fetch `laraxot` + `provtv`:
entrambi **`0 0`** (merge-base presente, storie correlate — la risoluzione
"unrelated" del 2026-07-21 sopra è rimasta stabile stavolta, a differenza di
`Xot`). Nessun commit da fare, nessun push necessario.

