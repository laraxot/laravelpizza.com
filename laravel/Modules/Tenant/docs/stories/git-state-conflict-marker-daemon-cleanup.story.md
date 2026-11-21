---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "git state conflict marker daemon cleanup.story"
issues: []
discussions: []
id: tenant-git-state-conflict-marker-daemon-cleanup
title: "Tenant — pulizia marker di conflitto reintrodotti dal daemon auto-commit"
type: chore
scope: module:Tenant
status: done
date: 2026-09-22
---

# Tenant — pulizia stato git (marker di conflitto residui)

## Diagnosi

`git status --short --branch` mostrava 11 file "dirty" nel working tree (non un
rebase in corso: `.git/rebase-merge` e `.git/rebase-apply` assenti). Nessuna
divergenza `dev`/`laraxot/dev` (0 ahead / 0 behind).

Root cause: un commit precedente (`4d7ffe3` — "fix(Tenant): pulizia marker di
conflitto residui in docs/") aveva gia' ripulito correttamente 8 file
(`docs/00-index.md`, `docs/index.md`, `docs/PATTERNS.md`, `docs/README.md`,
`docs/TROUBLESHOOTING.md`, `docs/architecture.md` e le 4 story
3.5/3.8/5.8/6.1). Due commit successivi (`7c6e6f1`, `c3deab5`, entrambi autore
`marco76tv`, messaggio `.`) hanno **reintrodotto** gli stessi marker di
conflitto in forma annidata sopra il contenuto gia' pulito — pattern
riconducibile al "daemon auto-commit locale" gia' noto (rifonde marker
letterali su push rejected). Il remote `laraxot/dev` stesso porta gli stessi
marker committati (verificato con `git fetch laraxot` + `git show
laraxot/dev:README.md`), quindi la corruzione risale a un push precedente
andato a buon fine con marker letterali dentro.

Un working tree gia' modificato (non mio, presumibilmente da un run
precedente) tentava di ripulire di nuovo ma **cancellava contenuto reale**
invece di limitarsi a rimuovere i marker: `docs/index.md` e `docs/README.md`
azzerati a 0 byte, `docs/architecture.md` troncato di 257 righe (perso l'intero
capitolo "Architecture: Tenant Module" merged da `architecture.md`), le 4
story private della YAML frontmatter (`id`, `epic`, `story`, `scope`,
`epic_title`).

## Azione

- Ripristinati `docs/00-index.md`, `docs/index.md`, `docs/PATTERNS.md`,
  `docs/README.md`, `docs/TROUBLESHOOTING.md`, `docs/architecture.md` e le 4
  story esattamente al contenuto gia' verificato in `4d7ffe3` (nessuna perdita,
  frontmatter preservato).
- `README.md` root: qui il conflitto era reale (mai toccato da `4d7ffe3`), tra
  il vecchio contenuto lungo (sezioni Quick Start/Architecture/Usage
  Examples/Testing) e il nuovo template standard "Cosa offre / Confini
  architetturali / Integrazione rapida / Documentazione / Qualita e
  manutenzione" — verificato confrontando con `Xot/README.md`,
  `Media/README.md`, `Notify/README.md`: tutti gia' migrati al nuovo template
  con lo stesso frontmatter (`id/type/category/tags/issues/discussions`,
  rollout 2026-09-14). Tenuto il nuovo template (contenuto lungo gia'
  preservato in `docs/README.md`/`docs/architecture.md`). Corretti anche due
  link Markdown malformati nella sezione "Documentazione"
  (`[Regole del progetto../../../docs/wiki/` senza `](` di chiusura) — unico
  modulo su 18 con questo bug, non presente negli altri README gia' migrati.
- `.gitignore`: il working tree modificato aveva cambiato `/.ai*` in `/_ai*`.
  Verificato con `git log -S` che `/.ai*` e' il valore originale intenzionale
  (introdotto identico in 3 commit) e che `Rating/.gitignore` e
  `UI/.gitignore` usano tuttora `/.ai*` — ripristinato. Mantenuto invece
  `graphify-out` → `graphify-out/` (slash finale), coerente con la
  standardizzazione gia' fatta su tutti i 18 moduli (story
  `Xot/graphify-out-gitignore-all-modules`, sprint-status.yaml).

## Esito

Commit `35353af` su `dev`, push su `laraxot dev` riuscito
(`c3deab5..35353af`). Zero marker di conflitto residui in tutto il working
tree (`git grep` verificato). Nessuna modifica a codice applicativo, solo
documentazione/config.

## Nota per altri agenti

Il "daemon auto-commit" che produce commit ".", autore `marco76tv` o
`Marco Xot`, e' un rischio noto: se rigira su Tenant e trova ancora marker nel
remote pre-`35353af` (improbabile ora, ma controllare `git log --oneline -5`
prima di assumere pulito), NON fare `git checkout -- <file>` alla cieca:
verificare prima con `git show <ref>:<path>` quale versione e' quella buona.
