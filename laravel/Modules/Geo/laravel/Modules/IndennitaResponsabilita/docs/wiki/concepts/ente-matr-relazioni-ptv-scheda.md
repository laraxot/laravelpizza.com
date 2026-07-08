---
title: "ente+matr su schede Ptv — hasMany vs hasManyByEnteMatr"
type: concept
module: IndennitaResponsabilita
tags: [relationships, ptv, sigma, dry]
created: 2026-06-15
updated: 2026-06-15
qmd: "hasManyByEnteMatr BaseScheda LettF ente matr Ptv Sigma"
related:
  - ../../../../../Sigma/docs/wiki/concepts/common-scope-date-range-ownership.md
  - relationship-date-range-naming.md
  - ../../../../../../docs/wiki/rules/relationship-filtered-naming.md
---

# ente+matr su schede Ptv

## Contesto

`LettF` / `LettI` estendono `Modules\Ptv\Models\BaseScheda` (connessione `ptv`), non `Modules\Sigma\Models\BaseModel` (connessione `generale`).

`hasManyByEnteMatr()` vive solo su **Sigma `BaseModel`** (`EnteMatrFieldsContract` + filtro `*ann`).

## Decisione (2026-06-15)

**Mantenere** `hasMany(..., 'matr', 'matr')->where('ente', $this->ente)` sulle relazioni custom di LettF finché Ptv non espone un helper equivalente.

Motivi:

1. **Confini modulo** — introdurre `hasManyByEnteMatr` su `Ptv\BaseModel` è refactor cross-modulo, fuori scope del fix naming/scope.
2. **Semantica identica** — per LettF `matrField()`/`enteField()` sono sempre `matr`/`ente`; nessun guadagno funzionale immediato.
3. **LettI** — query su `$anag->qua00f()` (Sigma `Anag`); già allineata al trait `EnteMatrRelationship`.

## Quando migrare

- Milestone Ptv: trait `PtvEnteMatrRelationship` o `BaseScheda::hasManyByEnteMatr()` con stesso contratto Sigma.
- Fino ad allora: relazioni filtrate con nome esplicito (`qua00fRetribuzioneDateRange`, `rep00fByAnno`) + scope `ofRangeDate`/`ofYear`.

## Collegamenti

- [relationship-date-range-naming](./relationship-date-range-naming.md)
- [relationship-filtered-naming](../../../../../../docs/wiki/rules/relationship-filtered-naming.md)
