---
id: "ui-root-hygiene-conflict-markers"
title: "UI: README/contributing marker + md uppercase in root"
status: review
scope: module:UI
created: 2026-09-22
updated: 2026-09-22
qmd: "ui readme contributing nested conflict markers architecture testing philosophy root hygiene"
related:
  - ../livewire-inventory.md
  - ../../architecture.md
  - ../../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
---
# UI — marker nidificati in README + igiene root

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

type: story
tags: [docs, ui, bmad]

# UI: marker nidificati in README + igiene root

**Perché.** `git status` pulito, HEAD con 20 hunk `<<<<<<<` in `README.md` (anche nidificati: theirs iniziava con `<<<<<<< HEAD`) e contributing duplicato. Root teneva `ARCHITECTURE.md`/`TESTING.md`/`PHILOSOPHY.md` (SSoT è `docs/architecture.md`, kebab).

## Scelta

Innermost-first strip; tenere frontmatter HEAD; footer project-agnostic (niente FixCity). Contributing: un solo PSR-12. Delete root uppercase md.

## Gate

PHPStan `Modules/UI`: 0. Commit deferred.

## Wave docs 2026-11-23

Risolti marker annidati in `Modules/UI/docs` (47 file, strategia innermost-first:
HEAD preferito, lato non vuoto, unione paragrafi unici). Verifica:
`/bin/grep -rIln '^<<<<<<< \|^>>>>>>> \|^=\{7\}$' laravel/Modules/UI/docs` → vuoto.
Status: done (docs).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
