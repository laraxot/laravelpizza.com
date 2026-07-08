---
title: Audit Metodi Relazioni Duplicate
type: audit
tags:
  - sigma
  - eloquent
  - relationships
  - dry
date: 2026-06-15
---

# Audit Metodi Relazioni Duplicate - Modulo Sigma

## Metodi hasManyByEnteMatr() - Pattern identico

| Model | Methodo | Stato |
|-------|---------|-------|
| Asz00k1 | hasManyByEnteMatr(Qua00f) | OK (usa trait) |
| Asz00k1 | hasManyByEnteMatr(Qua00f) duplicato | ⚠️ RIMOSSO |
| Rep00f | Repart() x3 versioni | ⚠️ CONSOLIDARE |
| Qua00f | Ana02f/Rep00f/Qua03f | OK (usa trait) |
| Wstr02f | Wstr01lx/Wmen00f | ❌ DUPLICATO trait |
| Wmen00f | Wstr01lx/Wstr02f | ❌ DUPLICATO trait |

## Metodi hasManyByEnteMatr con filtro anno

| Model | Methodo | Anno Field | Issue |
|-------|---------|------------|-------|
| EnteMatrAnnoRelationship | Qua00f() | `quaann` | OK |
| EnteMatrAnnoRelationship | Sto00f() | `stann` | OK |
| EnteMatrAnnoRelationship | Asz00k1() | `aszann` | OK |

## Pattern DRY Implementato

- `EnteMatrRelationship` - centralizza 10 relazioni base
- `Qua00k1Relationship` - specializzazione Qua00k1
- `yearField()` - nel contract EnteMatrFieldsContract

## Azioni Richieste

1. ❌ Rimuovere `use Qua00k1Relationship;` duplicato da Sto00f
2. ❌ Consolidare metodi Repart() in Rep00f
3. ❌ Creare trait per Wmen00f/Wstr02f relazioni duplicate