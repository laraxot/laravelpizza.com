---
title: "Activity Log"
module: "Sigma"
---

# Activity Log — Sigma

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

[2026-06-18] [BUGFIX] `GgFilterData::lista_tipo_codice`: `prepareForPipeline` normalizza array da `getListaTipoCodiceAspettative()` in CSV per `find_in_set`. Test `GgFilterDataTest`.

[2026-06-18] [BUGFIX-DOC] `applyQua00fProproFilters` TypeError: pattern relazione `qua00f`, percorsi alternativi A–F. Vedi [function-extra-relation-query-pattern](./concepts/function-extra-relation-query-pattern.md). Collegamento Ptv: [trova-esclusi-gg-cascade](../../../../Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md).

[2026-06-15] [REFACTOR] `HasEnteMatrRelationHelpers` estratto da `BaseModel`; riusato su `Ptv\BaseScheda`. Vedi [has-ente-matr-relation-helpers](./concepts/has-ente-matr-relation-helpers.md).

[2026-06-15] [UPDATE] `EnteMatrFieldsContract`: `matrField()`/`enteField()` + helper `hasManyByEnteMatr`/`hasOneByEnteMatr`. Vedi [ente-matr-field-ownership](./concepts/ente-matr-field-ownership.md).

[2026-06-15] [UPDATE] `Sto00f extends BaseDateRangeModel` — `st2kas`/`st2kdi`/`stann`; no `BaseDateRangeModelCarbon`. Vedi [sto00f-date-range](./concepts/sto00f-date-range.md).

[2026-06-15] [LINT] Regola CARDINAL documentata: `.cursor/rules/eloquent-basemodel-hierarchy.mdc`, memoria wiki, audit `audit-eloquent-basemodel-hierarchy.sh` (rg). `Qua00f extends BaseDateRangeModel` confermato.

[2026-06-15] [UPDATE] Ereditarietà modelli: zero `extends Model`; `BaseDateRangeModel implements Models\Contracts\DateRangeFieldsContract`; `Asz00k1`, `Asz00f`, `Qua00f`, `Qua03f`, `Rep00f` estendono il base senza ripetere `implements`. Vedi [sigma-model-inheritance](./concepts/sigma-model-inheritance.md).

[2026-06-15] [UPDATE] `Sto00f extends BaseDateRangeModel` — `st2kas`/`st2kdi`/`stann`; no `BaseDateRangeModelCarbon`. Vedi [sto00f-date-range](./concepts/sto00f-date-range.md).

[2026-06-15] [LINT] Gate PHPStan livello max su `Modules/Sigma`: 0 errori. Pattern: `whereRaw` con binding `?`, `selectRaw` letterale per aggregati gg.

[2026-06-15] [UPDATE] Architettura `CommonScope`: `rangeFromField` / `rangeToField` / `annFieldName` **abstract** nel trait, implementati su ogni modello (no `match(static::class)`). Vedi [common-scope-date-range-ownership](./concepts/common-scope-date-range-ownership.md).

[2026-06-15] [UPDATE] `Sto00f extends BaseDateRangeModel`: aggiunti `rangeFromField()='st2kas'`, `rangeToField()='st2kdi'`, `annFieldName()='stann'`; rimossi `scopeOfYear`/`scopeOfEnteYear` override (forniti da `CommonScope`). Aggiornati docs `architecture.md`, `sigma-model-inheritance.md`, `common-scope-date-range-ownership.md`, `basemodel-hierarchy.md`.

[2026-06-15] [RULE] Naming contratti: `DateRangeFieldsContract` canon; vietato `SigmaDateRangeFields`. Vedi [contract-naming-suffix](../../../../../../docs/wiki/rules/contract-naming-suffix.md).

[2026-06-15] [RULE] Composizione interface: `SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract`. La classe implementa UN solo contratto (il composito). Vedi architecture.md §Composizione Contratti.

[2026-06-15] [RULE] MAI passare come parametro ciò che il modello espone via contratto. `hasManyByEnteMatr()` interroga `annFieldName()` sul related — non riceve stringhe duplicate.

### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** 2026-06-15 — Contract rename + stacking pattern
**Total Operations:** 3

[2026-06-15] [RENAME] Contratti Sigma: `SigmaDateRangeFields`→`DateRangeFieldsContract`, `SigmaEnteMatrFields`→`EnteMatrFieldsContract`, `SigmaQuaRelationAnnFields`→`QuaRelationAnnFieldsContract`. Tutti suffisso `Contract`, senza prefisso `Sigma`.

[2026-06-15] [STACKING] `SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract`. Model implementa solo contratto composito. Regola: `docs/wiki/rules/contract-interface-stacking.md`. `SigmaQuaRelationAnnFields` eliminato.
