---
title: "handoff — ann field relazioni"
type: handoff
module: Sigma
status: completed
completed: 2026-06-15
related:
  - ../../../../docs/wiki/rules/model-owned-ann-field-relationships.md
  - ../wiki/concepts/ente-matr-field-ownership.md
---

# Handoff — ann field nelle relazioni

## Problema

Proposta errata in audit: `relatedByAnno(Qua00f::class, 'quaann')`.  
`Qua00f` espone già `annFieldName(): 'quaann'`.

## Fatto

- Regola wiki: [model-owned-ann-field-relationships](../../../../docs/wiki/rules/model-owned-ann-field-relationships.md)
- `EnteMatrRelationship`: rimossi `whereRaw('quaann=""')` ecc. ridondanti dopo `hasManyByEnteMatr`
- Rimossi `getQuaRelationAnnValue` / `getRepRelationAnnValue` (dead code)

## Prossimo

- Trait `EnteMatr*Relationship` legacy con `whereRaw('quaann=""')` hardcoded (Anno, Year, DateRange)
- `Asz00k1` relazioni locali con filtro ann esplicito — verificare ridondanza
