---
id: "user-uppercase-application-dir"
title: "User: Application/ in root è duplicato morto"
status: review
scope: module:User
created: 2026-09-22
updated: 2026-09-22
qmd: "user Application root uppercase psr-4 app Application UseCases duplicate"
related:
  - ../../../../Xot/docs/bmad/stories/uppercase-root-dirs-cleanup.story.md
  - ../../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
---
# User — `Application/` in root del modulo

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
tags: [docs, user, bmad]

# User — `Application/` in root del modulo

**Perché.** PSR-4 `Modules\User\` → `app/`. Il file `Application/UseCases/Owners/GetAllOwnersRelationshipUseCaseContract.php` in **root** era un duplicato di `app/Application/UseCases/Owners/...` (root senza `SaveOwnershipRelationUseCaseContract`). PascalCase in root viola l'igiene moduli.

`UserMigrationSyntaxTest` **non** ha marker: l'assert cerca la stringa `<<<<<<<` nelle migration. Falso positivo degli scanner.

## Scelta

`git rm -r Application/` (resta `app/Application/`).

## Gate

PHPStan `Modules/User`: 0. Commit deferred.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
