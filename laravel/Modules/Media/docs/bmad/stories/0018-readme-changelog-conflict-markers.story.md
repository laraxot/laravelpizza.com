---
id: "media-readme-changelog-conflict-markers"
title: "Media: marker README + CHANGELOG in HEAD"
status: review
scope: module:Media
created: 2026-09-22
updated: 2026-09-22
qmd: "media readme changelog committed conflict markers frontmatter"
related:
  - ../../README.md
  - ../../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
---
# Media — marker in README/CHANGELOG a git status pulito

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

**Perché.** HEAD README era un unico hunk (frontmatter canonico vs README datato 2026-07-28). CHANGELOG: HEAD aveva `[0.0.3-dev.12]`, theirs vuoto.

## Scelta

README: lato frontmatter `id: module-media-readme`. CHANGELOG: tenere la versione extra HEAD.

`.gitignore` `graphify-out/` è claim di `graphify-out-gitignore-all-modules` — non toccato qui.

## Gate

PHPStan `Modules/Media`: 0. Commit deferred.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
