---
title: "Notify — coordinamento wave PHPStan"
type: story
module: Notify
status: in-progress
created: 2026-10-20
updated: 2026-11-23
qmd: "notify phpstan wave coord cursor-scratch tsv"
---
# Notify — wave PHPStan (coordinamento)

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

- Ground truth: `.cursor-scratch/phpstan-wave/Notify.tsv`.
- Nessun `analyse Modules` dalla lane; non toccare file di test lockati.
- Scopo: [../scopo.md](../scopo.md). Indice: [../00-INDEX.md](../00-INDEX.md).
- Peer: [4.32.notify-phpstan-swarm-internal-errors.story.md](./4.32.notify-phpstan-swarm-internal-errors.story.md).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
