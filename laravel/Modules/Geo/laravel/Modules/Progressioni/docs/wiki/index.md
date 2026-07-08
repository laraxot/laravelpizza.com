---
title: "Wiki Index"
module: "Progressioni"
updated: "2026-06-18"
---

# Wiki Index — Progressioni

> **Purpose:** Content-oriented catalog of all wiki pages in this module.  
> **Replaces embedding-based RAG at moderate scale (~100 sources).**

## Concepts

- [phpstan-progressioni-gate](./concepts/phpstan-progressioni-gate.md) — gate PHPStan 0 errori, pattern hasMany/ASZ/route helper
- [method-name-homonyms](./concepts/method-name-homonyms.md) — censimento omonimi metodi (128 nel modulo)
- [scheda-contract-inheritance](../../../Ptv/docs/wiki/concepts/scheda-contract-inheritance.md) — owner gerarchia `BaseScheda` (Ptv)
- [eloquent-relationship-encapsulation](../../../../../docs/wiki/rules/eloquent-relationship-encapsulation.md) — regola cardinale (link root)
- [module-hierarchy-inheritance-pattern](../../../../../docs/wiki/rules/module-hierarchy-inheritance-pattern.md) — `Scheda extends BaseScheda` senza `implements` ridondante
- [contract-interface-stacking](../../../../../docs/wiki/rules/contract-interface-stacking.md) — contratto composito `extends`; model single-implements
- [organizzativa-money](./concepts/organizzativa-money.md)
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md)
- [context-overflow-prevention](./concepts/context-overflow-prevention.md)
- [trova-esclusi-ui-cascade](./concepts/trova-esclusi-ui-cascade.md) — stub UI → cascata Ptv/Sigma

## Rules

- [contract-aggregation-pattern](./rules/contract-aggregation-pattern.md) — consumer: estende `Ptv\BaseScheda`, niente contratto locale
- [database-connection-progressione](../database-connection-progressione.md) — `$connection = 'progressione'`; override su modelli Ptv

## Entities

_No entities tracked yet._

## Sources

_No sources ingested yet._

## Comparisons

_No comparisons synthesized yet._

---

**Last Updated:** 2026-06-15  
**Total Pages:** 6  
**Total Raw Sources:** 0

## Shared Second Brain Discipline

- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) — local docs/wiki operating contract aligned with root LLM Wiki discipline.
