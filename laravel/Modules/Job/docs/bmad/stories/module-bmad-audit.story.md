---
title: "Module BMAD audit — Job"
type: story
status: review
updated: 2026-11-16
module: Job
bmad: true
qmd: "story BMAD audit modulo Job inventario gate pest phpstan finding P0 policy scheduler"
related:
  - ../audits/job-audit.md
  - ../epics.md
  - ../piano-miglioramento.md
---

# Story: audit BMAD profondo del modulo Job

## Contesto

Audit source-first del modulo che deve rendere governabile il lavoro asincrono e i suoi fallimenti ([purpose](../purpose.md)).

## Acceptance

- [x] Inventario misurato e finding con `path:line` ([audit profondo](../audits/job-audit.md)).
- [x] Sintesi + gate ([audit](../audit.md)), checklist ([ECC](../../ecc/job-ecc-audit.md)).
- [x] Gap-fill: [purpose](../purpose.md), [architecture](../architecture.md), [decision-log](../decision-log.md), [epics](../epics.md), [brainstorming](../brainstorming.md).
- [x] Story 12.1 riaperta nel decision-log (D-4): il codice smentisce `done`.
- [x] PHPStan `Modules/Job`: 0 errori (exit 0).
- [ ] Pest modulo: parziale — 17 pass (`JobStatusAuthorizationTest`); suite completa non eseguita (carico macchina, load ≈ 50).
- [ ] E1–E5 chiuse con test di regressione.

## Task

1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
2. Audit codice → docs; nessun PHP toccato.
3. Pack ECC e indici aggiornati; `qmd update`.

## Riferimenti

- [audit](../audit.md)
- [piano](../piano-miglioramento.md)
- [ECC](../../ecc/job-ecc-audit.md)

## Esito

E1 (P0-1) chiuso in follow-up: [e1-job-policy-create-deny](./e1-job-policy-create-deny.story.md). Baseline originale: 2 P0, 4 P1, P2 elencati. Chiusura demandata alle story figlie di [epics.md](../epics.md); i P0 sono da chiudere per primi (E1, E2). PHPStan sul tree `Modules` a 0.
