---
title: "handoff — DateRangeFieldsContract naming"
type: handoff
module: Sigma
status: completed
completed: 2026-06-15
related:
  - ../../../../docs/wiki/rules/contract-naming-suffix.md
  - ../wiki/rules/model-contracts-placement.md
---

# Handoff — `DateRangeFieldsContract`

## Regola

- ❌ `SigmaDateRangeFields`
- ✅ `Modules\Sigma\Models\Contracts\DateRangeFieldsContract`

## Stato codice (2026-06-15)

- `DateRangeFieldsContract` — canon
- `EnteMatrFieldsContract` — canon
- `QuaRelationAnnFieldsContract` — eliminato (nessun implementer)

## BaseScheda e DateRangeFieldsContract

`BaseScheda` implementa solo `SchedaContract`, che **estende** `EnteMatrFieldsContract` + `DateRangeFieldsContract` (contract stacking).

Non estende `Sigma\BaseDateRangeModel` perché:
- connessione `ptv`, non `generale`
- colonne scheda: `dal`/`al`/`anno` (non `qua2kd`)
- `scopeWithDays` custom su Ptv, non `CommonScope` Sigma

Implementazione diretta dei tre metodi su `BaseScheda` è **corretta**.

## Prossimo

- Audit `whereRaw` intervallo `qua2kd` su moduli dominio (CondizioniLavoro, ServizioEsterno, Progressioni)
- Trait duplicati `EnteMatrYearRelationship` / `EnteMatrAnnoRelationship`

## Fix sessione

`SchedaContract.php` ancora importava `SigmaDateRangeFields` / `SigmaEnteMatrFields` — allineato a `DateRangeFieldsContract` / `EnteMatrFieldsContract`.
