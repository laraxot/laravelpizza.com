---
title: "convenzione getter ByYear su scheda"
type: concept
module: Ptv
tags: [naming, getter, scheda, criteri, dry]
created: 2026-06-18
updated: 2026-06-18
qmd: "getCriteriEsclusioneByYear getCriteriOptionsParsedByYear SchedaContract naming convention"
related:
  - ./scheda-contract-inheritance.md
  - ./trova-esclusi-criteri-by-year.md
  - ./phpstan-scheda-actions.md
  - ../ptv-sigma-shared-surface-catalog.md
---

# Convenzione getter `get*ByYear` (scheda / criteri)

## Regola

Per recuperare dati di dominio filtrati per anno (o altra dimensione):

| Usare | Evitare |
|-------|---------|
| `get` + risorsa + `By` + dimensione | `load` + risorsa + `For` + dimensione |
| `getCriteriEsclusioneByYear` | ~~`loadCriteriEsclusioneForYear`~~ |
| `getCriteriOptionsParsedByYear` | ~~`loadCriteriOptionsParsedForYear`~~ |

**Perché:** allineamento con getter già presenti (`getCriteriOptions()` su istanza scheda) e con action batch (`PopulateByYearAction`, `TrovaEsclusiByYearAction`, `HasExcellenceByYearAction`). `get` = lettura dominio; `ByYear` = criterio di filtro esplicito.

## Dove vive il metodo

| Layer | Ruolo |
|-------|--------|
| `SchedaContract` | firma static — type-hint per action e PHPStan |
| `BaseScheda` | implementazione (resolve moduli `Criteri*`, query, parsing) |
| `Progressioni\Scheda` | eredita senza override |

Le action Ptv su schede **non** referenziano `BaseScheda` direttamente: solo `SchedaContract`.

## Pattern nome

```
get{Risorsa}[Qualificatore]By{Dimensione}
```

- **Risorsa:** entità di dominio (`CriteriEsclusione`, `CriteriOptions`)
- **Qualificatore** (opzionale): trasformazione (`Parsed` se tipizzato list/int/date)
- **Dimensione:** filtro (`Year`, futuro `ValutatoreId`, …)

## Esempi nel monorepo

```php
// static batch — SchedaContract
$schedaClass::getCriteriEsclusioneByYear(2026);
$schedaClass::getCriteriOptionsParsedByYear(2026, 'anno');

// istanza — SchedaTrait (anno dalla scheda corrente)
$scheda->getCriteriOptions();
```

## Collegamenti

- [trova-esclusi-criteri-by-year](./trova-esclusi-criteri-by-year.md)
- [scheda-contract-inheritance](./scheda-contract-inheritance.md)
- [ptv-sigma-shared-surface-catalog](../ptv-sigma-shared-surface-catalog.md) — `getCriteriOptions`
