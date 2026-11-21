---
title: "Module BMAD audit — UI"
type: story
status: review
updated: 2026-11-16
module: UI
bmad: true
qmd: "story BMAD audit modulo UI inventario gate finding P0 P1"
---

# Story: audit BMAD ed ECC del modulo UI

## Perché

Rendere verificabile lo stato di UI: vocabolario visivo condiviso (componenti, widget, colonne, layout tabella) consumato da tutti i moduli. Senza baseline misurata ogni fix successivo è ad hoc.

## Acceptance

- [x] Inventario source-first misurato (2026-11-16).
- [x] Audit approfondito con finding P0/P1/P2 e path: [audits/ui-audit.md](../audits/ui-audit.md).
- [x] Pack: [audit](../audit.md), [decision-log](../decision-log.md), [epics](../epics.md), [brainstorming](../brainstorming.md), [ECC](../../ecc/ui-ecc-audit.md), [piano](../piano-miglioramento.md).
- [x] PHPStan `Modules/UI`: 0 errori.
- [ ] Pest modulo eseguito su DB `*_test` raggiungibile (oggi: skip documentato).
- [ ] Finding P1 chiusi con regressione Pest.

## Story figlie (da creare, vedi [epics](../epics.md))

- `ui-dashboard-real-widgets`
- `ui-remove-phantom-model-tests`
- `ui-personform-lang-or-delete`
- `ui-policy-base-xot`
- `ui-cleanup-stray-files`

## Esito (2026-11-16)

Baseline aggiornata, nessun codice applicativo modificato. Fix e Pest restano aperti (gate DB test).
