---
title: "Module BMAD audit — User"
type: story
status: review
updated: 2026-11-16
module: User
bmad: true
qmd: "story BMAD audit modulo User inventario gate finding P0 P1"
---

# Story: audit BMAD ed ECC del modulo User

## Perché

Rendere verificabile lo stato di User: chi è chi e cosa può fare: utenti, ruoli, permessi, team, OAuth, accesso ai pannelli. Senza baseline misurata ogni fix successivo è ad hoc.

## Acceptance

- [x] Inventario source-first misurato (2026-11-16).
- [x] Audit approfondito con finding P0/P1/P2 e path: [audits/user-audit.md](../audits/user-audit.md).
- [x] Pack: [audit](../audit.md), [decision-log](../decision-log.md), [epics](../epics.md), [brainstorming](../brainstorming.md), [ECC](../../ecc/user-ecc-audit.md).
- [x] PHPStan `Modules/User`: 0 errori.
- [ ] Pest modulo eseguito su DB `*_test` raggiungibile (oggi: skip documentato).
- [ ] Finding P0-U1, P0-U2 chiusi con regressione Pest.
- [x] Finding P1 «Cms phantom imports User FO pages» chiuso (2026-11-16): niente `Modules\Cms` nelle Folio pages; rimossa `pages/pages/`; Pest `NoCmsPhantomFolioImportsTest`. Vedi [decision-log](../decision-log.md).

## Riferimenti

- [audit](../audit.md)
- [piano](../piano-miglioramento.md)
- [ECC](../../ecc/user-ecc-audit.md)

## Story figlie (da creare, vedi [epics](../epics.md))

- `user-policy-role-permission-super-admin-only`
- `user-permissionpolicy-deny-all`
- `user-seed-permissions-no-runtime-create`
- `user-admin-roles-config`
- `user-remove-dead-policy-and-labels`

## Esito (2026-11-16)

Baseline aggiornata, nessun codice applicativo modificato. Fix e Pest restano aperti (gate DB test).
<<<<<<< HEAD


---

<!-- Contenuto unito da module-bmad-audit-.story.md (rimozione date dai nomi file, issue #64) -->

# Story — User: baseline BMAD

Come manutentore del modulo User, voglio una baseline BMAD verificabile, così da poter pianificare lavoro senza confondere ipotesi, WIP e comportamento osservato.

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
>>>>>>> laraxot/dev
