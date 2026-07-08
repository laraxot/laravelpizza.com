---
title: "ereditarietà modelli sigma"
type: concept
module: Sigma
tags: [sigma, basemodel, architecture, dry]
created: 2026-06-15
updated: 2026-06-15
qmd: "sigma BaseModel BaseDateRangeModel extends Model vietato CommonScope"
issues:
  - "https://github.com/provtv/module_sigma_fila5/issues/3"
discussions:
  - "https://github.com/provtv/module_sigma_fila5/discussions/5"
related:
  - ./common-scope-date-range-ownership.md
  - ../../architecture.md
  - ../../../../../../docs/wiki/rules/module-model-base-inheritance.md
---

# Ereditarietà modelli Sigma

## Perché

I modelli Sigma leggono tabelle legacy sulla connessione `generale`. Estendere `Illuminate\Database\Eloquent\Model` salta cast, factory, audit e convenzioni Laraxot del modulo.

## Gerarchia

```
XotBaseModel
  └── BaseModel              # connessione generale, cast comuni
        └── BaseDateRangeModel   # Models\Contracts\DateRangeFieldsContract + CommonScope + timestamps=false
              ├── Asz00k1, Asz00f, Qua00f, Qua03f, Rep00f, Sto00f, Dipt00f
```

Tutti gli altri modelli Sigma → `extends BaseModel`.

## Regole

| Situazione | Estensione |
|------------|------------|
| Tabella legacy generica | `BaseModel` |
| Intervallo date + scope `ofRangeDate` / `ofYear` | `BaseDateRangeModel` |
| Mai | `Illuminate\Database\Eloquent\Model` |

`SigmaModelTrait` **non** include `CommonScope` (evita collisione con `BaseDateRangeModel`).

## Implementazione range

`BaseDateRangeModel` implementa `Models\Contracts\DateRangeFieldsContract`. Su ogni figlio concreto: tre metodi `public` con literal-string dei nomi colonna. Vedi [common-scope-date-range-ownership](./common-scope-date-range-ownership.md).

## Regola child-implements

⚠️ **I figli NON devono ridichiarare `implements Contracts\DateRangeFieldsContract`.**  
L'interfaccia è già nella catena di ereditarietà via `BaseDateRangeModel`.  
Ridichiararla è: DRY violation, fuorviante, manutenzione doppia. Vedi [contract-inheritance-no-redeclare](../rules/contract-inheritance-no-redeclare.md).

## Audit rapido

```bash
rg "extends Model" laravel/Modules/Sigma/app/Models
```

Deve restituire zero match.

## Collegamenti

- [module-model-base-inheritance](../../../../../../docs/wiki/rules/module-model-base-inheritance.md)
- [common-scope-date-range-ownership](./common-scope-date-range-ownership.md)
