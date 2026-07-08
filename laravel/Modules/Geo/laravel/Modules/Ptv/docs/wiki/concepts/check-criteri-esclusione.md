---
title: "check criteri esclusione — orchestrazione"
type: concept
module: Ptv
tags: [trova-esclusi, criteri-esclusione, scheda-contract, fillable]
created: 2026-06-18
updated: 2026-06-18
qmd: "Check TrovaEsclusi SchedaContract getCriteriEsclusioneByYear fillable ha_diritto"
related:
  - ./trova-esclusi-criteri-by-year.md
  - ./trova-esclusi-gg-cascade.md
  - ./getter-by-year-naming.md
  - ./phpstan-scheda-actions.md
  - ./scheda-contract-inheritance.md
  - ../../../../../../docs/wiki/patterns/domain-method-naming-no-persist.md
---

# Check criteri esclusione

## Scopo

`Check` valuta tutti i criteri attivi per una scheda, aggrega i motivi di esclusione, aggiorna `ha_diritto` e `motivo`.

## Catena Trova esclusi

`TrovaEsclusiAction` → `TrovaEsclusiByModelClassYearAction` → `Check` → action figlie in `CriteriEsclusione/`.

## Regole architetturali

- Primo argomento: **`SchedaContract`** (non `Model` generico).
- Caricamento batch anno: **`getCriteriEsclusioneByYear`** / **`getCriteriOptionsParsedByYear`** su `SchedaContract`.
- Dispatch: `Str::studly($criterio->name)` → `Modules\Ptv\Actions\CriteriEsclusione\{Class}` — **fail-fast** se criterio/action invalidi (nessun `continue`).
- Registry: ogni `CriteriEsclusioneEnum` deve avere action corrispondente (`CriteriEsclusioneEnumActionRegistryTest`).
- **No `persist*`** su model/contratto — vedi [domain-method-naming-no-persist](../../../../../../docs/wiki/rules/domain-method-naming-no-persist.md).

## Update esito (`ha_diritto`, `motivo`)

`Check` chiama `update()` dopo `assertAttributesAreFillable()`:

- i campi **devono** essere in `$fillable` del modello concreto (es. `Progressioni\Models\Scheda`);
- essere solo in `$xls_fields` o in `validate()` **non basta** — Laravel ignora mass assignment.

## Action figlie note

| name DB | Action |
|---------|--------|
| `min_gg_integ_params` | `MinGgIntegParams` — calcolo da `Integparam` |
| `min_gg_integ_params_no_asz` | `MinGgIntegParamsNoAsz` — accessor `gg_esperienza_no_asz` |

## Collegamenti

- [trova-esclusi-gg-cascade](./trova-esclusi-gg-cascade.md)
- [trova-esclusi-criteri-by-year](./trova-esclusi-criteri-by-year.md)
