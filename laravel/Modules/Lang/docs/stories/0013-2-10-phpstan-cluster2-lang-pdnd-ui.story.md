---
title: "Story 8.10: PHPStan cluster 2 (Lang, Pdnd, UI) — timeout + recovery"
type: story
module: Lang
epic: "8 - Quality / PHPStan"
story_id: "8.10"
slug: phpstan-cluster2-timeout-recovery-2026-10-06
status: in-progress
created: 2026-10-06
author: fork-phpstan-cluster2
qmd: "story phpstan cluster lang pdnd timeout recovery"
---
# PHPStan Cluster 2 — Timeout Recovery

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

**Block**: Global phpstan >10min timeout (Lang, Pdnd, UI, Xot/Modules fork).

**Finding**: Syntax ✓ (php -l), switching to per-modulo strategy (6 parallel clusters).

**Recovery**: Fork per cluster → per-modulo phpstan → fix → BMAD story → second brain.

No code fixes this session (blocked on phpstan output). Documented recovery strategy.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
