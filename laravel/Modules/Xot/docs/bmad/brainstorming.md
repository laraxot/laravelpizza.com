---
title: "Xot - brainstorming.md"
module: Xot
bmad: true
status: active
---
---
title: "Xot: brainstorming BMAD"
type: brainstorming
tags: [brainstorming, xot, architettura, refactoring, phpstan]
created: 2026-09-28
updated: 2026-09-28
qmd: "Xot brainstorming refactoring architettura PHPStan rischi domande aperte"
related:
  - brainstorming/module-opportunities.md
  - brainstorming/ternary-filter-compact-ui.md
  - discussions/01-traits-composition.md
  - architecture.md
  - README.md
status: draft
---

# Xot: brainstorming

> **SUMMARY**: Indice e raccolta di domande aperte, rischi e ipotesi per il refactoring architetturale di Xot. Gli shard specialistici sono in `brainstorming/` e `discussions/`.

## Shard brainstorming esistenti

| Shard | Stato | Link |
|---|---|---|
| Opportunità e domande aperte | Active | [brainstorming/module-opportunities.md](brainstorming/module-opportunities.md) |
| TernaryFilter select vs controlli compatti | Decided | [brainstorming/ternary-filter-compact-ui.md](brainstorming/ternary-filter-compact-ui.md) |
| Architettura: trait vs ereditarietà statica | Open | [discussions/01-traits-composition.md](discussions/01-traits-composition.md) |

## Rischi osservati (da `module-opportunities.md`)

- Duplicazione tra moduli: `Arr/`, `Array/`, `Arrays/` in `app/Actions/` contengono versioni duplicate (es. `SavePhpArrayAction`, `DiffAssocRecursiveAction`, `RangeIntersectAction`). Verificabile in `app/Actions/Arr/`, `app/Actions/Array/`, `app/Actions/Arrays/`.
- Drift tra documentazione, codice e story status: le story in `stories/` coprono 01–5.249, ma `README.md` indicizza solo 01–04.
- Marker di merge e WIP concorrente: 272 errori PHPStan baseline (story 06, `issues/issue-05-phpstan-272.md`) + 29 da refactor/test.
- Contratti impliciti nei modelli Eloquent: uso di `property_exists()` invece di `isset()` (antipattern, vedi `docs/eloquent-magic-properties-rule.md`).

## Domande aperte da validare

- Vale la pena unificare `Arr/`, `Array/`, `Arrays/` in un unico namespace? (correlato a `stories/01-refactor-table-trans.md`)
- `getFormColumns()` default = 2 o `null` per delegare a Filament? (da `discussions/01-traits-composition.md`)
- `getSteps()` deve rimanere statico o migrarsi a istanza con Wizard Schema? (da `discussions/01-traits-composition.md`)
- `GatedXotBasePage` deve essere esteso a tutti i moduli che lo usano? (vedi `README.md` riga 82–84)

## Output attesi

Le risposte devono diventare story BMAD con acceptance criteria misurabili, riferimenti a file reali e gate di verifica (PHPStan/Pint/Pest).

## Vedi anche

- [Architecture](architecture.md)
- [Stories](stories/): indice completo in [README.md](readme.md)
- [Epics](epics/module-roadmap.md)
# Brainstorming - Modulo Xot

## Idee iniziali

- [IDEA 1]
- [IDEA 2]
- [IDEA 3]

## Problemi da risolvere

- [PROBLEMA 1]
- [PROBLEMA 2]

## Soluzioni proposte

- [SOLUZIONE 1]
- [SOLUZIONE 2]

## Domande aperte

- [DOMANDA 1]
- [DOMANDA 2]