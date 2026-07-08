---
title: "Ereditarietà SchedaContract su BaseScheda"
type: concept
tags: [ptv, scheda, contract, inheritance, architecture]
created: 2026-06-15
updated: 2026-06-15
qmd: "Ptv BaseScheda SchedaContract implements figlio extends gerarchia"
related:
  - ../../../../../../docs/wiki/rules/module-hierarchy-inheritance-pattern.md
  - ../../../../../../docs/wiki/rules/contract-interface-stacking.md
  - ./getter-by-year-naming.md
  - ./phpstan-scheda-actions.md
  - ../../../Progressioni/docs/database-connection-progressione.md
  - ../log.md
---

# Ereditarietà SchedaContract su BaseScheda

## Scopo

Il modulo **Ptv** possiede la gerarchia scheda condivisa: contratto, relazioni Sigma (`asz()`), campi comuni. I moduli dominio (**Progressioni**, futuro **Legge104**) estendono `BaseScheda` senza ripetere `implements SchedaContract`.

## Regola

| Layer | Dichiarazione |
|-------|----------------|
| `SchedaContract` | `interface SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract, ModelContract` — ogni implementazione è un `Model` Eloquent |
| `BaseScheda` | `implements SchedaContract` **solo** (transitivo via extends dell'interfaccia) + `asz()` + trait `HasEnteMatrRelationHelpers` |
| `Progressioni\Scheda` | `extends BaseScheda` + `protected $connection = 'progressione'` |

## Connessione database

`BaseScheda` eredita `protected $connection = 'ptv'` da `Ptv\Models\BaseModel`. I moduli consumer (**Progressioni**, futuro **Legge104**) devono **override** con la propria connessione modulo (`progressione`, ecc.). Vedi [database-connection-progressione](../../../database-connection-progressione.md).

## Perché (business + zen)

- **Un punto di verità** per filtri anagrafici e type-hint action
- **Meno rumore** in review e PHPStan
- **Coerenza** con [eloquent-relationship-encapsulation](../../../../../../docs/wiki/rules/eloquent-relationship-encapsulation.md)

## Audit

```bash
bash bashscripts/tools/audit-scheda-contract-inheritance.sh
```

## Collegamenti

- [scheda-resource-pages-inheritance.md](../../scheda-resource-pages-inheritance.md) — pagine Filament `ListSchedas` / `EditScheda` / `CreateScheda`
- [Modules/Progressioni/docs/filament-resource-getpages-naming.md](../../../Progressioni/docs/filament-resource-getpages-naming.md)

## Pending

`Legge104\Models\Scheda` → migrare a `extends BaseScheda` (STORY-002 Phase 3).
