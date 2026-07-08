---
title: "Wiki Index"
module: "Sigma"
updated: "2026-04-15T08:28:49Z"
---

# Wiki Index — Sigma

> **Purpose:** Content-oriented catalog of all wiki pages in this module.  
> **Replaces embedding-based RAG at moderate scale (~100 sources).**

## Concepts

- [asz-scheda-relationship](./concepts/asz-scheda-relationship.md) — relazione `asz()` verso `Asz00k1`, scope `ofRangeDate`
- [common-scope-date-range-ownership](./concepts/common-scope-date-range-ownership.md) — `rangeFromField` sul modello, non `match` nel trait
- [sigma-model-inheritance](./concepts/sigma-model-inheritance.md) — `BaseModel` / `BaseDateRangeModel`, mai `extends Model`
- [ente-matr-field-ownership](./concepts/ente-matr-field-ownership.md) — `matrField()` / `enteField()`, `hasManyByEnteMatr`
- [method-name-homonyms](./concepts/method-name-homonyms.md) — censimento omonimi metodi (203 nel modulo Sigma)
- [sto00f-date-range](./concepts/sto00f-date-range.md) — `st2kas`/`st2kdi`/`stann` → `BaseDateRangeModel`
- [has-ente-matr-relation-helpers](./concepts/has-ente-matr-relation-helpers.md) — trait condiviso `hasManyByEnteMatr` (Sigma + Ptv `BaseScheda`)
- [function-extra-relation-query-pattern](./concepts/function-extra-relation-query-pattern.md) — `ggInSedeTot` / `qua00f`, `Builder|Relation`, percorsi fix
- [mcq-contract-inheritance](./concepts/mcq-contract-inheritance.md) — 5 domande MCQ su contract inheritance

## Rules

- [contract-inheritance-no-redeclare](./rules/contract-inheritance-no-redeclare.md) — child NON ridichiarano `implements` già sul parent
- [model-contracts-placement](./rules/model-contracts-placement.md) — contract nel folder del layer implementatore
- [contract-interface-stacking](../../../../../../docs/wiki/rules/contract-interface-stacking.md) — contratto composito `extends`; model single-implements (`BaseScheda` via Ptv)
- [contract-naming-suffix](../../../../../../docs/wiki/rules/contract-naming-suffix.md) — suffisso `Contract`, MAI prefisso modulo
- [no-pass-model-known](./rules/no-pass-model-known.md) — MAI passare come parametro ciò che il modello espone via contratto

## Entities

## Sources

_No sources ingested yet._

## Comparisons

_No comparisons synthesized yet._

---

**Last Updated:** 2026-06-18  
**Total Pages:** 12  
**Total Raw Sources:** 8

## Shared Second Brain Discipline

- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) — local docs/wiki operating contract aligned with root LLM Wiki discipline.
