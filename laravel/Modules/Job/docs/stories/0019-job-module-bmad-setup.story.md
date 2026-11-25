---
type: epic-story
title: Job Module BMAD Setup
status: ready-for-dev
links:
  github_issue: 0
  module: Job
qmd: "job bmad setup story"
---
# Job Module BMAD Setup

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

## Overview
Initial BMAD documentation setup for the Job module.

## Acceptance Criteria
- [ ] All BMAD docs created in `Modules/Job/docs/`
- [ ] decision-log.md updated
- [ ] PHPStan passes on Job module
- [ ] Pint --dirty passes

## Notes
Module has 4 Service directories that may need refactoring to Spatie Queuable Actions.

### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
