---
title: "Module BMAD audit — UI"
<<<<<<< HEAD
=======
<<<<<<< .merge_file_1uIwKE
status: review
updated: 2026-11-16
module: UI
bmad: true
qmd: "story BMAD audit modulo UI inventario gate"
---

# Story: audit BMAD del modulo UI

## Acceptance

- [x] Inventario source-first (2026-11-16).
- [x] Audit + piano in `docs/bmad/`.
- [x] Pack ECC in `docs/ecc/`.
- [ ] Pest modulo eseguito in ambiente testing stabile.
- [ ] Finding P0/P1 chiusi con regressione.

## Riferimenti

- [audit](../audit.md)
- [piano](../piano-miglioramento.md)
- [ECC](../../ecc/ui-ecc-audit.md)

## Esito

Baseline audit aggiornata. PHPStan tree `Modules` a 0. Pest e chiusura P0/P1 aperti.
=======
>>>>>>> .merge_file_seJgFH
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
=======
<<<<<<< .merge_file_1uIwKE

---

## Contenuto unito da `module-bmad-audit.story.md`

# Story — UI: baseline BMAD

Come manutentore del modulo UI, voglio una baseline BMAD verificabile, così da poter pianificare lavoro senza confondere ipotesi, WIP e comportamento osservato.

## Acceptance criteria

- [ ] Confermare API pubblica e confini con riferimenti a codice reale.
- [ ] Inventariare i flussi critici e collegarli a test Pest.
- [ ] Misurare PHPStan/Pest nel contesto stabile del modulo.
- [ ] Registrare dipendenze, rischi e decisioni nel modulo.
- [ ] Aggiornare lo stato reale in `docs/sprint-status.yaml`.

## Task

- [ ] Revisione architettura.
- [ ] Brainstorming con stakeholder.
- [ ] Decomposizione epic in story più piccole.
- [ ] Quality gate e second-brain write-back.
=======
>>>>>>> .merge_file_seJgFH
>>>>>>> laraxot/dev
