---
title: "Module BMAD audit — Lang"
type: story
status: review
updated: 2026-11-16
module: Lang
bmad: true
qmd: "story BMAD audit modulo Lang inventario gate pest phpstan finding tracker chiavi mancanti test schema user_id"
related:
  - ../audits/lang-audit.md
  - ../epics.md
  - ../piano-miglioramento.md
---

# Story: audit BMAD profondo del modulo Lang

## Contesto

Audit source-first del modulo che deve tenere fuori dal codice ogni parola che l'utente legge ([purpose](../purpose.md)).

## Acceptance

- [x] Inventario misurato e finding con `path:line` ([audit profondo](../audits/lang-audit.md)).
- [x] Sintesi + gate ([audit](../audit.md)), checklist ([ECC](../../ecc/lang-ecc-audit.md)).
- [x] Gap-fill: [purpose](../purpose.md), [architecture](../architecture.md) (riscritta), [decision-log](../decision-log.md), [epics](../epics.md), [brainstorming](../brainstorming.md).
- [x] PHPStan `Modules/Lang`: 0 errori.
- [ ] Pest `Modules/Lang`: `tests/Feature` 10 pass / 13 fail (schema `user_id`, E2); `tests/Unit` non eseguito.
- [ ] E1–E5 chiuse con test di comportamento.

## Riferimenti

<<<<<<< HEAD
<<<<<<< .merge_file_7XcwvR
<<<<<<< HEAD
=======
>>>>>>> .merge_file_LwtzSN
=======
<<<<<<< .merge_file_ZG2VAu
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_7XcwvR
=======
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_LwtzSN
- [audit](../audit.md)
- [piano](../piano-miglioramento.md)
- [ECC](../../ecc/lang-ecc-audit.md)

## Task

<<<<<<< HEAD
<<<<<<< .merge_file_7XcwvR
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
=======
=======
<<<<<<< HEAD
>>>>>>> .merge_file_LwtzSN
1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
2. Audit codice → docs; nessun PHP toccato.
3. Pack ECC e indici aggiornati; `qmd update`.

<<<<<<< .merge_file_7XcwvR
<<<<<<< HEAD
=======
>>>>>>> .merge_file_LwtzSN
=======
>>>>>>> .merge_file_MdEVdA
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_7XcwvR
=======
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_LwtzSN
1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
2. Audit codice → docs; nessun PHP toccato.
3. Pack ECC e indici aggiornati; `qmd update`.

## Esito

<<<<<<< HEAD
<<<<<<< .merge_file_7XcwvR
<<<<<<< HEAD
=======
>>>>>>> .merge_file_LwtzSN
Baseline consegnata: 0 P0, 3 P1, P2 elencati. PHPStan sul tree `Modules` a 0; Pest e chiusura dei P1 aperti. Nota: esiste anche `module-bmad-audit-lang-baseline-analisi-completa.story.md` (storica, nome datato: da migrare a una story senza data).
=======
<<<<<<< .merge_file_ZG2VAu
Baseline consegnata: 0 P0, 3 P1, P2 elencati. Nota: esiste anche `module-bmad-audit-20260928.story.md` (storica, nome datato: da migrare a una story senza data).
=======
Baseline consegnata: 0 P0, 3 P1, P2 elencati. PHPStan sul tree `Modules` a 0; Pest e chiusura dei P1 aperti. Nota: esiste anche `module-bmad-audit-lang-baseline-analisi-completa.story.md` (storica, nome datato: da migrare a una story senza data).
>>>>>>> .merge_file_MdEVdA
>>>>>>> laraxot/dev
<<<<<<< .merge_file_7XcwvR
=======
Baseline consegnata: 0 P0, 3 P1, P2 elencati. PHPStan sul tree `Modules` a 0; Pest e chiusura dei P1 aperti. Nota: esiste anche `module-bmad-audit-lang-baseline-analisi-completa.story.md` (storica, nome datato: da migrare a una story senza data).
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_LwtzSN
