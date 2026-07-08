---
title: "collisioni nomi metodo — caso lettf"
type: concept
module: IndennitaResponsabilita
tags: [php, methods, lettf, qua00f, naming]
created: 2026-06-15
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/analysis/method-name-homonym-census.md
  - relationship-date-range-naming.md
  - ente-matr-relazioni-ptv-scheda.md
---

# Collisioni nomi metodo — caso LettF

## Problema originale

`Qua00f()` (PascalCase) su `LettF`:

1. **Sembra una classe**, non una relazione Eloquent.
2. In PHP collide con `qua00f()` del trait `EnteMatrRelationship` (case-insensitive).
3. Il corpo applicava filtro `dalf`/`alf` → nome fuorviante.

## Tre range, tre nomi obbligatori

| Campi | Metodo | Origine |
|-------|--------|---------|
| `dal` / `al` | `qua00fDaterange()` | trait `EnteMatrDateRangeRelationship` |
| `dalf` / `alf` | `qua00fRetribuzioneDateRange()` | `LettF` |
| `dali` / `ali` | (riservato) | futuro se serve |

`qua00fDateRange` **non** è alternativa a `qua00fRetribuzioneDateRange`: è **identico** a `qua00fDaterange` per PHP.

## Stato codice

- Rimosso `Qua00f()` / `Rep00f()` PascalCase
- `qua00fRetribuzioneDateRange()` + `ofRangeDate`
- `rep00fByAnno()` + `ofYear`
- `LettI::updateFields()` — `anag->qua00f()->ofRangeDate()` (no relazione locale)

## Riflessione

Il modulo ha **tre assi temporali** sulla stessa scheda; il naming deve leggere l’asse nel nome metodo, non solo il modello target.

## Collegamenti

- [censimento root](../../../../../../docs/wiki/analysis/method-name-homonym-census.md)
- [relationship-date-range-naming](./relationship-date-range-naming.md)
