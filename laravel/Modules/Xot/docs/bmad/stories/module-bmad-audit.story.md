---
title: "Module BMAD audit — Xot"
type: story
status: review
updated: 2026-11-16
module: Xot
bmad: true
qmd: "story BMAD audit modulo Xot inventario gate finding P0 P1"
---

# Story: audit BMAD ed ECC del modulo Xot

## Perché

Rendere verificabile lo stato di Xot: kernel Laraxot: classi base, Actions riusabili, contratti, guardie di test. Senza baseline misurata ogni fix successivo è ad hoc.

## Acceptance

- [x] Inventario source-first misurato (2026-11-16).
- [x] Audit approfondito con finding P0/P1/P2 e path: [audits/xot-audit.md](../audits/xot-audit.md).
- [x] Pack: [audit](../audit.md), [decision-log](../../decision-log.md), [epics](../epics.md), [brainstorming](../brainstorming.md), [ECC](../../ecc/xot-ecc-audit.md), [piano](../piano-miglioramento.md).
- [x] PHPStan `Modules/Xot`: 0 errori (rerun; prima passata 6+ errori in `FeatureFlagsTest` mentre un altro agente lo editava).
- [ ] Pest modulo eseguito su DB `*_test` raggiungibile (oggi: skip documentato).
- [ ] Finding P1 chiusi con regressione Pest.

## Story figlie (da creare, vedi [epics](../epics.md))

- `xot-core-no-feature-imports`
- `xot-services-to-actions`
- `xot-policy-before-no-once`
- `xot-remove-unused-traits`
- `xot-artisan-act-guard-or-delete`
- `xot-actions-over-services-doc-link`

## Esito (2026-11-16)

Baseline aggiornata, nessun codice applicativo modificato. Fix e Pest restano aperti (gate DB test).
